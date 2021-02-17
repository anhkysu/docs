<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cookie;
use \Firebase\JWT\JWT;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $dataResponseString)
    {
        $dataResponse = json_decode(str_replace("###", ",", $dataResponseString), true);
        $currentPath = request()->path();
        $navigationControlModel = new \App\Models\NavigationControl();
        $gates =  $navigationControlModel->selectAllActiveNavigationControl();
        foreach ($gates as $gateObj) {
            $gateName = $gateObj->attribute;
            $gateLink = substr($gateObj->link, 1); // Remove initial stash at gate link
            $gateLink = str_replace("/", "\/", $gateLink); // Escape / character in link to differentiate with delimiter in regex
            $checkRegex = '/^' . $gateLink . '/';
            if (preg_match($checkRegex, $currentPath) == 1) {
                if (Gate::denies($gateName)) {
                    return response(view('auth.unauthorized', $dataResponse));
                }
            }
        };
        return $next($request);
    }
}
