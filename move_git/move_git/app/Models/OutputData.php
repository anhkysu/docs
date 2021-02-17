<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OutputData extends Model
{
    protected $table = 'output_data';

    public $timestamps = false;

    public function getTranslate()
    {
        return $this->hasOne('\App\Models\Translate', 'output_data_id');
    }

    public function getProject()
    {
        return $this->belongsTo('\App\Models\ProjectInformation', 'project_id');
    }

    /**
     * get OutputData for a project, the amount of retreiving is based on $limit
     * @param $projectId
     * @param $limit
     * @return array
     */
    public function selectOutputDataInProject($projectId, $limit, $search)
    {
        $columns = [
            'output_data.id as id',
            'output_data.datetime as datetime',
            'dataStatus.value as data_status',
            'dataStatus.id as data_status_id',
            'ua.short_name as sender',
            'ua.id as sender_id',
            'ua.staff_id as staff_id',
            'output_data.name as name',
            'dataOutputType.value as data_type',
            'dataOutputType.id as data_type_id',
            'staffDataStatus.value as staff_data_status',
            'staffDataStatus.id as staff_data_status_id',
            'output_data.subject_mail as subject_mail',
            'output_data.path as path',
            't.id as translate_id',
            't.original_mail as original_mail',
            't.translated_mail as translated_mail',
            'translator.short_name as translator',
            'translator.id as translator_id',
            'translatorSuggested.short_name as translator_suggested',
            'translatorSuggested.id as translator_suggested_id',
            'dataTranslateStatus.value as data_translate_status',
            'dataTranslateStatus.id as data_translate_status_id',
            'output_data.path as attach_file'
        ];
        $outputDataList = DB::table($this->table)
            ->select($columns)
            ->join('user_application as ua', 'ua.id', '=', 'output_data.sender')
            ->leftJoin('dropdownlabel as dataStatus', 'dataStatus.id', '=', 'output_data.data_status')
            ->leftJoin('dropdownlabel as dataOutputType', 'dataOutputType.id', '=', 'output_data.data_out_type')
            ->leftJoin('dropdownlabel as staffDataStatus', 'staffDataStatus.id', '=', 'output_data.staff_data_status')
            ->join('translate as t', 't.output_data_id', '=', 'output_data.id')
            ->leftJoin('dropdownlabel as dataTranslateStatus', 'dataTranslateStatus.id', '=', 't.data_translate_status')
            ->leftJoin('user_application as translator', 'translator.id', '=', 't.translator')
            ->leftJoin('user_application as translatorSuggested', 'translatorSuggested.id', '=', 't.translator_suggested')
            ->where('output_data.project_id', $projectId)
            ->get();
        $result = $outputDataList->toArray();
        if(!empty($search)){
            $result = array_filter($result, function ($v, $k) use ($search) {
                return strpos($v->original_mail, $search) !== false || strpos($v->translated_mail, $search) !== false ;
            }, ARRAY_FILTER_USE_BOTH);
            $result = array_values($result);
        }

        return $result;
    }

    public function selectSendOutputData($conditions)
    {
        $columns = [
            'output_data.id as id',
            'output_data.datetime as datetime',
            'output_data.project_id as project_id',
            'pi.project_id as project_id_string',
            'ua.short_name as sender',
            'ua.staff_id as staff_id',
            'ua.team as team',
            'ua.department as department',
            'output_data.qc_er as qc_checked',
            'output_data.qa_er as qa_checked',
            'output_data.feedback_qc as feedback_qc',
            'output_data.feedback_qa as feedback_qa',
            'output_data.error_qc_found as error_qc_found',
            'errorStats.total as total_submitted_errors',
            'pi.project_name as project_name',
            'output_data.path as path'
        ];
        $outputDataList = DB::table($this->table)
            ->select($columns)
            ->leftJoin('user_application as ua', 'ua.id', '=', 'output_data.sender')
            ->leftJoin('project_information as pi', 'pi.id', '=', 'output_data.project_id')
            ->leftJoin(DB::raw('(SELECT SUM(es.times) as total, output_data_id FROM error_statistic AS es GROUP BY output_data_id) as errorStats'), 'errorStats.output_data_id', '=', 'output_data.id')
            ->where('output_data.data_status', '=', \App\Constants\DropdownLabel::IO_DATA_STATUS_DONE_PROGRESS_ID)
            ->whereIn('output_data.data_out_type', [\App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID, \App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE_GUI_HANG_SEND_ID_FILE_ASK_ID])
            ->where([
                ['output_data.datetime', '>=', $conditions['startDate']],
                ['output_data.datetime', '<', $conditions['endDate']]
            ]);

        if (!empty($conditions['staffId'])) {
            $projectsBelongsToUser = DB::table('joint_staff')->where('staff_id', '=', $conditions['staffId'])->pluck('project_id')->toArray();
            $outputDataList = $outputDataList
                ->where(function($q) use ( $projectsBelongsToUser, $conditions){
                    $q -> where('pi.team_manager', '=', $conditions['staffId'])
                    ->orWhere('pi.project_manager', '=', $conditions['staffId'])
                    ->orWhereIn('pi.id', $projectsBelongsToUser);
            }); 
        } else {
            $outputDataList = $outputDataList->where('ua.team', 'LIKE', '%' . $conditions['team'] . '%');
        }

        $result = $outputDataList->orderBy('output_data.datetime', "DESC")->get()->toArray();

        return $result;
    }

    public function insertOutputData($data, $actor, $time)
    {
        $newOutputDataObj = new \App\Models\OutputData();
        $newOutputDataObj->datetime = $data['datetime'];
        $newOutputDataObj->data_status = $data['data_status'];
        $newOutputDataObj->sender = $data['sender'];
        $newOutputDataObj->project_id = $data['project_id'];
        $newOutputDataObj->data_out_type = $data['data_output_type'];
        $newOutputDataObj->name = $data['name'];
        $newOutputDataObj->path = $data['path'];
        $newOutputDataObj->subject_mail = $data['subject_mail'];
        $newOutputDataObj->original_mail = $data['original_mail'];
        $newOutputDataObj->staff_data_status = $data['staff_data_status'];
        $newOutputDataObj->save();

        return $newOutputDataObj;
    }

    public function updateOutputData($data, $updateOutputDataObj, $actor, $time)
    {
        $updateOutputDataObj->datetime = $data['datetime'];
        $updateOutputDataObj->data_status = $data['data_status'];
        $updateOutputDataObj->sender = $data['sender'];
        $updateOutputDataObj->project_id = $data['project_id'];
        $updateOutputDataObj->data_out_type = $data['data_output_type'];
        $updateOutputDataObj->name = $data['name'];
        $updateOutputDataObj->path = $data['path'];
        $updateOutputDataObj->subject_mail = $data['subject_mail'];
        $updateOutputDataObj->original_mail = $data['original_mail'];
        $updateOutputDataObj->staff_data_status = $data['staff_data_status'];
        $updateOutputDataObj->save();

        return $updateOutputDataObj;
    }

    public function selectOutputMailTodayByProjectID($projectId, $date, $condition)
    {
        $columns = [
            'output_data.id'
        ];
        $outputDataList = DB::table($this->table)
            ->select($columns)
            ->join('translate as t', 't.output_data_id', '=', 'output_data.id')
            ->where('output_data.project_id', $projectId)
            ->where(DB::raw('DATE_FORMAT(t.created_at,"%Y-%m-%d")'), $date)
            ->whereIn('output_data.data_out_type', $condition['data_type_list'])
            ->get();
        $result = $outputDataList->toArray();

        return $result;
    }

    public function selectOutputDataTodayByProjectID($projectId, $date, $condition)
    {
        $columns = [
            'output_data.id'
        ];
        $outputDataList = DB::table($this->table)
            ->select($columns)
            ->join('translate as t', 't.output_data_id', '=', 'output_data.id')
            ->where('output_data.project_id', $projectId)
            ->where(DB::raw('DATE_FORMAT(t.created_at,"%Y-%m-%d")'), $date)
            ->whereIn('output_data.data_out_type', $condition['data_type_list'])
            ->get();
        $result = $outputDataList->toArray();

        return $result;
    }

    public function checkExistsLinkOutput($pathSend, $pathSent)
    {
        $columns = [
            'output_data.id'
        ];
        $outputDataList = DB::table($this->table)
            ->select($columns)
            ->where('output_data.path', $pathSend)
            ->orWhere('output_data.path', $pathSent)
            ->get();
        $result = $outputDataList->toArray();

        return $result;
    }
}
