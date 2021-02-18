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
              <th scope="col">{{ $t("qualitymng.system_check") }}</th>
              <th scope="col">{{ $t("base.stt") }}</th>
              <th scope="col">{{ $t("io_data.datetime") }} <br /></th>
              <th scope="col">{{ $t("projectmng.project_id") }}</th>
              <th scope="col">
                {{ $t("io_data.sender") }}<br />
                {{ $t("projectmng.team") }}<br />
                {{ $t("projectmng.staff_id") }}
              </th>
              <th scope="col">{{ $t("projectmng.department") }}</th>
              <th scope="col">{{ $t("qualitymng.qc_check") }}</th>
              <th scope="col">{{ $t("qualitymng.qa_check") }}</th>
              <th scope="col">{{ $t("qualitymng.qc_feedback") }}</th>
              <th scope="col">{{ $t("qualitymng.qa_feedback") }}</th>
              <th scope="col">{{ $t("projectmng.name") }}</th>
              <th scope="col">{{ $t("base.directory_path") }}</th>
            </tr>
          </thead>

          <tbody>
            <tr
              @click.prevent="selectSendDataItem(index)"
              @contextmenu.prevent="
                (e) => openContextMenu(e, index, sendDataItem.id)
              "
              v-for="(sendDataItem, index) in sendDataList"
              :key="index"
              :id="'qaqc-send-data-' + index"
              :class="
                'position-relative ' +
                (sendDataItem.data_type ===
                  $getConst('IO_CONST.IO_DATA_TYPE_NAME_INPUT') &&
                  'bg-lightblue')
              "
            >
              <td>SYSTEM CHECK</td>
              <td scope="row">{{ index + 1 }}</td>
              <td>
                {{ sendDataItem.datetime }}
              </td>
              <td>
                {{
                  sendDataItem.project_id_string
                }}
              </td>
              <td>
                <strong>
                  {{
                    sendDataItem.sender
                  }}
                </strong>
                <br />
                {{
                  sendDataItem.team
                }}
                <br />
                {{
                  sendDataItem.staff_id
                }}
              </td>
              <td>
                {{ sendDataItem.department }}
              </td>
              <td class="align-middle">
                <div class="d-flex justify-content-center">
                  <input type="checkbox" :checked="sendDataItem.qc_checked" readonly/>
                </div>
              </td>
              <td class="align-middle">
                <div class="d-flex justify-content-center">
                <input type="checkbox" :checked="sendDataItem.qa_checked" readonly/>
                </div>
              </td>
              <td>
                {{
                  sendDataItem.feedback_qc
                }}
              </td>
              <td>
                {{
                  sendDataItem.feedback_qa
                }}
              </td>
              <td>
                {{
                  sendDataItem.project_name
                }}
              </td>
              <td>
                {{
                  sendDataItem.path
                }}
              </td>
            </tr>
          </tbody>

          <div
            class="dropdown-menu dropdown-menu-sm position-absolute border-primary"
            style="position: absolute"
            id="context-menu-send-data"
          >
            <a
              @click.prevent="switchTab()"
              class="dropdown-item"
              >{{ $t("qualitymng.qc") }}</a
            >
            <a
              @click.prevent="switchTab()"
              class="dropdown-item"
              >{{ $t("qualitymng.qa") }}</a
            >
            <a class="dropdown-item">{{ $t("base.open_folder") }}</a>
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

<script src="../../js/qaqcsenddata.js"></script>