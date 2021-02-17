<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JointStaff extends Model
{
    protected $table = 'joint_staff';

    public $timestamps = false;

    /**
     * Insert a joint staff List to Project
     *
     * @param $staffList
     * @param $projectId
     * @return bool
     * @throws \Exception
     */
    public function insertBulkJointStaff($staffList, $projectId)
    {
        if(empty($staffList) || empty($projectId)) return true;
        
        try{
            $jointStaffRows = [];
            foreach($staffList as $jointStaff){
                $jointStaff = [
                    'staff_id' => $jointStaff,
                    'project_id' => $projectId
                ];
                $jointStaffRows[] = $jointStaff;
            }
            DB::table($this->table)
                ->insert($jointStaffRows);
            return true;

        }catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Get all JointStaff in Project with many information
     */
    public function selectJointStaffInProject($projectId)
    {
        if(empty($projectId)) return [];
        $columns = [
            'joint_staff.id as joint_staff_id',
            'jointStaff.staff_id as staff_id',
            'jointStaff.short_name as short_name',
            'jointStaff.team as team',
            'jointStaff.job_title as job_title',
            'jointStaff.id as ua_id',
            'jointStaff.uuid as user_uuid',
            DB::raw('CAST(qrt1.s  as decimal(10,2)) as drawing_time_sum'),
            DB::raw('CAST(qrt2.s  as decimal(10,2)) as checking_time_sum'),
            DB::raw('
                CASE
                WHEN (COALESCE(qrt3.s, 0) + COALESCE(qrt4.s, 0)) = 0 THEN NULL
                else CAST((COALESCE(qrt3.s, 0) + COALESCE(qrt4.s, 0)) as decimal(10,2))
                END as working_factor_i
            '),
            DB::raw('
                CASE
                WHEN (COALESCE(qrt5.s, 0) + COALESCE(qrt6.s, 0)) = 0 THEN NULL
                else CAST((COALESCE(qrt5.s, 0) + COALESCE(qrt6.s, 0)) as decimal(10,2))
                END as working_factor_ii
            '),
            DB::raw('
                CASE
                WHEN (COALESCE(qrt7.s, 0) + COALESCE(qrt8.s, 0)) = 0 THEN NULL
                else CAST((COALESCE(qrt7.s, 0) + COALESCE(qrt8.s, 0)) as decimal(10,2))
                END as working_factor_iii
            '),
            DB::raw('CAST(wt1.s  as decimal(10,2)) as working_time_sum'),
            DB::raw('
                CASE
                WHEN (COALESCE(qrt3.s, 0) + COALESCE(qrt4.s, 0) + COALESCE(qrt5.s, 0) + COALESCE(qrt6.s, 0) + COALESCE(qrt7.s, 0) + COALESCE(qrt8.s, 0)) = 0 THEN NULL
                else CAST((COALESCE(qrt3.s, 0) + COALESCE(qrt4.s, 0) + COALESCE(qrt5.s, 0) + COALESCE(qrt6.s, 0) + COALESCE(qrt7.s, 0) + COALESCE(qrt8.s, 0)) as decimal(10,2))
                END as quotation_really_time_sum
            '),
            DB::raw('
                CASE
                WHEN (COALESCE(qrt3.s, 0) + COALESCE(qrt4.s, 0) + COALESCE(qrt5.s, 0) + COALESCE(qrt6.s, 0) + COALESCE(qrt7.s, 0) + COALESCE(qrt8.s, 0)) = 0 THEN NULL
                WHEN COALESCE(wt1.s, 0) = 0 THEN NULL
                else  CONCAT_WS("%", CAST((COALESCE(qrt3.s, 0) + COALESCE(qrt4.s, 0) + COALESCE(qrt5.s, 0) + COALESCE(qrt6.s, 0) + COALESCE(qrt7.s, 0) + COALESCE(qrt8.s, 0))/(COALESCE(wt1.s, 0))*100 as decimal(10,2)),"")
                END as temp_productivity
            '),
            'es1.s as technical_error_sum',
            'qc1.s as qc_error_sum'
        ];
        $jointStaffSummary = DB::table($this->table)
        ->select($columns)
        ->join('user_application as jointStaff', 'jointStaff.id', '=', 'joint_staff.staff_id')
        ->leftJoin(
            DB::raw("(SELECT qr1.drawing_staff_id, (CAST(SUM(qr1.really_draw_time) AS decimal(10,2))/60) AS s FROM quotation_really_time AS qr1 WHERE qr1.project_id = $projectId GROUP BY qr1.drawing_staff_id) qrt1"), 
            'qrt1.drawing_staff_id', '=', 'joint_staff.staff_id'
        )
        ->leftJoin(
            DB::raw("(SELECT qr2.checking_staff_id, (CAST(SUM(qr2.really_check_time) AS decimal(10,2))/60) AS s FROM quotation_really_time AS qr2 WHERE qr2.project_id = $projectId GROUP BY qr2.checking_staff_id) qrt2"), 
            'qrt2.checking_staff_id', '=', 'joint_staff.staff_id'
        )  
        ->leftJoin(
            DB::raw("(SELECT wt.staff_id, CAST(SUM(wt.office_hour) AS decimal(10,2)) AS s FROM working_time AS wt WHERE wt.project_id = $projectId GROUP BY wt.staff_id) wt1"), 
            'wt1.staff_id', '=', 'joint_staff.staff_id'
        )
        ->leftJoin(
            DB::raw("(SELECT qr.drawing_staff_id, CAST(SUM(qr.estimate_time * (1- qr.factor)) as decimal(10,2))/60 AS s FROM quotation_really_time AS qr WHERE qr.project_id = $projectId AND qr.working_factor = 32 GROUP BY qr.drawing_staff_id) qrt3"), 
            'qrt3.drawing_staff_id', '=', 'joint_staff.staff_id'
        )
        ->leftJoin(
            DB::raw("(SELECT qr.checking_staff_id, CAST(SUM(qr.estimate_time * qr.factor) as decimal(10,2))/60 AS s FROM quotation_really_time AS qr WHERE qr.project_id = $projectId AND qr.working_factor = 32 GROUP BY qr.checking_staff_id) qrt4"), 
            'qrt4.checking_staff_id', '=', 'joint_staff.staff_id'
        )
        ->leftJoin(
            DB::raw("(SELECT qr.drawing_staff_id, CAST(SUM(qr.estimate_time * (1 - qr.factor)) as decimal(10,2))/60 AS s FROM quotation_really_time AS qr WHERE qr.project_id = $projectId AND qr.working_factor = 33 GROUP BY qr.drawing_staff_id) qrt5"), 
            'qrt5.drawing_staff_id', '=', 'joint_staff.staff_id'
        )
        ->leftJoin(
            DB::raw("(SELECT qr.checking_staff_id, CAST(SUM(qr.estimate_time * qr.factor) as decimal(10,2))/60 AS s FROM quotation_really_time AS qr WHERE qr.project_id = $projectId AND qr.working_factor = 33 GROUP BY qr.checking_staff_id) qrt6"), 
            'qrt6.checking_staff_id', '=', 'joint_staff.staff_id'
        )
        ->leftJoin(
            DB::raw("(SELECT qr.drawing_staff_id, CAST(SUM(qr.estimate_time * (1 - qr.factor)) as decimal(10,2))/60 AS s FROM quotation_really_time AS qr WHERE qr.project_id = $projectId AND qr.working_factor = 34 GROUP BY qr.drawing_staff_id) qrt7"), 
            'qrt7.drawing_staff_id', '=', 'joint_staff.staff_id'
        )
        ->leftJoin(
            DB::raw("(SELECT qr.checking_staff_id, CAST(SUM(qr.estimate_time * qr.factor) as decimal(10,2))/60 AS s FROM quotation_really_time AS qr WHERE qr.project_id = $projectId AND qr.working_factor = 34 GROUP BY qr.checking_staff_id) qrt8"), 
            'qrt8.checking_staff_id', '=', 'joint_staff.staff_id'
        )
        ->leftJoin(
            DB::raw("(SELECT es.violator, SUM(es.times) as s FROM error_statistic AS es WHERE es.project_id = $projectId GROUP BY es.violator) es1"), 
            'es1.violator', '=', 'joint_staff.staff_id'
        )
        ->leftJoin(
            DB::raw("(SELECT qc.staff_id, SUM(qc.number) as s FROM quality_control AS qc, output_data as od WHERE qc.output_data_id = od.id AND od.project_id = $projectId GROUP BY qc.staff_id) qc1"), 
            'qc1.staff_id', '=', 'joint_staff.staff_id'
        )
        ->where('joint_staff.project_id', '=', $projectId)
        ->get();
        $result = $jointStaffSummary->toArray();

        return $result;
    }
}
