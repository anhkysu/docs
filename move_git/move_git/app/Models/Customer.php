<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    protected $table = 'customer';

    public $timestamps = false;

    /**
     * get all customers in system
     * @return array
     */

    public function selectAllCustomers()
    {
        $customerList = DB::table($this->table)
            ->select('id', 'customer_id')
            ->orderBy('customer_id', 'ASC')
            ->get();
        $customerList = $customerList->toArray();

        return $customerList;
    }

}
