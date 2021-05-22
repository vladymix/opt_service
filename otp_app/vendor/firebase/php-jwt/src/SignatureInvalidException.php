<?php
namespace Firebase\JWT;

class SignatureInvalidException extends \UnexpectedValueException
{
    public function __construct($mensaje)
	{
		$this->message = $mensaje;
    }
}
