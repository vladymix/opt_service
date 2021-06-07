<?php 

require_once '../autoload.php';

require 'conecction/conectiondb.php';
require 'utilities/ExceptionService.php';
require 'utilities/RouterHelper.php';
require 'views/ServiceResponse.php';

require 'services/login.php';
require 'services/CodeOtp.php';
require 'services/validatecode.php';
require 'services/PushRegister.php';
require 'services/Status.php';

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
    
    case VALIDATE_CODE_SERVICE:
        switch ($metodo) {
            case 'post':
                $serviceResponse ->sendData(HttpStatus::OK, validatecode::validate());
            break;
            default:
                throw new ExceptionService(HttpStatus::NotFound, utf8_encode($metodo));
        }
    break; 
    case STATUS_SERVICE:
        switch ($metodo) {
            case 'post':
                // TODO
                $serviceResponse ->sendData(HttpStatus::OK, Status::verify());
            break;
            default:
                throw new ExceptionService(HttpStatus::NotFound, utf8_encode($metodo));
        }
    break; 
    case STATUS_CLIENT_SERVICE:
        switch ($metodo) {
            case 'post':
                // TODO
                $serviceResponse ->sendData(HttpStatus::OK, Status::verifyClient());
            break;
            default:
                throw new ExceptionService(HttpStatus::NotFound, utf8_encode($metodo));
        }
    break; 

    
    case PUSH_REGISTER_SERVICE:
        switch ($metodo) {
            case 'post':
                $serviceResponse ->sendData(HttpStatus::OK, PushRegister::register());
            break;
            default:
                throw new ExceptionService(HttpStatus::NotFound, utf8_encode($metodo));
        }
    break;

    

}