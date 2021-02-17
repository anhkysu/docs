<?php

namespace App\Http\Middleware;

use Closure;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userLoginDataObj = \App\Models\UserLogin::getInstance();
        $userLoginData = $userLoginDataObj->getUserLoginData();
        if(empty($userLoginData->profile)){
            return response()->json([
                'data' => null,
                'error' => 'Unauthenticated.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
