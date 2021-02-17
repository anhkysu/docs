<?php

namespace App\Business;

use Illuminate\Support\Facades\DB;
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 26/8/19
 * Time: 5:03 PM
 */
class JointStaffBusiness
{

    protected $_actor;
    protected $_time;

    public function __construct($actor = null, $time = null)
    {
        $this->_actor = $actor ?? 1;
        $this->_time = $time ?? new \DateTime('now');
    }

    #Joint Staff <=> Thanh Vien Tab
    public function addJointStaffList($newStaffList, $projectId)
    {
        try {
            DB::beginTransaction();
            $jointStaffModel = new \App\Models\JointStaff();
            $jointStaffModel->insertBulkJointStaff($newStaffList, $projectId);
            DB::commit();

            return true;
        } catch (\App\Exceptions\ApiException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getJointStaffList($projectId)
    {
        $jointStaffModel = new \App\Models\JointStaff();
        $jointStaffList = $jointStaffModel->selectJointStaffInProject($projectId);

        return $jointStaffList;
    }

    public function deleteJointStaff($idJointStaff)
    {
        try{
            $jointStaffObj = \App\Models\JointStaff::find($idJointStaff);
            if($jointStaffObj instanceof \App\Models\JointStaff){
                $jointStaffObj->delete();
            }
            return true;
        }catch(\App\Exceptions\ApiException $e){
            throw $e;
        }
        
    }
}
