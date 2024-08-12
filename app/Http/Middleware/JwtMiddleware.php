<?php

namespace App\Http\Middleware;

use App\Helpers\JwtHelper;
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
        $jwt_token = $request->cookie('jwt_token');

        if(!JwtHelper::decode($jwt_token)){
            return response()->json([
                'status' => 'error',
                'message' => 'User\' unauthorized',
                'data'=>null,
            ]);
        }
        return $next($request);
    }
}
