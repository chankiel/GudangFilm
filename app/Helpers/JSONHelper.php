<?php

namespace App\Helpers;

class JSONHelper{
    public static function JSONResponse($status,$message,$data,$code=200){
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ],$code);
    }
}