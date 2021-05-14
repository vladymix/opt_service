<?php 

require_once '../autoload.php';

require 'conecction/conectiondb.php';
require 'utilities/ExceptionService.php';
require 'utilities/RouterHelper.php';
require 'views/ServiceResponse.php';

require 'services/login.php';
require 'services/CodeOtp.php';

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
        "error" => $exception-> getMessage()
    );

    // DEBUG
    $cuerpo = array(
            "error_dev" => ''.$exception
     );

    $serviceResponse->sendData($serviceResponse->status, $cuerpo);
});

// Valida la ruta del api o genera una excepcion 
$service = RouterHelper::getService();

$metodo = strtolower($_SERVER['REQUEST_METHOD']); // tipo, get, post, put, delete

switch($service){
    case LOGIN_SERVICE:
        switch ($metodo) {
            case 'post':
                $serviceResponse ->sendData(HttpStatus::OK, Login::getToken());
            break;
            default:
                throw new ExceptionService(HttpStatus::NotFound, utf8_encode($metodo));
        }
    break;

    case GENERATE_CODE_SERVICE:
            switch ($metodo) {
                case 'post':
                    $serviceResponse ->sendData(HttpStatus::OK, CodeOtp::generate());
                break;
                default:
                    throw new ExceptionService(HttpStatus::NotFound, utf8_encode($metodo));
            }
    break; 
}