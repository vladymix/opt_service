<?php

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

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            //$sql = "SELECT * FROM usuario where email ='".$email."' and input_time >= '". $dateTime."'";
            // BUscar en base de datos
            // Si existe generar JWT con 
                // email
                // fecha_validez - 24 horas cogertimespan + 24 horas


            $sql = "SELECT * FROM usuario ";
            $return_arr = array();

            foreach ( $pdo->query($sql) as $row) {
                $item['contact'] = $row['email'];
                $item['hash'] = $row['passHash'];

    			array_push($return_arr,$item);
            }

            return [
				    "jwt" => $return_arr
                    ];
            
        }catch(Exception $ex){
            throw new ExceptionService(HttpStatus::MethodNotAllowed, 'No contiene registros'.$ex);
        }
    }
}