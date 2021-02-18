<template>
  <div
    class="modal fade"
    id="add-quotation-time-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg-custom" role="add-quotation-time-modal">
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
            <div class="col-8 col-md-8">
              <span class="pl-2">{{ notification }}</span>
            </div>
            <div class="col-4 col-md-4">
              <div class="float-right">
                <button class="btn btn-secondary" v-on:click="registerQuotationTime()">{{ $t('base.register') }}</button>
                <button class="btn btn-success" v-on:click="addQuotationTimeList()">{{ $t('base.save') }}</button>
                <button class="btn btn-warning" data-dismiss="modal" v-on:click="closeQuotationTime()">{{ $t('base.close') }}</button>
              </div>
            </div>
          </div>
          <div>
            <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col" width="5%">{{ $t('base.stt') }}</th>
                <th scope="col" width="10%">{{ $t('quotation_time.working_factor') }}</th>
                <th scope="col" width="15%">{{ $t('quotation_time.unit')}}</th>
                <th scope="col" width="20%">{{ $t('quotation_time.dwg_name') }}</th>
                <th scope="col" width="10%">{{ $t('quotation_time.estimate_time')}}</th> 
                <th scope="col" width="35%">{{ $t('quotation_time.note')}}</th>
                <th scope="col" width="5%"></th>
              </tr>
            </thead>
            <tbody class="scroll-bar-y">
              <tr v-show="quotationTimeRegisterList.length == 0">
                <td colspan="7" class="text-center">{{ $t('base.no_record') }}</td>
              </tr>
              <tr v-for="(quotationTime, index) in quotationTimeRegisterList" :key="index" :id="'quotation-time-register-' + index">
                <th scope="row">{{ index + 1 }}</th>
                <td>
                  <select class="form-control" v-model="quotationTime.working_factor">
                  <option
                    v-for="(workingFactor, name, index) in workingFactorList"
                    :key="index"
                    :value="workingFactor.id"
                  >{{ workingFactor.label }}</option>
                </select>
                <td><input class="form-control" v-model="quotationTime.unit" /></td>
                <td><input class="form-control" v-model="quotationTime.dwg_name" /></td>
                <td><input class="form-control" v-model="quotationTime.estimate_time" /></td>
                <td><textarea class="form-control" v-model="quotationTime.note" rows="1"></textarea></td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger btn-icon"
                    v-on:click="deleteQuotationTimeRegister(index)"
                  >x</button>
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

<script src="../../js/modals/addquotationtimemodal.js"></script>