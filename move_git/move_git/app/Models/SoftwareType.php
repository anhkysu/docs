<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SoftwareType extends Model
{
    protected $table = 'software_type';

    public $timestamps = false;

    /**
     * @param $groupValue
     * @return array
     */
    public function selectAllSoftwareTypes()
    {
        $valueFactorList = DB::table($this->table)
            ->select('id', 'name', 'description')
            ->get();
        $result = $valueFactorList->toArray();
        
        return $result;
    }

}
