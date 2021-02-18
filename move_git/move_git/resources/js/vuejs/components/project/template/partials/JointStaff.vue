<template>
  <div>
    <div class="row mb-2">
      <div class="col-12 col-md-12">
        <div class="form-group row">
          <label for="status" class="col-1 col-md-1 col-form-label">{{ $t('projectmng.team') }}</label>
          <div class="col-2 col-md-2">
            <select class="form-control" v-model="teamSelected">
              <option
                v-for="(team, name, index) in staffInTeam"
                :key="index"
                :value="name"
              >{{ name }}</option>
            </select>
          </div>
          <button type="button" class="btn btn-primary" v-on:click="addTeam()">{{ $t('base.add') }}</button>
          <label for="status" class="col-1 col-md-1 col-form-label">{{ $t('projectmng.staff') }}</label>
          <div class="col-2 col-md-2">
            <select class="form-control" v-model="staffSelected">
              <option
                v-for="(staff, name, index) in staffList"
                :key="index"
                :value="staff.id"
              >{{ staff.short_name }}</option>
            </select>
          </div>
          <div class="col-2 col-md-2">
            <select class="form-control" v-model="staffSelected">
              <option
                v-for="(staff, name, index) in staffList"
                :key="index"
                :value="staff.id"
              >{{ staff.staff_id }}</option>
            </select>
          </div>
          <button type="button" class="btn btn-primary" v-on:click="addStaff()">{{$t('base.add')}}</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-12" style="height: calc(100vh - 330px); overflow: scroll">
          <table class="table table-bordered table-sticky-head">
            <thead>
              <tr>
                <th scope="col">{{ $t('base.stt') }}</th>
                <th scope="col">
                  {{ $t('projectmng.staff_name')}}
                  <br />
                  {{ $t('projectmng.staff_id') }}
                  <br />
                  {{ $t('projectmng.team') }}
                  <br />
                  {{ $t('projectmng.job_title') }}
                </th>
                <th scope="col">{{ $t('projectmng.draw_time_total')}}</th>
                <th scope="col">{{ $t('projectmng.check_time_total')}}</th>
                <th scope="col">{{ $t('projectmng.I')}}</th>
                <th scope="col">{{ $t('projectmng.II')}}</th>
                <th scope="col">{{ $t('projectmng.III')}}</th>
                <th scope="col">{{ $t('projectmng.time_total')}}</th>
                <th scope="col">{{ $t('projectmng.quotation_total')}}</th>
                <th scope="col">{{ $t('projectmng.estimated_productivity')}}</th>
                <th scope="col">{{ $t('projectmng.technical_errors_total')}}</th>
                <th scope="col">{{ $t('projectmng.quality_errors_total')}}</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(jointstaff, index) in jointStaffList" :key="index">
                <td scope="row">{{index + 1}}</td>
                <td>
                  <b>{{jointstaff.short_name}}</b>
                  <br />
                  {{jointstaff.staff_id}}
                  <br />
                  {{jointstaff.team}}
                  <br />
                  {{jointstaff.job_title}}
                  <br />
                </td>
                <td>{{jointstaff.drawing_time_sum}}</td>
                <td>{{jointstaff.checking_time_sum}}</td>
                <td>{{jointstaff.working_factor_i}}</td>
                <td>{{jointstaff.working_factor_ii}}</td>
                <td>{{jointstaff.working_factor_iii}}</td>
                <td>{{jointstaff.working_time_sum}}</td>
                <td>{{jointstaff.quotation_really_time_sum}}</td>
                <td>{{jointstaff.temp_productivity}}</td>
                <td>{{jointstaff.technical_error_sum}}</td>
                <td>{{jointstaff.qc_error_sum}}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger btn-icon"
                    v-on:click="openDeleteJointStaffModal(index)"
                  >x</button>
                </td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>
    <div
      class="modal fade"
      id="delete-joint-staff-modal"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="delete-joint-staff-modal">
        <div class="modal-content bg-teal">
          <div class="modal-header">
            <h5 class="modal-title text-white">
              {{ $t("base.delete_confirmation_header_modal") }}
            </h5>
          </div>
          <div class="modal-body bg-white">
            {{ $t("io_data.messages.delete_joint_staff_warning") }}
          </div>
          <div class="modal-footer bg-white">
            <button
              type="button"
              class="btn btn-primary"
              v-on:click="yesDelete()"
            >
              {{ $t("base.agress") }}
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              v-on:click="noDelete()"
            >
              {{ $t("base.close") }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/jointstaff.js"></script>