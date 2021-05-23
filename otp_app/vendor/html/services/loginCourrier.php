<?php

require_once './utilities/HttpStatus.php';
require_once './utilities/ExceptionService.php';
require_once './utilities/IPControl.php';
require_once './utilities/JwtHelper.php';

class Login
{
    public static function getToken(){

        //SELECT DATE_FORMAT(time, '%Y-%m-%d') as fecha, COUNT(*) as total FROM `track_trace` GROUP BY fecha

        try{
            $res = file_get_contents('php://input'); // optiene los datos del tipo, get, post, put, delete
            
            $datosjson = json_decode($res); // Codificación para optener en formato json
			
			 //validacion si estan en blanco
            if (empty($datosjson)||empty($datosjson->{'company_ID'})||empty($datosjson->{'pass_hash'})){
				 IPControl::logIpError();
                throw new ExceptionService(HttpStatus::UnprocessableEntity, 'Petición de login con datos vacíos. company_ID y pass_hash son obligatorios');
            }
			
    
            $company_ID = $datosjson->{'company_ID'}; // Recuperas los datos
            $pass_hash = $datosjson->{'pass_hash'};
            
            // Analizamos si el cliente esta en la lista de bloqueos
            IPControl::analyzeClient();

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // BUscar en base de datos
            // Si existe generar JWT con 
                // company_ID
                // fecha_validez - 24 horas cogertimespan + 24 horas

            $sql = "SELECT * FROM usuario 
            WHERE company_ID='$company_ID' and passHash='$pass_hash'";

            //$userArray = array();
            $item = array();
            foreach ( $pdo->query($sql) as $row) {
                $item['company_ID'] = $row['company_ID'];
                $item['courrier_ID'] = $row['courrier_ID'];
            }

            if(empty($item)){
                IPControl::logIpError();
                throw new ExceptionService(HttpStatus::Unauthorized, 'Usuario o clave incorrectos');
            }

            $caducity=time()+(24*60*60);    //Caducidad de 24h

            $payload = array(
                "company_ID" =>  $item['company_ID'],
                "caducity" => $caducity,
                "courrier_ID" => $item['courrier_ID'],
            );

            $jwt =  JwtHelper::encode($payload);

            return [
				    "jwt" => $jwt
                    ];
            
        }catch(ExceptionService $serviceEx){
            throw $serviceEx;
       }
        catch(Exception $ex){
            //DEBUG 
            throw new ExceptionService(HttpStatus::InternalServerError, 'Se ha producido un error '.$ex);
            // PRODUCTION
           // throw new ExceptionService(HttpStatus::MethodNotAllowed, 'Se ha producido un error '.$ex-> getMessage());
        }
    }
}