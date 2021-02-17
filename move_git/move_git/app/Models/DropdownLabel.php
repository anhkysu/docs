<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DropdownLabel extends Model
{
    protected $table = 'dropdownlabel';

    public $timestamps = false;

    /**
     * @param $groupValue
     * @return array
     */
    public function selectListByGroup($group)
    {
        $dropdownlabelList = DB::table($this->table)
            ->select('id', 'label', 'value', 'group', 'description')
            ->where('group', 'LIKE', $group)
            ->get();
        $result = $dropdownlabelList->toArray();
        
        return $result;
    }

    public function indexSelectListByGroupByLabel($group)
    {
        $result = [];
        $list = $this->selectListByGroup($group);
        foreach($list as $item){
            $result[$item->label] = $item;
        }

        return $result;
    }

}
