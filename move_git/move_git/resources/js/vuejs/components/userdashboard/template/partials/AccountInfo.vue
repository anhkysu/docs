<template>
  <div class="container-xl" style="min-height: calc(100vh - 300px)">
    <div class="row">
      <div class="col-12 col-md-12 pt-4 pb-4 align-items-center">
        <div class="form-group row">
          <label
            for="input-username"
            class="col-sm-3 col-form-label"
          >
            {{ $t("user_dashboard.username") }}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-username"
              :value="accountInformation.username"
            />
          </div>
        </div>
        <div class="form-group row" v-if="accountInformation.display_name">
          <label
            for="input-display-name"
            class="col-sm-3 col-form-label"
          >
            {{ $t("user_dashboard.display_name") }}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-display-name"
              :value="accountInformation.display_name"
            />
          </div>
        </div>
        <div class="form-group row">
          <label
            for="input-staff-id"
            class="col-sm-3 col-form-label"
          >
            {{ $t("projectmng.staff_id") }}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-staff-id"
              :value="currentUser.staff_id"
            />
          </div>
        </div>
        <div class="form-group row">
          <label
            for="input-account-type"
            class="col-sm-3 col-form-label"
          >
            {{ $t("user_dashboard.account_type") }}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-account-type"
              :value="accountInformation.account_type"
            />
          </div>
        </div>

        <fieldset class="border p-2 rounded mt-3">
          <legend class="w-auto legend-cusome">
            <h6 class="text-secondary">
              {{ $t("user_dashboard.change_password") }}
            </h6>
          </legend>
          <div class="container">
            <div class="form-group row">
              <label
                for="input-new-password"
                class="col-sm-3 col-form-label"
              >
                {{ $t("user_dashboard.new_password") }}
              </label>
              <div class="col-sm-9">
                <input
                  type="password"
                  class="form-control"
                  id="input-new-password"
                  v-model="password.new"
                />
              </div>
            </div>
            <div class="form-group row">
              <label
                for="input-confirm-password"
                class="col-sm-3 col-form-label"
              >
                {{ $t("user_dashboard.confirm_password") }}
              </label>
              <div class="col-sm-9">
                <input
                  type="password"
                  class="form-control"
                  id="input-confirm-password"
                  v-model="password.confirm"
                />
              </div>
            </div>
            <div class="form-group row mt-4">
              <div class="col-sm-12 clearfix">
                <button
                  v-on:click="changePassword()"
                  class="btn btn-outline-primary float-right"
                >
                  {{ $t("user_dashboard.change_password") }}
                </button>
              </div>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
</template>

<script src="../../js/accountinfo.js"></script>