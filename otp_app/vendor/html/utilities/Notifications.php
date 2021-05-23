<?php 


class Notifications
{


    public static function sendOtp($email, $code){
        
        // Send Email

        // Send sms

        // Send Notification
        // Recuperar push token desde base de datos con el email
        Notifications::sendGCM("Codigo de confirmación ".$code." para la recepción del paquete","eRwmILD7SVGTvO5LmjcbYq:APA91bHNBUpG_zVusxBCkhr1xjNV0Z_NpsYNsD2t6T0gdXrwTV1VLD1uJEQ13Q7ib2WGUebR8Vn5CvtBCEdrWejCpDPF3fGL8-pXoo4X82QvhfOk0ZrNdiV3FSZbPbfJJCGEIm14xgkS");

    }


    private static function sendGCM($message, $id) {


        $url = 'https://fcm.googleapis.com/fcm/send';

     
        $fields = array (
               'to'=> $id,
                'notification' => array (
                    "title" => "PACK CHECK Service",
                    "body" => $message
                )
        );
        $fields = json_encode ( $fields );
    
        $headers = array (
                'Authorization: key=' . "AAAA0vhhgBQ:APA91bHP3GlaGMwFMpyIiUf3Ku07jSRCaWlASiFYneXtRq7d-uIwPubLivWcgzsVC0Ji6H5Ohv7Jylidat9IiXN5bI-3QDSJlDnK_sXsXwAPJCUvyT6c0es_Qg7YhpfBE0bAL2XQCDbM",
                'Content-Type: application/json'
        );
    
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
    
        $result = curl_exec ( $ch );
        echo $result;
        curl_close ( $ch );
    }

}
