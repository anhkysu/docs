<?php

namespace App\Business;

use App\Models\RefWorkingTime;

/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 26/8/19
 * Time: 5:03 PM
 */
class DropdownBusiness
{

    public function __construct()
    {
    }

    public function getDropDownInProjectManagement()
    {
        $customerModel = new \App\Models\Customer();
        $customerList = $customerModel->selectAllCustomers();
        $dropdownLabelModel = new \App\Models\DropdownLabel();
        $projectStatusList = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::PROJECT_STATUS_GROUP);
        $dataInputTypeList = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::IO_DATA_INPUT_TYPE);
        $dataOutputTypeList = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE);
        $dataStatusList = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::IO_DATA_STATUS);
        $dataTranslateStatusList = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::IO_DATA_TRANSLATE_STATUS);
        $staffDataStatusList = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::IO_STAFF_DATA_STATUS);
        $workingFactorList = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::WORKING_FACTOR_GROUP);
        $userApplicationModel = new \App\Models\UserApplication();
        $teamManagerList = $userApplicationModel->selectUsersByJobTitle();
        $projectManagerList = $userApplicationModel->selectUsersByJobTitle();
        $valueFactorModel = new \App\Models\ValueFactor();
        $valueFactorList = $valueFactorModel->selectAllValueFactors();
        $workTypeModel = new \App\Models\WorkType();
        $workTypeList = $workTypeModel->selectAllWorkTypes();
        $softwareTypeModel = new \App\Models\SoftwareType();
        $softwareTypeList = $softwareTypeModel->selectAllSoftwareTypes();
        $staffList = $userApplicationModel->selectActiveUsers();
        $staffInTeam = [];
        foreach ($staffList as $staff) {
            $team = $staff->team;
            if (!array_key_exists($team, $staffInTeam)) {
                $staffInTeam[$team] = [];
            }
            $staffInTeam[$team][] = $staff;
        }
        $endUserModel = new \App\Models\EndUser();
        $endUserList = $endUserModel->selectAllEndUsers();
        $unitModel = new \App\Models\Unit();
        $unitList = $unitModel->selectAllUnits();
        $projectInfomationModel = new \App\Models\ProjectInformation();
        $teamManagerAssignedList = $projectInfomationModel->selectTeamManagerAssigned();
        $projectManagerAssignedList = $projectInfomationModel->selectProjectManagerAssigned();
        $errorListModel = new \App\Models\ErrorList();
        $technicalErrorTemplateList = $errorListModel->selectAllErrors();
        $typeOfWorkList = $errorListModel->selectDistinctLabelList(\App\Constants\DropdownLabel::TYPE_OF_WORK);
        $errorTemplateGroupList = $errorListModel->selectDistinctLabelList(\App\Constants\DropdownLabel::ERROR_GROUP);
        $workingTimeTypeModel = new \App\Models\WorkingTimeType();
        $workingTimeTypeList = $workingTimeTypeModel->selectAllWorkingTimeTypes();
        $workingTimeGroupModel = new \App\Models\WorkingTimeGroup();
        $workingTimeGroupList = $workingTimeGroupModel->selectAllWorkingTimeGroups();
        $refWorkingTimeModel = new \App\Models\RefWorkingTime();
        $refWorkingTimeList = $refWorkingTimeModel->selectAllRefWorkingTime();
        
        return
            compact(
                'customerList',
                'projectStatusList',
                'dataInputTypeList',
                'dataOutputTypeList',
                'dataStatusList',
                'dataTranslateStatusList',
                'staffDataStatusList',
                'teamManagerList',
                'projectManagerList',
                'valueFactorList',
                'workTypeList',
                'softwareTypeList',
                'staffList',
                'staffInTeam',
                'endUserList',
                'unitList',
                'workingFactorList',
                'teamManagerAssignedList',
                'projectManagerAssignedList',
                'technicalErrorTemplateList',
                'typeOfWorkList',
                'errorTemplateGroupList',
                'workingTimeTypeList',
                'workingTimeGroupList',
                'refWorkingTimeList'
            );
    }

    public function getDropDownInTranslate()
    {
        $dropdownLabelModel = new \App\Models\DropdownLabel();
        $dataInputTypeList = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::IO_DATA_INPUT_TYPE);
        $dataOutputTypeList = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::IO_DATA_OUTPUT_TYPE);
        $loadDataOptionByDepartment = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::TRANSLATE_LOAD_DATA_OPTION_BY_DEPARTMENT);
        $translateActionMark = $dropdownLabelModel->selectListByGroup(\App\Constants\DropdownLabel::TRANSLATE_ACTION_MARK);

        return 
            compact(
                'loadDataOptionByDepartment', 
                'translateActionMark',
                'dataInputTypeList',
                'dataOutputTypeList'
            );
    }


}
