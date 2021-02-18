<template>
  <div
    class="modal fade"
    id="add-work-done-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg-custom" role="add-work-done-modal">
      <div class="modal-content bg-teal">
        <div class="modal-header">
          <h5 class="modal-title text-white">
            {{ $t("work_done.add_work_done_modal_title") }}
          </h5>
          <div class="modal-control-bar">
            <button
              type="button"
              class="btn btn-warning"
              v-on:click="closeAddWorkDoneModal()"
            >
              {{ $t("base.close") }}
            </button>
          </div>
        </div>

        <div class="modal-body bg-white">
          <div class="form-group row">
            <label for="status" class="col-md-2 col-form-label">{{
              $t("projectmng.staff_id")
            }}</label>
            <div class="col-md-4">
              <input
                disabled
                type="text"
                class="form-control"
                v-model="currentUser.staff_id"
              />
            </div>

            <div class="col-md-6">
              <input
                disabled
                type="text"
                class="form-control"
                v-model="currentUser.full_name"
              />
            </div>
          </div>

          <div class="form-group row">
            <label for="status" class="col-md-2 col-form-label">{{
              $t("base.input_date")
            }}</label>
            <div class="col-md-4">
              <input v-model="workDone.input_date" type="date" class="form-control" />
            </div>
          </div>

          <div class="form-group row">
            <label for="status" class="col-md-2 col-form-label">{{
              $t("work_done.working_time_type")
            }}</label>
            <div class="col-md-4 d-flex align-items-center">
              <div :key="index" v-for="(workingTimeType, index) in workingTimeTypeList" class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  v-model="workDone.working_time_type"
                  :value="workingTimeType.id"
                />
                <label class="form-check-label" for="inlineRadio1">{{
                  workingTimeType.name
                }}</label>
              </div>
            </div>

            <label for="status" class="col-md-2 col-form-label text-center">{{
              $t("projectmng.project_id")
            }}</label>
            <div class="col-md-4">
              <select :disabled="!isWorkDoneInProject" class="form-control" v-model="workDone.project_id">
                <option
                  v-for="(userRelatedProject, index) in userRelatedProjects"
                  :key="index"
                  :value="userRelatedProject.id"
                >
                  {{ userRelatedProject.project_id }}
                </option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="status" class="col-md-2 col-form-label">{{
              $t("technical_error.work_group")
            }}</label>
            <div class="col-md-10">
              <select class="form-control" v-model="workDone.working_time_group">
                <option
                  v-for="(workingTimeGroup, index) in filteredWorkingTimeGroupList"
                  :key="index"
                  :value="workingTimeGroup.id"
                >
                  {{ workingTimeGroup.name }}
                </option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="status" class="col-md-2 col-form-label">{{
              $t("work_done.work_description")
            }}</label>
            <div class="col-md-10">
              <div class="position-relative">
                 <select :disabled="!filteredRefWorkingTimeList.length" style="position: absolute;" class="form-control" v-model="workDone.work_content">
                    <option
                      v-for="(refWorkingTime, index) in filteredRefWorkingTimeList"
                      :key="index"
                      :value="refWorkingTime.name"
                    >
                  {{ refWorkingTime.name }}
                    </option>
                  </select>
                <input type="text" style="position: absolute; width: 97%;" class="form-control rounded-only-left" v-model="workDone.work_content" rows="1"/>
              </div>
            </div>
          </div>
          
          <div class="form-group row">
            <label for="status" class="col-md-2 col-form-label">{{
                $t("base.amount_of_time")
              }}</label>
              <div class="col-md-3">
                <input
                  type="number"
                  min="0.00"
                  step="0.10"
                  class="form-control"
                  v-model="workDone.office_hour"
                />
              </div>
              <label class="col-md-1 col-form-label">
                ({{$t('base.time.hour')}})
              </label>
          </div>

          <div class="form-group row">
            <label for="status" class="col-md-2 col-form-label">{{
              $t("projectmng.remark")
            }}</label>
            <div class="col-md-10">
              <textarea class="form-control" v-model="workDone.note" rows="2"></textarea>
            </div>
          </div>

          <div class="row mb-2 mt-2">
            <div class="col-8 col-md-8">
              <span>{{ notification }}</span>
            </div>
            <div class="col-4 col-md-4">
              <div class="float-right">
                <button
                  class="btn btn-secondary"
                  v-on:click="registerWorkDone()"
                >
                  {{ $t("base.register") }}
                </button>
                <button
                  class="btn btn-success"
                  v-on:click="addWorkDoneList()"
                >
                  {{ $t("base.save") }}
                </button>
                <button class="btn btn-warning" v-on:click="closeAddWorkDoneModal()">
                  {{ $t("base.close") }}
                </button>
              </div>
            </div>
          </div>
          <div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col" width="5%">{{ $t("base.stt") }}</th>
                  <th scope="col" width="20%">
                    {{ $t("work_done.working_time_type")}}/
                    {{ $t("projectmng.project_id")}}
                  </th>
                  <th scope="col" width="20%">
                    {{ $t("work_done.work_description") }}
                  </th>
                  <th scope="col" width="10%">
                    {{ $t("base.amount_of_time") }}
                  </th>
                  <th scope="col" width="20%">
                    {{ $t("technical_error.work_group") }}
                  </th>
                  <th scope="col" width="25%">
                    {{ $t("projectmng.remark") }}
                  </th>
                </tr>
              </thead>
              <tbody class="scroll-bar-y">
                <tr v-show="workDoneRegisterList.length == 0">
                  <td colspan="7" class="text-center">
                    {{ $t("base.no_record") }}
                  </td>
                </tr>
                <tr
                  v-for="(workDoneItem,
                  index) in workDoneRegisterList"
                  :key="index"
                  :id="'work-done-register-' + index"
                >
                  <th scope="row">{{ index + 1 }}</th>
                  <td>
                    <input
                      class="form-control"
                      :value="workDoneItem.project_id_string || $getConst('WORKING_TIME.WORKING_TIME_TYPE_NOT_IN_PROJECT_TITLE')"
                      disabled
                    />
                  </td>
                  <td>
                    <input
                      class="form-control"
                      v-model="workDoneItem.work_content"
                    />
                  </td>
                  <td>
                    <input
                      disabled
                      type="number"
                      min="0.00"
                      step="0.10"
                      class="form-control"
                      v-model="workDoneItem.office_hour"
                    />
                  </td>
                  <td>
                    <select disabled class="form-control" v-model="workDoneItem.working_time_group">
                      <option
                        v-for="(workingTimeGroup, index) in workingTimeGroupList"
                        :key="index"
                        :value="workingTimeGroup.id"
                      >
                        {{ workingTimeGroup.name }}
                      </option>
                    </select>
                  </td>
                  <td>
                    <input
                      class="form-control"
                      v-model="workDoneItem.note"
                    />
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-danger btn-icon"
                      v-on:click="deleteWorkDoneRegister(index)"
                    >
                      x
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/modals/addworkdonemodal.js"></script>