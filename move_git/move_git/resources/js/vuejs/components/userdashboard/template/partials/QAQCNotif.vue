<template>
  <div style="height: calc(100vh - 450px); overflow: scroll">
    <table class="table table-bordered table-sticky-head">
      <thead>
        <tr>
          <th scope="col">{{ $t("base.stt") }}</th>
          <th scope="col">{{ $t("base.action_name.confirmt") }}</th>
          <th scope="col">{{ $t("io_data.datetime") }}</th>
          <th scope="col">{{ $t("io_data.sender") }}</th>
          <th scope="col">{{ $t("base.action") }}</th>
          <th scope="col">{{ $t("technical_error.violated_error") }}</th>
          <th scope="col">{{ $t("technical_error.number_of_error") }}</th>
          <th scope="col">{{ $t("projectmng.remark") }}</th>
          <th scope="col">{{ $t("projectmng.project_id") }}</th>
          <th scope="col">{{ $t("technical_error.error_content") }}</th>
          <th scope="col">{{ $t("translate.data_path") }}</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(qaqcNotif, index) in qaqcNotifList"
          :key="index"
          :id="'qaqc-notif-' + index"
        >
          <td scope="row">{{ index + 1 }}</td>
          <td>
            <input
              type = "checkbox"
              :id="'qaqc-notif-confirmed' + index"
              :checked="qaqcNotif.confirmed"
            />
          </td>
          <td>{{ qaqcNotif.datetime }}</td>
          <td>{{ qaqcNotif.sender_short_name }}</td>
          <td>{{ qaqcNotif.action }}</td>
          <td>{{ qaqcNotif.violated_criteria_id }}</td>
          <td>{{ qaqcNotif.times}}</td>
          <td>{{ qaqcNotif.note}}</td>
          <td>{{ qaqcNotif.project_id}}</td>
          <td>{{ qaqcNotif.violated_error_content}}</td>
          <td>{{ qaqcNotif.data_path}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script src="../../js/qaqcnotif.js"></script>
