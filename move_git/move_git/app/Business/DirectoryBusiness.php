<?php

namespace App\Business;

use Illuminate\Support\Facades\File;

/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 26/8/19
 * Time: 5:03 PM
 */
class DirectoryBusiness
{

    public static $ParentDirectory;
    public function __construct()
    {
        static::$ParentDirectory = config('app.DIRECTORY_ROOT');
    }

    public static function createDirectoryForInputData($data)
    {
        $now = new \DateTime('now');
        $dateString = date_format($now,"Y-m-d");
        $mdString = date_format($now,"md");
        $projectPath = $data['project_path'];
        $path = '';
        try{
                /*Tự tạo tên folder 
                 => tên folder  = MMdd-number Ten
                    - MMdd = today
                    number = số input trong ngay + 1
                    Ten = loai du lieu
                 */
                $inputDataModel = new \App\Models\InputData();
                $inputDataList = $inputDataModel->selectInputDataAmountByDatePerProject($data['project_id'], $dateString);
                $stt = (string)(count($inputDataList) + 1);
                $folderName = $mdString . "-" . $stt . " " . $data['data_input_type_name'];
                $path = $projectPath . "\\INPUT\\" . $folderName;
                self::makeDirectory($path, 0777, true, true);
               return $path;   
        }catch(\App\Exceptions\ApiException $e){
            throw $e;
        }
                 
    }

    public static function createDirectoryForOutputData($data)
    {
        $now = new \DateTime('now');
        $yymmdd = date_format($now,"ymd");
        $dateString = date_format($now,"Y-m-d");
        $projectPath = $data['project_path'];
        $outputDataModel = new \App\Models\OutputData();
        $projectId = $data['project_id'];
        $projectCode = $data['project_code'];
        $pathAsk = '';
        $pathSend = '';
        try{
                /*Tự tạo tên folder 
                 => tên folder  = MMdd-number Ten
                    - MMdd = today
                    number = số input trong ngay + 1
                    Ten = loai du lieu
                 */
                if ($data['data_output_type'] == \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_FILE_HOI_ASK_ID
                || $data['data_output_type'] == \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_FILE_XAC_NHAN_CONFIRM_ID){
                    $condition = [
                        'data_type_list' => [
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_FILE_HOI_ASK_ID,
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_FILE_XAC_NHAN_CONFIRM_ID,
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID_FILE_ASK_ID
                        ]
                    ];
                    $outDataList = $outputDataModel->selectOutputMailTodayByProjectID($projectId, $dateString, $condition);
                    // if (Variables.isNhapFileOutput) num += 1;
                    $stt = (string)(count($outDataList) + 1);
                    $folderName = $yymmdd . "-" . $stt;
                    $pathAsk = $projectPath . "\\OUTPUT\\3.ASK\\" . $folderName;
                    self::makeDirectory($pathAsk, 0777, true, true);

                    $destinatePath = $pathAsk . "\\" . $projectCode . "_お問合せ_" . $folderName . "vn.xlsx";
                    $sourcePath = public_path()."\\MasterData\\XXX_お問合せ_XXXXXX-1vn.xlsx";
                    self::copy($sourcePath, $destinatePath);
               } 
               if($data['data_output_type'] == \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID){
                    $condition = [
                        'data_type_list' => [
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID,
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID_FILE_ASK_ID
                        ]
                    ];
                    $outDataList = $outputDataModel->selectOutputDataTodayByProjectID($projectId, $dateString, $condition);
                    $stt = (string)(count($outDataList) + 1);
                    $folderName = $yymmdd . "-" . $stt;
                    $pathSend = $projectPath . "\\OUTPUT\\2.SEND\\" . $projectCode . "_" . $folderName;
                    self::makeDirectory($pathSend, 0777, true, true);
               }
               if($data['data_output_type'] == \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID_FILE_ASK_ID){
                    $condition = [
                        'data_type_list' => [
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID,
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID_FILE_ASK_ID
                        ]
                    ];
                    $outDataList = $outputDataModel->selectOutputDataTodayByProjectID($projectId, $dateString, $condition);
                    $stt = (string)(count($outDataList) + 1);
                    $folderName = $yymmdd . "-" . $stt;
                    $pathSend = $projectPath . "\\OUTPUT\\2.SEND\\" . $projectCode . "_" . $folderName;
                    self::makeDirectory($pathSend, $mode = 0777, true, true);

                    $condition = [
                        'data_type_list' => [
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_FILE_HOI_ASK_ID,
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_FILE_XAC_NHAN_CONFIRM_ID,
                            \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID_FILE_ASK_ID
                        ]
                    ];
                    $outDataList = $outputDataModel->selectOutputMailTodayByProjectID($projectId, $dateString, $condition);
                    // if (Variables.isNhapFileOutput) num += 1;
                    $stt = (string)(count($outDataList) + 1);
                    $folderName = $yymmdd . "-" . $stt;
                    $pathAsk = $projectPath . "\\OUTPUT\\3.ASK\\" . $folderName;
                    self::makeDirectory($pathAsk, 0777, true, true);

                    $destinatePath = $pathAsk . "\\" . $projectCode . "_お問合せ_" . $folderName . "vn.xlsx";
                    $sourcePath = public_path()."\\MasterData\\XXX_お問合せ_XXXXXX-1vn.xlsx";
                    self::copy($sourcePath, $destinatePath);
                     
               }
               return $pathSend ? $pathSend : $pathAsk;
        }catch(\App\Exceptions\ApiException $e){
            throw $e;
        }
                 
    }

    public static function makeDirectory($path, $mode, $recursive, $force)
    {
        $directoryRoot = config('app.DIRECTORY_ROOT');
        $directoryMount = config('app.DIRECTORY_MOUNT');
        $path = str_replace($directoryRoot, $directoryMount, $path);
        $path = str_replace("\\", "/", $path);
        File::makeDirectory($path, $mode, $recursive, $force);
    }

    public static function copy($sourcePath, $destinatePath)
    {
        $directoryRoot = config('app.DIRECTORY_ROOT');
        $directoryMount = config('app.DIRECTORY_MOUNT');
        $sourcePath = str_replace($directoryRoot, $directoryMount, $sourcePath);
        $destinatePath = str_replace($directoryRoot, $directoryMount, $destinatePath);
        $sourcePath = str_replace("\\", "/", $sourcePath);
        $destinatePath = str_replace("\\", "/", $destinatePath);
        File::copy($sourcePath, $destinatePath);
    }

    public static function exists($path)
    {
        $directoryRoot = config('app.DIRECTORY_ROOT');
        $directoryMount = config('app.DIRECTORY_MOUNT');
        $path = str_replace($directoryRoot, $directoryMount, $path);
        $path = str_replace("\\", "/", $path);
        return File::exists($path);
    }
}
