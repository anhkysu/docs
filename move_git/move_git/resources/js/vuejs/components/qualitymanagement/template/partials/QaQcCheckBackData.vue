<template>
  <div>
    <div class="row">
      <div
        class="col-12 col-md-12"
        style="height: calc(100vh - 300px); min-height: 800px; overflow: scroll"
      >
        <table class="table table-bordered table-sticky-head">
          <thead>
            <tr>
              <th scope="col">{{ $t("base.stt") }}</th>
              <th scope="col">{{ $t("io_data.datetime") }}</th>
              <th scope="col">{{ $t("io_data.data_type") }}</th>
              <th scope="col">{{ $t("projectmng.project_id") }}</th>
              <th scope="col">{{ $t("io_data.data_status") }}</th>
              <th scope="col">{{ $t("io_data.staff_data_status") }}</th>
              <th scope="col">
                {{ $t("io_data.sender") }}<br />
                {{ $t("projectmng.team") }}<br />
                {{ $t("projectmng.staff_id") }}<br />
              </th>
              <th scope="col">{{ $t("projectmng.department") }}</th>
              <th scope="col">{{ $t("projectmng.name") }}</th>
              <th scope="col">{{ $t("base.directory_path") }}</th>
            </tr>
          </thead>

          <tbody>
            <tr
              @click.prevent="selectCheckbackDataItem(index)"
              @contextmenu.prevent="
                (e) => openContextMenu(e, index, checkbackDataItem.id)
              "
              v-for="(checkbackDataItem, index) in checkbackDataList"
              :key="index"
              :id="'qaqc-checkback-data-' + index"
              class="position-relative"
            >
              <td scope="row">{{ index + 1 }}</td>
              <td>
                {{ checkbackDataItem.datetime }}
              </td>
              <td>
                {{ checkbackDataItem.data_input_type }}
              </td>
              <td>
                {{ checkbackDataItem.project_id_string }}
              </td>
              <td>
                {{ checkbackDataItem.data_status }}
              </td>
              <td>
                {{ checkbackDataItem.staff_data_status }}
              </td>
              <td>
                <strong>
                  {{ checkbackDataItem.sender }}
                </strong>
                <br />
                {{ checkbackDataItem.team }}
                <br />
                {{ checkbackDataItem.staff_id_string }}
              </td>
              <td>
                {{ checkbackDataItem.department }}
              </td>
              <td>
                {{ checkbackDataItem.project_name }}
              </td>
              <td>
                {{ checkbackDataItem.path }}
              </td>
            </tr>
          </tbody>

          <div
            class="dropdown-menu dropdown-menu-sm position-absolute border-primary"
            style="position: absolute"
            id="context-menu-checkback-data"
          >
            <a class="dropdown-item">{{ $t("base.open_folder") }}</a>
            <a
              class="dropdown-item"
              >{{ $t("base.view_detail") }}</a
            >
            <a
              @click.prevent="viewProjectDetailAction()"
              class="dropdown-item"
              >{{ $t("base.go_to_project") }}</a
            >
          </div>
        </table>
      </div>
    </div>
  </div>
</template>

<script src="../../js/qaqccheckbackdata.js"></script>