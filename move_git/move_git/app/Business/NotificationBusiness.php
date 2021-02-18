<?php

namespace App\Business;

use Illuminate\Support\Facades\DB;
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 26/8/19
 * Time: 5:03 PM
 */
class NotificationBusiness
{

    protected $_actor;
    protected $_time;

    public function __construct($actor = null, $time = null)
    {
        $this->_actor = $actor ?? 1;
        $this->_time = $time ?? new \DateTime('now');
    }

    #Joint Staff <=> Thanh Vien Tab
    public function getNotificationDataToTranslators()
    {
        try {
            
            return 'some data';
        } catch (\App\Exceptions\ApiException $e) {
            
            throw $e;
        }
    }

    public function getNotificationDataToProjectMember()
    {
        try {
            
            return 'some data to project member';
        } catch (\App\Exceptions\ApiException $e) {
            
            throw $e;
        }
    }

    public function getNotificationDataToManagers()
    {
        try {
            
            return 'some data';
        } catch (\App\Exceptions\ApiException $e) {
            
            throw $e;
        }
    }
}
