<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InputData extends Model
{
    protected $table = 'input_data';

    public $timestamps = false;

    public function getTranslate()
    {
        return $this->hasOne('\App\Models\Translate', 'input_data_id');
    } 

    public function getProject()
    {
        return $this->belongsTo('\App\Models\ProjectInformation', 'project_id');
    }

    /**
     * get InputData for a project, the amount of retreiving is based on $limit
     * @param $projectId
     * @param $limit
     * @return array
     */
    public function selectInputDataInProject($projectId, $limit = [], $search)
    {
        $columns = [
            'input_data.id as id', 
            'input_data.datetime as datetime', 
            'dataStatus.value as data_status', 
            'dataStatus.id as data_status_id', 
            'ua.short_name as sender',
            'ua.id as sender_id',
            'ua.staff_id as staff_id',
            'input_data.name as name',
            'dataInputType.value as data_type',
            'dataInputType.id as data_type_id',
            'staffDataStatus.value as staff_data_status',
            'staffDataStatus.id as staff_data_status_id',
            'input_data.subject_mail as subject_mail',
            'input_data.path as path',
            't.id as translate_id',
            't.original_mail as original_mail',
            't.translated_mail as translated_mail',
            'translator.short_name as translator',
            'translator.id as translator_id',
            'translatorSuggested.short_name as translator_suggested',
            'translatorSuggested.id as translator_suggested_id',
            'dataTranslateStatus.value as data_translate_status',
            'dataTranslateStatus.id as data_translate_status_id',
            'input_data.attach_file as attach_file'
        ];
        $inputDataList = DB::table($this->table)
            ->select($columns)
            ->join('user_application as ua', 'ua.id', '=', 'input_data.sender')
            ->leftJoin('dropdownlabel as dataStatus', 'dataStatus.id', '=', 'input_data.data_status')
            ->leftJoin('dropdownlabel as dataInputType', 'dataInputType.id', '=', 'input_data.data_input_type')
            ->leftJoin('dropdownlabel as staffDataStatus', 'staffDataStatus.id', '=', 'input_data.staff_data_status')
            ->join('translate as t', 't.input_data_id', '=', 'input_data.id')
            ->leftJoin('dropdownlabel as dataTranslateStatus', 'dataTranslateStatus.id', '=', 't.data_translate_status')
            ->leftJoin('user_application as translator', 'translator.id', '=', 't.translator')
            ->leftJoin('user_application as translatorSuggested', 'translatorSuggested.id', '=', 't.translator_suggested')
            ->where('input_data.project_id', $projectId)
            ->get();
        $result = $inputDataList->toArray();
        if(!empty($search)){
            $result = array_filter($result, function ($v, $k) use ($search) {
                return strpos($v->original_mail, $search) !== false || strpos($v->translated_mail, $search) !== false ;
            }, ARRAY_FILTER_USE_BOTH);
            $result = array_values($result);
        }
        
        return $result;
    }

    public function selectInputDataAmountByDatePerProject($projectId, $date)
    {
        $columns = [
            'input_data.id'
        ];
        $inputDataList = DB::table($this->table)
            ->select($columns)
            ->join('translate as t', 't.input_data_id', '=', 'input_data.id')
            ->where(DB::raw('DATE_FORMAT(t.created_at,"%Y-%m-%d")'), $date)
            ->where('input_data.project_id', $projectId)
            ->get();
        $result = $inputDataList->toArray();
        
        return $result;

    }

    public function selectCheckbackData($conditions)
    {       
        $columns = [
            'input_data.id as id',
            'input_data.datetime as datetime',
            'dataInputType.label as data_input_type',
            'input_data.project_id as project_id',
            'pi.project_id as project_id_string',
            'dataStatus.label as data_status',
            'staffDataStatus.label as staff_data_status',
            'ua.short_name as sender',
            'ua.staff_id as staff_id_string',
            'ua.team as team',
            'ua.department as department',
            'pi.project_name as project_name',
            'input_data.path as path',
        ];

        $checkbackDataList = DB::table($this->table)
            ->select($columns)
            ->leftJoin('dropdownlabel as dataInputType', 'dataInputType.id', '=', 'input_data.data_input_type')
            ->leftJoin('user_application as ua', 'ua.id', '=', 'input_data.sender')
            ->leftJoin('project_information as pi', 'pi.id', '=', 'input_data.project_id')
            ->leftJoin('dropdownlabel as dataStatus', 'dataStatus.id', '=', 'input_data.data_status')
            ->leftJoin('dropdownlabel as staffDataStatus', 'staffDataStatus.id', '=', 'input_data.staff_data_status')
            ->whereIn('input_data.data_input_type', [\App\Constants\DropdownLabel::IO_DATA_INPUT_TYPE_CHECK_BACK_ID, \App\Constants\DropdownLabel::IO_DATA_INPUT_TYPE_COMPLAIN_ID])
            ->where([
                ['input_data.datetime', '>=', $conditions['startDate']],
                ['input_data.datetime', '<', $conditions['endDate']]
            ])
            ->where('ua.team', 'LIKE', '%' . $conditions['team'] . '%')
            ->orderBy('input_data.datetime', "DESC")
            ->get();
        $result = $checkbackDataList->toArray();

        return $result;
    }

    public function insertInputData($data, $actor = null, $time = null)
    {
        $newInputDataObj = new \App\Models\InputData();
        $newInputDataObj->datetime = $data['datetime'];
        $newInputDataObj->data_status = $data['data_status'];
        $newInputDataObj->sender = $data['sender'];
        $newInputDataObj->project_id = $data['project_id'];
        $newInputDataObj->data_input_type = $data['data_input_type'];
        $newInputDataObj->name = $data['name'];
        $newInputDataObj->attach_file = $data['attach_file'];
        $newInputDataObj->path = $data['path'];
        $newInputDataObj->subject_mail = $data['subject_mail'];
        $newInputDataObj->staff_data_status = $data['staff_data_status'];
        $newInputDataObj->save();

        return $newInputDataObj;
    }

    public function updateInputData($data, $updateInputDataObj, $actor = null, $time = null)
    {
        $isUpdateOnlyInputDataType = isset($data['inputData']);
        if($isUpdateOnlyInputDataType){
            $updateInputDataObj->data_input_type = $data['inputData']['data_input_type'];
            $updateInputDataObj->save();
        }
        else {
        $updateInputDataObj->datetime = $data['datetime'];
        $updateInputDataObj->data_status = $data['data_status'];
        $updateInputDataObj->sender = $data['sender'];
        $updateInputDataObj->project_id = $data['project_id'];
        $updateInputDataObj->data_input_type = $data['data_input_type'];
        $updateInputDataObj->name = $data['name'];
        $updateInputDataObj->attach_file = $data['attach_file'];
        $updateInputDataObj->path = $data['path'];
        $updateInputDataObj->subject_mail = $data['subject_mail'];
        $updateInputDataObj->staff_data_status = $data['staff_data_status'];
        $updateInputDataObj->save();
        }

        return $updateInputDataObj;
    }
}
