<?php

namespace App\Http\Middleware;

use App\Helpers\JSONHelper;
use Closure;
use App\Helpers\JwtHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $credentials = JwtHelper::decode($request->cookie('jwt_token'));
        if($credentials['usrnm'] !== 'admin'){
            return JSONHelper::JSONResponse('error','Only admin can access this',null);
        }

        $user = DB::table('users')->where('username',$credentials['usrnm'])->first();
        if(!Hash::check($credentials['pswrd'],$user->password)){
            return JSONHelper::JSONResponse('error','Admin credentials doesn\' match',null);
        }
        return $next($request);
    }
}
