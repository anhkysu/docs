<?php

namespace App\Models;

class UserLogin
{
    private static $_instance;
    private $userLoginData;

    private function __construct($userLoginData)
    {
        if(!isset($userLoginData)){
            $userLoginData = new \stdClass();
        }
        $this->userLoginData = $userLoginData;
    }

    public static function getInstance($userLoginData = null)
    {
        if(!isset(self::$_instance)){
            self::$_instance = new UserLogin($userLoginData);
        }
        return self::$_instance;
    }

    public function getUserLoginData()
    {
        return $this->userLoginData;
    }
}
