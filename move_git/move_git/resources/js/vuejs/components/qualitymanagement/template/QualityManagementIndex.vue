<template>
  <div>
    <div class="row mb-2">
      <div class="col-12">
        <div class="tab pt-1">
          <ul class="nav nav-tabs" id="bs-qaqc-data-list-tab-nav">
            <li class="nav-item active">
              <a data-toggle="tab" href="#qaqc-data-list" class="nav-link active">{{
                $t("qualitymng.data_list")
              }}</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" href="#qc-action" class="nav-link">{{
                $t("qualitymng.qc")
              }}</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" href="#qa-action" class="nav-link">{{
                $t("qualitymng.qa")
              }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="tab-content clearfix">
      <div class="tab-pane in active pt-2 pb-2" id="qaqc-data-list">
        <qaqc-data-list></qaqc-data-list>
      </div>
      <div class="tab-pane fade pt-2 pb-2" id="qc-action">
        <qc-action></qc-action>
      </div>
      <div class="tab-pane fade pt-2 pb-2" id="qa-action">
        <qa-action></qa-action>
      </div>
    </div>
  </div>
</template>


<script src='../js/qualitymanagement.js'></script>
