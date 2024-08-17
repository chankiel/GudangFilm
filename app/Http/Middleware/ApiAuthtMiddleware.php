<?php

namespace App\Http\Middleware;

use App\Helpers\JSONHelper;
use App\Helpers\JwtHelper;
use App\Http\Controllers\AuthController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if(!AuthController::check($request,false,true)){
            return response()->json([
                'status' => 'error',
                'message' => 'User\' unauthorized',
                'data'=>null,
            ]);
        }
        return $next($request);
    }
}
