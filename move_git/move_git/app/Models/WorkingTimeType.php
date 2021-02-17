<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkingTimeType extends Model
{
    protected $table = 'working_time_type';

    public $timestamps = false;

    /**
     * get all customers in system
     * @return array
     */

    public function selectAllWorkingTimeTypes()
    {
        $workingTimeTypes = DB::table($this->table)
            ->select('id', 'name', 'description')
            ->get();
        $workingTimeTypes = $workingTimeTypes->toArray();

        return $workingTimeTypes;
    }

}
