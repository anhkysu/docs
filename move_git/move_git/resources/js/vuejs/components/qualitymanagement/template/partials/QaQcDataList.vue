<template>
  <div class="row flex-xl-nowrap">
    <div class="col-2 col-md-2 col-xl-2 bd-sidebar">
      <div class="bd-search d-flex align-items-center mb-3">
        <input
          type="search"
          class="form-control ds-input"
          id="search-project"
          autocomplete="off"
          spellcheck="false"
          role="combobox"
          aria-autocomplete="list"
          aria-expanded="false"
          aria-owns="algolia-autocomplete-listbox-0"
          dir="auto"
          style="position: relative; vertical-align: top"
        />
        <button
          class="btn btn-white btn-setting"
          data-toggle="modal"
          data-target=""
        >
          <img src="/application/image/search-icon-1.png" />
        </button>
      </div>

      <div class="bg-white p-4">
        <p class="mb-2">
          <strong>{{ $t("translate.load_data_by_time") }}</strong>
        </p>
        <div class="ml-2 mr-2">
          <div class="form-check form-check-inline">
            <input
              class="form-check-input"
              type="radio"
              v-model="loadOptions.datetimeOption"
              id="datetime-option-month"
              value="month"
            />
            <label class="form-check-label" for="datetime-option-month">{{
              $t("base.month")
            }}</label>
          </div>
          <div class="form-group row mt-1">
            <div class="col-12">
              <input
                v-model="loadOptions.pickedMonth"
                type="month"
                class="form-control"
              />
            </div>
          </div>

          <div class="form-check form-check-inline">
            <input
              class="form-check-input"
              type="radio"
              v-model="loadOptions.datetimeOption"
              id="datetime-option-period"
              value="period"
            />
            <label class="form-check-label" for="datetime-option-period">{{
              $t("translate.time_period")
            }}</label>
          </div>
          <div class="form-group row mt-1">
            <div class="col-12">
              <input
                v-model="loadOptions.datetimeFrom"
                type="date"
                class="form-control"
              />
            </div>
            <div
              class="col-12 d-flex justify-content-center align-items-center"
            >
              ▼
            </div>
            <div class="col-12">
              <input
                v-model="loadOptions.datetimeTo"
                type="date"
                class="form-control"
              />
            </div>
          </div>
        </div>
        <p class="mb-2">
          <strong>{{ $t("translate.department") }}</strong>
        </p>
        <div class="ml-2 mr-2">
          <div
            :key="index"
            v-for="({ label, value }, index) in groupTypes"
            class="form-check"
          >
            <input
              class="form-check-input"
              type="radio"
              :id="label"
              :checked="index === 1"
              :value="value"
              v-model="loadOptions.selectedGroupType"
            />
            <label class="form-check-label" :for="label">
              {{ label }}
            </label>
          </div>
          <button
            @click="refreshData()"
            class="btn btn-outline-primary btn-lg btn-block mt-4"
          >
            <img
              src="/application/image/refresh-icon-1.png"
              alt="refresh icon"
            />
          </button>

          <div class="btn-group btn-block">
            <button class="btn btn-outline-primary">
              {{ $t("qualitymng.report_qc") }}
            </button>
            <button class="btn btn-outline-primary">
              {{ $t("qualitymng.report_qa") }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <main class="col-10 col-md-10 col-xl-10 p-3 bg-light" role="main">
      <h5 class="text rounded">
        {{ titleSummary }}
      </h5>
      <div class="tab pt-2">
        <ul class="nav nav-tabs" id="bs-qaqc-data-list-subtab-nav">
          <li class="nav-item active">
            <a
              data-toggle="tab"
              href="#qaqc-send-data-list"
              class="nav-link active"
              >{{ $t("qualitymng.send_data_list") }}</a
            >
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#qaqc-checkback-data-list"
              class="nav-link"
              >{{ $t("qualitymng.checkback_data_list") }}</a
            >
          </li>
        </ul>

        <div class="tab-content clearfix">
          <div
            class="tab-pane in active pt-2 pb-2"
            id="qaqc-send-data-list"
          >
            <qaqc-send-data :sendDataList="sendDataList"></qaqc-send-data>
          </div>
          <div
            class="tab-pane fade pt-2 pb-2"
            id="qaqc-checkback-data-list"
          >
            <qaqc-checkback-data :checkbackDataList="checkbackDataList"></qaqc-checkback-data>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script src="../../js/qaqcdatalist.js"></script>