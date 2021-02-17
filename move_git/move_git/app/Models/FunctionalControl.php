<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FunctionalControl extends Model
{
    protected $table = 'functional_control';

    public $timestamps = false;
    
    protected $connection = 'iam';

    public function selectAllFunctionalControl()
    {
        $functionalControlList = DB::table($this->table)
            ->select('id', 'name', 'attribute')
            ->get();
        $result = $functionalControlList->toArray();

        return $result;
    }

}
