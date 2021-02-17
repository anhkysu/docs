<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RefWorkingTime extends Model
{
    protected $table = 'ref_working_time';

    public $timestamps = false;

    /**
     * get all customers in system
     * @return array
     */

    public function selectAllRefWorkingTime()
    {
        $refWorkingTime = DB::table($this->table)
            ->select('id', 'working_time_type', 'working_time_group', 'name', 'description')
            ->get();
        $refWorkingTimeList = $refWorkingTime->toArray();

        return $refWorkingTimeList;
    }

}
