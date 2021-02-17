<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Unit extends Model
{
    protected $table = 'unit';

    public $timestamps = false;

    /**
     * get all units in system
     * @return array
     */
    public function selectAllUnits()
    {
        $unitList = DB::table($this->table)
            ->select('id', 'unit_id', 'description')
            ->get();
        $result = $unitList->toArray();
        
        return $result;
    }

}
