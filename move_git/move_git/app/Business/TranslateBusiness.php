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
class TranslateBusiness
{

    protected $_actor;
    protected $_time;

    public function __construct($actor = null, $time = null)
    {
        $this->_actor = $actor ?? 1;
        $this->_time = $time ?? new \DateTime('now');
    }

    public function getTranslateListData($conditions)
    {
        $translateData = new \App\Models\Translate();
        $data = $translateData->getTranslateDataList($conditions);
        
        return $data;
    }

    public function getTranslateItemData($id)
    {
        $translateData = new \App\Models\Translate();
        $data = $translateData->getTranslateDataItem($id);
        
        return $data;
    }

    public function createInputData($newInputData)
    {
        try{
           
        }catch(\App\Exceptions\ApiException $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function createOutputData($newOutputData)
    {
        try{
            
        }catch(\App\Exceptions\ApiException $e){
            DB::rollBack();
            throw $e;
        }
       
    }

    public function updateTranslateData($newTranslateData, $translateDataId)
    {
        try{
            DB::beginTransaction();
            $translateDataModel = new \App\Models\Translate();
            $translateDataObj = $translateDataModel::find($translateDataId);
            if(!($translateDataObj instanceof \App\Models\Translate)){
                throw new \App\Exceptions\ApiException("[NotFound][Translate] TranslateDataId# $translateDataId", Response::HTTP_NOT_FOUND);
            }
            $isUpdateInputDataType = isset($newTranslateData['inputData']['data_input_type']);
            if($isUpdateInputDataType){
                $inputDataObj = $translateDataObj->getInputData;
                if(!($inputDataObj instanceof \App\Models\InputData)){
                    throw new \App\Exceptions\ApiException("[NotFound][InputData] TranslateDataId# $translateDataId", Response::HTTP_NOT_FOUND);
                }
                $inputDataModel = new \App\Models\InputData();
                $inputDataModel->updateInputData($newTranslateData, $inputDataObj,$this->_actor, $this->_time);
                $translateDataModel->updateInputDataTranslate($newTranslateData['translateData'], $translateDataObj,$this->_actor, $this->_time);
            } else {
                $translateDataModel->updateOutputDataTranslate($newTranslateData['translateData'], $translateDataObj,$this->_actor, $this->_time);
            }
            DB::commit();
            
            return $newTranslateData;
        }catch(\App\Exceptions\ApiException $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteInputData($inputDataId)
    {
       
    }

    public function deleteOutputData($outputDataId)
    {
       
    }

    #Input Output Data <=> Du Lieu Input/Output
    public function getInputOutputDataList($projectId, $limit)
    {
        
    }

    public function validateTranslateData($translateData)
    {
       $msg = [];
       return $msg;
    }

    public function messageTranslateDataSuccessful($translateData)
    {
       $msg = [];
       return $msg;
    }

    private function _reconstructOutputData($newOutputData)
    {
       
    }

    private function _formatInputOutputData($ioData)
    {
       
    }

    private function _reconstructInputData($newInputData)
    {
       
    }
}
