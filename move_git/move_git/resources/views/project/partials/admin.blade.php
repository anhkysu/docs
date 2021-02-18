<fieldset class="border p-2">
    <legend class="w-auto legend-custome">@lang('projectmng.factor_rate')</legend>
    <div class="form-group row">
        <label for="status" class="col-md-2 col-form-label text-right">I:</label>
        <div class="col-md-2">
            <select class="form-control" name="working_factor_i" id="working-factor-i">
                @foreach($valueFactorList as $valueFactorI)
                    @if($valueFactorI->id == 3)
                        <option selected value="{{ $valueFactorI->id }}">{{ $valueFactorI->value }}</option>
                    @else
                        <option value="{{ $valueFactorI->id }}">{{ $valueFactorI->value }}</option>
                    @endif

                @endforeach
            </select>
        </div>
        <label for="status" class="col-md-1 col-form-label text-right">II:</label>
        <div class="col-md-2">
            <select class="form-control" name="working_factor_ii" id="working-factor-ii">
                @foreach($valueFactorList as $valueFactorII)
                    @if($valueFactorII->id == 5)
                        <option selected value="{{ $valueFactorII->id }}">{{ $valueFactorII->value }}</option>
                    @else
                        <option value="{{ $valueFactorII->id }}">{{ $valueFactorII->value }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <label for="status" class="col-md-1 col-form-label text-right">III:</label>
        <div class="col-md-2">
            <select class="form-control" name="working_factor_iii" id="working-factor-iii">
                @foreach($valueFactorList as $valueFactorIII)
                    @if($valueFactorIII->id == 9)
                        <option selected value="{{ $valueFactorIII->id }}">{{ $valueFactorIII->value }}</option>
                    @else
                        <option value="{{ $valueFactorIII->id }}">{{ $valueFactorIII->value }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</fieldset>

<fieldset class="border p-2">
    <legend class="w-auto legend-custome">@lang('projectmng.team_manager')</legend>
    <div class="form-group row">
        <input type="hidden" name="team_manager" id="team-manager" value="{{!empty($teamManagerList) ? $teamManagerList[0]->id : 0}}"/>
        <label for="status" class="col-md-2 col-form-label text-right">@lang('projectmng.staff_name')</label>
        <div class="col-md-4">
            <select class="form-control" id="team_manager_name" onchange="projectMangement.selectManager(event,'TeamManager')">
                @foreach($teamManagerList as $teamManager)
                <option value="{{ $teamManager->id }}">{{ $teamManager->short_name }}</option>
                @endforeach
            </select>
        </div>
        <label for="status" class="col-md-2 col-form-label text-right">@lang('projectmng.staff_id')</label>
        <div class="col-md-4">
            <select class="form-control" id="team_manager_id" onchange="projectMangement.selectManager(event,'TeamManager')">
                @foreach($teamManagerList as $teamManager)
                    <option value="{{ $teamManager->id }}">{{ $teamManager->staff_id }}</option>
                @endforeach
            </select>
        </div>
    </div>
</fieldset>

<fieldset class="border p-2">
    <legend class="w-auto legend-custome">@lang('projectmng.project_manager')</legend>
    <div class="form-group row">
        <input type="hidden" name="project_manager" id="project-manager" value="{{!empty($projectManagerList) ? $projectManagerList[0]->id : 0}}"/>
        <label for="status" class="col-md-2 col-form-label text-right">@lang('projectmng.staff_name')</label>
        <div class="col-md-4">
            <select class="form-control" id="project_manager_name" onchange="projectMangement.selectManager(event,'ProjectManager')">
                @foreach($projectManagerList as $projectManager)
                    <option value="{{ $projectManager->id }}">{{ $projectManager->short_name }}</option>
                @endforeach
            </select>
        </div>
        <label for="status" class="col-md-2 col-form-label text-right">@lang('projectmng.staff_id')</label>
        <div class="col-md-4">
            <select class="form-control"  id="project_manager_id" onchange="projectMangement.selectManager(event,'ProjectManager')">
                @foreach($projectManagerList as $projectManager)
                    <option value="{{ $projectManager->id }}">{{ $projectManager->staff_id }}</option>
                @endforeach
            </select>
        </div>
    </div>
</fieldset>