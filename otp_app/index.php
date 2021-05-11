<?php 

require 'conecction/conectiondb.php';
require 'utilities/constants.php';
require 'utilities/ExceptionService.php';
require 'views/ServiceResponse.php';
require 'services/login.php';

// Create exceptions
$serviceResponse = new ServiceResponse();

// Captura todas las exepciones para enviarla como respuesta api
set_exception_handler(function ($exception) use ($serviceResponse) {
	
    if ($exception->getCode()) {
        $serviceResponse->status = $exception->getCode();
    } else {
        $serviceResponse->status = HttpStatus::MethodNotAllowed;
    }

    $cuerpo = array(
        "status" => $serviceResponse->status,
        "message" => $exception-> getMessage()
        );
    $serviceResponse->send($cuerpo);
}); 


// optine los parametros de la url
$url_req = trim($_SERVER['REQUEST_URI']);

// Extraer segmento de la url
if (isset($url_req)){
    $peticion = explode('/', $url_req);
}
else
    throw new ExceptionService(HttpStatus::NotFound, utf8_encode($url_req));

// Obtener recurso
// 127.0.0.0/api/login
$service = explode('/', $url_req)[2];

// Comprobar si existe el recurso
if (!in_array($service, SERVICES)) 
{
	// Respuesta error
	throw new ExceptionService(HttpStatus::NotFound, "Function not defined in array tipecall:".$service);
}
else{
    $metodo = strtolower($_SERVER['REQUEST_METHOD']); // tipo, get, post, put, delete

    switch($service){
            case LOGIN_SERVICE:
            switch ($metodo) {
                 case 'post':
                     $serviceResponse ->sendData(Login::getToken());
                 break;
            }
            break;
            
        default:
             throw new ExceptionService(HttpStatus::NotFound, utf8_encode($url_req));
        break;
    }
}

