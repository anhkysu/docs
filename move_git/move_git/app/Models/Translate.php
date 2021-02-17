<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Translate extends Model
{
    protected $table = 'translate';

    public $timestamps = false;

    public function getInputData()
    {
        return $this->belongsTo('\App\Models\InputData', 'input_data_id');
    }

    public function insertInputDataTranslate($data, $actor, $time)
    {
        $newTranslateObj = new \App\Models\Translate();
        $newTranslateObj->data_type = $data['data_type'];
        $newTranslateObj->data_translate_status = $data['data_translate_status'];
        $newTranslateObj->translator_suggested = $data['translator_suggested'];
        $newTranslateObj->input_data_id = $data['input_data_id'];
        $newTranslateObj->original_mail = $data['original_mail'];
        $newTranslateObj->translated_mail = $data['translated_mail'];
        $newTranslateObj->urgent = $data['urgent'];
        $newTranslateObj->updated_at = $time;
        $newTranslateObj->updated_by = $actor;
        $newTranslateObj->created_at = $time;
        $newTranslateObj->created_by = $actor;
        $newTranslateObj->save();

        return $newTranslateObj;
    }

    public function updateInputDataTranslate($data, $updateTranslateObj, $actor, $time)
    {
        if(isset($data['translator_suggested'])){
            // translator_suggested -> update called from io data
            $updateTranslateObj->translator_suggested = $data['translator_suggested'];
            $updateTranslateObj->urgent = $data['urgent'];
        } else {
            // update called from translate action
            $updateTranslateObj->original_file_mail = $data['original_file_mail'];
            $updateTranslateObj->translated_file_mail = $data['translated_file_mail'];
            $updateTranslateObj->translator = $data['translator'];
        }
        $updateTranslateObj->data_translate_status = $data['data_translate_status'];
        $updateTranslateObj->original_mail = $data['original_mail'];
        $updateTranslateObj->translated_mail = $data['translated_mail'];
        $updateTranslateObj->updated_at = $time;
        $updateTranslateObj->updated_by = $actor;
        $updateTranslateObj->save();

        return $updateTranslateObj;
    }

    public function insertOutputDataTranslate($data, $actor, $time)
    {
        $newTranslateObj = new \App\Models\Translate();
        $newTranslateObj->data_type = $data['data_type'];
        $newTranslateObj->data_translate_status = $data['data_translate_status'];
        $newTranslateObj->translator_suggested = $data['translator_suggested'];
        $newTranslateObj->output_data_id = $data['output_data_id'];
        $newTranslateObj->original_mail = $data['original_mail'];
        $newTranslateObj->translated_mail = $data['translated_mail'];
        $newTranslateObj->urgent = $data['urgent'];
        $newTranslateObj->updated_at = $time;
        $newTranslateObj->updated_by = $actor;
        $newTranslateObj->created_at = $time;
        $newTranslateObj->created_by = $actor;
        $newTranslateObj->save();

        return $newTranslateObj;
    }

    public function updateOutputDataTranslate($data, $updateTranslateObj, $actor, $time)
    {
        if(isset($data['translator_suggested'])){
            // translator_suggested -> update called from io data
            $updateTranslateObj->translator_suggested = $data['translator_suggested'];
            $updateTranslateObj->urgent = $data['urgent'];
        } else {
            // update called from translate action
            $updateTranslateObj->original_file_mail = $data['original_file_mail'];
            $updateTranslateObj->translated_file_mail = $data['translated_file_mail'];
            $updateTranslateObj->translator = $data['translator'];
        }
        $updateTranslateObj->data_translate_status = $data['data_translate_status'];
        $updateTranslateObj->original_mail = $data['original_mail'];
        $updateTranslateObj->translated_mail = $data['translated_mail'];
        $updateTranslateObj->updated_at = $time;
        $updateTranslateObj->updated_by = $actor;
        $updateTranslateObj->save();

        return $updateTranslateObj;
    }

    public function getTranslateDataList($conditions)
    {
        $startDate = $conditions['startDate'];
        $endDate = $conditions['endDate'];
        $team = $conditions['team'];
        $columns = [
            'translate.id as id',
            'inputData.id as input_data_id',
            'outputData.id as output_data_id',
            'inputData.datetime as input_data_datetime',
            'outputData.datetime as output_data_datetime',
            'dataStatusIn.label as input_data_status',
            'dataStatusIn.id as input_data_status_id',
            'dataStatusOut.label as output_data_status',
            'dataStatusOut.id as output_data_status_id',
            'staffDataStatusIn.label as input_staff_data_status',
            'staffDataStatusIn.id as input_staff_data_status_id',
            'staffDataStatusOut.label as output_staff_data_status',
            'staffDataStatusOut.id as output_staff_data_status_id',

            'dataTranslateStatus.label as data_translate_status_label',
            'dataTranslateStatus.id as data_translate_status',

            'inputSender.short_name as input_sender_name',
            'outputSender.short_name as output_sender_name',
            'inputSender.team as input_sender_team',
            'outputSender.team as output_sender_team',
            'inputSender.staff_id as input_sender_id',
            'outputSender.staff_id as output_sender_id',
            'projectInfoIn.project_id as input_data_project_id',
            'projectInfoOut.project_id as output_data_project_id',
            'translate.original_mail as original_mail',
            'translate.translated_mail as translated_mail',
            'dataType.label as data_type',
            'translate.urgent as urgent',

            'translatorSuggested.short_name as translator_suggested',

            'translator.short_name as translator_short_name',
            'translator.id as translator',

            'inputData.path as input_data_path',
            'outputData.path as output_data_path',
            'dataInputType.id as data_input_type',
            'dataOutputType.id as data_output_type'
        ];

        if ($startDate && $endDate) {
            $translateData = DB::table($this->table)
                ->select($columns)
                ->join('dropdownlabel as dataType', 'dataType.id', '=', 'translate.data_type')
                ->join('dropdownlabel as dataTranslateStatus', 'dataTranslateStatus.id', '=', 'translate.data_translate_status')
                ->leftJoin('user_application as translator', 'translator.id', '=', 'translate.translator')
                ->leftJoin('user_application as translatorSuggested', 'translatorSuggested.id', '=', 'translate.translator_suggested')
                ->leftJoin('output_data as outputData', 'outputData.id', '=', 'translate.output_data_id')
                ->leftJoin('input_data as inputData', 'inputData.id', '=', 'translate.input_data_id')
                ->leftJoin('project_information as projectInfoIn', 'projectInfoIn.id', '=', 'inputData.project_id')
                ->leftJoin('project_information as projectInfoOut', 'projectInfoOut.id', '=', 'outputData.project_id')
                ->leftJoin('dropdownlabel as dataInputType', 'dataInputType.id', '=', 'inputData.data_input_type')
                ->leftJoin('dropdownlabel as dataOutputType', 'dataOutputType.id', '=', 'outputData.data_out_type')
                ->leftJoin('dropdownlabel as staffDataStatusIn', 'staffDataStatusIn.id', '=', 'inputData.staff_data_status')
                ->leftJoin('dropdownlabel as staffDataStatusOut', 'staffDataStatusOut.id', '=', 'outputData.staff_data_status')
                ->leftJoin('dropdownlabel as dataStatusIn', 'dataStatusIn.id', '=', 'inputData.data_status')
                ->leftJoin('dropdownlabel as dataStatusOut', 'dataStatusOut.id', '=', 'outputData.data_status')
                ->leftJoin('user_application as inputSender', 'inputSender.id', '=', 'inputData.sender')
                ->leftJoin('user_application as outputSender', 'outputSender.id', '=', 'outputData.sender')
                ->where(function($q) use ($team){
                    $q
                    ->where('inputSender.team', 'LIKE', $team)
                    ->orWhere('outputSender.team', 'LIKE', $team);
                })
                ->where(function($q) use ($startDate, $endDate){
                    $q
                    ->where([
                        ['inputData.datetime', '>=', $startDate],
                        ['inputData.datetime', '<', $endDate]
                    ])
                    ->orWhere([
                        ['outputData.datetime', '>=', $startDate],
                        ['outputData.datetime', '<', $endDate]
                    ])
                    ->orWhereIn(
                        'dataTranslateStatus.id', 
                        [\App\Constants\DropdownLabel::IO_DATA_TRANSLATE_STATUS_NOT_TRANSLATED_ID, 
                        \App\Constants\DropdownLabel::IO_DATA_TRANSLATE_STATUS_TRANSLATING_ID]
                    );
                })
                ->orderBy('dataType.label', 'DESC')
                ->orderBy('translate.urgent', 'DESC')
                ->get();
            $result = $translateData->toArray();

            return $result;
        } else {

            return [];
        }
    }

    public function getTranslateDataItem($id)
    {
        $columns = [
            'translate.id as id',
            'inputData.id as input_data_id',
            'outputData.id as output_data_id',
            'inputData.datetime as input_data_datetime',
            'outputData.datetime as output_data_datetime',
            'dataStatusIn.label as input_data_status',
            'dataStatusIn.id as input_data_status_id',
            'dataStatusOut.label as output_data_status',
            'dataStatusOut.id as output_data_status_id',
            'staffDataStatusIn.label as input_staff_data_status',
            'staffDataStatusIn.id as input_staff_data_status_id',
            'staffDataStatusOut.label as output_staff_data_status',
            'staffDataStatusOut.id as output_staff_data_status_id',

            'dataTranslateStatus.label as data_translate_status_label',
            'dataTranslateStatus.id as data_translate_status',

            'inputSender.short_name as input_sender_name',
            'outputSender.short_name as output_sender_name',
            'inputSender.team as input_sender_team',
            'outputSender.team as output_sender_team',
            'inputSender.staff_id as input_sender_id',
            'outputSender.staff_id as output_sender_id',
            'projectInfoIn.project_id as input_data_project_id',
            'projectInfoOut.project_id as output_data_project_id',
            'translate.original_mail as original_mail',
            'translate.translated_mail as translated_mail',
            'dataType.label as data_type',
            'translate.urgent as urgent',
            'translatorSuggested.short_name as translator_suggested',

            'translator.short_name as translator_short_name',
            'translator.id as translator',

            'inputData.path as input_data_path',
            'outputData.path as output_data_path',
            'dataInputType.id as data_input_type',
            'dataOutputType.id as data_output_type'
        ];

        $translateData = DB::table($this->table)
            ->select($columns)
            ->join('dropdownlabel as dataType', 'dataType.id', '=', 'translate.data_type')
            ->join('dropdownlabel as dataTranslateStatus', 'dataTranslateStatus.id', '=', 'translate.data_translate_status')
            ->leftJoin('user_application as translator', 'translator.id', '=', 'translate.translator')
            ->leftJoin('user_application as translatorSuggested', 'translatorSuggested.id', '=', 'translate.translator_suggested')
            ->leftJoin('output_data as outputData', 'outputData.id', '=', 'translate.output_data_id')
            ->leftJoin('input_data as inputData', 'inputData.id', '=', 'translate.input_data_id')

            ->leftJoin('project_information as projectInfoIn', 'projectInfoIn.id', '=', 'inputData.project_id')
            ->leftJoin('project_information as projectInfoOut', 'projectInfoOut.id', '=', 'outputData.project_id')

            ->leftJoin('dropdownlabel as dataInputType', 'dataInputType.id', '=', 'inputData.data_input_type')
            ->leftJoin('dropdownlabel as dataOutputType', 'dataOutputType.id', '=', 'outputData.data_out_type')
            ->leftJoin('dropdownlabel as staffDataStatusIn', 'staffDataStatusIn.id', '=', 'inputData.staff_data_status')
            ->leftJoin('dropdownlabel as staffDataStatusOut', 'staffDataStatusOut.id', '=', 'outputData.staff_data_status')
            ->leftJoin('dropdownlabel as dataStatusIn', 'dataStatusIn.id', '=', 'inputData.data_status')
            ->leftJoin('dropdownlabel as dataStatusOut', 'dataStatusOut.id', '=', 'outputData.data_status')
            ->leftJoin('user_application as inputSender', 'inputSender.id', '=', 'inputData.sender')
            ->leftJoin('user_application as outputSender', 'outputSender.id', '=', 'outputData.sender')
            ->where('translate.id', $id)
            ->get();

        $result = $translateData->toArray();

        return $result;
    }
}
