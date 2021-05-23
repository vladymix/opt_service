<?php

class validatecode{

    public static function validate(){
        try{
            
            $res = file_get_contents('php://input'); // Obtiene los datos del tipo, get, post, put, delete
            $datosjson = json_decode($res); // Codificación para optener en formato json

            //Comprueba que tienen contenido
            if(empty($datosjson)||empty($datosjson->{'token'})||empty($datosjson->{'otp'}||empty($datosjson->{'jwt_otp'}){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::UnprocessableEntity, 'Validación de código con datos vacíos');
            }

            if (empty($tokenDecoded->{'email'})||empty($tokenDecoded->{'caducity'})
            ||empty($tokenDecoded->{'User_ID'})){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::NotFound, 'Token no correcto.');
            }

            //Comprueba caducidad del token
            $token=$datosSolicitud->{'token'};
            $tokenDecoded=JwtHelper::decode($token); //Decodifica y comprueba firma.
            if($tokenDecoded->{'caducity'} < time()){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::NotFound, 'Token caducado.');
            }
            //Comprueba contenido de token
            if (empty($tokenDecoded->{'email'})||empty($tokenDecoded->{'caducity'})
            ||empty($tokenDecoded->{'User_ID'})){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::NotFound, 'Token no correcto.');
            }

            
            //Extrae jwt_otp
            $jwt_otp=$datosjson->{'jwt_otp'};
            $jwt_otp_Decoded=JwtHelper::decode($jwt_otp);
            $track_ID=$jwt_otp_Decoded->{'track_id'}; //Lo usamos como clave al buscar en BBDD. Si lo referencio como puntero no funciona el select
            $User_ID=$jwt_otp_Decoded->{'user_id'};

            //Valida contenido y caducidad jwt_otp
            if (empty($jwt_otp_Decoded->{'user_id'})||empty($jwt_otp_Decoded->{'token'})||empty($track_ID)||
                empty($jwt_otp_Decoded->{'email_cliente'})||empty($jwt_otp_Decoded->{'caducidad'})){
                    IPControl::logIpError();
                    throw new ExceptionService(HttpStatus::NotFound, 'Jwt_otp no correcto.');
                }
            
            if  ($jwt_otp_Decoded->{'token'} =! $token){
                    IPControl::logIpError();
                    throw new ExceptionService(HttpStatus::NotFound, 'Token no correcto. Usuario no identificado');
            }
            
            if  ($jwt_otp_Decoded->{'caducidad'} < time()){
                    IPControl::logIpError();
                    throw new ExceptionService(HttpStatus::NotFound, 'Token caducado.');
            }
            
            
            IPControl::analyzeClient();
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD(); //Conexión a la BBDD tras comprobar cliente

            //Consulta en la BBDD
            $joinSQL="  SELECT otp, delivery_ID
                        FROM otp_data O
                        JOIN delivery D
                        ON O.delivery_ID = D.delivery_ID
                        WHERE D.user_id = '$User_ID'
                        AND D.track_ID = '$track_ID'";
            
            foreach($pdo->query($joinSQL) as $row){
                $otp_DB=$row['otp'];
                $delivery_ID=$row['delivery_ID'];
            }

            if($datosjson->{'otp'} == $otp_DB){
                updateStatus();
            }
            else throw new ExceptionService(HttpStatus::NotAcceptable, 'Código incorrecto');
        }

        catch(SignatureInvalidException $signEx){
            IPControl::logIpError();
            throw new ExceptionService(HttpStatus::Unauthorized, 'Se ha producido un error al verificar la firma '.$signEx);

        }
    }

    private static function updateStatus(){
        $status=2;
        $updateStatusD=" UPDATE delivery 
                         SET status = :status 
                         WHERE track_ID = :track_ID AND delivery_ID = :delivery_ID
        ";
        $stmt=$pdo->prepare($updateStatusD);
        $stmt->bindParam(':status',$status);
        $stmt->bindParam(':track_ID',$track_ID);
        $stmt->bindParam(':delivery_ID',$delivery_ID);
        $stmt->execute();
        
        $updateStatusO=" UPDATE otp_data 
                         SET status = :status 
                         WHERE delivery_ID = :delivery_ID";
        $stmt2=$pdo->prepare($updateStatusO);
        $stmt2->bindParam(':status',$status);
        $stmt2->bindParam(':delivery_ID',$delivery_ID);
        $stmt2->execute();
    }
}