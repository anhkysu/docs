<?php

namespace App\Business;

use DateTime;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 26/8/19
 * Time: 5:03 PM
 */
class WorkingTimeBusiness
{

    protected $_actor;
    protected $_time;

    public function __construct($actor = null, $time = null)
    {
        $this->_actor = $actor ?? 1;
        $this->_time = $time ?? new \DateTime('now');
    }

    public function addWorkingTimeList($workingTimeList)
    {
        try {
            DB::beginTransaction();
            $workingTimeModal = new \App\Models\WorkingTime();
            $workingTimeModal->insertWorkingTime($workingTimeList, $this->_actor, $this->_time);
            DB::commit();

            return true;
        } catch (\App\Exceptions\ApiException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateWorkingTime($newWorkingTimeData, $workingTimeId)
    {
        $workingTimeModel = new \App\Models\WorkingTime();
        $workingTimeObj = $workingTimeModel::find($workingTimeId);
        if(!($workingTimeObj instanceof \App\Models\WorkingTime)){
            throw new \App\Exceptions\ApiException("[NotFound][WorkingTime] Id# $workingTimeId", Response::HTTP_NOT_FOUND);
        };
        $newWorkingTimeData = $workingTimeModel->updateWorkingTime($newWorkingTimeData, $workingTimeObj, $this->_actor, $this->_time);
        
        return $newWorkingTimeData;
    }

    public function getWorkingTimeList($projectId, $limit = [])
    {
        $workingTimeModel = new \App\Models\WorkingTime();
        $workingTimeList = $workingTimeModel->selectWorkingTimeInProject($projectId, $limit);
        
        return $workingTimeList;
    }

    public function deleteWorkingTime($workingTimeId)
    {
        $errorMsg = [];       
        $workingTimeObj = \App\Models\WorkingTime::find($workingTimeId);
        if(!($workingTimeObj instanceof \App\Models\WorkingTime)){
            throw new \App\Exceptions\ApiException("[NotFound][WorkingTime] Id# $workingTimeId", Response::HTTP_NOT_FOUND);
        };
        if ($workingTimeObj->staff_id != $this->_actor) {
                $errorMsg[] = trans('working_time.messages.delete_working_time_not_granted');
        }
        if(empty($errorMsg)){
            $workingTimeObj->delete();
            return true;
        }

        return $errorMsg;
    }

    public function exportWorkingTime($projectId)
    {
        try{
            $sourcePath = public_path()."/MasterData/CONG_VIEC_THUC_HIEN.xlsx";
            $destinatePath = public_path() . "/../storage/export/CONG VIEC THUC HIEN $projectId.xlsx";
            //\App\Business\DirectoryBusiness::copy($sourcePath, $destinatePath);
            $workingTimeModel = new \App\Models\WorkingTime();
            $workingTimeList = $workingTimeModel->selectWorkingTimeInProject($projectId);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($sourcePath);
            $worksheet = $spreadsheet->getSheetByName('CONG VIEC THUC HIEN');
            $columns = [
                'B' => 'input_date', 
                'C' => 'short_name', 
                'D' => 'staff_id_string',  
                'E' => 'office_hour',  
                'F' => 'work_content',  
            ];

            $rowIndex = 2;
            foreach($workingTimeList as $workingTime){
                $worksheet->getCell("A$rowIndex")->setValue($rowIndex - 1);
                foreach($columns as $key => $value){
                    $cell = $key . $rowIndex;
                    $worksheet->getCell($cell)->setValue($workingTime->{$value});
                }
                $rowIndex++;
            }
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($destinatePath);

            return $destinatePath;
        }catch(\App\Exceptions\ApiException $e){

        }
        
    }

}
