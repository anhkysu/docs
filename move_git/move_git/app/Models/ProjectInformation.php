<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectInformation extends Model
{
    protected $table = 'project_information';

    public $timestamps = false;

    public function getTeamManager()
    {
        $teamManager = new \stdClass();
        $teamManagerList = $this->belongsTo('\App\Models\UserApplication', 'team_manager');
        $teamManagerList = $teamManagerList->get();
        if(count($teamManagerList)){
            $teamManagerObj = $teamManagerList[0];
            $teamManager->staff_joint_id = 0;
            $teamManager->staff_id = $teamManagerObj->staff_id;
            $teamManager->short_name = $teamManagerObj->short_name;
            $teamManager->job_title = $teamManagerObj->job_title;
            $teamManager->team = $teamManagerObj->team;
            $teamManager->ua_id = $teamManagerObj->id;
            $teamManager->id = $teamManagerObj->id;
            $teamManager->user_uuid = $teamManagerObj->uuid;
        }
        
        return $teamManager;
    }

    public function getProjectManager()
    {
        $projectManager = new \stdClass();
        $projectManagerList = $this->belongsTo('\App\Models\UserApplication', 'project_manager');
        $projectManagerList = $projectManagerList->get();
        if(count($projectManagerList)){
            $projectManagerObj = $projectManagerList[0];
            $projectManager->staff_joint_id = 0;
            $projectManager->staff_id = $projectManagerObj->staff_id;
            $projectManager->short_name = $projectManagerObj->short_name;
            $projectManager->job_title = $projectManagerObj->job_title;
            $projectManager->team = $projectManagerObj->team;
            $projectManager->ua_id = $projectManagerObj->id;
            $projectManager->id = $projectManagerObj->id;
            $projectManager->user_uuid = $projectManagerObj->uuid;
        }
        
        return $projectManager;
    }

    /**
     * insert a new project with essential data
     *
     * @param $data
     * @param $actor
     * @param $time
     * @return ProjectInformation
     */
    public function insertProjectInformation($data, $actor, $time)
    {
        $newProjectInfoObj = new \App\Models\ProjectInformation();
        $newProjectInfoObj->project_id = $data['projectInfo']['project_id'];
        $newProjectInfoObj->customer_id = $data['projectInfo']['customer_id'];
        $newProjectInfoObj->status = $data['projectInfo']['status'];
        $newProjectInfoObj->project_path = $data['projectInfo']['project_path'];
        $newProjectInfoObj->project_name = $data['projectInfo']['project_name'];
        $newProjectInfoObj->working_factor_i = $data['admin']['working_factor_i'];
        $newProjectInfoObj->working_factor_ii = $data['admin']['working_factor_ii'];
        $newProjectInfoObj->working_factor_iii = $data['admin']['working_factor_iii'];
        $newProjectInfoObj->project_manager = $data['admin']['project_manager'];
        $newProjectInfoObj->team_manager = $data['admin']['team_manager'];
        $newProjectInfoObj->created_at = $time;
        $newProjectInfoObj->create_date = $time;
        $newProjectInfoObj->created_by = $actor;
        $newProjectInfoObj->updated_at = $time;
        $newProjectInfoObj->updated_by = $actor;
        $newProjectInfoObj->save();

        return $newProjectInfoObj;
    }

    public function updateProjectInformation($data, $updateProjectInfoObj, $actor, $time)
    {
        #projectInfo
        $updateProjectInfoObj->project_id = $data['projectInfo']['project_id'];
        $updateProjectInfoObj->customer_id = $data['projectInfo']['customer_id'];
        $updateProjectInfoObj->status = $data['projectInfo']['status'];
        $updateProjectInfoObj->project_path = $data['projectInfo']['project_path'];
        $updateProjectInfoObj->project_name = $data['projectInfo']['project_name'];
        $updateProjectInfoObj->end_user_id = $data['projectInfo']['end_user_id'];
        $updateProjectInfoObj->remark = $data['projectInfo']['remark'];
        $updateProjectInfoObj->amount = $data['projectInfo']['amount'];
        $updateProjectInfoObj->unit_id = $data['projectInfo']['unit_id'];
        $updateProjectInfoObj->start_date = $data['projectInfo']['start_date'];
        $updateProjectInfoObj->finish_date = $data['projectInfo']['finish_date'];
        #admin
        $updateProjectInfoObj->working_factor_i = $data['admin']['working_factor_i'];
        $updateProjectInfoObj->working_factor_ii = $data['admin']['working_factor_ii'];
        $updateProjectInfoObj->working_factor_iii = $data['admin']['working_factor_iii'];
        $updateProjectInfoObj->project_manager = $data['admin']['project_manager'];
        $updateProjectInfoObj->team_manager = $data['admin']['team_manager'];
        $updateProjectInfoObj->updated_at = $time;
        $updateProjectInfoObj->updated_by = $actor;
        $updateProjectInfoObj->save();

        return $updateProjectInfoObj;
    }

    public function selectProjectInformations($conditions, $actor)
    {
        $projectInformationQuery = DB::table($this->table)
            ->select('*');

        if(!empty($conditions['conditionProjectStatus'])){
            $projectInformationQuery->whereIn('project_information.status', $conditions['conditionProjectStatus']);
        }
        if(!empty($conditions['conditionManagement'])){
            if(!empty($conditions['conditionManagement']['teamManager'])){
                $projectInformationQuery->where('project_information.team_manager', $conditions['conditionManagement']['teamManager']);
            }
            if(!empty($conditions['conditionManagement']['projectManager'])){
                $projectInformationQuery->where('project_information.project_manager', $conditions['conditionManagement']['projectManager']);
            }
        }
        if(!empty($conditions['conditionOrganization'])){
            switch($conditions['conditionOrganization'][0]){
                case \App\Constants\ProjectManagement::ORGANIZATION_INDIVIDUAL: 
                    //  ((pi.Team_Manager = $actor OR pi.Project_Manager = $actor OR 
                    //pi.Project_ID IN (SELECT Project_ID from StaffJoin WHERE Staff_Join_ID = 00002)));
                    $projectIdList = DB::table('joint_staff')
                                    ->select('joint_staff.project_id')
                                    ->where('joint_staff.staff_id', $actor)
                                    ->get();
                    $projectArr = [];                
                    foreach($projectIdList as $projectId){
                        $projectArr[] = $projectId->project_id;
                    }               
                    $projectInformationQuery->where(function ($query) use ($actor, $projectArr){
                        $query->where('project_information.team_manager', $actor)
                              ->orWhere('project_information.project_manager', $actor)
                              ->orWhereIn('project_information.id', $projectArr);
                    });
                break;
                case \App\Constants\ProjectManagement::ORGANIZATION_TEAM: 
                    /**
                     *  AND((pi.Team_Manager IN (SELECT Staff_ID From StaffInformation WHERE Team = N'BOD'))  
                        OR(pi.Project_Manager IN (SELECT Staff_ID From StaffInformation WHERE Team = N'BOD')) 
                        OR pi.Project_ID IN(SELECT Project_ID from StaffJoin WHERE Staff_Join_ID 
                            IN(SELECT Staff_ID From StaffInformation WHERE Team = N'BOD'))) ;
                     */
                    $actorObj = UserApplication::find($actor);
                    $team = $actorObj->team;
                    $actorInTeamList = DB::table('user_application')
                                    ->select('user_application.id')
                                    ->where('user_application.team', $team)
                                    ->get();
                    $actorIdArr = [];                
                    foreach($actorInTeamList as $actorInTeam){
                        $actorIdArr[] = $actorInTeam->id;
                    }
                    $projectIdList = DB::table('joint_staff')
                                    ->select('joint_staff.project_id')
                                    ->join('user_application as ua', 'ua.id', 'joint_staff.staff_id')
                                    ->where('ua.id', $actor)
                                    ->where('ua.team', $team)
                                    ->get();
                    $projectArr = [];                
                    foreach($projectIdList as $projectId){
                        $projectArr[] = $projectId->project_id;
                    }
                    $projectInformationQuery->where(function ($query) use ($actorIdArr, $projectArr){
                        $query->whereIn('project_information.team_manager', $actorIdArr)
                              ->orWhereIn('project_information.project_manager', $actorIdArr)
                              ->orWhereIn('project_information.id', $projectArr);
                    });
                break;
                case \App\Constants\ProjectManagement::ORGANIZATION_DEPARTMENT: 
                    /**
                     * AND ((pi.Team_Manager IN (SELECT Staff_ID From StaffInformation , Organization WHERE StaffInformation.Team = Organization.Team AND Organization.Department = N'ITSC'))  
                        OR (pi.Project_Manager IN (SELECT Staff_ID From StaffInformation , Organization WHERE StaffInformation.Team = Organization.Team AND Organization.Department = N'ITSC')) 
                        OR pi.Project_ID 
                            IN(SELECT Project_ID from StaffJoin WHERE Staff_Join_ID IN(SELECT Staff_ID From StaffInformation , Organization
                            WHERE StaffInformation.Team = Organization.Team AND Organization.Department = N'ITSC'))) 
                     */
                    $actorObj = UserApplication::find($actor);
                    $team = $actorObj->team;
                    $department = $actorObj->department;
                    $actorInTeamList = DB::table('user_application')
                                    ->select('user_application.id')
                                    ->where('user_application.team', $team)
                                    ->where('user_application.department', $department)
                                    ->get();
                    $actorIdArr = [];                
                    foreach($actorInTeamList as $actorInTeam){
                        $actorIdArr[] = $actorInTeam->id;
                    }
                    $projectIdList = DB::table('joint_staff')
                                    ->select('joint_staff.project_id')
                                    ->join('user_application as ua', 'ua.id', 'joint_staff.staff_id')
                                    ->where('ua.id', $actor)
                                    ->where('ua.department', $department)
                                    ->get();
                    $projectArr = [];                
                    foreach($projectIdList as $projectId){
                        $projectArr[] = $projectId->project_id;
                    }
                    $projectInformationQuery->where(function ($query) use ($actorIdArr, $projectArr){
                        $query->whereIn('project_information.team_manager', $actorIdArr)
                              ->orWhereIn('project_information.project_manager', $actorIdArr)
                              ->orWhereIn('project_information.id', $projectArr);
                    });
                break;
                case \App\Constants\ProjectManagement::ORGANIZATION_COMPANY: 
                break; 
            }
        }
        if(!empty($conditions['projectId'])){
            $projectId = $conditions['projectId'];
            $projectInformationQuery->where('project_id', $projectId);
        }
        if(!empty($conditions['userId'])){
            $userId = $conditions['userId'];
            $projectListContainingStaff = DB::table('joint_staff')
            ->where('staff_id', $userId)        
            ->pluck('project_id');
            $projectInformationQuery = DB::table($this->table)
            ->select('id', 'project_id')
            ->whereIn('project_information.status', array(1,2,3,4))
            ->where(function($q) use($userId, $projectListContainingStaff){
                $q
                ->where('project_information.team_manager', $userId)
                ->orWhere('project_information.project_manager', $userId)
                ->orWhereIn('project_information.id', $projectListContainingStaff);
            })
            ->orderBy('project_information.project_id');
        }
        //var_dump($projectInformationQuery->toSql());die;
        $result = $projectInformationQuery->get()->toArray();

        return $result;
    }

    public function selectCustomerHasProjectInformationByMonth($customerId, $date)
    {
        $columns = [
            'project_information.id'
        ];
        $projectInformationList = DB::table($this->table)
            ->select($columns)
            ->where('project_information.customer_id', $customerId)
            ->where(DB::raw('DATE_FORMAT(project_information.created_at,"%Y-%m")'), $date)
            ->get();
        $result = $projectInformationList->toArray();
        
        return $result;
    }

    public function selectTeamManagerAssigned()
    {
        $columns = [
            'teamManager.id',
            'teamManager.staff_id'
        ];
        $teamManagerList = DB::table($this->table)
            ->select($columns)
            ->distinct()
            ->join('user_application as teamManager', 'teamManager.id', '=', 'project_information.team_manager')
            ->get();
        $result = $teamManagerList->toArray();
        
        return $result;
    }

    public function selectProjectManagerAssigned()
    {
        $columns = [
            'projectManager.id',
            'projectManager.staff_id'
        ];
        $projectMangerList = DB::table($this->table)
            ->select($columns)
            ->distinct()
            ->join('user_application as projectManager', 'projectManager.id', '=', 'project_information.project_manager')
            ->get();
        $result = $projectMangerList->toArray();
        
        return $result;
    }
}
