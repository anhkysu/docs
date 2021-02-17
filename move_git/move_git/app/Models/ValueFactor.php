<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ValueFactor extends Model
{
    protected $table = 'value_factor';

    public $timestamps = false;

    /**
     * @param $groupValue
     * @return array
     */
    public function selectAllValueFactors()
    {
        $valueFactorList = DB::table($this->table)
            ->select('id', 'value', 'description')
            ->get();
        $result = $valueFactorList->toArray();
        
        return $result;
    }

}
