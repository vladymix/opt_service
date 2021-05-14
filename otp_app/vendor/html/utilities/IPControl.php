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

        $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

        // buscar ip en tabla de bloqueos
        $sql = "SELECT retry_times, locked_up FROM ipcontrol WHERE cliente_ip='$ip' ";

        $times=0;
        $locked_up = 0;
        foreach ( $pdo->query($sql) as $row) {
            $times = $row['retry_times'];
            $locked_up = $row['locked_up'];
        }

       if ($locked_up > 0 && $locked_up < time()){
            // El cliente ya espero 1 dia
            // Elimino el registro de la base de datos.
            $sql = 'DELETE FROM ipcontrol WHERE cliente_ip = :mdata';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':mdata', $ip);
            $stmt->execute();
       }
        else if($times >= 6){
            throw new ExceptionService(HttpStatus::TooManyRequests, 'Cliente '.$ip.' bloqueado');
        }
    }

    public static function logIpError(){

        $ip = IPControl::getIPAddress();
        // Guardar la ip en la tabla de errores

        $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

        // Buscar cliente
        $sql = "SELECT * FROM ipcontrol WHERE cliente_ip='$ip' ";

        $data = array();

        foreach ( $pdo->query($sql) as $row) {
            $data['cliente_ip'] = $row['cliente_ip'];
            $data['retry_times'] = $row['retry_times'];
        }


        if(empty($data)){
            // Insert
            $command = "INSERT INTO ipcontrol (cliente_ip, retry_times, locked_up) VALUES (?,?,?)";
            $stmt = $pdo -> prepare($command);
            $times = 1;
            $locked_up = time()+(24*60*60);
            $stmt->bindParam(1, $ip);
            $stmt->bindParam(2, $times);
            $stmt->bindParam(3, $locked_up);

            $resultado = $stmt->execute();
        }else{
            // Update
            $command = "UPDATE  ipcontrol SET retry_times=? WHERE cliente_ip=?";
            $stmt = $pdo -> prepare($command);
            $stmt->execute([$data['retry_times']+1, $ip]);
        }
    }

}