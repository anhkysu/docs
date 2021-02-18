<template>
  <div>
    <div class="row mb-2">
      <div class="col-12 col-md-12">
        <button class="btn btn-secondary" v-on:click="openAddInputDataModal()" :disabled="!sectionControl.isAction">{{ $t('io_data.add_input') }}</button>
        <button class="btn btn-secondary" v-on:click="openAddOutputDataModal()" :disabled="!sectionControl.isAction">{{ $t('io_data.add_output') }}</button>
        <button class="btn btn-secondary" v-on:click="openUpdateDataModal()" :disabled="(sectionControl.ioPreviousSelected == -1)">{{ $t('base.edit') }}</button>
        <button class="btn btn-secondary" v-on:click="openDeleteIODataModal()" :disabled="(sectionControl.ioPreviousSelected == -1)">{{ $t('io_data.delete_data') }}</button>
        <button class="btn btn-secondary" :disabled="(sectionControl.ioPreviousSelected == -1)" >{{ $t('base.open_folder') }}</button>
        <button class="btn btn-secondary" v-on:click="refreshIOList()" :disabled="!sectionControl.isAction">{{ $t('base.refresh') }}</button>
        <button class="btn btn-secondary" :disabled="!sectionControl.isAction">{{ $t('base.print') }}</button>
        <div class="d-inline-block align-middle">
          <div class="input-group">
            <input @keydown="onSearchBoxKeyDown" v-model="searchBoxInput" type="text" class="form-control" aria-label="Text input with segmented dropdown button">
            <div class="input-group-append">
              <button v-on:click="searchMailContent()" class="btn btn-outline-secondary" type="button">{{$t('io_data.search_mail_content')}}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-md-12" style="height: calc(100vh - 330px); overflow: scroll" id="iodata-table-wrapper">
          <table class="table table-bordered table-sticky-head">
            <thead>
              <tr>
                <th scope="col">{{ $t('base.stt') }}</th>
                <th scope="col">
                  {{ $t('io_data.data_group') }} <br />
                  {{ $t('io_data.datetime')}} <br />
                  {{ $t('io_data.data_type') }}
                </th>
                <th scope="col">{{ $t('io_data.data_status')}}</th>
                <th scope="col">{{ $t('io_data.staff_data_status')}}</th>
                <th scope="col">{{ $t('io_data.original_mail')}}</th>
                <th scope="col">{{ $t('io_data.translated_mail')}}</th>
                <th scope="col">
                  {{ $t('io_data.receiver')}}
                  ({{ $t('io_data.sender')}})
                  /<br />
                  {{ $t('staff.staff_id')}}
                </th>
                <th scope="col">{{ $t('io_data.pd_status')}}</th>
                <th scope="col">{{ $t('io_data.translator')}}</th>
                <th scope="col">{{ $t('io_data.mail_subject')}}</th>
                <th scope="col">{{ $t('base.directory_path')}}</th>
              </tr>
            </thead>
            <tbody class="scroll-bar-y">
              <tr v-for="(ioData, index) in ioDataList" :key="index" :id="'io-data-' + index" :data-iodata-id="ioData.name.toLowerCase()+ioData.id" v-on:click="selectIOData(ioData.name, ioData.id, index)"
                :class="ioData.name === $getConst('IO_CONST.IO_DATA_TYPE_NAME_INPUT') && 'bg-lightblue'">
                <td scope="row">{{index + 1}}</td>
                <td>{{ioData.name}} <br />
                {{ioData.datetime}} <br />
                {{ioData.data_type}}
                </td>
                <td>{{ioData.data_status}}</td>
                <td>{{ioData.staff_data_status}}</td>
                <td>{{ioData.original_mail}}</td>
                <td>{{ioData.translated_mail}}</td>
                <td>
                  {{ioData.sender}}
                  <br />
                  {{ioData.receiver}}
                  <br />
                  {{ioData.staff_id}}
                </td>
                <td>{{ioData.data_translate_status}}</td>
                <td>{{ioData.translator}}</td>
                <td>{{ioData.subject_mail}}</td>
                <td>{{ioData.path}}</td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>

     <input-data-modal :loadData="ioLoadData.data" @refreshInputData="refreshIOList" :projectInformation="projectInformation" v-model="inputDataSelected"></input-data-modal>
     <output-data-modal :loadData="ioLoadData.data" @refreshOutputData="refreshIOList" :projectInformation="projectInformation" v-model="outputDataSelected"></output-data-modal>
    <div
        class="modal fade"
        id="delete-data-modal"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
        data-backdrop="static"
      >
        <div class="modal-dialog" role="input-data-modal">
          <div class="modal-content bg-teal">
            <div class="modal-header">
              <h5 class="modal-title text-white">{{ $t('base.delete_confirmation_header_modal') }}</h5>
            </div>  
            <div class="modal-body bg-white">
              {{ $t('base.delete_question') }}
            </div>
            <div class="modal-footer bg-white">
              <button type="button" class="btn btn-primary" v-on:click="yesDelete()">{{ $t('base.agress') }}</button>
              <button type="button" class="btn btn-secondary" v-on:click="noDelete()">{{ $t('base.close') }}</button>
            </div>
          </div>
        </div>
      </div>
  </div>
</template>

<script src="../../js/iodata.js"></script>