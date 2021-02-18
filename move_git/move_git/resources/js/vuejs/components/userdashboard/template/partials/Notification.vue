<template>
  <div>
    <div class="row">
      <div
        class="col-12 col-md-12"
      >
        <fieldset class="border p-2 rounded h-100">
          <legend class="w-auto legend-custome">
            <h4 class="text-teal">{{ $t("user_dashboard.notification") }}</h4>
          </legend>

          <div class="mt-n4 pr-2 clearfix">
            <div class="float-right d-flex justify-content-end">
              <button class="btn btn-primary mt-4 mb-0">
                {{ $t("user_dashboard.meal_register") }}
              </button>

              <fieldset class="ml-3 border p-2 rounded">
                <legend class="w-auto legend-custome">
                    {{ $t("user_dashboard.notification_filter") }}                  
                </legend>
                <div class="form-check form-check-inline">
                  <input
                    v-model="notificationFilter"
                    name="notificationFilterRadioCheck"
                    id="radio-shrink"
                    class="form-check-input ml-2"
                    type="radio"
                    :value="$getConst('NOTIFICATION.SHRINK')"
                  />
                  <label class="form-check-label" for="radio-shrink">
                    {{ $t("base.shrink") }}
                  </label>
                  <input
                    v-model="notificationFilter"
                    name="notificationFilterRadioCheck"
                    id="radio-show-all"
                    class="form-check-input ml-2"
                    type="radio"
                    :value="$getConst('NOTIFICATION.EXPAND_ALL')"
                  />
                  <label class="form-check-label" for="radio-show-all">
                    {{ $t("base.show_all") }}
                  </label>
                </div>
              </fieldset>

              <fieldset class="ml-3 border p-2 rounded">
                <legend class="w-auto legend-custome">
                    {{ $t("user_dashboard.notification_load") }}                
                </legend>
                <div class="form-check form-check-inline">
                  <input
                    v-model="notificationLoad"
                    id="radio-not-confirm"
                    name="notificationLoadRadioCheck"
                    class="form-check-input ml-2"
                    type="radio"
                    :value="$getConst('CONFIRM_STATUS.NOT_CONFIRMED')"
                  />
                  <label class="form-check-label" for="radio-not-confirm">
                    {{ $t("base.confirm_status.not_confirm") }}
                  </label>
                  <input
                    v-model="notificationLoad"
                    id="radio-confirm"
                    name="notificationLoadRadioCheck"
                    class="form-check-input ml-2"
                    type="radio"
                    :value="$getConst('CONFIRM_STATUS.CONFIRMED')"
                  />
                  <label class="form-check-label" for="radio-confirm">
                    {{ $t("base.confirm_status.confirmed_during_date") }}
                  </label>
                </div>
              </fieldset>

              <button @click="refresh" class="btn btn-outline-primary ml-3 mt-4 mb-0">
                <img src="/application/image/refresh-icon-1.png" />
              </button>
              <button @click="confirm" class="btn btn-primary ml-3 mt-4 mb-0">
                {{ $t("base.action_name.confirmt") }}
              </button>
            </div>
          </div>

          <div class="tab">
            <ul class="nav nav-tabs" id="bs-notif-tab-nav">
              <li class="nav-item active">
                <a
                  data-toggle="tab"
                  href="#projectmng-notif"
                  class="nav-link active"
                  >{{ $t("projectmng.page_name") }}</a
                >
              </li>
              <li class="nav-item">
                <a data-toggle="tab" href="#qaqc-notif" class="nav-link">{{
                  $t("object.qaqc")
                }}</a>
              </li>
              <li class="nav-item">
                <a data-toggle="tab" href="#system-notif" class="nav-link">{{
                  $t("user_dashboard.system_notification")
                }}</a>
              </li>
            </ul>

            <div class="tab-content clearfix">
              <div class="tab-pane in active pt-2 pb-2" id="projectmng-notif">
                <project-management-notif
                  ref="projectManagementNotif"
                ></project-management-notif>
              </div>
              <div class="tab-pane pt-2 pb-2" id="qaqc-notif">
                <qa-qc-notif ref="qaqcNotif"></qa-qc-notif>
              </div>
              <div class="tab-pane pt-2 pb-2" id="system-notif">
                <system-notif ref="systemNotif"></system-notif>
              </div>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
    <div
      class="modal fade"
      id="delete-work-done-modal"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="delete-work-done-modal">
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
            <button type="button" class="btn btn-primary">
              {{ $t("base.agress") }}
            </button>
            <button type="button" class="btn btn-secondary">
              {{ $t("base.close") }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/notification.js"></script>