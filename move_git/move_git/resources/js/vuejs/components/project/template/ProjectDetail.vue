<template>
  <div class="row flex-xl-nowrap">
    <main class="col-12 col-md-12 col-xl-12" role="main">
      <div class="mb-2">
        <button class="btn btn-white" data-toggle="modal" data-target="#create-project">
          <img src="/application/image/add-icon.png" />
          {{ $t('base.add') }}
        </button>
        <button class="btn btn-white">
          <img src="/application/image/refresh-icon.png" />
          {{ $t('base.refresh') }}
        </button>
        <button class="btn btn-white">
          <img src="/application/image/open-file-icon.png" />
          {{ $t('base.open_folder') }}
        </button>
        <button class="btn btn-white">
          <img src="/application/image/checklist-icon.png" />
          {{ $t('projectmng.add_work_done') }}
        </button>
        <button class="btn btn-white">
          <img src="/application/image/delete-icon.png" />
          {{ $t('base.delete') }}</button>
      </div>
      <div class="tab pt-2">
        <h5 class="pl-3">{{projectSelectedName}}</h5>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <router-link
                class="nav-link"
                :to="{ name: 'projectSummaryTab' }">
                {{ $t("projectmng.project_info") }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                class="nav-link"
                :to="{ name: 'jointStaffTab' }">
                {{ $t('projectmng.joint_staff') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                class="nav-link"
                :to="{ name: 'ioDataTab' }">
                {{ $t('projectmng.input_output_data') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                class="nav-link"
                :to="{ name: 'quotationTimeTab' }">
                {{ $t('projectmng.quotation_time') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                class="nav-link"
                :to="{ name: 'workDoneTab' }">
                {{ $t('projectmng.have_worked') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                class="nav-link"
                :to="{ name: 'technicalErrorTab' }">
                {{ $t('projectmng.errors') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                class="nav-link"
                :to="{ name: 'internalDataTab' }">
                {{ $t('projectmng.internal_data') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                class="nav-link"
                :to="{ name: 'contactListTab' }">
                {{ $t('projectmng.contact_list') }}
            </router-link>
          </li>
        </ul>

        <div class="tab-content clearfix">
          <div class="tab-pane in active pl-3 pr-3 pt-2 pb-2" id="project-summary">
            <router-view :projectInformation="projectInformationSelected" :projectId="projectInformationSelected.id" :key="$route.path" />
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script src="../js/projectdetail.js"></script>

