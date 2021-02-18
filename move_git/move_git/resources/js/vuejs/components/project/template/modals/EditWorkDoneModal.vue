<template>
  <div
    class="modal fade"
    id="edit-work-done-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg-custom">
      <div class="modal-content bg-teal">
        <div class="modal-header">
          <h5 class="modal-title text-white">
            {{ $t("work_done.add_work_done_modal_title") }}
          </h5>
          <div class="modal-control-bar">
            <button
              type="button"
              class="btn btn-warning"
              v-on:click="closeEditWorkDoneModal()"
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

          <div class="row mb-2 mt-2 ">
            <div class="col-12 col-md-12">
              <div class="float-right">
                <button class="btn btn-success" v-on:click="updateWorkDone()">{{ $t('base.update') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/modals/editworkdonemodal.js"></script>