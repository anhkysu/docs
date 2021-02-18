<template>
  <div>
    <div>
      <button class="btn btn-success" :disabled="!sectionControl.isUpdateProjectInformation" v-on:click="updateProjectInformation()">{{ $t('base.update') }}</button>
    </div>
    
    <form class="form">
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.project_id') }}</label>
        <div class="col-md-4">
          <input type="text" class="form-control" disabled :value="projectInformation.project_id" />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.name') }}</label>
        <div class="col-md-4">
          <input type="text" class="form-control" v-model="projectInformation.project_name" />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.directory_path') }}</label>
        <div class="col-md-4">
          <input type="text" class="form-control" v-model="projectInformation.project_path" />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.status') }}</label>
        <div class="col-md-4">
          <select class="form-control" v-model="projectInformation.status">
            <option
              v-for="(status, index) in projectStatusList"
              :key="index"
              :value="status.id"
            >{{ status.label }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.factor_rate') }}</label>
        <div class="col-md-1">
          <span>I: </span>
          <select class="form-control" v-model="projectInformation.working_factor_i">
            <option
              v-for="(valueFactorI, index) in valueFactorList"
              :key="index"
              :value="valueFactorI.id"
            >{{ valueFactorI.value }}</option>
          </select>
        </div>
        <div class="col-md-1">
          <span>II: </span>
          <select class="form-control" v-model="projectInformation.working_factor_ii">
            <option
              v-for="(valueFactorII, index) in valueFactorList"
              :key="index"
              :value="valueFactorII.id"
            >{{ valueFactorII.value }}</option>
          </select>
        </div>
        <div class="col-md-1">
          <span>III: </span>
          <select class="form-control" v-model="projectInformation.working_factor_iii">
            <option
              v-for="(valueFactorIII, index) in valueFactorList"
              :key="index"
              :value="valueFactorIII.id"
            >{{ valueFactorIII.value }}</option>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="status" class="col-md-2 col-form-label">{{ $t('projectmng.end_user_email') }}</label>
        <div class="col-md-4">
          <select class="form-control" v-model="projectInformation.end_user_id">
            <option
              v-for="(endUser, index) in endUserList"
              :key="index"
              :value="endUser.id"
            >{{ endUser.name }}</option>
          </select>
        </div>
        <div class="col-md-4">
          <select class="form-control" v-model="projectInformation.end_user_id">
            <option
              v-for="(endUser, index) in endUserList"
              :key="index"
              :value="endUser.id"
            >{{ endUser.email }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.team_manager') }}</label>
        <div class="col-md-4">
          <select class="form-control" v-model="projectInformation.team_manager" disabled>
            <option
              v-for="(teamManager, index) in teamManagerList"
              :key="index"
              :value="teamManager.id"
            >{{ teamManager.short_name }}</option>
          </select>
        </div>
        <div class="col-md-4">
          <select class="form-control" v-model="projectInformation.team_manager" disabled>
            <option
              v-for="(teamManager, index) in teamManagerList"
              :key="index"
              :value="teamManager.id"
            >{{ teamManager.staff_id }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="status" class="col-md-2 col-form-label">{{ $t('projectmng.project_manager') }}</label>
        <div class="col-md-4">
          <select class="form-control" v-model="projectInformation.project_manager" disabled>
            <option
              v-for="(projectManager, index) in projectManagerList"
              :key="index"
              :value="projectManager.id"
            >{{ projectManager.short_name }}</option>
          </select>
        </div>
        <div class="col-md-4">
          <select class="form-control" v-model="projectInformation.project_manager" disabled>
            <option
              v-for="(projectManager, index) in projectManagerList"
              :key="index"
              :value="projectManager.id"
            >{{ projectManager.staff_id }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label
          for="project-id"
          class="col-md-2 col-form-label"
        >{{ $t('projectmng.business_manager') }}</label>
        <div class="col-md-4">
          <input type="text" class="form-control" readonly />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.quantity_unit') }}</label>
        <div class="col-md-4">
          <input type="number" class="form-control" v-model="projectInformation.amount" />
        </div>
        <div class="col-md-4">
          <select class="form-control" v-model="projectInformation.unit_id">
            <option
              v-for="(unit, index) in unitList"
              :key="index"
              :value="unit.id"
            >{{ unit.unit_id }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.start_date') }}</label>
        <div class="col-md-4">
          <input type="datetime-local" class="form-control" v-model="projectInformation.start_date" />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.finish_date') }}</label>
        <div class="col-md-4">
          <input type="datetime-local" class="form-control" v-model="projectInformation.finish_date" />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.create_date') }}</label>
        <div class="col-md-4">
          <input type="text" class="form-control" :value="projectInformation.create_date" readonly />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label">{{ $t('projectmng.remark') }}</label>
        <div class="col-md-8">
          <textarea type="text" class="form-control" v-model="projectInformation.remark"></textarea>
        </div>
      </div>
    </form>
  </div>
</template>

<script src="../../js/projectsummary.js"></script>