<template>
  <div
    class="modal fade"
    id="import-quotation-time-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-xl-custom" role="import-quotation-time-modal">
      <div class="modal-content bg-teal">
        <div class="modal-header">
          <h5 class="modal-title text-white">
            {{ $t("quotation_time.quotation_time_modal_title") }}
          </h5>
          <div class="modal-control-bar">
            <button
              type="button"
              class="btn btn-warning"
              v-on:click="closeImportQuotationTime()"
            >
              {{ $t("base.close") }}
            </button>
          </div>
        </div>
        <div class="modal-body bg-white">
          <fieldset class="border p-2">
            <legend class="w-auto legend-custome">
              {{ $t("quotation_time.quotation_time_set") }}
            </legend>
            <div class="form-group row">
              <div class="col-5 col-md-5">
                <div>
                <input type="file" id="import-quotation-time-file" v-on:change="loadQuotationTimeImport($event)" />
                </div>
                <div class="mt-5">
                      <button
                    type="button"
                    class="btn btn-success"
                    v-on:click="importQuotationTimeList()"
                  >
                    {{ $t("quotation_time.quotation_confirm_import") }}
                  </button>
                </div>
              </div>
              <div class="col-7 col-md-7">
                <h6>Cách thức hoạt động:</h6>
                <div class="info-text">
                  <p><span class="label-action label-confirm">Xác Nhận</span> Bỏ qua.</p>
                  <p><span class="label-action label-update">Cập Nhật</span> Cập nhật thông tin bản vẽ.</p>
                  <p><span class="label-action label-insert">Thêm</span> Thêm mới bản vẽ, và Bản vẽ đã có nhưng không nằm trong danh sách này và chưa được xác nhận sẽ bị XÓA.</p>
                </div>
               </div> 
            </div>
          </fieldset>
          <div class="mt-2">
            <div class="scroll-bar-y grid-frame">
              <table class="table table-bordered">
                <thead >
                  <tr>
                    <th scope="col" width="1%">{{ $t('base.stt') }}</th>
                    <th scope="col" width="10%">
                      {{ $t('quotation_time.working_factor') }} <br />
                      {{ $t('quotation_time.unit')}} <br />
                      {{ $t('quotation_time.dwg_name') }}
                    </th>
                    <th scope="col" width="3%">{{ $t('quotation_time.estimate_time')}}</th>
                    <th scope="col" width="3%">{{ $t('quotation_time.factor')}}</th>
                    <th scope="col" width="3%">{{ $t('quotation_time.really_draw_time')}}</th>
                    <th scope="col" width="3%">{{ $t('quotation_time.really_check_time')}}</th>
                    <th scope="col" width="13%">
                      {{ $t('quotation_time.finish_draw_date')}}
                      <br />
                      {{ $t('quotation_time.drawing_staff_name')}}
                    </th>
                    <th scope="col" width="3%">{{ $t('quotation_time.drawing_time')}}</th>
                    <th scope="col" width="13%">
                      {{ $t('quotation_time.finish_check_date')}}
                      <br />
                      {{ $t('quotation_time.checking_staff_name')}}
                    </th>
                    <th scope="col" width="3%">{{ $t('quotation_time.checking_time')}}</th>    

                    <th scope="col" width="43%">{{ $t('quotation_time.note')}}</th>
                    <th scope="col" width="43%">{{ $t('base.action')}}</th>
                  </tr>
                </thead>
                <tbody class="scroll-bar-y">
                  <tr  v-for="(quotationTime, index) in quotationTimeImportList" :key="index" :id="'quotation-time-import-' + index">
                    <th scope="row">{{index + 1}}</th>
                    <td>
                      <b>{{ quotationTime.working_factor  }}</b> <br />
                      {{ quotationTime.unit }} <br />
                      <i>{{ quotationTime.dwg_name  }}</i>
                    </td>
                    <td>{{ quotationTime.estimate_time }}</td>
                    <td>{{ quotationTime.factor }}</td>
                    <td>{{ quotationTime.really_draw_time }}</td>
                    <td>{{ quotationTime.really_check_time }}</td>
                    <td>
                      {{ quotationTime.finish_draw_date }}
                      <br />
                      {{ quotationTime.drawing_staff_name }}
                    </td>
                    <td>{{ quotationTime.drawing_time }}</td>
                    <td>
                      {{ quotationTime.finish_check_date }}
                      <br />
                      {{ quotationTime.checking_staff_name }}
                    </td>
                    <td>{{ quotationTime.checking_time }}</td>    

                    <td>{{ quotationTime.note }}</td>
                    <td> <span class="label-action" :class="'label-' + quotationTime.action">{{ $t('base.action_name.' + quotationTime.action) }}</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/modals/importquotationtimemodal.js"></script>