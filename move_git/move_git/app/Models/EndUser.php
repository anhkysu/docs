<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EndUser extends Model
{
    protected $table = 'end_user';

    public $timestamps = false;

    /**
     * @return array
     */
    public function selectAllEndUsers()
    {
        $endUserList = DB::table($this->table)
            ->select('id', 'name', 'description', 'email')
            ->get();
        $result = $endUserList->toArray();

        return $result;
    }

}
