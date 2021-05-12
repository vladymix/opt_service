<?php

use \Firebase\JWT\JWT;

require_once './utilities/HttpStatus.php';
require_once './utilities/ExceptionService.php';

class Login
{
    public static function getToken(){

        //SELECT DATE_FORMAT(time, '%Y-%m-%d') as fecha, COUNT(*) as total FROM `track_trace` GROUP BY fecha

        try{
            $res = file_get_contents('php://input'); // optiene los datos del tipo, get, post, put, delete
            
        
            $datosjson = json_decode($res); // Codificación para optener en formato json
    
            $email = $datosjson->{'email'}; // Recuperas los datos
            $pass_hash = $datosjson->{'pass_hash'};
            
            //validacion si estan en blanco
            if (empty($datosjson)||empty($email)||empty($pass_hash)){
                throw new ExceptionService(HttpStatus::UnprocessableEntity, 'Petición de login con datos vacíos');
            }

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            //$sql = "SELECT * FROM usuario where email ='".$email."' and input_time >= '". $dateTime."'";
            // BUscar en base de datos
            // Si existe generar JWT con 
                // email
                // fecha_validez - 24 horas cogertimespan + 24 horas


            $sql = "SELECT * FROM usuario 
            WHERE email='$email'";

           
            //$userArray = array();

            foreach ( $pdo->query($sql) as $row) {
                $item['email'] = $row['email'];
                $item['userID'] = $row['User_ID'];
                $item['pwd'] = $row['passHash'];
            }

            if(empty($item)||$item['pwd']!=$pass_hash||$item['email']!=$email){
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
            
        }catch(Exception $ex){
            throw new ExceptionService(HttpStatus::MethodNotAllowed, 'No contiene registros'.$ex);
        }
    }
}