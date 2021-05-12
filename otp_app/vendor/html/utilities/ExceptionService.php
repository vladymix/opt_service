<?php

class ExceptionService extends Exception
{
	public function __construct($code, $mensaje)
	{
		$this->status = $code;
		$this->code = $code;
		$this->message = $mensaje;
    }
}