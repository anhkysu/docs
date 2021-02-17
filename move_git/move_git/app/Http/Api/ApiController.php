<?php

namespace App\Http\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $dataResponse = [];

    public $message = [];

    public $error = [];

    public $timeRequest;

    public $codeResponse;

    public $actor;

    public function __construct()
    {
        $this->middleware('api.auth');
        $this->timeRequest = new \DateTime('now');
        $time = new \DateTime('now');
        $time = $time->getTimestamp();
        $this->dataResponse['timeStampResponse'] = $time;
        $this->dataResponse['hash'] = $time;
        $this->codeResponse = 200;
        $accessToken = Cookie::get('access_token');
        if(!$accessToken){
            return response()->json([
                'data' => null,
                'error' => 'Unauthenticated.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $key = '0CbKsNMxTaqxXqjxBWrMi1CH7vTmUE1LbrMLEIzHYInfUi1bhoGbDDHgwOJREvHB';
        $decoded = JWT::decode($accessToken, $key, array('HS256'));
        $userLoginDataObj = \App\Models\UserLogin::getInstance($decoded);
        $userLoginData = $userLoginDataObj->getUserLoginData();
        if(!empty($userLoginData)){
            $this->actor = $userLoginData->profile->user_application_id;
        }
    }
}
