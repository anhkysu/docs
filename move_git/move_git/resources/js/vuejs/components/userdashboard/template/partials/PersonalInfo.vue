<template>
  <div class="container-xl" style="min-height: calc(100vh - 300px);">
    <div class="row">
      <div
        class="col-4 col-md-4 pt-4 d-flex flex-column align-items-center"
      >
        <div
          class="rounded-circle bg-secondary avatar-wrapper"
        >
          <img
            :src="currentUser.avatar"
            class="avatar-image"
          />
        </div>
        <input id='upload-avatar' type='file' v-on:change="onUploadFileChange" name="avatar" hidden/>
        <button v-on:click="changeAvatar" class="mt-3 btn btn-outline-primary">
          {{$t('user_dashboard.change_avatar')}}
        </button>
      </div>
      <div
        class="col-8 col-md-8 pt-4 pb-4 align-items-center"
      >
        <div class="form-group row">
          <label for="input-msnv" class="col-sm-3 col-form-label">
            {{$t('projectmng.staff_id')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-msnv"
              :value="staffInformation.staff_id"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="input-name" class="col-sm-3 col-form-label">
            {{$t('projectmng.staff_name')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-name"
              :value="staffInformation.first_name"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="input-family-name" class="col-sm-3 col-form-label">
            {{$t('projectmng.staff_family_name')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-family-name"
              :value="staffInformation.last_name"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="input-short-name" class="col-sm-3 col-form-label">
            {{$t('projectmng.staff_short_name')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-short-name"
              :value="staffInformation.short_name"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="input-status" class="col-sm-3 col-form-label">
            {{$t('projectmng.status')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-status"
              :value="staffInformation.status_label"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="input-group" class="col-sm-3 col-form-label">
            {{$t('projectmng.team')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-group"
              :value="staffInformation.team_label"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="input-start-working-day" class="col-sm-3 col-form-label">
            {{$t('user_dashboard.start_working_day')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-start-working-day"
              :value="staffInformation.working_sign_date"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="input-contract-signing-day" class="col-sm-3 col-form-label">
            {{$t('user_dashboard.contract_signing_day')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-contract-signing-day"
              :value="staffInformation.contract_sign_date"
            />
          </div>
        </div>
        <div class="form-group row" v-if="staffInformation.contract_end_date">
          <label for="input-stop-working-day" class="col-sm-3 col-form-label">
            {{$t('user_dashboard.stop_working_day')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-stop-working-day"
              :value="staffInformation.contract_end_date"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="input-job-title" class="col-sm-3 col-form-label">
            {{$t('projectmng.job_title')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-job-title"
              :value="staffInformation.job_title_label"
            />
          </div>
        </div>
        <div class="form-group row" v-if="staffInformation.authority">
          <label for="input-power" class="col-sm-3 col-form-label">
            {{$t('user_dashboard.authority')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-power"
              :value="staffInformation.authority"
            />
          </div>
        </div>
        <div class="form-group row" v-if="staffInformation.responsibility">
          <label for="input-responsibility" class="col-sm-3 col-form-label">
            {{$t('user_dashboard.responsibility')}}
          </label>
          <div class="col-sm-9">
            <input
              readonly
              type="text"
              class="form-control"
              id="input-responsibility"
              :value="staffInformation.responsibility"
            />
          </div>
        </div>
        <div class="form-group row">
          <label for="input-slogan" class="col-sm-3 col-form-label">
            {{$t('user_dashboard.slogan')}}
          </label>
          <div class="col-sm-7">
            <textarea
              class="form-control"
              id="input-slogan"
              v-model="staffInformation.slogan"
            />
          </div>
          <div class="col-sm-2">
            <button v-on:click="saveSlogan()" class="btn btn-block btn-outline-primary">
              {{$t('base.save') + ' ' + $t('user_dashboard.slogan')}}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/personalinfo.js"></script>