<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TechnicalError extends Model
{
    protected $table = 'error_statistic';

    public $timestamps = false;

    public function selectTechnicalErrorInProject($projectId, $limit = [])
    {
        try {
            $columns = [
                'error_statistic.id as id',
                'error_statistic.project_id as project_id',
                'error_statistic.discoverer as discoverer',
                'error_statistic.times as times',
                'errorList.type_of_work as type_of_work',
                'errorList.error_group as error_group',
                'errorList.id as error_id',
                'errorList.error_id as error_id_string',
                'errorList.error_content as error_content',
                'violatorInfo.id as violator',
                'violatorInfo.staff_id as violator_staff_id',
                'violatorInfo.short_name as violator_short_name',
                'output_data.path as output_data_path',
                'output_data.id as output_data_id',
                'error_statistic.input_date as input_date',
                'error_statistic.check_date as check_date'
            ];

            $technicalErrorList = DB::table($this->table)
                ->select($columns)
                ->join('error_list as errorList', 'errorList.id', '=', 'error_statistic.error_id')
                ->join('user_application as violatorInfo', 'violatorInfo.id', '=', 'error_statistic.violator')
                ->join('output_data', 'output_data.id', '=', 'error_statistic.output_data_id')
                ->where('error_statistic.project_id', $projectId)
                ->get();
            $result = $technicalErrorList->toArray();
    
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function insertTechnicalError($technicalErrorList, $actor = null, $time = null)
    {
        if(empty($technicalErrorList)) return true;
        try{
            $technicalErrorRows = [];
            foreach($technicalErrorList as $technicalError){
                $row = [
                    'project_id' => $technicalError['project_id'],
                    'error_id' => $technicalError['error_id'],
                    'discoverer' => $technicalError['discoverer'],
                    'violator' => $technicalError['violator'],
                    'times' => $technicalError['times'],
                    'output_data_id' => $technicalError['output_data_id'],
                    'input_date' => $time,
                ];
                $technicalErrorRows[] = $row;
            };
            
            DB::table($this->table)
                ->insert($technicalErrorRows);
                
            return true;
        }catch(\Exception $e){
            throw $e;
        }
    }

    public function updateTechnicalError($data, $updateTechnicalErrorObj, $actor = null, $time = null)
    {
        $updateTechnicalErrorObj->error_id = $data['error_id'];
        $updateTechnicalErrorObj->discoverer = $data['discoverer'];
        $updateTechnicalErrorObj->times = $data['times'];
        $updateTechnicalErrorObj->output_data_id = $data['output_data_id'];
        $updateTechnicalErrorObj->input_date = $time;
        $updateTechnicalErrorObj->save();

        return $updateTechnicalErrorObj;
    }
}
