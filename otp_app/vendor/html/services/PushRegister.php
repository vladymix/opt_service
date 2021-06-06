<?php

class PushRegister{
    public static function register(){
        try{
            $rest =file_get_contents('php://input'); //Obtencion de la solicitud por parte del courrier
            $datosjson = json_decode($rest); 

          $email =   $datosjson->{'email'};
          $token_push=  $datosjson->{'token_push'};

          $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

           // Buscar cliente
        $sql = "SELECT * FROM userpush WHERE email='$email' ";

        $data = array();

        foreach ( $pdo->query($sql) as $row) {
            $data['id'] = $row['id'];
            $data['email'] = $row['email'];
            $data['token_push'] = $row['token_push'];
        }

        $status ="insert";

        if(empty($data)){
            // Insert
            $command = "INSERT INTO userpush (email, token_push) VALUES (?,?)";
            $stmt = $pdo -> prepare($command);
          
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $token_push);

            $resultado = $stmt->execute();
        }else{
            // Update
            $command = "UPDATE  userpush SET token_push=? WHERE email=?";
            $stmt = $pdo -> prepare($command);
            $stmt->execute([$token_push, $email]);
            $status ="update";
        }

        $responseObject=array(
            "email"=>$email, 
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