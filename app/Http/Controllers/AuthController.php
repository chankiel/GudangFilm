<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JwtHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request){
        $credentials = $request->only('username','password');
        $user = DB::table('users')->where('username',$credentials['username'])->first();
        if(!$user || !Hash::check($credentials['password'],$user->password)){
            return response()->json([
                'status' => 'error',
                'message' => 'Credentials doesn\'t match',
                'data' => null,
            ]);
        }

        $token = JwtHelper::encode([
            'usrnm' => $credentials['username'],
            'pswrd' => $credentials['password'],
        ]);

        setcookie('jwt_token', $token, [
            'expires' => time() + (86400*30),
            'path' => '/',
            'domain' => '', // Default to the current domain
            'secure' => true, // Ensure the cookie is sent over HTTPS
            'httponly' => true, // Make the cookie accessible only through HTTP
            'samesite' => 'Strict', // Prevents the cookie from being sent with cross-site requests
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'login berhasil',
            'data' => [
                'username'=>$credentials['username'],
                'token' => $token,
            ],
        ]);    
    }
}
