<template>
  <div
    class="modal fade"
    id="edit-quotation-time-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg-custom" role="edit-quotation-time-modal">
      <div class="modal-content bg-teal">
        <div class="modal-header">
          <h5 class="modal-title text-white">{{ $t('quotation_time.quotation_time_modal_title') }}</h5>
          <div class="modal-control-bar">
            <button
              type="button"
              class="btn btn-warning"
              v-on:click="closeQuotationTime()"
            >{{ $t('base.close') }}</button>
          </div>
        </div>
        <div class="modal-body bg-white">
          <fieldset class="border p-2">
            <legend class="w-auto legend-custome">{{ $t('quotation_time.quotation_time_set') }}</legend>
            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label required-field">{{ $t('quotation_time.working_factor') }}</label>
              <div class="col-md-2">
                <select class="form-control" v-model="quotationTime.working_factor">
                  <option
                    v-for="(workingFactor, name, index) in workingFactorList"
                    :key="index"
                    :value="workingFactor.id"
                  >{{ workingFactor.label }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label required-field">{{ $t('quotation_time.unit') }}</label>
              <div class="col-md-10">
                <input class="form-control" v-model="quotationTime.unit" />
              </div>
            </div>
            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label required-field">{{ $t('quotation_time.dwg_name') }}</label>
              <div class="col-md-10">
                <input class="form-control" v-model="quotationTime.dwg_name" />
              </div>
            </div>
            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label">{{ $t('quotation_time.estimate_quotation_time') }}</label>
              <div class="col-md-2">
                <input type="number" class="form-control" v-model="quotationTime.estimate_time" v-on:change="timeOfQuotationConvert('hour')"/> 
              </div>
              <div class="col-md-1 pt-1">
                <span>({{ $t('base.time.minute') }})</span>
              </div>
              <div class="col-md-2">
                <input type="number" class="form-control" v-model="quotationTime.estimate_time_hour" v-on:change="timeOfQuotationConvert('minute')" />
              </div>
              <div class="col-md-1 pt-1">
                <span>({{ $t('base.time.hour') }})</span>
              </div>
            </div>
            <div class="form-group row">
              <label for="status" class="col-md-2 col-form-label">{{ $t('quotation_time.note') }}</label>
              <div class="col-md-10">
                <textarea class="form-control" v-model="quotationTime.note" rows="3"></textarea>
              </div>
            </div>
          </fieldset>
          <div class="row mb-2 mt-2 ">
            <div class="col-12 col-md-12">
              <div class="float-right">
                <button class="btn btn-success" v-on:click="updateQuotationTime()">{{ $t('base.update') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/modals/editquotationtimemodal.js"></script>