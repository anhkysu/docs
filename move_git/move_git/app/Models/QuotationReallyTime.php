<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuotationReallyTime extends Model
{
    protected $table = 'quotation_really_time';

    public $timestamps = false;

    public function getProject()
    {
        return $this->belongsTo('\App\Models\ProjectInformation', 'project_id');
    }

    public function selectQuotationTimeInProject($projectId, $limit = [], $search)
    {
        $columns = [
            'quotation_really_time.id as id', 
            'quotation_really_time.project_id as project_id', 
            'ddl_working_factor.value as working_factor', 
            'ddl_working_factor.id as working_factor_id',
            'quotation_really_time.unit as unit', 
            'quotation_really_time.dwg_name as dwg_name', 
            'quotation_really_time.estimate_time as estimate_time', 
            'quotation_really_time.really_draw_time as really_draw_time', 
            'quotation_really_time.finish_draw_date as finish_draw_date', 
            'drawing_staff.short_name as drawing_staff_name', 
            'drawing_staff.staff_id as drawing_staff_id',
            'quotation_really_time.really_check_time as really_check_time', 
            'quotation_really_time.finish_check_date as finish_check_date', 
            'checking_staff.short_name as checking_staff_name', 
            'checking_staff.staff_id as checking_staff_id', 
            'quotation_really_time.factor as factor', 
            'quotation_really_time.note as note', 
            'quotation_really_time.confirm as confirm'
        ];
        $quotationTimeList = DB::table($this->table)
            ->select($columns)
            ->leftJoin('dropdownlabel as ddl_working_factor', 'quotation_really_time.working_factor', '=', 'ddl_working_factor.id')
            ->leftJoin('user_application as drawing_staff', 'quotation_really_time.drawing_staff_id', '=', 'drawing_staff.id')
            ->leftJoin('user_application as checking_staff', 'quotation_really_time.checking_staff_id', '=', 'checking_staff.id')
            ->where('quotation_really_time.project_id', $projectId)
            ->get();
        $result = $quotationTimeList->toArray();
        if(!empty($search)){
            $result = array_filter($result, function ($v, $k) use ($search) {
                return strpos($v->unit, $search) !== false || strpos($v->dwg_name, $search) !== false ;
            }, ARRAY_FILTER_USE_BOTH);
            $result = array_values($result);
        }
        return $result;
    }

    public function insertBulkQuotatinReallyTime($quotationTimeList, $actor = null, $time = null)
    {
        if(empty($quotationTimeList)) return true;
        
        try{
            $quotationTimeRows = [];
            foreach($quotationTimeList as $quotationTime){
                $row = [
                    'working_factor' => $quotationTime['working_factor'],
                    'project_id' => $quotationTime['project_id'],
                    'unit' => $quotationTime['unit'],
                    'dwg_name' => $quotationTime['dwg_name'],
                    'estimate_time' => $quotationTime['estimate_time'],
                    'note' => $quotationTime['note'],
                    'factor' => $quotationTime['factor'] ?? null,
                    'really_draw_time' => $quotationTime['really_draw_time'] ?? null,
                    'finish_draw_date' => $quotationTime['finish_draw_date'] ?? null,
                    'drawing_staff_id' => $quotationTime['drawing_staff_id'] ?? null,
                    'really_check_time' => $quotationTime['really_check_time'] ?? null,
                    'finish_check_date' => $quotationTime['finish_check_date'] ?? null,
                    'checking_staff_id' => $quotationTime['checking_staff_id'] ?? null,
                    'updated_at' => $time,
                    'updated_by' => $actor,
                    'created_at' => $time,
                    'created_by' => $actor
                ];
                $quotationTimeRows[] = $row;
            }
            DB::table($this->table)
                ->insert($quotationTimeRows);
            return true;

        }catch(\Exception $e){
            throw $e;
        }
    }

    public function updateQuotationTime($data, $updateQuotationTimeObj, $actor = null, $time = null)
    {
        if(!empty($data['really_draw_time'])){
            $updateQuotationTimeObj->really_draw_time = $data['really_draw_time'] == 'NAN' ? null : $data['really_draw_time'];
            $updateQuotationTimeObj->drawing_staff_id = $data['drawing_staff_id'];
            $updateQuotationTimeObj->finish_draw_date = $data['finish_draw_date'];
        } else if (!empty($data['really_check_time'])){
            $updateQuotationTimeObj->really_check_time = $data['really_check_time'] == 'NAN' ? null : $data['really_check_time'];
            $updateQuotationTimeObj->checking_staff_id = $data['checking_staff_id'];
            $updateQuotationTimeObj->finish_check_date = $data['finish_check_date'];
        } else if (!empty($data['factor'])){
            $updateQuotationTimeObj->factor = $data['factor'];
        } else {
            $updateQuotationTimeObj->working_factor = $data['working_factor'];
            $updateQuotationTimeObj->unit = $data['unit'];
            $updateQuotationTimeObj->dwg_name = $data['dwg_name'];
            $updateQuotationTimeObj->estimate_time = $data['estimate_time'];
            $updateQuotationTimeObj->note = $data['note'];
        }
        $updateQuotationTimeObj->updated_at = $time;
        $updateQuotationTimeObj->updated_by = $actor;
        $updateQuotationTimeObj->save();

        return $updateQuotationTimeObj;
    }

    public function updateBulkQuotatinReallyTime($quotationTimeList, $actor = null, $time = null)
    {
        if(empty($quotationTimeList)) return true;
        
        try{
            foreach($quotationTimeList as $quotationTime){
                //$this->updateQuotationTime($quotationTime, )
            }

            return true;

        }catch(\Exception $e){
            throw $e;
        }
    }

}
