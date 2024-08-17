<?php

namespace App\Http\Middleware;

use App\Helpers\JSONHelper;
use Closure;
use App\Helpers\JwtHelper;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if(!AuthController::check()){
            return redirect('/login');
        }
        
        return $next($request);
    }
}
