<?php

namespace App\Helpers\Classes;

class SMS
{

    public static function send($destination, $body, $sender='')
    {
        if(env('APP_SMS', false) == false){
            return false;
        }

        //how much sms credit we have?
        $curentCredit = self::getCredit();
        if($curentCredit < 1){
            notify2Slack('error', 'We do not have enough SMS credit.');
            return false;
        }

        //valid phone number sample 8801685300025

        if(!preg_match("/^[8]{2}[0]{1}[1]{1}[0-9]{9}$/", $destination)) {
            notify2Slack('error', 'SMS Error: Given phone number is not well formatted ['.$destination.']');
            return false;
        }

        if(empty($sender)){
            $sender = env('SMS_SENDER', 'MF');
        }

        //now we are sure that our phone number is a valid number
        //let's try to send sms
        //prepearing data array
        $dataArray = [
            'authentication' => [
                'username' => env('SMS_USERNAME'),
                'password' => env('SMS_PASSWORD')
            ],
            'messages' => [
                [
                    'sender' => $sender,
                    'text' => $body,
                    'type' => 'longSMS',
                    'datacoding' => 8,
                    'recipients' => [
                        [
                            'gsm' => $destination
                        ]
                    ]
                ]
            ]
        ];

        //prepearing end point
        $url = env('SMS_API') . "/" . env('SMS_API_VERSION') . "/sendsms/json";

        //trying to send sms
        $response = SMS::curlCall($url, $dataArray);

        /*if($response != false){

            $d = [
                'gateway_response' => $response,
                'body' => $body
            ];

            self::storeLog($d);
        }*/
        
        return $response;
    }

    public static function getCredit()
    {
        $url = env('SMS_API')."/command?username=".env('SMS_USERNAME')."&password=".env('SMS_PASSWORD')."&cmd=Credits";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Download the given URL, and return output
        $output = curl_exec($ch);

        if ($output === false) {
            notify2Slack('error', curl_error($ch));
        }

        // Close the cURL resource, and free system resources
        curl_close($ch);

        return $output;
    }

    /**
     * Description: This function will handle all kinds of curl request
     * @param $url string
     * @param $data array
     * @return json
     */
    private static function curlCall($url, $data)
    {

        //converting data array to json
        $data_string = json_encode($data);
        //initialize curl
        $ch = curl_init($url);
        //setting up the curl options
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        // Download the given URL, and return output
        $output = curl_exec($ch);

        if ($output === false) {
            notify2Slack('error', curl_error($ch));
        }

        // Close the cURL resource, and free system resources
        curl_close($ch);

        return $output;
    }

    private static function storeLog($response){

        $data = json_decode($response['gateway_response']);

        $log = new \App\SMSLog();
        $log->messageid = !empty($data->results[0]->messageid) ? $data->results[0]->messageid : "";
        $log->destination = !empty($data->results[0]->destination) ? $data->results[0]->destination : "";
        $log->body = $response['body'];
        $log->credit_cost = ceil(strlen($log->body)/160); /*assume per sms = 160 char*/
        $log->status = !empty($data->results[0]->status) ? $data->results[0]->status : "";
        $log->gateway_response = $response['gateway_response'];

        return $log->save() ? true : false;
    }
}