<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TotalHour extends Model
{
    protected $table = 'total_hour';

    public $timestamps = false;

    /**
     *
     * @param $projectId
     * @return TotalHour
     */
    public function insertTotalHour($projectId)
    {
        $newTotalHourObj = new \App\Models\TotalHour();
        $newTotalHourObj->project_id = $projectId;
        $newTotalHourObj->save();

        return $newTotalHourObj;
    }
}
