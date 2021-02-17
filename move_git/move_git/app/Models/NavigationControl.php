<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NavigationControl extends Model
{
    protected $table = 'navigation_control';

    protected $connection = 'iam';
    
    public $timestamps = false;

    public function selectAllNavigationControl()
    {
        $navigationControlList = DB::connection($this->connection)->table($this->table)
            ->select('id', 'name', 'attribute', 'parent_id', 'order', 'link')
            ->get();
        $result = $navigationControlList->toArray();

        return $result;
    }

    public function selectAllActiveNavigationControl()
    {
        $navigationControlList = DB::connection($this->connection)->table($this->table)
            ->select('id', 'name', 'attribute', 'parent_id', 'order', 'link')
            ->whereNotNull('link')
            ->get();
        $result = $navigationControlList->toArray();

        return $result;
    }
}
