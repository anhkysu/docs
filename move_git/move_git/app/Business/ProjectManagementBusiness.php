<?php

namespace App\Business;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 26/8/19
 * Time: 5:03 PM
 */
class ProjectManagementBusiness
{
    protected $_actor;
    protected $_time;

    public function __construct($actor = null, $time = null)
    {
        $this->_actor = $actor ?? 1;
        $this->_time = $time ?? new \DateTime('now');
    }

    public function getProjectInformationById($projectId)
    {
        $projectInformationModel = new \App\Models\ProjectInformation();
        $projectInfoObj = \App\Models\ProjectInformation::find($projectId);
        if(!($projectInfoObj instanceof \App\Models\ProjectInformation)){
            throw new \App\Exceptions\ApiException("[NotFound][Project] Id# $projectId", Response::HTTP_NOT_FOUND);
        };
        
        return $projectInfoObj;
    }

    #Project Information <=> Thong Tin Du An Tab
    public function updateProjectInformation($newProjectInformationData, $projectId = 0)
    {
        // should store historical data
        $projectInformationModel = new \App\Models\ProjectInformation();
        $updateProjectInfoObj = \App\Models\ProjectInformation::find($projectId);
        if(!($updateProjectInfoObj instanceof \App\Models\ProjectInformation)){
            throw new \App\Exceptions\ApiException("[NotFound][Project] Id# $projectId", Response::HTTP_NOT_FOUND);
        };
        $projectInformationModel->updateProjectInformation($newProjectInformationData, $updateProjectInfoObj, $this->_actor, $this->_time);

        return true;
    }

    public function getProjectInformations($conditions)
    {
        $projectInformationModel = new \App\Models\ProjectInformation();
        $projectInformationList = $projectInformationModel->selectProjectInformations($conditions, $this->_actor);
        foreach($projectInformationList as $projectInformation){
            $this->_formatProjectInformation($projectInformation);
        }

        return $projectInformationList;
    }

    public function validateProjectInformation($projectData)
    {
        // YYYY\KhanhHang\KhachHangYYMM\KhachHangYYMM-STT OF Month
        $now = new \DateTime('now');
        $dateString = date_format($now,"Y-m");
        $YYYY = date_format($now,"Y");
        $YY = date_format($now,"y");
        $mm = date_format($now,"m");
        
        $msg = [];
        $projectPath = $projectData['project_path'];
        if(!DirectoryBusiness::exists($projectPath)) {
            $msg[] = trans('projectmng.messages.path_error');
        }
        if($projectPath && !$projectData['id']){
            $projectInformationModel = new \App\Models\ProjectInformation();
            $projectInformationList = $projectInformationModel->selectCustomerHasProjectInformationByMonth($projectData['customer_id'], $dateString);
            $stt = (string)(count($projectInformationList) + 1);
            $customerName = $projectData['customer_name'];
            switch(strlen($stt)){
                case 1: 
                    $stt = "00$stt";
                break;
                case 2: 
                    $stt = "0$stt";
                break;
                default:
                $stt = $stt;
            }
            $validPath = "$YYYY\\$customerName\\$customerName$YY$mm\\$customerName$YY$mm-$stt";
            if(strpos($projectPath, $validPath) == false){
                $msg[] = trans('projectmng.messages.path_project_invalid');
            }
        }

        return $msg;
    }
    public function createProject($projectData)
    {
        try{
            DB::beginTransaction();
            // Step 1: Create a new customer if it is not existing

            // Step 2: Create a new project information, checking if it is existing, then throwing it if being existed.
            $projectInformationModel = new \App\Models\ProjectInformation();
            $projectInformationObj = $projectInformationModel->insertProjectInformation($projectData, $this->_actor, $this->_time);
            $errMsg = 'Dường như mã dự án đã tồn tại, vui lòng kiểm tra lại';

            if($projectInformationObj instanceof \App\Models\ProjectInformation && $projectInformationObj->id){
                $projectId = $projectInformationObj->id;
                // Step 3: Create a Total Hour as Placeholder for this project, using for Madoguchi Confirmation
                $totalHourModel = new \App\Models\TotalHour();
                $totalHourModel->insertTotalHour($projectId);

                // Step 4: Create Folder and copy base files to it

                // Step 5: Insert JointStaff to Project
                $jointStaffModel = new \App\Models\JointStaff();
                $projectData['jointStaffList'][] = $projectData['admin']['project_manager'];
                $jointStaffModel->insertBulkJointStaff($projectData['jointStaffList'], $projectId);

                // Step 6: Notify Project Manger / Team Manager
            }
            DB::commit();

            return $projectId;
        }catch(\App\Exceptions\ApiException $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function _formatProjectInformation($projectInformation)
    {
        if(!empty($projectInformation->start_date)){
            $projectInformation->start_date =  strftime('%Y-%m-%dT%H:%M:%S', strtotime($projectInformation->start_date));
        }
        if(!empty($projectInformation->finish_date)){
            $projectInformation->finish_date =  strftime('%Y-%m-%dT%H:%M:%S', strtotime($projectInformation->finish_date));
        }
    }
}