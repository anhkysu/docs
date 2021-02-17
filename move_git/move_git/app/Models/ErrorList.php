<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ErrorList extends Model
{
    protected $table = 'error_list';

    public $timestamps = false;

    /**
     * @return array
     */
    public function selectAllErrors()
    {
        $columns = [
            'error_list.id',
            'error_id',
            'type_of_work',
            'error_group',
            'error_content'
        ];

        $errorList = DB::table($this->table)
            ->select($columns)
            ->get();
        $result = $errorList->toArray();

        return $result;
    }

    public function selectDistinctLabelList($labelGroup)
    {
        $labelList = DB::table($this->table)
        ->select($labelGroup.' as label')
        ->distinct($labelGroup)
        ->get();
        $result = $labelList->toArray();

        return $result;
    }
}
