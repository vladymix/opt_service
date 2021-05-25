<?php

use Firebase\JWT\SignatureInvalidException;

require_once './utilities/HttpStatus.php';
require_once './utilities/ExceptionService.php';
require_once './utilities/IPControl.php';
require_once './utilities/JwtHelper.php';

class CodeOtp
{
    public static function generate(){
        try{

            $solicitud=file_get_contents('php://input'); //Obtencion de la solicitud por parte del courrier
            $datosSolicitud = json_decode($solicitud);

            if(empty($datosSolicitud)||empty($datosSolicitud->{'token'})||
            empty($datosSolicitud->{'track_id'})||empty($datosSolicitud->{'email_cliente'})){
                IPControl::logIpError();
               throw new ExceptionService(HttpStatus::UnprocessableEntity, 'Petición de código con datos vacíos.');
           }

           $token=$datosSolicitud->{'token'};
           $track_id=$datosSolicitud->{'track_id'};
           $email_cliente=$datosSolicitud->{'email_cliente'};
           $status=0;

            //Si la firma no es válida, el token tampoco lo es y se lanza SignatureInvalidException
            $tokenDecoded=JwtHelper::decode($token); //Decodifica y comprueba firma.
            
            //¿Token correcto?
            if (empty($tokenDecoded)||empty($tokenDecoded->{'email'})||empty($tokenDecoded->{'caducity'})
            ||empty($tokenDecoded->{'User_ID'})){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::NotFound, 'Token no correcto.');
            }
            //Comprueba caducicdad
            if($tokenDecoded->{'caducity'}<time()){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::NotFound, 'Token caducado.');
            }    
           
            //Comprobar identidad del usuario
            if($email_cliente != $tokenDecoded->{'email'}){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::Unauthorized, 'Se ha producido un error al verificar la identidad ');
            }

            IPControl::analyzeClient();

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD(); //Conexión a la BBDD tras comprobar cliente

            //Insertar datos en BBD, tabla delivery
            $delInsert="INSERT INTO delivery (User_ID, track_ID, status)
            VALUES (:userid, :trackid, :_status)";
            $stmt=$pdo->prepare($delInsert);
            $stmt->bindParam(':userid', $tokenDecoded->{'User_ID'});
            $stmt->bindParam(':trackid', $track_id);
            $stmt->bindParam(':_status', $status=0);
            $resul = $stmt->execute();
            //Obtención de clave primaria
            $PK_id=$pdo->lastInsertId();
            
    
            $otp_pass=CodeOtp::random_str(6); //Generamos código de 6 cifras en Base64. Prob colisión=1/64^6
            $status=1;

            $payloadJwt_otp=array( //Introducir userID y trackerID como clave primaria33
                "user_id" => $tokenDecoded->{'User_ID'},
                "token" => $token,
                "track_id" => $track_id,
                "email_cliente" => $email_cliente,
                "caducidad" => $tokenDecoded->{'caducity'},
            );

            $jwt_otp=JwtHelper::encode($payloadJwt_otp);
            
            //Insertar datos de OTP en BBD, en tabla otp_data
            $otpInsert="INSERT INTO otp_data (jwt_otp, otp, status, delivery_ID)
            VALUES (:jwt_otp, :otp_pass, :_status, :PK_id)";
            $stmt=$pdo->prepare($otpInsert);
            $stmt->bindParam(':jwt_otp', $jwt_otp);
            $stmt->bindParam(':otp_pass', $otp_pass);
            $stmt->bindParam(':_status', $status=1);
            $stmt->bindParam(':PK_id', $PK_id);
            $resul = $stmt->execute();

            $responseObject=array(
                "jwt_otp"=>$jwt_otp, 
                "track_id"=>$track_id, 
                "estado"=>$status);
            
            return[
                $responseObject
            ];
            
        }
        catch(ExceptionService $serviceEx){
            throw $serviceEx;
        }
        catch(Exception $ex){
            //DEBUG 
            throw new ExceptionService(HttpStatus::InternalServerError, 'Se ha producido un error '.$ex);
            // PRODUCTION
            // throw new ExceptionService(HttpStatus::MethodNotAllowed, 'Se ha producido un error '.$ex-> getMessage());
        }
        catch(SignatureInvalidException $signEx){
            IPControl::logIpError();
            throw new ExceptionService(HttpStatus::Unauthorized, 'Se ha producido un error al verificar la firma '.$signEx);

        }
    }

    public static function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode($pieces);
    }
}