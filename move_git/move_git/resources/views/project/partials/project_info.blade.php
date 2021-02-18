<fieldset class="border p-2">
    <legend class="w-auto legend-custome">@lang('projectmng.essential_info')</legend>
    <form class="form">
        <div class="form-group row">
            <label for="customer-id" class="col-md-2 col-form-label required-field text-white">@lang('projectmng.customer')</label>
            <div class="col-md-4">
                <select class="form-control" name="customer_id" id="customer-id" disabled="disabled">
                    <option value=""></option>
                    @foreach($customerList as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->customer_id }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="project-id" class="col-md-2 col-form-label required-field text-white">@lang('projectmng.project_id')</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="project_id" id="project-id" required disabled="disabled"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-2 col-form-label required-field text-white">@lang('projectmng.name')</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="project_name" id="project-name" disabled="disabled"/>
            </div>
        </div>
        {{-- <div class="form-group row">
            <label for="name" class="col-md-2 col-form-label required-field text-white">Người Liên Lạc/Email</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="project_name" id="project-name"/>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="project_name" id="project-name"/>
            </div>
        </div> --}}
        <div class="form-group row">
            <label for="status" class="col-md-2 col-form-label required-field text-white">@lang('projectmng.status')</label>
            <div class="col-md-4">
                <select class="form-control" name="status" id="status">
                    @foreach($projectStatusList as $projectStatus)
                    <option value="{{ $projectStatus->id }}">{{ $projectStatus->label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="project-path" class="col-md-2 col-form-label required-field text-white">@lang('projectmng.directory_path')</label>
            <div class="col-md-8">
                <div class="custom-file">
                    <input type="input" class="form-control" id="project-path" name="project_path" onblur="projectMangement.changeProjectFolder(event)"/>
                  </div>
            </div>
        </div>
    </form>
</fieldset>
