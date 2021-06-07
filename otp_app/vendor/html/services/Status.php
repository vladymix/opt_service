<?php

class Status{
    public static function verify(){
        try{
            $rest =file_get_contents('php://input'); //Obtencion de la solicitud por parte del courrier
            $datosjson = json_decode($rest); 

          $token = $datosjson->{'token'};
          $jwt_otp = $datosjson->{'jwt_otp'};
          $id_tracker = $datosjson->{'id_tracker'};

          $jwt_otp_decode=JwtHelper::decode($jwt_otp);
          $track_id=  $jwt_otp_decode->{'track_id'};
          $user_id=  $jwt_otp_decode->{'user_id'};

          if(strcmp($track_id, $id_tracker) !== 0){
            throw new ExceptionService(HttpStatus::InternalServerError, 'The tracking code  are not equals');
          }

          
          $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

           // Buscar cliente
        $sql = "SELECT status FROM otp_data WHERE jwt_otp='$jwt_otp' ";

        $data = array();
        $status = "-1";
        foreach ( $pdo->query($sql) as $row) {
                  $status  = $row['status'];
        }

        $responseObject=array(
            "id_tracker"=>$id_tracker, 
            "status"=>$status);
        
        return $responseObject;


        }catch(Exception $ex){
            //DEBUG 
            throw new ExceptionService(HttpStatus::InternalServerError, 'Se ha producido un error '.$ex);
            // PRODUCTION
            // throw new ExceptionService(HttpStatus::MethodNotAllowed, 'Se ha producido un error '.$ex-> getMessage());
        }
    }

    //
public static function verifyClient(){
    try{
        $rest =file_get_contents('php://input'); //Obtencion de la solicitud por parte del courrier
        $datosjson = json_decode($rest); 

      $token = $datosjson->{'token'};
      $id_tracker = $datosjson->{'id_tracker'};

      $jwt_otp_decode=JwtHelper::decode($token);
      $m_user_id=  $jwt_otp_decode->{'User_ID'};

      $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

       // Buscar cliente
    $sql = "SELECT otp.status FROM otp_data otp join delivery d on d.delivery_ID = otp.delivery_ID    WHERE User_ID=".$m_user_id." AND  track_ID='".$id_tracker."'";

    $data = array();
    $status = "-1";
    foreach ( $pdo->query($sql) as $row) {
              $status  = $row['status'];
    }

    $responseObject=array(
        "id_tracker"=>$id_tracker, 
        "status"=>$status);
    
    return $responseObject;


    }catch(Exception $ex){
        //DEBUG 
        throw new ExceptionService(HttpStatus::InternalServerError, 'Se ha producido un error '.$ex);
        // PRODUCTION
        // throw new ExceptionService(HttpStatus::MethodNotAllowed, 'Se ha producido un error '.$ex-> getMessage());
    }
}
}

?>