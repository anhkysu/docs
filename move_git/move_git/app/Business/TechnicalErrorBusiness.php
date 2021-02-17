<?php

namespace App\Business;

use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 26/8/19
 * Time: 5:03 PM
 */
class TechnicalErrorBusiness
{

    protected $_actor;
    protected $_time;

    public function __construct($actor = null, $time = null)
    {
        $this->_actor = $actor ?? 1;
        $this->_time = $time ?? new \DateTime('now');
    }

    public function getOutputDataLinkList($projectId){
        $technicalErrorModal = new \App\Models\TechnicalError();
        $data = $technicalErrorModal->getOutputDataLinkList($projectId);

        return $data;
    }

    public function addTechnicalErrorList($technicalErrorList)
    {
        try {
            DB::beginTransaction();
            $technicalErrorModal = new \App\Models\TechnicalError();
            $technicalErrorModal->insertTechnicalError($technicalErrorList, $this->_actor, $this->_time);
            DB::commit();

            return true;
        } catch (\App\Exceptions\ApiException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateTechnicalError($newTechnicalErrorData, $technicalErrorId)
    {
        $technicalErrorModel = new \App\Models\TechnicalError();
        $technicalErrorObj = $technicalErrorModel::find($technicalErrorId);
        if(!($technicalErrorObj instanceof \App\Models\TechnicalError)){
            throw new \App\Exceptions\ApiException("[NotFound][TechnicalError] Id# $technicalErrorId", Response::HTTP_NOT_FOUND);
        };
        $newTechnicalErrorData = $technicalErrorModel->updateTechnicalError($newTechnicalErrorData, $technicalErrorObj, $this->_actor, $this->_time);
        $newTechnicalErrorData['input_date'] = $this->_time;
        return $newTechnicalErrorData;
    }

    public function getTechnicalErrorList($projectId, $limit = [])
    {
        $technicalErrorModel = new \App\Models\TechnicalError();
        $technicalErrorList = $technicalErrorModel->selectTechnicalErrorInProject($projectId, $limit);
        
        return $technicalErrorList;
    }

    public function deleteTechnicalError($technicalErrorId)
    {
        $errorMsg = [];       
        $technicalErrorObj = \App\Models\TechnicalError::find($technicalErrorId);
        if(!($technicalErrorObj instanceof \App\Models\TechnicalError)){
            throw new \App\Exceptions\ApiException("[NotFound][TechnicalError] Id# $technicalErrorId", Response::HTTP_NOT_FOUND);
        };
        if ($technicalErrorObj->violator != $this->_actor) {
                $errorMsg[] = trans('technical_error.messages.delete_technical_error_not_granted');
        }
        if(empty($errorMsg)){
            $technicalErrorObj->delete();
            return true;
        }

        return $errorMsg;
    }

    public function exportTechnicalError($projectId)
    {
        try{
            $sourcePath = public_path()."/MasterData/LOI_KY_THUAT.xlsx";
            $destinatePath = public_path() . "/../storage/export/LOI KY THUAT $projectId.xlsx";
            //\App\Business\DirectoryBusiness::copy($sourcePath, $destinatePath);
    
            $technicalErrorModel = new \App\Models\TechnicalError();
            $technicalErrorList = $technicalErrorModel->selectTechnicalErrorInProject($projectId);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($sourcePath);
            $worksheet = $spreadsheet->getSheetByName('LOI KY THUAT');
            $columns = [
                'B' => 'discoverer', 
                'C' => 'type_of_work', 
                'D' => 'error_group',  
                'E' => 'error_id_string',  
                'F' => 'error_content',  
                'G' => 'times',  
                'H' => 'violator_staff_id',  
                'I' => 'violator_short_name',  
                'J' => 'output_data_path',  
                'K' => 'input_date',  
                'M' => 'check_date',  
            ];

            $rowIndex = 2;
            foreach($technicalErrorList as $technicalError){
                $worksheet->getCell("A$rowIndex")->setValue($rowIndex - 1);
                foreach($columns as $key => $value){
                    $cell = $key . $rowIndex;
                    $worksheet->getCell($cell)->setValue($technicalError->{$value});
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
