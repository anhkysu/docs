<template>
  <div>
    <div class="row mb-2">
      <div class="col-12 col-md-12">
        <button
          class="btn btn-secondary"
          v-on:click="openAddTechnicalErrorModal()"
          :disabled="!sectionControl.isAction || sectionControl.isStatisticMode"
        >
          {{ $t("technical_error.add_error") }}
        </button>
        <button
          class="btn btn-secondary"
          v-on:click="openDeleteTechnicalErrorModal()"
          :disabled="
            !sectionControl.isAction ||
            sectionControl.itemPreviousSelected == -1 || sectionControl.isStatisticMode
          "
        >
          {{ $t("technical_error.delete_error") }}
        </button>
        <button
          class="btn btn-secondary"
          v-on:click="openEditTechnicalErrorModal()"
          :disabled="
            !sectionControl.isAction ||
            sectionControl.itemPreviousSelected == -1 || sectionControl.isStatisticMode
          "
        >
          {{ $t("base.edit") }}
        </button>
        <button class="btn btn-secondary" v-on:click="statisticizeTechnicalError()" :disabled="!sectionControl.isAction">
          {{ $t("technical_error.statisticize_error") }}
        </button>
        <button class="btn btn-secondary" v-on:click="refreshTechnicalErrorList()" :disabled="!sectionControl.isAction">
          {{ $t("base.refresh") }}
        </button>
        <button class="btn btn-secondary" v-on:click="exportTechnicalError()" :disabled="!sectionControl.isAction">
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
                <th scope="col">{{ $t("technical_error.error_source") }}</th>
                <th scope="col">{{ $t("technical_error.work_group") }}</th>
                <th scope="col">{{ $t("technical_error.error_group") }}</th>
                <th scope="col">{{ $t("technical_error.error_code") }}</th>
                <th scope="col">{{ $t("technical_error.error_content") }}</th>
                <th scope="col">{{ $t("base.times") }}</th>
                <th scope="col">
                  {{ $t("technical_error.violator") }} <br/>
                  {{ $t("staff.staff_id") }}
                </th>
                <th scope="col">{{ $t("base.directory_path") }}</th>
                <th scope="col">{{ $t("base.input_date") }}</th>
              </tr>
            </thead>
            <tbody>
              <tr
                  v-for="(technicalError, index) in technicalErrorList"
                  :key="index"
                  :id="'technical-error-' + index"
                  v-on:click="selectRowData(index, '#technical-error-')"
                >
                <td scope="row">{{index + 1}}</td>
                <td>{{technicalError.discoverer}}</td>
                <td>{{technicalError.type_of_work}}</td>
                <td>{{technicalError.error_group}}</td>
                <td>{{technicalError.error_id_string}}</td>
                <td>{{technicalError.error_content}}</td>
                <td>{{technicalError.times}}</td>
                <td>
                  <strong>{{technicalError.violator_short_name}}</strong><br/>
                  {{technicalError.violator_staff_id}}
                </td>
                <td>{{technicalError.output_data_path}}</td> 
                <td>{{technicalError.input_date}}</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered table-sticky-head" v-if="sectionControl.isStatisticMode">
            <thead>
              <tr>
                <th scope="col">{{ $t("base.times") }}</th>
                <th scope="col">
                  {{ $t("technical_error.violator") }} <br/>
                  {{ $t("staff.staff_id") }}
                </th>
                <th scope="col">{{ $t("base.directory_path") }}</th>
              </tr>
            </thead>
            <tbody>
              <tr
                  v-for="(technicalErrorStats, index) in errorStatistic"
                  :key="index"
                  :id="'technical-error-stats-' + index"
                  v-on:click="selectRowData(index, '#technical-error-stats-')"
                >
                <td>{{technicalErrorStats.times}}</td>
                <td>
                  <strong>{{technicalErrorStats.violator_short_name}}</strong><br/>
                  {{technicalErrorStats.violator_staff_id}}
                </td>
                <td>{{technicalErrorStats.output_data_path}}</td> 
              </tr>
            </tbody>
          </table>
      </div>
    </div>
    <add-technical-error-modal
      @refreshTechnicalErrorList="refreshTechnicalErrorList"
      :outputDataLinkList="outputDataLinkList"
      :projectInformation="projectInformation"
    ></add-technical-error-modal>
    <edit-technical-error-modal
      @updateTechnicalErrorGrid="updateTechnicalErrorGrid"
      :outputDataLinkList="outputDataLinkList"
      :value="technicalErrorSelected"
      :projectInformation="projectInformation"
    ></edit-technical-error-modal>
    <div
      class="modal fade"
      id="delete-technical-error-modal"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="delete-technical-error-modal">
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

<script src="../../js/technicalerror.js"></script>