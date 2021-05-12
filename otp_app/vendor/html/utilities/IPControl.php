<?php

class IPControl
{
    private static function getIPAddress() {  
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'LocalHost';
        return $ipaddress;
    
    }  

    public static function analyzeClient(){
        $ip = IPControl::getIPAddress();
        // buscar ip en tabla de bloqueos
        // if(tabla de bloqueos mayor a 5 bloquear
        if(5 >= 6){
            throw new ExceptionService(HttpStatus::TooManyRequests, 'Cliente '.$ip.' bloqueado');
        }
    }

    public static function logIpError(){
        $ip = IPControl::getIPAddress();
        // Guardar la ip en la tabla de errores
    }

    
}