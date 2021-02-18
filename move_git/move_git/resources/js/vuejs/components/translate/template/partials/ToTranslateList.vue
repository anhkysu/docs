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
              id="datetime-option-date"
              value="date"
              checked
            />
            <label class="form-check-label" for="datetime-option-date">{{
              $t("translate.date")
            }}</label>
          </div>
          <div class="form-group row mt-1">
            <div class="col-12">
              <input v-model="loadOptions.pickedDate" type="date" class="form-control" />
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
              <input v-model="loadOptions.datetimeFrom" type="date" class="form-control" />
            </div>
            <div
              class="col-12 d-flex justify-content-center align-items-center"
            >
              ▼
            </div>
            <div class="col-12">
              <input v-model="loadOptions.datetimeTo" type="date" class="form-control" />
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
            <div v-if="value!==$getConst('LOAD_DATA_OPTION_BY_SELF')">
              <input
                class="form-check-input"
                type="radio"
                :id="label"
                v-model="loadOptions.selectedGroupType"
                :value="value"
              />
              <label class="form-check-label" :for="label">
                {{ label }}
              </label>
            </div>
          </div>
        </div>
        <button
          @click="getTranslateList()"
          class="btn btn-outline-primary btn-lg btn-block mt-4"
        >
          <img src="/application/image/refresh-icon-1.png" alt="refresh icon" />
        </button>
      </div>
    </div>

    <main class="col-10 col-md-10 col-xl-10 bg-white p-3" role="main">
      <h5 class="text rounded">
        {{
          (
            $t("translate.summary_translate_data") +
            " " +
            summaryTitlePostFix
          ).toUpperCase()
        }}
      </h5>
      <div class="row pt-3 rounded">
        <div class="col-12 col-md-12" style="height: calc(100vh - 280px); overflow: scroll">
            <table class="table table-bordered table-sticky-head">
              <thead>
                <tr>
                  <th scope="col">{{ $t("base.stt") }}</th>
                  <th scope="col">{{ $t("io_data.datetime") }} <br /></th>
                  <th scope="col">{{ $t("io_data.data_status") }}</th>
                  <th scope="col">
                    {{ $t("io_data.staff_data_status") }}
                  </th>
                  <th scope="col">{{ $t("io_data.pd_status") }}</th>
                  <th scope="col">
                    {{ $t("io_data.sender") }}<br />
                    {{ $t("projectmng.team") }}<br />
                    {{ $t("projectmng.staff_id") }}<br />
                  </th>
                  <th scope="col">{{ $t("projectmng.project_id") }}</th>
                  <th scope="col">{{ $t("io_data.original_mail") }}</th>
                  <th scope="col">{{ $t("io_data.translated_mail") }}</th>
                  <th scope="col">{{ $t("io_data.data_type") }}</th>
                  <th scope="col">
                    {{ $t("io_data.urgent_translate_mark") }}
                  </th>
                  <th scope="col">
                    {{ $t("translate.suggested_translator") }}
                  </th>
                  <th scope="col">{{ $t("translate.real_translator") }}</th>
                  <th scope="col">{{ $t("translate.data_path") }}</th>
                </tr>
              </thead>

              <tbody>
                <tr
                  @click.prevent="selectTranslateItem(index)"
                  @contextmenu.prevent="e=>openContextMenu(e, index, translateItem.id)"
                  v-for="(translateItem, index) in translateList"
                  :key="index"
                  :id="'translate-data-' + index"
                  :class="'position-relative ' + (translateItem.data_type === $getConst('IO_CONST.IO_DATA_TYPE_NAME_INPUT') && 'bg-lightblue')"
                >
                  <td scope="row">{{ index + 1 }}</td>
                  <td>
                    {{
                      translateItem.input_data_datetime ||
                      translateItem.output_data_datetime
                    }}
                  </td>
                  <td>
                    {{
                      translateItem.input_data_status ||
                      translateItem.output_data_status
                    }}
                  </td>
                  <td>
                    {{
                      translateItem.input_staff_data_status ||
                      translateItem.output_staff_data_status
                    }}
                  </td>
                  <td>{{ translateItem.data_translate_status_label }}</td>
                  <td>
                    <strong>
                    {{
                      translateItem.input_sender_name ||
                      translateItem.output_sender_name
                    }}
                    </strong>
                    <br />
                    {{
                      translateItem.input_sender_team ||
                      translateItem.output_sender_team
                    }}
                    <br />
                    {{
                      translateItem.input_sender_id ||
                      translateItem.output_sender_id
                    }}
                  </td>
                  <td>
                    {{
                      translateItem.input_data_project_id ||
                      translateItem.output_data_project_id
                    }}
                  </td>
                  <td>{{ translateItem.original_mail }}</td>
                  <td>{{ translateItem.translated_mail }}</td>
                  <td>{{ translateItem.data_type }}</td>
                  <td>{{ translateItem.urgent }}</td>
                  <td>{{ translateItem.translator_suggested }}</td>
                  <td>{{ translateItem.translator_short_name }}</td>
                  <td>
                    {{
                      translateItem.input_data_path ||
                      translateItem.output_data_path
                    }}
                  </td>
                </tr>
              </tbody>
               <div
                    class="dropdown-menu dropdown-menu-sm position-absolute border-primary"
                    style="position: absolute;"
                    id="context-menu"
                  >
                    <a @click.prevent="switchTabTranslateAction()" class="dropdown-item">{{$t('translate.translate_action')}}</a>
                    <a class="dropdown-item">{{$t('base.open_folder')}}</a>
                    <a @click.prevent="viewProjectDetailAction()" class="dropdown-item">{{$t('base.go_to_project')}}</a>
                  </div>
            </table>
          
        </div>
      </div>
    </main>
  </div>
</template>


<script src='../../js/totranslatelist.js'></script>
