<?php

namespace App\Business;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 26/8/19
 * Time: 5:03 PM
 */
class QuotationTimeBusiness
{

    protected $_actor;
    protected $_time;

    public function __construct($actor = null, $time = null)
    {
        $this->_actor = $actor ?? 1;
        $this->_time = $time ?? new \DateTime('now');
    }

    public function importQuotationTime($quotationTimeImportList)
    {
        $quotationTimeImportList = $this->_formatQuotationTimeImport($quotationTimeImportList);
        $quotationTimeInsertingList = [];
        $quotationTimeUpdatingList = [];
        $quotationTimeDeletingList = [];
        foreach($quotationTimeImportList as $quotationTimeImport){
            switch($quotationTimeImport['action']){
                case \App\Constants\DropdownLabel::ACTION_INSERT:
                    $quotationTimeInsertingList[] = $quotationTimeImport;
                break;
                case \App\Constants\DropdownLabel::ACTION_UPDATE:
                    $quotationTimeUpdatingList[] = $quotationTimeImport;
                break;
            }
        }
        try {
            DB::beginTransaction();
            $this->quotationTimeInsertingList($quotationTimeInsertingList);
            $this->quotationTimeUpdatingList($quotationTimeUpdatingList);
            $this->quotationTimeDeletingList($quotationTimeDeletingList);
            DB::commit();

            return true;
        } catch (\App\Exceptions\ApiException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    #Joint Staff <=> Thanh Vien Tab
    public function addQuotationTimeList($quotationTimeList)
    {
        try {
            DB::beginTransaction();
            $quotationReallyTimeModel = new \App\Models\QuotationReallyTime();
            $quotationReallyTimeModel->insertBulkQuotatinReallyTime($quotationTimeList, $this->_actor, $this->_time);
            DB::commit();

            return true;
        } catch (\App\Exceptions\ApiException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function quotationTimeInsertingList($quotationTimeList)
    {
        $quotationReallyTimeModel = new \App\Models\QuotationReallyTime();
        $quotationReallyTimeModel->insertBulkQuotatinReallyTime($quotationTimeList, $this->_actor, $this->_time);
    }

    public function quotationTimeUpdatingList($quotationTimeList)
    {
        
    }

    public function quotationTimeDeletingList($quotationTimeList)
    {

    }

    public function getQuotationTimeList($projectId, $limit = [], $search)
    {
        $quotationReallyTimeModel = new \App\Models\QuotationReallyTime();
        $quotationTimeList = $quotationReallyTimeModel->selectQuotationTimeInProject($projectId, $limit, $search);
        $quotationTimeList = $this->_formatQuotationTime($quotationTimeList);
        return $quotationTimeList;
    }

    public function updateQuotationTime($newQuotationTimeData, $quotationTimeId)
    {
        $quotationReallyTimeModel = new \App\Models\QuotationReallyTime();
        $quotationReallyTimeObj = $quotationReallyTimeModel::find($quotationTimeId);
        if(!($quotationReallyTimeObj instanceof \App\Models\QuotationReallyTime)){
            throw new \App\Exceptions\ApiException("[NotFound][QuotationReallyTime] Id# $quotationTimeId", Response::HTTP_NOT_FOUND);
        };
        $newQuotationTimeData = $quotationReallyTimeModel->updateQuotationTime($newQuotationTimeData, $quotationReallyTimeObj, $this->_actor, $this->_time);
        
        return $newQuotationTimeData;
    }

    public function deleteQuotationTime($quotationTimeId)
    {
        $errorMsg = [];
        $quotationReallyTimeObj = \App\Models\QuotationReallyTime::find($quotationTimeId);
        if (!($quotationReallyTimeObj instanceof \App\Models\QuotationReallyTime)) {
            throw new \App\Exceptions\ApiException("[NotFound][QuotationReallyTime] Id# $quotationTimeId", Response::HTTP_NOT_FOUND);
        }
        $projectObj = $quotationReallyTimeObj->getProject;
        if (!($projectObj instanceof \App\Models\ProjectInformation)) {
            throw new \App\Exceptions\ApiException("[NotFound][ProjectInformation] InputDataId# $quotationTimeId", Response::HTTP_NOT_FOUND);
        }
        if ($projectObj->team_manager != $this->_actor || $projectObj->project_manager != $this->_actor) {
                $errorMsg[] = trans('quotation_time.messages.delete_quotation_time_not_granted');
            }
        if($quotationReallyTimeObj->confirm){
            $errorMsg[] = trans('quotation_time.messages.cannot_delete_confirmed_quotation_time');
        }
        if(empty($errorMsg)){
            $quotationReallyTimeObj->delete();
            return true;
        }
        return $errorMsg;
    }

    public function exportQuotationTime($projectId)
    {
        try{
            $sourcePath = public_path()."/MasterData/BAO_GIA.xlsx";
            $destinatePath = public_path() . "/../storage/export/BAO GIO $projectId.xlsx";
            //\App\Business\DirectoryBusiness::copy($sourcePath, $destinatePath);
    
            $quotationReallyTimeModel = new \App\Models\QuotationReallyTime();
            $quotationTimeList = $quotationReallyTimeModel->selectQuotationTimeInProject($projectId);
            $quotationTimeList = $this->_formatQuotationTimeForExporting($quotationTimeList);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($sourcePath);
            $worksheet = $spreadsheet->getSheetByName('BAO GIO');
            $columns = [
                'B' => 'working_factor', 
                'C' => 'unit', 
                'D' => 'dwg_name',  
                'E' => 'estimate_time',  
                'F' => 'factor',  
                'G' => 'really_draw_time',  
                'H' => 'really_check_time',  
                'I' => 'finish_draw_date',  
                'J' => 'drawing_staff_id',  
                'K' => 'drawing_staff_name',  
                'M' => 'finish_draw_date',  
                'N' => 'checking_staff_id',  
                'O' => 'checking_staff_name',  
                'Q' => 'note',  
                'R' => 'id'
            ];
            $rowIndex = 2;
            foreach($quotationTimeList as $quotationTime){
                foreach($columns as $key => $value){
                    $cell = $key . $rowIndex;
                    $worksheet->getCell($cell)->setValue($quotationTime->{$value});
                }
                $rowIndex++;
            }
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($destinatePath);

            return $destinatePath;
        }catch(\App\Exceptions\ApiException $e){

        }
        
    }

    private function _formatQuotationTime($quotationTimeList)
    {
        foreach($quotationTimeList as $quotationTime){
            $quotationTime->checking_time = (float)round(($quotationTime->factor * $quotationTime->estimate_time), 2);
            $quotationTime->drawing_time = (float)round(((1-$quotationTime->factor) * $quotationTime->estimate_time), 2);
            $quotationTime->checking_time = sprintf('%0.2f', $quotationTime->checking_time); 
            $quotationTime->drawing_time = sprintf('%0.2f', $quotationTime->drawing_time); 
            $quotationTime->factor = sprintf('%0.1f', $quotationTime->factor);
        }

        return $quotationTimeList;
    }

    private function _formatQuotationTimeForExporting($quotationTimeList)
    {
        foreach($quotationTimeList as $quotationTime){
            $quotationTime->checking_time = (float)round(($quotationTime->factor * $quotationTime->estimate_time), 2);
            $quotationTime->drawing_time = (float)round(((1-$quotationTime->factor) * $quotationTime->estimate_time), 2);
            $quotationTime->checking_time = sprintf('%0.2f', $quotationTime->checking_time); 
            $quotationTime->drawing_time = sprintf('%0.2f', $quotationTime->drawing_time); 
            $quotationTime->factor = sprintf('%0.1f', $quotationTime->factor);
        }

        return $quotationTimeList;
    }

    private function _formatQuotationTimeImport($quotationTimeImportList)
    {
        $dropdownLabelModel = new \App\Models\DropdownLabel();
        $workingFactorList = $dropdownLabelModel->indexSelectListByGroupByLabel(\App\Constants\DropdownLabel::WORKING_FACTOR_GROUP);
        $staffIdListTaken = [];
        foreach($quotationTimeImportList as $quotationTimeImport){
            $staffIdListTaken[] = $quotationTimeImport['drawing_staff_id'];
            $staffIdListTaken[] = $quotationTimeImport['checking_staff_id'];
        }
        $staffIdListTaken = array_unique($staffIdListTaken);
        $userApplicationModel = new \App\Models\UserApplication();
        $userStaffIdListTaken = $userApplicationModel->selectUserListByStaffIdListAndIndexByStaffId($staffIdListTaken);
        foreach($quotationTimeImportList as &$quotationTimeImport){
            if(isset($userStaffIdListTaken[$quotationTimeImport['drawing_staff_id']])){
                $quotationTimeImport['drawing_staff_id'] = $userStaffIdListTaken[$quotationTimeImport['drawing_staff_id']]->id;
            }
            if(isset($userStaffIdListTaken[$quotationTimeImport['checking_staff_id']])){
                $quotationTimeImport['checking_staff_id'] = $userStaffIdListTaken[$quotationTimeImport['checking_staff_id']]->id;
            }
            if(isset($workingFactorList[$quotationTimeImport['working_factor']])){
                $quotationTimeImport['working_factor'] = $workingFactorList[$quotationTimeImport['working_factor']]->id;
            }
        }

        return $quotationTimeImportList;
    }
}
