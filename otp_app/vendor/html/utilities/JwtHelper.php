<?php

use \Firebase\JWT\JWT;

class JwtHelper {

    private  const KEY = "MIICXAIBAAKBgQCrncGS3U1s8VFKKNSPV5sbk1/I4uU/BTuGik+hFtMILqnYjYms";

     /**
     * Encode data
     *
     * @param object|array  $payload    PHP object or array
     */
   public static function encode($payload){
        return JWT::encode($payload, JwtHelper::KEY);
    }

    public static function decode($jwt){
        return JWT::decode($jwt, JwtHelper::KEY, array('HS256'));
    }


}