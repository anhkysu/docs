<template>
  <div>
    <div class="row mb-2">
      <div class="col-12 col-md-12">
        <button
          class="btn btn-secondary"
          v-on:click="openAddQuotationTimeModal()"
          :disabled="!sectionControl.isAction"
        >
          {{ $t("base.add") }}
        </button>
        <button
          class="btn btn-secondary"
          v-on:click="openEditQuotationTimeModal()"
          :disabled="
            !sectionControl.isAction ||
            sectionControl.itemPreviousSelected == -1
          "
        >
          {{ $t("base.edit") }}
        </button>
        <button
          class="btn btn-secondary"
          v-on:click="openDeleteQuotationTimeModal()"
          :disabled="
            !sectionControl.isAction ||
            sectionControl.itemPreviousSelected == -1
          "
        >
          {{ $t("base.delete") }}
        </button>
        <button
          class="btn btn-secondary"
          v-on:click="openImportQuotationTimeModal()"
          :disabled="!sectionControl.isAction"
        >
          {{ $t("base.import") }}
        </button>
        <button
          class="btn btn-secondary"
          v-on:click="exportQuotationTime()"
          :disabled="!sectionControl.isAction"
        >
          {{ $t("base.export") }}
        </button>
        <button
          class="btn btn-secondary"
          v-on:click="refreshQuotationTimeList()"
          :disabled="!sectionControl.isAction"
        >
          {{ $t("base.refresh") }}
        </button>
        <button class="btn btn-secondary" :disabled="!sectionControl.isAction">
          {{ $t("base.print") }}
        </button>
        <div class="d-inline-block align-middle">
          <div class="input-group">
            <input @keydown="onSearchBoxKeyDown" v-model="searchBoxInput" type="text" class="form-control" aria-label="Text input with segmented dropdown button">
            <div class="input-group-append">
              <button v-on:click="searchUnitDwg()" class="btn btn-outline-secondary" type="button">{{$t('quotation_time.search_unit_dwg')}}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-md-12" style="height: calc(100vh - 330px); overflow: scroll">
            <table class="table table-bordered table-sticky-head">
              <thead>
                <tr>
                <th scope="col" width="1%">{{ $t("base.stt") }}</th>
                <th scope="col" width="10%">
                  {{ $t("quotation_time.working_factor") }} <br />
                  {{ $t("quotation_time.unit") }} <br />
                  {{ $t("quotation_time.dwg_name") }}
                </th>
                <th scope="col" width="3%">
                  {{ $t("quotation_time.estimate_time") }}
                </th>
                <th scope="col" width="8%">
                  {{ $t("quotation_time.factor") }}
                </th>
                <th scope="col" width="10%">
                  {{ $t("quotation_time.really_draw_time") }}
                </th>
                <th scope="col" width="10%">
                  {{ $t("quotation_time.really_check_time") }}
                </th>
                <th scope="col" width="13%">
                  {{ $t("quotation_time.finish_draw_date") }}
                  <br />
                  {{ $t("quotation_time.drawing_staff_name") }}
                  <br />
                  {{ $t("staff.staff_id") }}
                </th>
                <th scope="col" width="3%">
                  {{ $t("quotation_time.drawing_time") }}
                </th>
                <th scope="col" width="13%">
                  {{ $t("quotation_time.finish_check_date") }}
                  <br />
                  {{ $t("quotation_time.checking_staff_name") }}
                  <br />
                  {{ $t("staff.staff_id") }}
                </th>
                <th scope="col" width="3%">
                  {{ $t("quotation_time.checking_time") }}
                </th>

                <th scope="col" width="40%">{{ $t("quotation_time.note") }}</th>
                <th scope="col" width="3%">
                  {{ $t("quotation_time.confirm") }}
                </th>
              </tr>
              </thead>
              <tbody class="scroll-bar-y">
                <tr
                  v-for="(quotationTime, index) in quotationTimeList"
                  :key="index"
                  :id="'quotation-time-' + index"
                  v-on:click="selectQuotationTimeData(index)"
                >
                  <td scope="row">{{ index + 1 }}</td>
                  <td>
                    <b>{{ quotationTime.working_factor }}</b> <br />
                    {{ quotationTime.unit }} <br />
                    <i>{{ quotationTime.dwg_name }}</i>
                  </td>
                  <td>{{ quotationTime.estimate_time }}</td>
                  <td class="align-middle">
                    <input id="factor" @focus="onDataCellInputFocus" @blur="e=>onFactorChange(e,index)" step="0.1" type="number" class="form-control" v-model="quotationTime.factor" />
                  </td>
                  <td class="align-middle">
                    <input id="really_draw_time" @focus="onDataCellInputFocus" @blur="e=>onDrawTimeChange(e,index)" step="1" type="number" class="form-control" v-model="quotationTime.really_draw_time" />
                  </td>
                  <td class="align-middle">
                    <input id="really_check_time" @focus="onDataCellInputFocus" @blur="e=>onCheckTimeChange(e,index)" step="1" type="number" class="form-control" v-model="quotationTime.really_check_time" />
                  </td>
                  <td>
                    {{ quotationTime.finish_draw_date }}
                    <br />
                    {{ quotationTime.drawing_staff_name }}
                    <br />
                    {{ quotationTime.drawing_staff_id }}
                  </td>
                  <td>{{ quotationTime.drawing_time }}</td>
                  <td>
                    {{ quotationTime.finish_check_date }}
                    <br />
                    {{ quotationTime.checking_staff_name }}
                    <br />
                    {{ quotationTime.checking_staff_id }}
                  </td>
                  <td>{{ quotationTime.checking_time }}</td>

                  <td>{{ quotationTime.note }}</td>
                  <td>
                    <input
                      type="checkbox"
                      id="output_attach_folder"
                      :checked="quotationTime.confirm"
                      disabled="disabled"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
      </div>
    </div>

    <add-quotation-time-modal
      @refreshQuotationTimeList="refreshQuotationTimeList"
      :projectInformation="projectInformation"
    ></add-quotation-time-modal>
    <edit-quotation-time-modal
      @updateQuotationTimeGrid="updateQuotationTimeGrid"
      v-model="quotationTimeSelected"
    ></edit-quotation-time-modal>
    <import-quotation-time-modal
      :projectInformation="projectInformation"
      :confirmedQuotationTimeList="confirmedQuotationTimeList"
      :notConfirmedQuotationTimeList="notConfirmedQuotationTimeList"
    ></import-quotation-time-modal>
    <div
      class="modal fade"
      id="delete-quotation-time-modal"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="delete-quotation-time-modal">
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
    <div
      class="modal fade"
      id="confirm-override-quotation-time-modal"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="confirm-override-quotation-time-modal">
        <div class="modal-content bg-teal">
          <div class="modal-header">
            <h5 class="modal-title text-white">
              {{ $t("base.override_confirmation_header_modal") }}
            </h5>
          </div>
          <div class="modal-body bg-white">
            {{ $t("base.override_question") }}
          </div>
          <div class="modal-footer bg-white">
            <button
              type="button"
              class="btn btn-primary"
              v-on:click="yesConfirm()"
            >
              {{ $t("base.agress") }}
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              v-on:click="notConfirm()"
            >
              {{ $t("base.close") }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/quotationtime.js"></script>