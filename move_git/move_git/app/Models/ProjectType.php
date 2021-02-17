<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectType extends Model
{
    protected $table = 'project_type';

    public $timestamps = false;

    /**
     * get all customers in system
     * @return array
     */
    public function selectAllCustomers()
    {
        $customerList = DB::table($this->table)
            ->select('id', 'label', 'value', 'group', 'description')
            ->get();
        $result = $customerList->toArray();
        
        return $result;
    }

}
