<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;

class JwtAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            //check token validation    
            JWTAuth::parseToken()->authenticate();
            return $next($request);

        }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            //token invalid
            $message = 'invalid token';
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            //token gaada
            $message = 'need token';
        }
        return response()->json([
            'succes'=>false,
            'message'=>$message
        ]);
    }
}
