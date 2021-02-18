<!-- Modal -->
<div class="modal fade" id="create-project" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg-custom" role="create-project">
        <div class="modal-content bg-teal">
            <div class="modal-header">
                <h5 class="modal-title text-white">@lang('projectmng.project_create_modal_title')</h5>
                <div class="modal-control-bar">
                    <button type="button" class="btn btn-warning" id="btn-my-activity-close" data-dismiss="modal">@lang('base.close')</button>
                    <button type="button" class="btn btn-white" id="btn-my-activity-create" onclick="projectMangement.createProjectInformation()">@lang('base.add')</button>
                </div>
            </div>
            <div class="modal-body">
                @include('project.partials.project_info',['customerList' => $customerList, 'projectStatuList' => $projectStatusList])
                <div class="tab">
                    <ul class="nav nav-tabs">
                        <li class="nav-item active">
                            <a data-toggle="tab" href="#admin-project" class="nav-link active">@lang('projectmng.admin_tab_name')</a>
                        </li>
                        {{--<li class="nav-item">--}}
                        {{--<a data-toggle="tab" href="#issue-detail" class="nav-link">@lang('projectmng.issue_detail_tab_name')</a>--}}
                        {{--</li>--}}
                        {{-- <li class="nav-item">
                            <a data-toggle="tab" href="#joint-staff" class="nav-link">@lang('projectmng.joint_staff_tab_name')</a>
                        </li>  --}}
                    </ul>

                    <div class="tab-content clearfix">
                        <div class="tab-pane in active" id="admin-project">
                            @include('project.partials.admin', ['teamManagerList' => $teamManagerList, 'projectManagerList' => $projectManagerList])
                        </div>
                        {{--<div class="tab-pane fade" id="issue-detail">--}}
                        {{--@include('project.partials.issue_detail', ['workTypeList' => $workTypeList, 'softwareTypeList' => $softwareTypeList])--}}
                        {{--</div>--}}
                        {{-- <div class="tab-pane fade" id="joint-staff">
                            @include('project.partials.joint_staff', ['staffList' => $staffList, 'staffInTeam' => $staffInTeam])
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var jointStaff = {
      staffList: [],
        staffInTeam: []
    };
    jointStaff.staffList = {!! json_encode($staffList) !!};
    jointStaff.staffInTeam = {!! json_encode($staffInTeam) !!};
</script>