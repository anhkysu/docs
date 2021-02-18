<template>
  <div class="row flex-xl-nowrap">
    <div class="col-2 col-md-2 col-xl-2 bd-sidebar">
      <div class="bd-search d-flex align-items-center mb-2">
        <input
          type="search"
          class="form-control ds-input"
          id="search-project"
          autocomplete="off"
          spellcheck="false"
          role="combobox"
          aria-autocomplete="list"
          aria-expanded="false"
          aria-owns="algolia-autocomplete-listbox-0"
          dir="auto"
          style="position: relative; vertical-align: top;"
          v-model="searchCriteria.inputText"
          v-on:keyup.enter="search()"
        />
        <button class="btn btn-white btn-setting" data-toggle="modal" data-target="#setting-search-modal">
          <img src="/application/image/setting-icon.png" />
        </button>
        <setting-search-project @refreshProjectList="getProjectInformations"></setting-search-project>
      </div>

      <nav class="bd-links" id="bd-docs-nav">
        <h5 class="nav-header">{{ $t('projectmng.project_list') }}</h5>
        <div class="scroll-bar-y" id="project-list-wrapper">
          <ul class="nav flex-column list-group list-group-flush">
            <li
              class="nav-item list-group-item text-wrap"
              style="width: 100%;"
              role="tab"
              v-for="(projectInformation, index) in tempProjectInformationList"
              :key="index"
              :id="'project-index-' + index"
              v-on:click="selectProjectInformation(index)"
            >
              <span
                class="text-wrap"
              >{{projectInformation.project_id}} - {{projectInformation.project_name}}</span>
            </li>
          </ul>
        </div>
      </nav>
    </div>

    <main class="col-10 col-md-10 col-xl-10" role="main">
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
        <button v-on:click="openAddWorkDoneModal()" class="btn btn-white">
          <img src="/application/image/checklist-icon.png" />
          {{ $t('projectmng.add_work_done') }}
        </button>
        <button class="btn btn-white">
          <img src="/application/image/delete-icon.png" />
          {{ $t('base.delete') }}</button>
      </div>
      <div class="tab pt-2">
        <h5 class="pl-3">{{projectSelectedName}}</h5>
        <ul class="nav nav-tabs" id="bs-projectmng-tab-nav">
          <li class="nav-item active">
            <a
              data-toggle="tab"
              href="#project-summary"
              class="nav-link active"
            >{{ $t('projectmng.project_info') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#joint-staff"
              class="nav-link"
            >{{ $t('projectmng.joint_staff') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#input-output-data"
              class="nav-link"
            >{{ $t('projectmng.input_output_data') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#quotation-time"
              class="nav-link"
            >{{ $t('projectmng.quotation_time') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#have-worked"
              class="nav-link"
            >{{ $t('projectmng.have_worked') }}</a>
          </li>
          <li class="nav-item">
            <a data-toggle="tab" href="#errors" class="nav-link">{{ $t('projectmng.errors') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#internal-data"
              class="nav-link"
            >{{ $t('projectmng.internal_data') }}</a>
          </li>
          <li class="nav-item">
            <a data-toggle="tab" href="#contact-list" class="nav-link">Danh Sach Nguoi Lien Lac</a>
          </li>
        </ul>

        <div class="tab-content clearfix">
          <div class="tab-pane in active pl-3 pr-3 pt-2 pb-2" id="project-summary">
            <project-summary :projectInformation="projectInformationSelected"></project-summary>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="joint-staff">
            <joint-staff :projectId="projectInformationSelected.id" :projectInformation="projectInformationSelected"></joint-staff>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="input-output-data">
            <input-output-data :projectId="projectInformationSelected.id" :projectInformation="projectInformationSelected"></input-output-data>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="quotation-time">
            <quotation-time :projectId="projectInformationSelected.id" :projectInformation="projectInformationSelected"></quotation-time>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="have-worked">
            <work-done :projectId="projectInformationSelected.id" :projectInformation="projectInformationSelected"></work-done>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="errors">
            <technical-error :projectId="projectInformationSelected.id" :projectInformation="projectInformationSelected"></technical-error>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="internal-data">internal-data</div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="contact-list">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Ten Nguoi Lien Lac</th>
                  <th scope="col">Email Nguoi Lien Lac</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Otto</td>
                  <td>Mark.Otto@gmail.com</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>Otto</td>
                  <td>Mark.Otto@gmail.com</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script src="../js/project.js"></script>