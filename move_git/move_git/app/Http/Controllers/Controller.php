<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use \Firebase\JWT\JWT;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $dataResponse = array();

    public $timeRequest;

    protected $_actor;

    protected $_currentUser;

    protected $_currentUserNavigationControl;

    protected $_pageTitle;

    protected $exceptedMethods = [
        'loginAction',
        'credentialsAction'
    ];

    public function __construct()
    {
        $this->middleware('auth')->except($this->exceptedMethods);
        $this->timeRequest = new \DateTime('now');
        $time = new \DateTime('now');
        $time = $time->getTimestamp();
        $this->_init();
        $this->dataResponse['timeStampResponse'] = $time;
        $this->dataResponse['hash'] = $time;
        $this->dataResponse['pageTitle'] = $this->_pageTitle;
        $accessToken = Cookie::get('access_token');
        if($accessToken){
            $key = '0CbKsNMxTaqxXqjxBWrMi1CH7vTmUE1LbrMLEIzHYInfUi1bhoGbDDHgwOJREvHB';
            $decoded = JWT::decode($accessToken, $key, array('HS256'));
            $userLoginDataObj = \App\Models\UserLogin::getInstance($decoded);
            $userLoginData = $userLoginDataObj->getUserLoginData();            
            $this->_actor = $userLoginData->profile->user_application_id;
            $this->_currentUser = $userLoginData->profile;
            $this->_currentUserNavigationControl = $userLoginData->navigation_control;
        }
        $this->dataResponse['currentUser'] =  $this->_currentUser;
        $this->dataResponse['currentUserNavigationControl'] =  $this->_currentUserNavigationControl;
        $dataResponseString = str_replace(",", "###", json_encode($this->dataResponse));
        $this->middleware('authorize:'.$dataResponseString)->except($this->exceptedMethods);
    }

    abstract function _init();
}
