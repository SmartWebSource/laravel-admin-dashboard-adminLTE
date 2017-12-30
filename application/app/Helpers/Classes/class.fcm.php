<?php

/**
 * Resource collected from
 * https://gist.githubusercontent.com/rolinger/d6500d65128db95f004041c2b636753a/raw/7a67d221e171eb9fa60d5f4bbbaa6c7d1260515e/gistfile1.txt
 */

namespace App\Helpers\Classes;

class FirebaseCloudMessaging{

    private $fcmEndPoint;
    private $fcmApiAccess;
    private $fcmFields;

    public function __construct($fcmEndPoint='', $fcmApiAccess=''){

        $this->fcmEndPoint = !empty($fcmEndPoint) ? $fcmEndPoint : env('FCM_END_POINT');
        $this->fcmApiAccess = !empty($fcmApiAccess) ? $fcmApiAccess : env('FCM_API_ACCESS_KEY');

        if(empty($this->fcmEndPoint) || empty($this->fcmApiAccess)){
            throw new \Exception('Invalid FCM configuration, endpoint and api_access both are required.');
        }
    }

    /**
     * Description: This function will post payload to fcm api via curl
     * @param $payload Array 
     * sample payload array ['to' => 'receiver','notification' => ['title' => 'title','body' => 'body'],'data' => [KEY-VALUE PAIR DATA ARRAY]]
     * @return json from curl response
     */

    public function sendNotification($payload){

        //let's append some global param into notification array 
        //like notification sound, vibrate

        $payload['notification']['sound'] = 'default';
        //$payload['notification']['vibrate'] = 1;

        $this->fcmFields = $payload;

        $response = $this->curl();

        return json_encode($response);
        
    }

    private function curl(){

        $headers = [
            'Authorization: key=' . $this->fcmApiAccess,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $this->fcmEndPoint );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $this->fcmFields ) );
        
        $result = curl_exec($ch);
        
        curl_close( $ch );

        return $result;
    }
}