<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkingTime extends Model
{
    protected $table = 'working_time';

    public $timestamps = false;

    public function selectWorkingTimeInProject($projectId, $limit = [])
    {
        try {
            $columns = [
                'working_time.date as input_date',
                'working_time.project_id as project_id',
                'working_time.working_time_type as working_time_type',
                'working_time.working_time_group as working_time_group',
                'userApplication.short_name as short_name',
                'userApplication.id as staff_id',
                'userApplication.staff_id as staff_id_string',
                'working_time.office_hour as office_hour',
                'working_time.work_content as work_content',
                'working_time.note as note',
                'working_time.id as id'
            ];

            $workingTimeList = DB::table($this->table)
                ->select($columns)
                ->join('user_application as userApplication', 'userApplication.id', 'working_time.staff_id')
                ->where('working_time.project_id', $projectId)
                ->orderBy('working_time.date', 'desc')
                ->orderBy('working_time.staff_id')
                ->get();

            $result = $workingTimeList->toArray();
    
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function insertWorkingTime($workingTimeList, $actor = null, $time = null)
    {
        if(empty($workingTimeList)) return true;
        try{
            $workingTimeRows = [];
            foreach($workingTimeList as $workingTime){
                $row = [
                    'project_id' => $workingTime['project_id'],
                    'staff_id' => $workingTime['staff_id'],
                    'date' => $workingTime['input_date'],
                    'office_hour' => $workingTime['office_hour'],
                    'work_content' => $workingTime['work_content'],
                    'working_time_type' => $workingTime['working_time_type'],
                    'working_time_group' => $workingTime['working_time_group'],
                    'note' => $workingTime['note'],
                    'confirm' => \App\Constants\DropdownLabel::NOT_CONFIRM
                ];
                $workingTimeRows[] = $row;
            };

            DB::table($this->table)
                ->insert($workingTimeRows);
                
            return true;
        }catch(\Exception $e){
            throw $e;
        }
    }

    public function updateWorkingTime($data, $updateWorkingTimeObj, $actor = null, $time = null)
    {
        $updateWorkingTimeObj->project_id = $data['project_id'];
        $updateWorkingTimeObj->staff_id = $data['staff_id'];
        $updateWorkingTimeObj->date = $data['input_date'];
        $updateWorkingTimeObj->work_content = $data['work_content'];
        $updateWorkingTimeObj->office_hour = $data['office_hour'];
        $updateWorkingTimeObj->working_time_type = $data['working_time_type'];
        $updateWorkingTimeObj->working_time_group = $data['working_time_group'];
        $updateWorkingTimeObj->note = $data['note'];
        $updateWorkingTimeObj->save();

        return $updateWorkingTimeObj;
    }
}
