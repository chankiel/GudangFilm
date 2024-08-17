<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\JwtHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{

    public static function check(Request $request=null,$isAdmin=false,$isAPI=false){
        $jwt_token = null;
        if(!$isAPI){
            if(!isset($_COOKIE['jwt_token'])){
                return null;
            }

            $jwt_token = $_COOKIE['jwt_token'];
        }else{
            if(!$request->bearerToken()){
                return null;
            }

            $jwt_token = $request->bearerToken();
        }

        $credentials = JwtHelper::decode($jwt_token);
        if(!$credentials){
            return null;
        }

        if(!isset($credentials['usrnm'])){
            return null;
        }

        if($isAdmin && $credentials['usnrm']!=='admin'){
            return null;
        }

        $user = User::where('username',$credentials['usrnm'])->first();
        if(!$user){
            return null;
        }
        return $user;
    }

    public function setJwt($token)
    {
        setcookie('jwt_token', $token, time() + (86400 * 30), '/');
        
    }

    public function checkCred($credentials)
    {
        if (!isset($credentials['emailUsr'])) {
            return ["status" => "emailUsr","msg"=>"Email / Username field is required!"];
        }

        if (!isset($credentials['password'])) {
            return ["status"=>"password","msg"=>"Password field is required!"];
        }

        $user = DB::table('users')->where('username', $credentials['emailUsr'])
            ->orWhere('email', $credentials['emailUsr'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return ["status"=>"creds","msg"=>'Credentials doesn\'t match'];
        }
        
        $token = JwtHelper::encode([
            'usrnm' => $user->username,
            'pswrd' => $credentials['password'],
        ]);
        return ["status"=>"true","msg"=>$token];
    }

    public function login(Request $request)
    {
        $res = $this->checkCred($request->all());

        if ($res['status']) {
            $this->setJwt($res['msg']);
        }
        return $res;
    }

    public function logout(Request $request){
        // Check if the cookie exists
        if (!isset($_COOKIE['jwt_token'])) {
            return redirect('/')->with('success', 'User not logged in!');
        }

        // Create a response to include the cookie deletion
        $response = redirect('/')->with('success', 'User logged out!');

        // Forget the cookie by setting it with an expiration date in the past
        $response->withCookie(Cookie::forget('jwt_token'));

        return $response;
    }
}
