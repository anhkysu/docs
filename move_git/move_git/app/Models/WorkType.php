<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkType extends Model
{
    protected $table = 'work_type';

    public $timestamps = false;

    /**
     * @param $groupValue
     * @return array
     */
    public function selectAllWorkTypes()
    {
        $valueFactorList = DB::table($this->table)
            ->select('id', 'name', 'description')
            ->get();
        $result = $valueFactorList->toArray();
        
        return $result;
    }

}
