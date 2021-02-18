<template>
  <div
    class="modal fade"
    id="edit-technical-error-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg-custom" role="add-technical-error-modal">
      <div class="modal-content bg-teal">
        <div class="modal-header">
          <h5 class="modal-title text-white">{{ $t('technical_error.technical_error_modal_title') }}</h5>
          <div class="modal-control-bar">
            <button
              type="button"
              class="btn btn-warning"
              v-on:click="closeTechnicalError()"
            >{{ $t('base.close') }}</button>
          </div>
        </div>
        <div class="modal-body bg-white">
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
                  v-model="technicalError.error_id_string"
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
                    value="Công Ty"
                  />
                  <label class="form-check-label" for="inlineRadio1"
                    >Công Ty</label
                  >
                </div>
                <div class="form-check form-check-inline">
                  <input
                    disabled
                    class="form-check-input"
                    type="radio"
                    v-model="technicalError.discoverer"
                    id="inlineRadio2"
                    value="Khách Hàng"
                  />
                  <label class="form-check-label" for="inlineRadio2"
                    >Khách Hàng</label
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
          <div class="row mb-2 mt-2 ">
            <div class="col-12 col-md-12">
              <div class="float-right">
                <button class="btn btn-success" v-on:click="updateTechnicalError()">{{ $t('base.update') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/modals/edittechnicalerrormodal.js"></script>