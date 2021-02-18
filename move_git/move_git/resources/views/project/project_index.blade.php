@extends('layout.layout')

@section('container')
<div id="project">
    <project-index></project-index>
</div>
@endsection

@include('project.modals.create_project', $dropdownList)

<script>
    var metaData = {
        projectInformationList: [],
        projectStatusList: [],
        teamManagerList: [],
        projectManagerList: [],
        staffInTeam: [],
        staffList: [],
        endUserList: [],
        unitList: [],
        valueFactorList: [],
        dataInputTypeList: [],
        dataOutputTypeList: [],
        dataStatusList: [],
        dataTranslateStatusList: [],
        staffDataStatusList: [],
        customerList: [],
        workingFactorList: [],
        teamManagerAssignedList: [],
        projectManagerAssignedList: [],
        technicalErrorTemplateList: [],
        typeOfWorkList: [],
        errorTemplateGroupList: [],
        workingTimeTypeList: [],
        workingTimeGroupList: [],
        refWorkingTimeList: []
    };
    metaData.projectStatusList = {!! json_encode($dropdownList['projectStatusList']) !!};
    metaData.teamManagerList = {!! json_encode($dropdownList['teamManagerList']) !!};
    metaData.projectManagerList = {!! json_encode($dropdownList['projectManagerList']) !!};
    metaData.staffInTeam = {!! json_encode($dropdownList['staffInTeam']) !!};
    metaData.staffList = {!! json_encode($dropdownList['staffList']) !!};
    metaData.endUserList = {!! json_encode($dropdownList['endUserList']) !!};
    metaData.unitList = {!! json_encode($dropdownList['unitList']) !!};
    metaData.valueFactorList = {!! json_encode($dropdownList['valueFactorList']) !!};
    metaData.dataInputTypeList = {!! json_encode($dropdownList['dataInputTypeList']) !!};
    metaData.dataOutputTypeList = {!! json_encode($dropdownList['dataOutputTypeList']) !!};
    metaData.dataStatusList = {!! json_encode($dropdownList['dataStatusList']) !!};
    metaData.dataTranslateStatusList = {!! json_encode($dropdownList['dataTranslateStatusList']) !!};
    metaData.staffDataStatusList = {!! json_encode($dropdownList['staffDataStatusList']) !!};
    metaData.customerList = {!! json_encode($dropdownList['customerList']) !!};
    metaData.workingFactorList = {!! json_encode($dropdownList['workingFactorList']) !!};
    metaData.teamManagerAssignedList = {!! json_encode($dropdownList['teamManagerAssignedList']) !!};
    metaData.projectManagerAssignedList = {!! json_encode($dropdownList['projectManagerAssignedList']) !!};
    metaData.technicalErrorTemplateList = {!! json_encode($dropdownList['technicalErrorTemplateList']) !!};
    metaData.typeOfWorkList = {!! json_encode($dropdownList['typeOfWorkList']) !!};
    metaData.errorTemplateGroupList = {!! json_encode($dropdownList['errorTemplateGroupList']) !!};
    metaData.workingTimeTypeList = {!! json_encode($dropdownList['workingTimeTypeList']) !!};
    metaData.workingTimeGroupList = {!! json_encode($dropdownList['workingTimeGroupList']) !!};
    metaData.refWorkingTimeList = {!! json_encode($dropdownList['refWorkingTimeList']) !!};
</script>

@section('script')
    <script type="text/javascript" src="{{ asset(mix('js/vuejs/project.js') . '?hash=' .$hash) }}"></script>
    <script type="text/javascript" src="{{ asset('js/projectmanagement.min.js?hash=' . $hash)  }}"></script>
@endsection
