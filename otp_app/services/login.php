<?php

require_once './utilities/constants.php';
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
            
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            $sql = "SELECT user FROM UserRegister where email ='".$email."' and input_time >= '". $dateTime."'";

            $return_arr = array();

            foreach ( $pdo->query($sql) as $row) {
                $row_array['contact'] = $row['contact'];
                $row_array['message'] = $row['message'];
                $row_array['time'] = $row['time'];
    			array_push($return_arr,$row_array);
            }

            return [
                    "status" => HttpStatus::OK,
                    "email" =>  $email,
				    "messages" => $return_arr
                    ];
            
        }catch(Exception $ex){
            throw new ExceptionService(HttpStatus::MethodNotAllowed, 'No contiene registros'.$ex);
        }
    }
}