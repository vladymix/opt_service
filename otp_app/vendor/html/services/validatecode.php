<?php

class validatecode{

    public static function validate(){
        try{
            
            $res = file_get_contents('php://input'); // Obtiene los datos del tipo, get, post, put, delete
            $datosjson = json_decode($res); // Codificación para optener en formato json

            //Comprueba que tienen contenido
            if(empty($datosjson) 
            || empty($datosjson->{'token'})
            ||empty($datosjson->{'otp_pass'})
            ||empty($datosjson->{'track_id'})){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::UnprocessableEntity, 'Validación de código con datos vacíos');
            }

         
            //Comprueba caducidad del token
            $token=$datosjson->{'token'};

            $tokenDecoded=JwtHelper::decode($token); //Decodifica y comprueba firma.
            

            //Comprueba contenido de token
            if (empty($tokenDecoded->{'email'})||empty($tokenDecoded->{'caducity'})
            ||empty($tokenDecoded->{'User_ID'})){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::NotFound, 'Token no correcto.');
            }

             // Verifico la caducidad
            if($tokenDecoded->{'caducity'} < time()){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::NotFound, 'Token caducado.'.$tokenDecoded->{'caducity'});
            }
            
            //Extrae jwt_otp
            $track_ID=$datosjson->{'track_id'}; //Lo usamos como clave al buscar en BBDD. Si lo referencio como puntero no funciona el select
            $User_ID=$tokenDecoded->{'User_ID'};

           
            IPControl::analyzeClient();
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD(); //Conexión a la BBDD tras comprobar cliente

            //Consulta en la BBDD
            $joinSQL="  SELECT O.otp, O.delivery_ID
                        FROM otp_data O
                        JOIN delivery D
                        ON O.delivery_ID = D.delivery_ID
                        WHERE D.user_id = '$User_ID'
                        AND D.track_ID = '$track_ID'";
            $otp_DB ='';
            foreach($pdo->query($joinSQL) as $row){
                $otp_DB=$row['otp'];
                $delivery_ID=$row['delivery_ID'];
            }

            if($datosjson->{'otp_pass'} == $otp_DB){
                $status=2;
                $updateStatusD=" UPDATE delivery 
                         SET status = :status 
                         WHERE track_ID = :track_ID AND delivery_ID = :delivery_ID";
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
            else throw new ExceptionService(HttpStatus::NotAcceptable, 'Código incorrecto');
            
            
            $responseObject=array(
                "track_id"=>$track_ID, 
                "status"=>$status);
            
            return $responseObject;

        }

        catch(SignatureInvalidException $signEx){
            IPControl::logIpError();
            throw new ExceptionService(HttpStatus::Unauthorized, 'Se ha producido un error al verificar la firma '.$signEx);

        }
    }

   }