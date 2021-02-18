<template>
  <div
    class="modal fade"
    id="setting-search-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg-custom" role="setting-search-modal">
      <div class="modal-content bg-teal">
        <div class="modal-header">
          <h5 class="modal-title text-white">{{ $t('projectmng.setting_search.header_modal') }}</h5>
        </div>
        <div class="modal-body bg-white">
          <div class="row mb-2 mt-2">
            <div class="col-3 col-md-3">
              <fieldset class="border p-2">
                <legend
                  class="w-auto legend-custome"
                >{{ $t('projectmng.setting_search.condition_organization') }}</legend>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="condition_organization"
                    id="condition_organization_individual"
                    value="individual"
                  />
                  <label class="form-check-label" for="condition_organization_individual">Cá Nhân</label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="condition_organization"
                    id="condition_organization_team"
                    value="team"
                  />
                  <label class="form-check-label" for="condition_organization_team">Nhóm</label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="condition_organization"
                    id="condition_organization_department"
                    value="department"
                  />
                  <label class="form-check-label" for="condition_organization_department">Phòng</label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="condition_organization"
                    id="condition_organization_company"
                    value="company"
                  />
                  <label class="form-check-label" for="condition_organization_company">Công Ty</label>
                </div>
              </fieldset>
            </div>
            <div class="col-3 col-md-3">
              <fieldset class="border p-2">
                <legend
                  class="w-auto legend-custome"
                >{{ $t('projectmng.setting_search.condition_project_status') }}</legend>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" id="condition_project_status_planned" name="condition_project_status" />
                  <label class="form-check-label" for="condition_project_status_planned">Dự Kiến</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" id="condition_project_status_in_progress" name="condition_project_status"/>
                  <label class="form-check-label" for="condition_project_status_in_progress">Đang Thực Hiện</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" id="condition_project_status_done" name="condition_project_status"/>
                  <label class="form-check-label" for="condition_project_status_done">Hoàn Thành</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="5" id="condition_project_status_halted" name="condition_project_status"/>
                  <label class="form-check-label" for="condition_project_status_halted">Tạm Dừng</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="6" id="condition_project_status_canceled" name="condition_project_status"/>
                  <label class="form-check-label" for="condition_project_status_canceled">Huỷ Bỏ</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="4" id="condition_project_status_ended" name="condition_project_status"/>
                  <label class="form-check-label" for="condition_project_status_ended">Kết Thúc</label>
                </div>
              </fieldset>
            </div>
            <div class="col-6 col-md-6">
              <fieldset class="border p-2">
                <legend
                  class="w-auto legend-custome"
                >{{ $t('projectmng.setting_search.condition_management') }}</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="teamManager" name="condition_management" />
                            <label class="form-check-label" for="teamManager">{{ $t('projectmng.team_manager') }}</label>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-check">
                            <select class="form-control" name="teamManager">
                              <option
                                v-for="(staff, name, index) in teamManagerAssignedList"
                                :key="index"
                                :value="staff.id"
                              >{{ staff.staff_id }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="projectManager" name="condition_management" />
                            <label class="form-check-label" for="projectManager">{{ $t('projectmng.project_manager') }}</label>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-check">
                            <select class="form-control" name="projectManager">
                              <option
                                v-for="(staff, name, index) in projectManagerAssignedList"
                                :key="index"
                                :value="staff.id"
                              >{{ staff.staff_id }}</option>
                            </select>
                        </div>
                    </div>
                </div>
              </fieldset>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-white">
          <button
            type="button"
            class="btn btn-primary"
            v-on:click="search()"
          >{{ $t('base.search') }}</button>
          <button
            type="button"
            class="btn btn-secondary"
            v-on:click="close()"
          >{{ $t('base.close') }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="../../js/modals/settingsearchmodal.js"></script>