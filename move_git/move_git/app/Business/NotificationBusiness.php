<?php

namespace App\Business;

use Illuminate\Support\Facades\DB;
use stdClass;

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

    public function getNotifInputData($newInputData, $inputDataObj, $translateObj, $method)
    {
        try {
            $notifDataToTranslators = $this->getNotificationDataToTranslators($newInputData, $inputDataObj, $translateObj, $method);
            $notifDataToProjectMembers = $this->getNotificationDataToProjectMembers($newInputData, $inputDataObj, $translateObj, $method);

            return array($notifDataToTranslators, $notifDataToProjectMembers);
        } catch (\App\Exceptions\ApiException $e) {
            
            throw $e;
        }
    }

    public function getNotifOutputData($newOutputData, $outputDataObj, $translateObj, $method)
    {
        try {
            $notifDataToTranslators = $this->getNotificationDataToTranslators($newOutputData, $outputDataObj, $translateObj, $method);
            $notifDataToManagers = $this->getNotificationDataToManagers($newOutputData, $outputDataObj, $translateObj, $method);

            return array($notifDataToTranslators);
        } catch (\App\Exceptions\ApiException $e) {
            
            throw $e;
        }
    }

    public function getNotificationDataToTranslators($newIOData, $ioDataObj, $translateObj, $method)
    {
        try {
            if($this->_actor == $newIOData['translator_suggested']){
                return;
            }
            $notifDataObj = new \stdClass();
            $notifDataObj->source_table = "translate";
            $notifDataObj->data_id = $newIOData['translate_id'];
            $notifDataObj->sender = $this->_actor;
            $notifDataObj->action = null;
            $notifDataObj->content = \App\Constants\Notification::CONTENT_TRANSLATE;
            $userApplicationModel = new \App\Models\UserApplication();
            $notifDataObj->receiverList = $userApplicationModel->selectUserById($newIOData['translator_suggested']);
 
            if($method == \App\Constants\Notification::METHOD_CREATE){
                $notifDataObj->action = \App\Constants\Notification::MSG_CREATE;
            } else if($method == \App\Constants\Notification::METHOD_UPDATE){
                if($newIOData['staff_data_status'] == \App\Constants\ProjectManagement::IO_STAFF_DATA_STATUS_IN_PROGRESS_ID){
                    $notifDataObj->action = \App\Constants\Notification::MSG_CREATE_OR_UPDATE;
                }
                if($newIOData['staff_data_status'] == \App\Constants\ProjectManagement::IO_STAFF_DATA_STATUS_FINISHED_ID){
                    if($newIOData['original_mail'] != $translateObj->original_mail || $newIOData['translated_mail'] != $translateObj->translated_mail){
                        $notifDataObj->action = \App\Constants\Notification::MSG_MANAGER_OR_STAFF_CHANGE_MAIL_CONTENT;
                    }
                }
            }

            return $notifDataObj;
        } catch (\App\Exceptions\ApiException $e) {
            
            throw $e;
        }
    }

    public function getNotificationDataToProjectMembers($newIOData, $ioDataObj, $translateObj, $method)
    {
        try {
            $notifDataObj = new \stdClass();
            $notifDataObj->source_table = "translate";
            $notifDataObj->data_id = $newIOData['translate_id'];
            $notifDataObj->sender = $this->_actor;
            $notifDataObj->content = \App\Constants\Notification::CONTENT_QLDA_INPUT_DATA;
            $notifDataObj->action = null;
            $jointStaffModel = new \App\Models\JointStaff();
            $jointStaffList = $jointStaffModel->selectJointStaffInProject($newIOData['project_id']);
            $notifDataObj->receiverList =  array_values(array_filter($jointStaffList, function($v, $k){
                return $v->ua_id != $this->_actor;
            }, ARRAY_FILTER_USE_BOTH));
            // Nhớ loại bỏ các attributes thừa trong jointStaffList, chỉ lấy ua_id, user_uuid

            if($method == \App\Constants\Notification::METHOD_CREATE){
                $notifDataObj->action = \App\Constants\Notification::MSG_CREATE;
            } else if($method == \App\Constants\Notification::METHOD_UPDATE){
                $notifDataObj->action = \App\Constants\Notification::MSG_UPDATE;
            }

            return $notifDataObj;
        } catch (\App\Exceptions\ApiException $e) {
            
            throw $e;
        }
    }

    public function getNotificationDataToManagers($newIOData, $ioDataObj, $translateObj, $method)
    {
        try {
            $notifDataObj = new \stdClass();
            $notifDataObj->source_table = "translate";
            $notifDataObj->data_id = $newIOData['translate_id'];
            $notifDataObj->sender = $this->_actor;
            $notifDataObj->content = \App\Constants\Notification::CONTENT_QLDA_OUTPUT_DATA;
            $notifDataObj->action = null;
            if($method == \App\Constants\Notification::METHOD_CREATE){
                $notifDataObj->action = \App\Constants\Notification::MSG_CREATE;
            } else if($method == \App\Constants\Notification::METHOD_UPDATE){
                $notifDataObj->action = \App\Constants\Notification::MSG_UPDATE;
            }
            $projectInfomation = \App\Models\ProjectInformation::find($newIOData['project_id']);
            if(!($projectInfomation instanceof \App\Models\ProjectInformation)){
                throw new \App\Exceptions\ApiException("[NotFound][Project] Id# $projectId", Response::HTTP_NOT_FOUND);
            }
            $teamManagerObj = $projectInfomation->getTeamManager();
            if($teamManagerObj)
            $projectManagerObj = $projectInfomation->getProjectManager();

            return $notifDataObj;
        } catch (\App\Exceptions\ApiException $e) {
            
            throw $e;
        }
    }
}
