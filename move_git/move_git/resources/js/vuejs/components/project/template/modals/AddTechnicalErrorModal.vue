<template>
  <div
    class="modal fade"
    id="add-technical-error-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg-custom" role="add-quotation-time-modal">
      <div class="modal-content bg-teal">
        <div class="modal-header">
          <h5 class="modal-title text-white">
            {{ $t("technical_error.technical_error_modal_title") }}
          </h5>
          <div class="modal-control-bar">
            <button
              type="button"
              class="btn btn-warning"
              v-on:click="closeTechnicalErrorModal()"
            >
              {{ $t("base.close") }}
            </button>
          </div>
        </div>

        <div class="modal-body bg-white">
          <div class="bg-light ml-n3 mr-n3 mt-n3 p-3">
            <fieldset class="border p-2">
              <legend class="w-auto legend-custome">
                {{ $t("base.information") }}
              </legend>
              <div class="form-group row">
                <label for="status" class="col-md-2 col-form-label">{{
                  $t("projectmng.project_id")
                }}</label>
                <div class="col-md-4">
                  <input
                    disabled
                    type="text"
                    class="form-control"
                    v-model="projectInformation.project_id"
                  />
                </div>

                <div class="col-md-6">
                  <input
                    disabled
                    type="text"
                    class="form-control"
                    v-model="projectInformation.project_name"
                  />
                </div>
              </div>

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
            </fieldset>
          </div>

          <fieldset class="border p-2">
            <legend class="w-auto legend-custome font-weight-bold">
              {{ $t("technical_error.violated_error") }}
            </legend>
            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label">{{
                $t("technical_error.error_code")
              }}</label>
              <div class="col-md-2">
                <input
                  disabled
                  type="text"
                  class="form-control"
                  v-model="errorIdString"
                />
              </div>
              <label for="status" class="col-md-3 col-form-label">{{
                $t("projectmng.work_type")
              }}</label>
              <div class="col-md-5">
                <select class="form-control" v-model="technicalError.type_of_work">
                  <option
                    v-for="({ label }, index) in typeOfWorkList"
                    :key="index"
                    :value="label"
                  >
                    {{ label }}
                  </option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label">{{
                $t("technical_error.error_group")
              }}</label>
              <div class="col-md-10">
                <select
                  class="form-control"
                  v-model="technicalError.error_group"
                >
                  <option
                    v-for="({ label }, index) in filteredErrorTemplateGroupList"
                    :key="index"
                    :value="label"
                  >
                    {{ label }}
                  </option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label">{{
                $t("projectmng.description_detail")
              }}</label>
              <div class="col-md-10">
                <select class="form-control" v-model="technicalError.error_id">
                  <option
                    v-show="error_content"
                    v-for="({ id, error_content },
                    index) in filteredErrorTemplateList"
                    :key="index"
                    :value="id"
                  >
                    {{ error_content }}
                  </option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label">{{
                $t("base.source")
              }}</label>
              <div class="col-md-6 d-flex align-items-center">
                <div class="form-check form-check-inline">
                  <input
                    class="form-check-input"
                    type="radio"
                    v-model="technicalError.discoverer"
                    id="inlineRadio1"
                    :value="$getConst('LOAD_DATA_OPTION_BY_COMPANY')"
                  />
                  <label class="form-check-label" for="inlineRadio1"
                    >{{$t("base.company")}}</label
                  >
                </div>
                <div class="form-check form-check-inline">
                  <input
                    disabled
                    class="form-check-input"
                    type="radio"
                    v-model="technicalError.discoverer"
                    id="inlineRadio2"
                    :value="$getConst('OBJECTS.OBJECT_CUSTOMER')"
                  />
                  <label class="form-check-label" for="inlineRadio2"
                    >{{$t("projectmng.customer")}}</label
                  >
                </div>
              </div>

              <label for="status" class="col-md-2 col-form-label">{{
                $t("technical_error.number_of_error")
              }}</label>
              <div class="col-md-2">
                <input
                  type="number"
                  min="1"
                  class="form-control"
                  v-model="technicalError.times"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label">{{
                $t("translate.data_path")
              }}</label>
              <div class="col-md-10">
                <select
                  class="form-control"
                  v-model="technicalError.output_data_id"
                >
                  <option
                    v-for="({ id, path }, index) in abbreviatedOutputDataLinkList"
                    v-show="path"
                    :key="index"
                    :value="id"
                  >
                    {{ path }}
                  </option>
                </select>
              </div>
            </div>
          </fieldset>

          <div class="row mb-2 mt-2">
            <div class="col-8 col-md-8">
              <span class="pl-2">{{ notification }}</span>
            </div>
            <div class="col-4 col-md-4">
              <div class="float-right">
                <button
                  class="btn btn-secondary"
                  v-on:click="registerTechnicalError()"
                >
                  {{ $t("base.register") }}
                </button>
                <button
                  class="btn btn-success"
                  v-on:click="addTechnicalErrorList()"
                >
                  {{ $t("base.save") }}
                </button>
                <button class="btn btn-warning" data-dismiss="modal">
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
                  <th scope="col" width="12%">
                    {{ $t("technical_error.error_code") }}
                  </th>
                  <th scope="col" width="15%">
                    {{ $t("projectmng.work_type") }}
                  </th>
                  <th scope="col" width="18%">
                    {{ $t("technical_error.error_source") }}
                  </th>
                  <th scope="col" width="10%">
                    {{ $t("technical_error.number_of_error") }}
                  </th>
                  <th scope="col" width="35%">
                    {{ $t("base.directory_path") }}
                  </th>
                </tr>
              </thead>
              <tbody class="scroll-bar-y">
                <tr v-show="technicalErrorRegisterList.length == 0">
                  <td colspan="7" class="text-center">
                    {{ $t("base.no_record") }}
                  </td>
                </tr>
                <tr
                  v-for="(technicalErrorItem,
                  index) in technicalErrorRegisterList"
                  :key="index"
                  :id="'quotation-time-register-' + index"
                >
                  <th scope="row">{{ index + 1 }}</th>
                  <td>
                    <input
                      class="form-control"
                      v-model="technicalErrorItem.error_id_string"
                      disabled
                    />
                  </td>
                  <td>
                    <input
                      class="form-control"
                      v-model="technicalErrorItem.type_of_work"
                      disabled
                    />

                  </td>
                  <td>
                    <input
                      disabled
                      class="form-control"
                      v-model="technicalErrorItem.discoverer"
                    />
                  </td>
                  <td>
                    <input
                      class="form-control"
                      v-model="technicalErrorItem.times"
                      type="number"
                    />
                  </td>
                  <td>
                    <select
                      class="form-control"
                      v-model="technicalErrorItem.output_data_id"
                    >
                      <option
                        v-for="({ id, path }, index) in abbreviatedOutputDataLinkList"
                        v-show="path"
                        :key="index"
                        :value="id"
                      >
                        {{ path }}
                      </option>
                    </select>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-danger btn-icon"
                      v-on:click="deleteTechnicalErrorRegister(index)"
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

<script src="../../js/modals/addtechnicalerrormodal.js"></script>