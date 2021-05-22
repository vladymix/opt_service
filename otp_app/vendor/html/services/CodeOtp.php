<?php

require_once './utilities/HttpStatus.php';
require_once './utilities/ExceptionService.php';
require_once './utilities/IPControl.php';
require_once './utilities/JwtHelper.php';

class CodeOtp
{
    public static function generate(){
        try{

            IPControl::analyzeClient();

            IPControl::logIpError();

             return [
                "result" => "Pruebas generacion de codigo"
                ];
        }
        catch(ExceptionService $serviceEx){
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