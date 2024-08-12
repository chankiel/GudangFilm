<?php

namespace App\Helpers;

class JwtHelper
{
    private static $header = [
        'alg' => 'HS256',
        'typ' => 'JWT',
    ];
    private static $key;

    public function __construct()
    {
        self::$key = env('JWT_KEY');
    }

    public static function encode($payload)
    {
        $headerEncoded = base64_encode(json_encode(self::$header));
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", self::$key, true);
        $signatureEncoded = base64_encode($signature);

        return "$headerEncoded.$payloadEncoded.$signatureEncoded";
    }

    public static function decode($jwt)
    {
        $jwt = urldecode($jwt);

        if(substr_count($jwt,'.')!==2){
            return null;
        }

        $firstDotPos = strpos($jwt, '.');
        $secondDotPos = strrpos($jwt, '.');
        
        $headerEncoded = substr($jwt,0,$firstDotPos);
        $payloadEncoded = substr($jwt,$firstDotPos+1,$secondDotPos-$firstDotPos-1);
        $signatureEncoded = substr($jwt, $secondDotPos + 1);

        $header = json_decode(base64_decode($headerEncoded), true);
        $payload = json_decode(base64_decode($payloadEncoded), true);
        $signature = base64_decode(str_replace(' ','+',$signatureEncoded));

        $validSignature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", self::$key, true);
        if ($signature !== $validSignature) {
            return null;
        }

        return $payload;
    }
}