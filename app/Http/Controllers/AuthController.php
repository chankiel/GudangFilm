<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\JwtHelper;
use App\Helpers\JSONHelper;
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

        if($isAdmin && $credentials['usrnm']!=='admin'){
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

    public function checkCred($credentials,$isAPI)
    {
        if (!isset($credentials['password'])) {
            return ["status"=>"password","msg"=>"Password field is required!"];
        }

        if(!$isAPI){
            if (!isset($credentials['emailUsr'])) {
                return ["status" => "emailUsr","msg"=>"Email / Username field is required!"];
            }
            $user = DB::table('users')->where('username', $credentials['emailUsr'])
            ->orWhere('email', $credentials['emailUsr'])->first();
        }else{
            if (!isset($credentials['username'])) {
                return ["status" => "username","msg"=>"Username field is required!"];
            }
            $user = DB::table('users')->where('username', $credentials['username'])->first();
        }
        
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
        $isAPI = $request->route()->uri()==='api/login';
        $res = $this->checkCred($request->all(),$isAPI);

        if(!$isAPI){
            if ($res['status'] === "true") {
                $this->setJwt($res['msg']);
            }
            return $res;
        }

        $status = "error";
        $message = $res['msg'];
        $data = null;

        if($res['status']==="true"){
            $status = "success";
            $message = "Login Successful";
            $data = [
                'username' => $request->only('username')['username'],
                'token' => $res['msg'],
            ];
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function logout(Request $request){
        if (!isset($_COOKIE['jwt_token'])) {
            return redirect('/')->with('success', 'User not logged in!');
        }

        $response = redirect('/')->with('success', 'User logged out!');

        $response->withCookie(Cookie::forget('jwt_token'));

        return $response;
    }

    public function self(Request $request){
        $user = $this::check($request,false,true);

        if(!$user){
            return JSONHelper::JSONResponse('error','Credentials doesn\' match',null);
        }

        return JSONHelper::JSONResponse('success','User found',[
            'username'=>$user->username,
            'token'=>$request->bearerToken(),
        ]);
    }
}
