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
class InputOutputDataBusiness
{

    protected $_actor;
    protected $_time;

    public function __construct($actor = null, $time = null)
    {
        $this->_actor = $actor ?? 1;
        $this->_time = $time ?? new \DateTime('now');
    }

    public function getLoadData($projectId = 0)
    {
        $projectInfomation = \App\Models\ProjectInformation::find($projectId);
        if(!($projectInfomation instanceof \App\Models\ProjectInformation)){
            throw new \App\Exceptions\ApiException("[NotFound][Project] Id# $projectId", Response::HTTP_NOT_FOUND);
        }
        $teamManagerObj = $projectInfomation->getTeamManager();
        $projectManagerObj = $projectInfomation->getProjectManager();
        $jointStaffModel = new \App\Models\JointStaff();
        $jointStaffList = $jointStaffModel->selectJointStaffInProject($projectId);
        $userApplicationModel = new \App\Models\UserApplication();
        $translatorList = $userApplicationModel->selectTranslatorList();
        array_unshift($translatorList, $teamManagerObj);
        array_unshift($jointStaffList, $projectManagerObj);

        return compact(
            'jointStaffList',
            'translatorList'
        );
    }

    public function createInputData($newInputData)
    {
        try{
            $newInputData = $this->_reconstructInputData($newInputData);
            DB::beginTransaction();
            // Step 1: Insert a new InputData
            $inputDataModel = new \App\Models\InputData();
            $inputDataObj = $inputDataModel->insertInputData($newInputData, $this->_actor, $this->_time);
            if($inputDataObj instanceof \App\Models\InputData && $inputDataObj->id){
                $inputDataId = $inputDataObj->id;
                $newInputData['id'] = $inputDataId;
                $newInputData['input_data_id'] = $inputDataId;
                $newInputData['data_type'] = \App\Constants\DropdownLabel::IO_DATA_TYPE_INPUT_ID;
                // Step 2: Insert Translate for this InputData
                $translateModel = new \App\Models\Translate();
                $newTranslateObj = $translateModel->insertInputDataTranslate($newInputData, $this->_actor, $this->_time);
                if($newTranslateObj instanceof \App\Models\Translate && $newTranslateObj->id){
                    $newInputData['translate_id'] = $newTranslateObj->id;
                }
            }
            DB::commit();

            return $newInputData;
        }catch(\App\Exceptions\ApiException $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function createOutputData($newOutputData)
    {
        try{
            $newOutputData = $this->_reconstructOutputData($newOutputData);
            DB::beginTransaction();
            // Step 1: Insert a new InputData
            $outputDataModel = new \App\Models\OutputData();
            $outputDataObj = $outputDataModel->insertOutputData($newOutputData, $this->_actor, $this->_time);
            if($outputDataModel instanceof \App\Models\OutputData && $outputDataObj->id){
                $outputDataId = $outputDataObj->id;
                $newOutputData['output_data_id'] = $outputDataId;
                $newOutputData['data_type'] = \App\Constants\DropdownLabel::IO_DATA_TYPE_OUTPUT_ID;
                // Step 2: Insert Translate for this OutputData
                $translateModel = new \App\Models\Translate();
                $newTranslateObj = $translateModel->insertOutputDataTranslate($newOutputData, $this->_actor, $this->_time);
                if($newTranslateObj instanceof \App\Models\Translate && $newTranslateObj->id){
                    $newOutputData['translate_id'] = $newTranslateObj->id;
                }
            }
            DB::commit();

            return $newOutputData;
        }catch(\App\Exceptions\ApiException $e){
            DB::rollBack();
            throw $e;
        }
        /*try
        {
            string id = fNhapFile.cbxLoaiOutput.SelectedValue.ToString();
            if (CheckData())
            {
                string ngayGui = fNhapFile.dtpkrNgayGui.Value.ToString();
                string MSNV = fNhapFile.cbxMSNV.Text;
                string path = fNhapFile.tbxLinkDuLieu.Text;

                string typeofDataID = fNhapFile.cbxLoaiOutput.SelectedValue.ToString();
                string subjectMail = fNhapFile.cbxSubjectMail.Text;
                string translatorSuggest = fNhapFile.cbxPDID.Text == "" ? null : fNhapFile.cbxPDID.Text;
                int uuTien = fNhapFile.chbxUuTienDich.Checked ? 1 : 0;
                string mailcandich = fNhapFile.tbxNDGKHTV.Text == "" ? null : fNhapFile.tbxNDGKHTV.Text;
                string maildich = fNhapFile.tbxDNDGKH.Text == "" ? null : fNhapFile.tbxDNDGKH.Text;
                string mailGoc = fNhapFile.tbxMailGoc.Text == "" ? null : fNhapFile.tbxMailGoc.Text;
                IDTTTH = fNhapFile.cbxTTTH.SelectedValue.ToString();
                string outputDataID = null;

                if (Variables.isNhapFileOutput)
                {
                    ViewModels_FNhapFileOutput.Instance.InsertOutputData(ngayGui, datastatus,
                        MSNV, path, null, null, null, null, Variables.projectInformation.ProjectID, mailGoc, typeofDataID, subjectMail, IDTTTH);

                    //Insert Translate                           
                    DataTable dataOutputDataID = ViewModels_FNhapFileOutput.Instance.GetOutputDataIDByNgayGuiandMSNV(ngayGui, MSNV);
                    if (dataOutputDataID.Rows.Count > 0)
                    {
                        outputDataID = dataOutputDataID.Rows[0][0].ToString();
                    }
                    ViewModels_FNhapFileOutput.Instance.InsertTranslate(2, translateStatus, null, outputDataID, mailcandich, maildich, uuTien, translatorSuggest);

                    MessageBox.Show("Đã thêm 1 dữ liệu Output thành công", "Completed", MessageBoxButtons.OK, MessageBoxIcon.Asterisk, MessageBoxDefaultButton.Button1);
                }
                else
                {
                    outputDataID = Variables.iDOutputData;
                    if ((!oldMailOrigi.Equals(mailcandich) || !oldMailTrans.Equals(maildich)) && !fNhapFile.cbxPDID.Text.Equals(Variables.accountInfor.StaffID))
                    {
                        translateStatus = 1;
                        if (IDTTTH == "3")
                        {
                            IDTTTH = "2";
                        }
                    }
                    ViewModels_FNhapFileOutput.Instance.UpdateOutputData(outputDataID, ngayGui, datastatus, MSNV, path, mailGoc, typeofDataID, subjectMail, IDTTTH);

                    ViewModels_FNhapFileOutput.Instance.UpdateTranslate(outputDataID, translateStatus, mailcandich, maildich, uuTien, translatorSuggest);

                    MessageBox.Show("Đã chỉnh sửa 1 dữ liệu Output thành công", "Completed", MessageBoxButtons.OK, MessageBoxIcon.Asterisk, MessageBoxDefaultButton.Button1);
                }
                //Insert Notifications                 
                string idTranslate = ViewModels_FNhapFileOutput.Instance.GetIDTranslateByOutputID(outputDataID).Rows[0][0].ToString();
                //Gửi thông báo đến phiên dịch
                if (Variables.isNhapFileOutput)
                {
                    if (IDTTTH.Equals("2"))
                    {
                        if (!translatorSuggest.Equals(Variables.accountInfor.StaffID))
                        {
                            ViewModels_FNhapFileOutput.Instance.InsertNotifications(DateTime.Now.ToString(), Variables.accountInfor.StaffID,
                    translatorSuggest, "Translate", idTranslate, "PhienDich", "Thêm Mới");

                            var message = "Thêm Mới";
                            var routingKey = translatorSuggest;

                            RabbitMQClient.send(routingKey, message);
                        }
                    }
                }
                else
                {
                    if (!translatorSuggest.Equals(Variables.accountInfor.StaffID))
                    {
                        if (IDTTTH.Equals("2"))
                        {
                            ViewModels_FNhapFileOutput.Instance.InsertNotifications(DateTime.Now.ToString(), Variables.accountInfor.StaffID,
                    translatorSuggest, "Translate", idTranslate, "PhienDich", "Thêm mới hoặc chỉnh sửa");
                            
                            var message = "Thêm mới hoặc chỉnh sửa";
                            var routingKey = translatorSuggest;

                            RabbitMQClient.send(routingKey, message);
                        }

                        if (IDTTTH.Equals("3"))
                        {
                            if (!oldMailOrigi.Equals(mailcandich) || !oldMailTrans.Equals(maildich))
                            {
                                ViewModels_FNhapFileOutput.Instance.InsertNotifications(DateTime.Now.ToString(), Variables.accountInfor.StaffID,
                    translatorSuggest, "Translate", idTranslate, "PhienDich", "Quản Lý Hoặc Người Làm Thay Đổi Nội Dung Mail");

                                var message = "Quản Lý Hoặc Người Làm Thay Đổi Nội Dung Mail";
                                var routingKey = translatorSuggest;
                                if (!MSNV.Equals(Variables.accountInfor.StaffID))
                                {
                                    routingKey += "." + MSNV;
                                }
                                RabbitMQClient.send(routingKey, message);
                            }

                        }
                    }
                }


                if (!Variables.accountInfor.StaffID.Equals(Variables.projectInformation.TeamManager))
                {
                    if (Variables.isNhapFileOutput)
                    {
                        ViewModels_FNhapFileOutput.Instance.InsertNotifications(DateTime.Now.ToString(), Variables.accountInfor.StaffID,
                           Variables.projectInformation.TeamManager, "Translate", idTranslate, "QLDA-OutputData", "Thêm Mới");
                    }
                    else
                    {
                        ViewModels_FNhapFileOutput.Instance.InsertNotifications(DateTime.Now.ToString(), Variables.accountInfor.StaffID,
                           Variables.projectInformation.TeamManager, "Translate", idTranslate, "QLDA-OutputData", "Chỉnh Sửa");
                    }

                    //Gửi Thông Báo Đến Quản Lý
                    if (!Variables.accountInfor.StaffID.Equals(Variables.projectInformation.ProjectManager))
                    {
                        if (Variables.isNhapFileOutput)
                        {
                            ViewModels_FNhapFileOutput.Instance.InsertNotifications(DateTime.Now.ToString(), Variables.accountInfor.StaffID,
                               Variables.projectInformation.ProjectManager, "Translate", idTranslate, "QLDA-OutputData", "Thêm Mới");
                        }
                        else
                        {
                            ViewModels_FNhapFileOutput.Instance.InsertNotifications(DateTime.Now.ToString(), Variables.accountInfor.StaffID,
                               Variables.projectInformation.ProjectManager, "Translate", idTranslate, "QLDA-OutputData", "Chỉnh Sửa");
                        }                            
                    }

                    string routingKey2 = Variables.projectInformation.TeamManager;
                    string message2 = "QLDA-OutputData";
                    
                    RabbitMQClient.send(routingKey2, message2);
                }
                fNhapFile.Close();
            }
        }
        catch (Exception e)
        {
            MessageBox.Show(e.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error, MessageBoxDefaultButton.Button1);
        }*/
    }

    public function updateInputData($newInputData, $inputDataId)
    {
        try{
            DB::beginTransaction();
            // Step 1: Insert a new InputData
            $inputDataModel = new \App\Models\InputData();
            $inputDataObj = $inputDataModel::find($inputDataId);
            if(!($inputDataObj instanceof \App\Models\InputData)){
                throw new \App\Exceptions\ApiException("[NotFound][InputData] Id# $inputDataId", Response::HTTP_NOT_FOUND);
            };
            $translateObj = $inputDataObj->getTranslate;
            if(!($translateObj instanceof \App\Models\Translate)){
                throw new \App\Exceptions\ApiException("[NotFound][Translate] InputDataId# $inputDataId", Response::HTTP_NOT_FOUND);
            };
            $translateModel = new \App\Models\Translate();
            $newInputData['data_translate_status'] = $translateObj->data_translate_status;
            if(($translateObj->original_mail != $newInputData['original_mail']
            || $translateObj->original_mail != $newInputData['original_mail'])
            &&  $newInputData['translator_suggested'] == $this->_actor){
                $newInputData['data_translate_status'] = \App\Constants\DropdownLabel::IO_DATA_TRANSLATE_STATUS_NOT_TRANSLATED_ID;
            }
            $inputDataModel->updateInputData($newInputData, $inputDataObj, $this->_actor, $this->_time);
            $translateModel->updateInputDataTranslate($newInputData, $translateObj, $this->_actor, $this->_time);
            
            DB::commit();

            return $newInputData;
        }catch(\App\Exceptions\ApiException $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function updateOutputData($newOutputData, $outputId)
    {
        try{
            DB::beginTransaction();
            $outputDataModel = new \App\Models\OutputData();
            $outputDataObj = $outputDataModel::find($outputId);
            if(!($outputDataObj instanceof \App\Models\OutputData)){
                throw new \App\Exceptions\ApiException("[NotFound][OutputData] Id# $outputId", Response::HTTP_NOT_FOUND);
            };

            $translateObj =  $outputDataObj->getTranslate;
            if(!($translateObj instanceof \App\Models\Translate)){
                throw new \App\Exceptions\ApiException("[NotFound][Translate] OutputDataId# $outputId", Response::HTTP_NOT_FOUND);
            };
            $translateModel = new \App\Models\Translate();
            $newOutputData['data_translate_status'] = $translateObj->data_translate_status;
            if(($translateObj->original_mail != $newOutputData['original_mail']
            || $translateObj->original_mail != $newOutputData['original_mail'])
            &&  $newOutputData['translator_suggested'] == $this->_actor){
                $newOutputData['data_translate_status'] = \App\Constants\DropdownLabel::IO_DATA_TRANSLATE_STATUS_NOT_TRANSLATED_ID;
                if($newOutputData['staff_data_status'] == \App\Constants\DropdownLabel::IO_STAFF_DATA_STATUS_FINISHED_ID){
                    $newOutputData['staff_data_status'] = \App\Constants\DropdownLabel::IO_STAFF_DATA_STATUS_IN_PROGRESS_ID;
                }
            }
            $outputDataModel->updateOutputData($newOutputData, $outputDataObj, $this->_actor, $this->_time);
            $translateModel->updateOutputDataTranslate($newOutputData, $translateObj, $this->_actor, $this->_time);
            
            DB::commit();

            return $newOutputData;
        }catch(\App\Exceptions\ApiException $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteInputData($inputDataId)
    {
        $errorMsg = [];
        $inputDataObj = \App\Models\InputData::find($inputDataId);
        if (!($inputDataObj instanceof \App\Models\InputData)) {
            throw new \App\Exceptions\ApiException("[NotFound][InputData] Id# $inputDataId", Response::HTTP_NOT_FOUND);
        }

        $translateObj = $inputDataObj->getTranslate;
        if (!($translateObj instanceof \App\Models\Translate)) {
            throw new \App\Exceptions\ApiException("[NotFound][Translate] InputDataId# $inputDataId", Response::HTTP_NOT_FOUND);
        }
        $projectObj = $inputDataObj->getProject;
        if (!($projectObj instanceof \App\Models\ProjectInformation)) {
            throw new \App\Exceptions\ApiException("[NotFound][ProjectInformation] InputDataId# $inputDataId", Response::HTTP_NOT_FOUND);
        }
        if (!($inputDataObj->sender == $this->_actor)
                && !($projectObj->team_manager == $this->_actor)) {
                $errorMsg[] = trans('io_data.messages.delete_io_data_not_granted');
            }
        if($inputDataObj->data_status == \App\Constants\DropdownLabel::IO_DATA_STATUS_DONE_PROGRESS_ID){
            $errorMsg[] = trans('io_data.messages.delete_io_data_in_progress');
        }
        if(empty($errorMsg)){
            $translateObj->delete();
            $inputDataObj->delete();
            return true;
        }
        return $errorMsg;
    }

    public function deleteOutputData($outputDataId)
    {
        $errorMsg = [];
        $outputDataObj = \App\Models\OutputData::find($outputDataId);
        if (!($outputDataObj instanceof \App\Models\OutputData)) {
            throw new \App\Exceptions\ApiException("[NotFound][OutputData] Id# $outputDataId", Response::HTTP_NOT_FOUND);
        }
        $translateObj = $outputDataObj->getTranslate;
        if (!($translateObj instanceof \App\Models\Translate)) {
            throw new \App\Exceptions\ApiException("[NotFound][Translate] OutputDataId# $outputDataId", Response::HTTP_NOT_FOUND);
        }
        $projectObj = $outputDataObj->getProject;
        if (!($projectObj instanceof \App\Models\ProjectInformation)) {
            throw new \App\Exceptions\ApiException("[NotFound][ProjectInformation] OutputDataId# $outputDataId", Response::HTTP_NOT_FOUND);
        }
        if (!($outputDataObj->sender == $this->_actor)
                && !($projectObj->team_manager == $this->_actor)) {
                $errorMsg[] = trans('io_data.messages.delete_io_data_not_granted');
        }
        if($outputDataObj->data_status == \App\Constants\DropdownLabel::IO_DATA_STATUS_DONE_PROGRESS_ID){
            $errorMsg[] = trans('io_data.messages.delete_io_data_in_progress');
        }
        if(empty($errorMsg)){
            $translateObj->delete();
            $outputDataObj->delete();
            return true;
        }
        return $errorMsg;
    }

    #Input Output Data <=> Du Lieu Input/Output
    public function getInputOutputDataList($projectId, $limit, $search)
    {
        $inputDataModel = new \App\Models\InputData();
        $inputDataList = $inputDataModel->selectInputDataInProject($projectId, $limit, $search);
        $outputDataModel = new \App\Models\OutputData();
        $outputDataList = $outputDataModel->selectOutputDataInProject($projectId, $limit, $search);
        $ioDataList = array_merge($inputDataList, $outputDataList);

        usort($ioDataList, function ($item1, $item2) {
            return $item2->datetime <=> $item1->datetime;
        });
        foreach ($ioDataList as $ioData) {
            $this->_formatInputOutputData($ioData);
        }

        return $ioDataList;
    }

    public function getSendDataList($conditions)
    {
        $sendDataList = [];
        $outputDataModel = new \App\Models\OutputData();
        $sendDataList = $outputDataModel->selectSendOutputData($conditions);
        return $sendDataList;
    }

    public function getCheckbackDataList($conditions)
    {
        $checkbackDataList = [];
        $inputDataModel = new \App\Models\InputData();
        $checkbackDataList = $inputDataModel->selectCheckbackData($conditions);
        return $checkbackDataList;
    }

    public function validateInputData($newInputData)
    {
        $msg = [];
        if($newInputData['translator_suggested'] != $this->_actor){
            if($newInputData['staff_data_status'] == \App\Constants\DropdownLabel::IO_STAFF_DATA_STATUS_FINISHED_ID && !$newInputData['id']){
                $msg[] = trans('io_data.messages.pdv_staff_status');
            }
        }
        if($newInputData['path'] && !DirectoryBusiness::exists($newInputData['path'])) {
            $msg[] = trans('io_data.messages.path_error');
        }

        return $msg;
    }

    public function messageInputDataSuccessful($newInputData)
    {
        $msg = [];
        if($newInputData['translator_suggested'] != $this->_actor){
            if($newInputData['staff_data_status'] == \App\Constants\DropdownLabel::IO_STAFF_DATA_STATUS_NOT_FINISHED_ID){
                $msg[] = trans('io_data.messages.staff_status_not_finished');
            }
        }

        return $msg;
    }

    public function validateOutputData($newOutputData)
    {
        $msg = [];
        if($newOutputData['translator_suggested'] != $this->_actor){
            if($newOutputData['staff_data_status'] == \App\Constants\DropdownLabel::IO_STAFF_DATA_STATUS_FINISHED_ID && !$newOutputData['id']){
                $msg[] = trans('io_data.messages.pdv_staff_status');
            }
        }
        if($newOutputData['data_status'] != \App\Constants\DropdownLabel::IO_DATA_STATUS_DONE_PROGRESS_ID){
            if($newOutputData['data_output_type'] ==  \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID){
                if(!$newOutputData['path']){
                    $msg[] = trans('io_data.messages.path_required');
                }
                if($newOutputData['path'] && !DirectoryBusiness::exists($newOutputData['path'])) {
                    $msg[] = trans('io_data.messages.path_error');
                }
                if($newOutputData['path'] && strpos($newOutputData['path'], $newOutputData['project_path']) === false){
                    $msg[] = trans('io_data.messages.path_project_error');
                }
                if($newOutputData['path'] && strpos($newOutputData['path'], 'OUTPUT\\2.SEND') === false){
                    $msg[] = trans('io_data.messages.data_put_wrong_place_SEND');
                }
                if($newOutputData['path'] && strpos($newOutputData['path'], '2.SEND\\1.SENT') !== false){
                    $msg[] = trans('io_data.messages.data_put_wrong_place_SENT');
                }
            }
            if($newOutputData['path'] && !$newOutputData['id']){
                $pathSend = "";
                $pathSent = "";
                if (strpos($newOutputData['path'],"2.SEND") != false)
                {
                    $pathSend = $newOutputData['path'];
                    $pathSent = str_replace("2.SEND", "2.SEND\\1.SENT", $newOutputData['path']);
                }else{
                    $pathSend = $newOutputData['path'];
                    $pathSent = $newOutputData['path'];
                }
                $outputDataModel = new \App\Models\OutputData();
                $outDataList = $outputDataModel->checkExistsLinkOutput($pathSend, $pathSent);
                if (!empty($outDataList)){
                    $msg[] = trans('io_data.messages.existing_path_error');
                }
            }
        }
        if($newOutputData['data_status'] == \App\Constants\DropdownLabel::IO_DATA_STATUS_DONE_PROGRESS_ID){
            if($newOutputData['data_output_type'] ==  \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID){
                if(!$newOutputData['path']){
                    $msg[] = trans('io_data.messages.path_required');
                }
            }
            if($newOutputData['path'] && strpos($newOutputData['path'], $newOutputData['project_path']) === false){
                $msg[] = trans('io_data.messages.path_project_error');
            }
            if($newOutputData['path'] && !DirectoryBusiness::exists($newOutputData['path'])) {
                $msg[] = trans('io_data.messages.path_error');
            }
        }
        
        return $msg;
    }

    public function messageOutputDataSuccessful($newOutputData)
    {
        $msg = [];
        if($newOutputData['translator_suggested'] != $this->_actor){
            if($newOutputData['staff_data_status'] == \App\Constants\DropdownLabel::IO_STAFF_DATA_STATUS_NOT_FINISHED_ID){
                $msg[] = trans('io_data.messages.staff_status_not_finished');
            }
        }

        return $msg;
    }

    private function _reconstructOutputData($newOutputData)
    {
        $newOutputData['data_translate_status'] = \App\Constants\DropdownLabel::IO_DATA_TRANSLATE_STATUS_NOT_TRANSLATED_ID;
        if($newOutputData['translator_suggested'] == $this->_actor){
            $newOutputData['data_translate_status'] = \App\Constants\DropdownLabel::IO_DATA_TRANSLATE_STATUS_TRANSLATED_ID;
        }
        
        $newOutputData['data_status'] = \App\Constants\DropdownLabel::IO_DATA_STATUS_NO_PROGRESS_ID;

        return $newOutputData;
    }

    private function _formatInputOutputData($ioData)
    {
        if (!empty($ioData->datetime)) {
           // $ioData->datetime = strftime('%d/%m/%Y %H:%M:%S', strtotime($ioData->datetime));
        }
    }

    private function _reconstructInputData($newInputData)
    {
        $newInputData['data_translate_status'] = \App\Constants\DropdownLabel::IO_DATA_TRANSLATE_STATUS_NOT_TRANSLATED_ID;
        if($newInputData['translator_suggested'] == $this->_actor){
            $newInputData['data_translate_status'] = \App\Constants\DropdownLabel::IO_DATA_TRANSLATE_STATUS_TRANSLATED_ID;
        }
        if(!$newInputData['id']){
            $newInputData['data_status'] = \App\Constants\DropdownLabel::IO_DATA_STATUS_NO_PROGRESS_ID;
        }
        
        return $newInputData;
    }
}
