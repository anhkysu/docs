<template>
  <div class="row flex-xl-nowrap" v-if="translateDataItem">
    <div class="col-2 col-md-2 col-xl-2 bd-sidebar">
      <div class="bg-white p-4">
        <p>
          <strong>{{ $t("translate.mark") }}</strong>
        </p>
        <div class="ml-4 mb-2">
          <!--Dropdown Nhóm Phòng Công Ty-->
          <div
            :key="index"
            v-for="({ id, label, group }, index) in translateActionMark"
            class="form-check"
          >
            <input
              :name="group"
              class="form-check-input"
              type="radio"
              v-model="translateDataItem.data_translate_status"
              :id="label"
              :value="id"
            />
            <label class="form-check-label" :for="label">
              {{ label }}
            </label>
          </div>
        </div>
        <button
          @click="updateTranslateDataItem()"
          class="btn btn-primary btn-md btn-block mt-3"
        >
          {{ $t("translate.btn.save_changes") }}
        </button>
        <button
          @click="viewProjectDetailAction()"
          class="btn btn-primary btn-md btn-block mt-3"
        >
          {{ $t("base.go_to_project") }}
        </button>
        <button class="btn btn-primary btn-md btn-block mt-3">
          {{ $t("translate.btn.send_to_view") }}
        </button>
      </div>
    </div>

    <main class="col-10 col-md-10 col-xl-10 bg-white p-3" role="main">
      <h5 class="text">
        {{ $t("translate.translate_data").toUpperCase() }}
      </h5>
      <hr />
      <div class="row d-flex bg-white pl-1 pt-1 pb-1">
        <div
          class="col-3 border-right font-weight-bold d-flex align-items-center"
        >
          {{ $t("projectmng.project_id") }}:
          {{ translateDataItem.project_id }}
        </div>
        <div
          class="col-3 border-right font-weight-bold d-flex align-items-center"
        >
          {{ $t("io_data.translator") }}:
          {{ currentUser.full_name }}
        </div>
        <div
          class="col-3 border-right font-weight-bold d-flex align-items-center"
        >
          {{ $t("io_data.data_type") }}:
          {{ translateDataItem.data_type }}
        </div>
        <div class="col-3 border-right font-weight-bold">
          <div
            class="row d-flex align-items-center"
            v-if="translateDataItem.data_input_type"
          >
            <label for="inputPassword3" class="col-4 col-form-label"
              >{{ $t("io_data.input_type") }}:</label
            >
            <div class="col-8">
              <select
                class="form-control"
                v-model="translateDataItem.data_input_type"
              >
                <option
                  :value="id"
                  :key="index"
                  v-for="({ label, id }, index) in dataInputTypeList"
                >
                  {{ label }}
                </option>
              </select>
            </div>
          </div>
          <div
            class="row d-flex align-items-center"
            v-if="translateDataItem.data_output_type"
          >
            <label for="inputPassword3" class="col-4 col-form-label"
              >{{ $t("io_data.output_type") }}:</label
            >
            <div class="col-8">
              <select
                class="form-control"
                v-model="translateDataItem.data_output_type"
                disabled
              >
                <option
                  :value="id"
                  :key="index"
                  v-for="({ label, id }, index) in dataOutputTypeList"
                >
                  {{ label }}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div
        v-if="translateDataItem.data_path"
        class="row bg-white pl-1 pt-1 pb-1"
      >
        <div class="col-10 font-weight-bold">
          <div class="row d-flex align-items-center">
            <label for="inputPassword3" class="col-2 col-form-label">
              {{ $t("io_data.data_attachment") }}:
            </label>
            <div class="col-10">
              <input
                disabled
                type="text"
                class="form-control"
                placeholder=""
                :value="translateDataItem.data_path"
              />
            </div>
          </div>
        </div>
        <div class="col-2 font-weight-bold d-flex align-items-center">
          <button class="btn btn-md btn-block btn-primary">
            {{ $t("base.open_folder") }}
          </button>
        </div>
      </div>

      <div v-else class="row bg-white pl-1 pt-1 pb-1">
        <div class="col-12 font-italic">
          {{ $t("base.no_attached_file") }}
        </div>
      </div>

      <div class="row bg-white mt-2 pl-1">
        <div class="col-6 form-group">
          <label class="font-weight-bold" for="exampleFormControlTextarea1">{{
            $t("io_data.original_mail")
          }}</label>
          <textarea
            class="form-control"
            rows="21"
            v-model="translateDataItem.original_mail"
          ></textarea>
        </div>
        <div class="col-6 form-group">
          <label class="font-weight-bold" for="exampleFormControlTextarea1">{{
            $t("io_data.translated_mail")
          }}</label>
          <textarea
            class="form-control"
            rows="21"
            v-model="translateDataItem.translated_mail"
          ></textarea>
        </div>
      </div>
    </main>
  </div>
</template>
<script src="../../js/translateaction.js"></script>

