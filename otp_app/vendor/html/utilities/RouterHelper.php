<?php

require_once 'ExceptionService.php';

 // Constantes de estado
 const LOGIN_SERVICE = 'login';
 const GENERATE_CODE_SERVICE = 'generatecode';
 const VALIDATE_CODE_SERVICE = 'validatecode';
 const STATUS_SERVICE = 'status';
 const STATUS_CLIENT_SERVICE = 'statusclient';
 const PUSH_REGISTER_SERVICE = 'pushregister';

 // Array para meter todos los servicios
 const SERVICES = array(LOGIN_SERVICE, GENERATE_CODE_SERVICE, VALIDATE_CODE_SERVICE, STATUS_SERVICE, PUSH_REGISTER_SERVICE, STATUS_CLIENT_SERVICE);

class RouterHelper{

    public static function getService(){

            // optine los parametros de la url
            // 127.0.0.0/api/login
            $url_req = trim($_SERVER['REQUEST_URI']);

            // Extraer segmento de la url
            if (isset($url_req)){
                $peticion = explode('/', $url_req);
            }
            else
                throw new ExceptionService(HttpStatus::NotFound, utf8_encode($url_req));

            // Obtener recurso
            // 127.0.0.0
            $service = explode('/', $url_req)[2];

            // Comprobar si existe el recurso
            if (!in_array($service, SERVICES)) 
            {
                // Respuesta error
                throw new ExceptionService(HttpStatus::NotFound, "Function not defined in array tipecall:".$service);
            }

            return  $service;
    }
}
