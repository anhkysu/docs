<div class="form-group row">
    <div class="col-md-4">
        <table class="table table-sm borderless">
            <tbody>
            <tr>
                <td>@lang('projectmng.team')</td>
                <td>
                    <select class="form-control" id="project_team">
                        @foreach($staffInTeam as $key => $team)
                        <option value="{{ $key }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>&nbsp</td>
                <td class="text-right">
                    <button type="button" class="btn btn-primary" onclick="projectMangement.addTeam()">@lang('base.add')</button>
                </td>
            </tr>
            <tr>
                <td>@lang('projectmng.staff')</td>
                <td>
                    <select class="form-control" id="project_staff">
                        @foreach($staffList as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->short_name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>&nbsp</td>
                <td class="text-right">
                    <button type="button" class="btn btn-primary" onclick="projectMangement.addStaff()">@lang('base.add')</button>
                </td>
            </tr>

        </table>

    </div>
    <div class="col-md-8">
        <table class="table table-borderless" id="joint-staff-table">
            <thead>
            <tr class="bg-teal text-white text-center">
                <th scope="col" width="25%">@lang('projectmng.staff_id')</th>
                <th scope="col" width="30%">@lang('projectmng.staff_name')</th>
                <th scope="col" width="25%">@lang('projectmng.team')</th>
                <th scope="col" width="20%">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>