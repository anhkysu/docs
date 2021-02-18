<template>
  <div
    class="modal fade"
    id="input-data-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg-custom" role="input-data-modal">
      <div class="modal-content bg-teal">
        <div class="modal-header">
          <h5 class="modal-title text-white">{{ $t('io_data.input_data_modal_title') }}</h5>
          <div class="modal-control-bar">
            <button
              type="button"
              class="btn btn-warning"
              data-dismiss="modal"
              v-on:click="closeInputData()"
            >{{ $t('base.close') }}</button>
            <button
              type="button"
              class="btn btn-white"
              v-on:click="addInputData()"
              v-show="sectionControl.isCreate">{{ $t('base.add') }}</button>
            <button
            type="button"
            class="btn btn-white"
            v-on:click="updateInputData()"
            v-show="sectionControl.isUpdate">{{ $t('base.update') }}</button>
          </div>
        </div>
        <div class="modal-body bg-white">
          <fieldset class="border p-2">
            <legend class="w-auto legend-custome">{{ $t('base.required_data_field_set') }}</legend>
            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label required-field">{{ $t('io_data.receiver') }}</label>
              <div class="col-md-2">
                <select class="form-control" v-model="inputData.sender">
                  <option
                    v-for="(staff, name, index) in loadData.jointStaffList"
                    :key="index"
                    :value="staff.ua_id"
                  >{{ staff.short_name }}</option>
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control" v-model="inputData.sender">
                  <option
                    v-for="(staff, name, index) in loadData.jointStaffList"
                    :key="index"
                    :value="staff.ua_id"
                  >{{ staff.staff_id }}</option>
                </select>
              </div>
              <label for="status" class="col-md-2 col-form-label">{{ $t('io_data.datetime') }}</label>
              <div class="col-md-4">
                <input type="datetime-local" class="form-control" v-model="inputData.datetime" />
              </div>
            </div>
            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label">{{ $t('io_data.data_type') }}</label>
              <div class="col-md-4">
                <select class="form-control" v-model="inputData.data_input_type" v-on:change="selectDataInputType()">
                  <option
                    v-for="(dataInputType, index) in dataInputTypeList"
                    :key="index"
                    :value="dataInputType.id"
                  >{{ dataInputType.label }}</option>
                </select>
              </div>
              <label
                for="status"
                class="col-md-3 col-form-label"
              >{{ $t('io_data.staff_data_status') }}</label>
              <div class="col-md-3">
                <select class="form-control" v-model="inputData.staff_data_status">
                  <option
                    v-for="(staffDataStatus, index) in staffDataStatusList"
                    :key="index"
                    :value="staffDataStatus.id"
                  >{{ staffDataStatus.label }}</option>
                </select>
              </div>
            </div>
          </fieldset>
          <fieldset class="border p-2">
            <legend class="w-auto legend-custome">{{ $t('io_data.data_attachment') }}</legend>
            <div class="form-group row">
              <div class="col-md-6">
                <h6 class="required-field">{{ $t('io_data.original_mail') }}</h6>
                <textarea
                  type="text"
                  class="form-control"
                  rows="5"
                  v-model="inputData.original_mail"
                ></textarea>
              </div>
              <div class="col-md-6">
                <h6>{{ $t('io_data.translated_mail') }}</h6>
                <textarea
                  type="text"
                  class="form-control"
                  rows="5"
                  v-model="inputData.translated_mail"
                ></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="form-check col-md-3">
                <input type="checkbox" id="input_attach_file" v-model="inputData.attach_file" v-on:change="attachFileChange()" :disabled="sectionControl.disableAttachFile"/>
                <label class="form-check-label" for="input_attach_file">{{ $t('io_data.attach_file') }}</label>
              </div>
              <div class="form-check col-md-3" v-show="sectionControl.showCreateFolder">
                <input type="checkbox" id="input_attach_folder" v-model="inputData.attach_folder" v-on:change="createDirectoryInput()"/>
                <label
                  class="form-check-label"
                  for="input_attach_folder"
                >{{ $t('io_data.attach_folder') }}</label>
              </div>
              <div class="form-check col-md-6">
                <span class="notice-text">{{ $t('io_data.notice_attachment_auto_created') }}</span>
              </div>
            </div>
            <div class="form-group row">
              <label
                for="mail_subject"
                class="col-md-2 col-form-label required-field"
              >{{ $t('io_data.mail_subject') }}</label>
              <div class="col-md-5">
                <input class="form-control" v-model="inputData.subject_mail" />
              </div>
              <div class="col-md-5">
                <select class="form-control" v-model="inputData.subject_mail">
                  <option value="">{{ $t('io_data.select_subject_mail') }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label
                for="path"
                class="col-md-2 col-form-label"
                :class="inputData.attach_file ? 'required-field' : ''"
              >{{ $t('base.directory_path') }}</label>
              <div class="col-md-10">
                <!-- :disabled="inputData.attach_file && !inputData.attach_folder ? false : true"  -->
                  <input class="form-control" v-model="inputData.path" />
              </div>
            </div>
            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label required-field">{{ $t('io_data.translator') }}</label>
              <div class="col-md-3">
                <select class="form-control" v-model="inputData.translator_suggested">
                  <option
                    v-for="(staff, name, index) in loadData.translatorList"
                    :key="index"
                    :value="staff.id"
                  >{{ staff.short_name }}</option>
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-control" v-model="inputData.translator_suggested">
                  <option
                    v-for="(staff, name, index) in loadData.translatorList"
                    :key="index"
                    :value="staff.id"
                  >{{ staff.staff_id }}</option>
                </select>
              </div>
              <div class="form-check col-md-3 text-right">
                <input type="checkbox" id="input_urgent" v-model="inputData.urgent" />
                <label
                  class="form-check-label"
                  for="input_urgent"
                >{{ $t('io_data.urgent_translate_mark') }}</label>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/modals/inputdatamodal.js"></script>