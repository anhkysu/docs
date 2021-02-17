<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkingTimeGroup extends Model
{
    protected $table = 'working_time_group';

    public $timestamps = false;

    /**
     * get all customers in system
     * @return array
     */

    public function selectAllWorkingTimeGroups()
    {
        $WorkingTimeGroups = DB::table($this->table)
            ->select('id', 'name', 'description', 'working_time_type')
            ->get();
        $WorkingTimeGroups = $WorkingTimeGroups->toArray();

        return $WorkingTimeGroups;
    }

}
