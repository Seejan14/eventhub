<?php

namespace App\Services;
use Exception;

class SmsService{
    public static function send($phone,$text)
    {
        $identity = \config('sms.identity');
        $token = \config('sms.token');

       
        $args = http_build_query(array(
            'token' => $token,
            'from'  => $identity,
            'to'    => $phone,
            'text'  => $text));
    
        $url = "http://api.sparrowsms.com/v2/sms/";
    
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status_code != 200)
        {
            throw new Exception("Unable to send OTP.");
        }

    }
}
    