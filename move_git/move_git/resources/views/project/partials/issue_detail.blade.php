<fieldset class="border p-2">
    <legend class="w-auto legend-custome">@lang('projectmng.work_type')</legend>
    <div class="form-group row">
        <div class="col-md-4">
            <table class="table table-sm borderless">
                <tbody>
                <tr>
                    <td>
                        <select class="form-control mb-2" id="work-type-list">
                            @foreach($workTypeList as $workType)
                                <option value="{{ $workType->id }}">{{ $workType->name }}</option>
                            @endforeach
                        </select>
                        <textarea type="text" placeholder="@lang('projectmng.description_detail')" class="form-control" name="name" id="name" rows="2"></textarea>
                    </td>
                    <td><button type="button" class="btn btn-primary">@lang('base.add')</button></td>
                </tr>
            </table>

        </div>
        <div class="col-md-8">
            <table class="table table-bordered" id="work-type-addition">
                <thead>
                <tr>
                    <th scope="col" width="45%">@lang('projectmng.work_type')</th>
                    <th scope="col" width="50%">@lang('projectmng.specification')</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td name="work_type_name">Mark</td>
                    <td name="work_type_">Otto</td>
                </tr>
                <tr>
                    <td>Jacob</td>
                    <td>Thornton</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</fieldset>

<fieldset class="border p-2">
    <legend class="w-auto legend-custome">@lang('projectmng.software')</legend>
    <div class="form-group row">
        <div class="col-md-4">
            <table class="table table-sm borderless">
                <tbody>
                <tr>
                    <td>
                        <select class="form-control mb-2" id="software-type-list">
                            @foreach($softwareTypeList as $softwareType)
                            <option value="{{ $softwareType->id }}">{{ $softwareType->name }}</option>
                            @endforeach
                        </select>
                        <textarea type="text" placeholder="@lang('projectmng.work_description_placeholder')" class="form-control" name="name" id="name" rows="2"></textarea>
                    </td>
                    <td><button type="button" class="btn btn-primary">@lang('base.add')</button></td>
                </tr>
            </table>

        </div>
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" width="5%">STT</th>
                    <th scope="col" width="45%">Loai Hinh Cong Viec</th>
                    <th scope="col" width="50%">Cu The</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>

                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</fieldset>