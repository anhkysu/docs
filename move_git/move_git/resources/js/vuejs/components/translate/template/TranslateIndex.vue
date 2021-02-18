<template>
  <div>
    <div class="row mb-2">
      <div class="col-12">
        <div class="tab pt-1">
          <ul class="nav nav-tabs" :key="$route.path">
            <li class="nav-item" id="to-translate-list-nav">
              <router-link
                data-toggle="tab"
                class="nav-link"
                :to="{ name: 'translateListPage' }"
                >{{ $t("translate.to_translate_list") }}</router-link
              >
            </li>
            <li class="nav-item" id="translate-action-nav">
              <router-link
                data-toggle="tab"
                class="nav-link"
                :to="{ name: 'translateActionPage', params: { dataId: translatingDataId } }"
                >{{ $t("translate.translate_action") }}</router-link
              >
            </li>
          </ul>
        </div>  
      </div>
    </div>

    <div class="tab-content clearfix">
      <div class="tab-pane active pr-3 pt-2 pb-2">
        <router-view :key="$route.path" />
      </div>
    </div>
  </div>
</template>


<script src='../js/translate.js'></script>
