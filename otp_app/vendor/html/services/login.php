<?php

use \Firebase\JWT\JWT;

require_once './utilities/HttpStatus.php';
require_once './utilities/ExceptionService.php';
require_once './utilities/IPControl.php';

class Login
{
    public static function getToken(){

        //SELECT DATE_FORMAT(time, '%Y-%m-%d') as fecha, COUNT(*) as total FROM `track_trace` GROUP BY fecha

        try{
            $res = file_get_contents('php://input'); // optiene los datos del tipo, get, post, put, delete
            
            $datosjson = json_decode($res); // Codificación para optener en formato json
			
			 //validacion si estan en blanco
            if (empty($datosjson)||empty($datosjson->{'email'})||empty($datosjson->{'pass_hash'})){
				 IPControl::logIpError();
                throw new ExceptionService(HttpStatus::UnprocessableEntity, 'Petición de login con datos vacíos email y pass_hash son obligatorios');
            }
			
    
            $email = $datosjson->{'email'}; // Recuperas los datos
            $pass_hash = $datosjson->{'pass_hash'};
            
            // Analizamos si el cliente esta en la lista de bloqueos
            IPControl::analyzeClient();

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // BUscar en base de datos
            // Si existe generar JWT con 
                // email
                // fecha_validez - 24 horas cogertimespan + 24 horas

            $sql = "SELECT * FROM usuario 
            WHERE email='$email' and passHash='$pass_hash'";

            //$userArray = array();
            $item = array();
            foreach ( $pdo->query($sql) as $row) {
                $item['email'] = $row['email'];
                $item['userID'] = $row['User_ID'];
            }

            if(empty($item)){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::UnprocessableEntity, 'Usuario o clave incorrectos');
            }

            $caducity=time()+(24*60*60);    //Caducidad de 24h

            $key = "MIICXAIBAAKBgQCrncGS3U1s8VFKKNSPV5sbk1/I4uU/BTuGik+hFtMILqnYjYms";
            $payload = array(
                "email" =>  $item['email'],
                "caducity" => $caducity,
                "User_ID" => $item['userID'],
            );

            $jwt = JWT::encode($payload, $key);

            return [
				    "jwt" => $jwt
                    ];
            
        }catch(ExceptionService $serviceEx){
            throw $serviceEx;
       }
        catch(Exception $ex){
            //DEBUG 
            throw new ExceptionService(HttpStatus::MethodNotAllowed, 'Se ha producido un error '.$ex);
            // PRODUCTION
           // throw new ExceptionService(HttpStatus::MethodNotAllowed, 'Se ha producido un error '.$ex-> getMessage());
        }
    }
}