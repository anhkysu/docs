<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserApplication extends Model
{
    protected $table = 'user_application';

    public $timestamps = false;

    public function selectUsersByJobTitle()
    {
        $userList = DB::table($this->table)
            ->select('id', 'short_name', 'staff_id', 'full_name')
            ->orderBy('id', 'ASC')
            ->get();
        $result = $userList->toArray();

        return $result;
    }

    public function selectActiveUsers(){
        $userList = DB::table($this->table)
            ->select('id', 'short_name', 'staff_id',  'team')
            ->where('status', '<>', \App\Constants\User::USER_SIGN_OFF)
            ->orderBy('team', 'ASC')
            ->orderBy('id', 'ASC')
            ->get();
        $result = $userList->toArray();

        return $result;
    }

    public function selectTranslatorList()
    {
        $userList = DB::table($this->table)
            ->select('id', 'uuid as user_uuid', 'id as ua_id', 'short_name', 'full_name', 'staff_id')
            ->where('status', '=', \App\Constants\User::USER_OFFICIAL)
            ->where('team', '=', \App\Constants\User::USER_TEAM_TRANSLATOR)
            ->orderBy('id', 'ASC')
            ->get();
        $result = $userList->toArray();

        return $result;
    }

    public function selectUserById($user_id)
    {
        $user = DB::table($this->table)
            ->select('id','uuid as user_uuid', 'id as ua_id', 'short_name', 'staff_id','full_name', 'team')
            ->where('id', '=', $user_id)
            ->get();
        $result = $user->toArray();

        return $result;
    }

    public function selectUserListByStaffIdListAndIndexByStaffId($staffIdList)
    {
        $result = [];
        $userList = DB::table($this->table)
            ->select('id', 'short_name', 'staff_id')
            ->whereIn('staff_id', $staffIdList)
            ->orderBy('id', 'ASC')
            ->get();
        $userList = $userList->toArray();
        foreach($userList as $user){
            $result[$user->staff_id] = $user;
        }

        return $result;
    }

}
