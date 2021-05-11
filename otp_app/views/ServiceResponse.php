<?php

require 'HttpStatus.php';


class ServiceResponse {

    public function __construct($status = HttpStatus::BadRequest)
    {
        $this->status = $status;
    }

    public function sendData($status, $cuerpo){
        http_response_code($status);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf8');
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        echo json_encode($cuerpo, JSON_PRETTY_PRINT);
        exit;
    }

}

