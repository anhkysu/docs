<template>
  <div>
    <div class="row mb-2">
      <div class="col-12 col-md-12">
        <button
          class="btn btn-secondary"
          v-on:click="openDeleteWorkDoneModal()"
          :disabled="
            !sectionControl.isAction ||
            sectionControl.itemPreviousSelected == -1 || sectionControl.isStatisticMode
          "
        >
          {{ $t("work_done.delete_work_done") }}
        </button>
        <button
          class="btn btn-secondary"
          v-on:click="openEditWorkDoneModal()"
          :disabled="
            !sectionControl.isAction ||
            sectionControl.itemPreviousSelected == -1 || sectionControl.isStatisticMode
          "
        >
          {{ $t("base.edit") }}
        </button>
        <button class="btn btn-secondary" v-on:click="statisticizeWorkDone()" :disabled="!sectionControl.isAction">
          {{ $t("work_done.statisticize_work_done") }}
        </button>
        <button class="btn btn-secondary" v-on:click="refreshWorkDoneList()" :disabled="!sectionControl.isAction">
          {{ $t("base.refresh") }}
        </button>
        <button class="btn btn-secondary" v-on:click="exportWorkDoneList()" :disabled="!sectionControl.isAction">
          {{ $t("base.export") }}
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-12" style="height: calc(100vh - 330px); overflow: scroll">
          <table class="table table-bordered table-sticky-head" v-if="!sectionControl.isStatisticMode">
            <thead>
              <tr>
                <th scope="col">{{ $t("base.stt") }}</th>
                <th scope="col">{{ $t("base.input_date") }}</th>
                <th scope="col">
                  {{ $t("projectmng.staff_name") }} <br/>
                  {{ $t("projectmng.staff_id") }}
                </th>
                <th scope="col">{{ $t("work_done.working_time") }}</th>
                <th scope="col">{{ $t("work_done.work_description") }}</th>
              </tr>
            </thead>
            <tbody>
              <tr
                  v-for="(workDone, index) in workDoneList"
                  :key="index"
                  :id="'work-done-' + index"
                  v-on:click="selectRowData(index, '#work-done-')"
                >
                <td scope="row">{{index + 1}}</td>
                <td>{{workDone.input_date}}</td>
                <td>
                  <strong>{{workDone.short_name}}</strong><br/>
                  {{workDone.staff_id_string}}
                </td>
                <td>{{workDone.office_hour}}</td>
                <td>{{workDone.work_content}}</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered table-sticky-head" v-if="sectionControl.isStatisticMode">
            <thead>
              <tr>
                <th scope="col">{{ $t("base.stt") }}</th>
                <th scope="col">
                  {{ $t("projectmng.staff_name") }} <br/>
                  {{ $t("projectmng.staff_id") }}
                </th>
                <th scope="col">{{ $t("projectmng.time_total") }}</th>
              </tr>
            </thead>
            <tbody>
              <tr
                  v-for="(workDoneStats, index) in workDoneStatistics"
                  :key="index"
                  :id="'work-done-stats-' + index"
                  v-on:click="selectRowData(index, '#work-done-stats-')"
                >
                <td>{{index + 1}}</td>
                <td>
                  <strong>{{workDoneStats.short_name}}</strong><br/>
                  {{workDoneStats.staff_id_string}}
                </td>
                <td>{{workDoneStats.working_time_total}}</td> 
              </tr>
            </tbody>
          </table>
      </div>
    </div>
    <add-work-done-modal
      @refreshWorkDoneList="refreshWorkDoneList"
      :projectInformation="projectInformation"
      :userRelatedProjects="userRelatedProjects"
    ></add-work-done-modal>
    <edit-work-done-modal
      @updateWorkDoneGrid="updateWorkDoneGrid"
      :value="workDoneSelected"
      :projectInformation="projectInformation"
      :userRelatedProjects="userRelatedProjects"
    ></edit-work-done-modal>
    <div
      class="modal fade"
      id="delete-work-done-modal"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="delete-work-done-modal">
        <div class="modal-content bg-teal">
          <div class="modal-header">
            <h5 class="modal-title text-white">
              {{ $t("base.delete_confirmation_header_modal") }}
            </h5>
          </div>
          <div class="modal-body bg-white">
            {{ $t("base.delete_question") }}
          </div>
          <div class="modal-footer bg-white">
            <button
              type="button"
              class="btn btn-primary"
              v-on:click="yesDelete()"
            >
              {{ $t("base.agress") }}
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              v-on:click="noDelete()"
            >
              {{ $t("base.close") }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/workdone.js"></script>