<template>
  <div style="height: calc(100vh - 450px); overflow: scroll">
    <table class="table table-bordered table-sticky-head">
      <thead>
        <tr>
          <th scope="col">{{ $t("base.action_name.confirmt") }}</th>
          <th scope="col">{{ $t("base.seen") }}</th>
          <th scope="col">{{ $t("base.stt") }}</th>
          <th scope="col">{{ $t("io_data.datetime") }}</th>
          <th scope="col">{{ $t("io_data.data_group") }}</th>
          <th scope="col">{{ $t("io_data.data_type") }}</th>
          <th scope="col">{{ $t("io_data.pd_status") }}</th>
          <th scope="col">{{ $t("base.action") }}</th>
          <th scope="col">{{ $t("io_data.translator") }}</th>
          <th scope="col">{{ $t("translate.suggested_translator") }}</th>
          <th scope="col">{{ $t("projectmng.joint_staff_tab_name") }}</th>
          <th scope="col">{{ $t("projectmng.project_id") }}</th>
          <th scope="col">{{ $t("translate.data_path") }}</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(notif, index) in projectMngNotifList"
          :key="index"
          :id="'project-mng-notif' + index"
        >
          <td>
            <input
              type = "checkbox"
              :id="'project-mng-confirmed' + index"
              :checked="notif.confirmed"
            />
          </td>
          <td>
            <input
              type="checkbox"
              :id ="'project-mng-seen' + index"
              :checked="false"
            />
          </td>
          <td>{{ index + 1 }}</td>
          <td>{{ notif.datetime }}</td>
          <td>{{ notif.data_group }}</td>
          <td>{{ notif.data_type }}</td>
          <td>{{ notif.data_translate_status }}</td>
          <td>{{ notif.action }}</td>
          <td>{{ notif.translator }}</td>
          <td>{{ notif.translator_suggested }}</td>
          <td>
              {{ notif.action_staff_staff_id }} <br/>
              {{ notif.action_staff_short_name }}
          </td>
          <td>
              {{ notif.project_id }}
          </td>
          <td>
              {{ notif.project_path }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script src="../../js/projectmanagementnotif.js"></script>