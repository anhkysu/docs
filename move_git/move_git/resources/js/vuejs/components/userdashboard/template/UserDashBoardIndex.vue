<template>
  <div class="row flex-xl-nowrap">
    <main class="col-12 col-md-12 col-xl-12" role="main">
      <div class="mb-2">
          <h3 class="text-light">" {{currentUser && currentUser.slogan}} "</h3>
      </div>
      <div class="tab pt-2">
        <h5 class="pl-3"></h5>
        <ul class="nav nav-tabs" id="bs-projectmng-tab-nav">
          <li class="nav-item active">
            <a
              data-toggle="tab"
              href="#user-dashboard-notification"
              class="nav-link active"
            >{{ $t('user_dashboard.notification') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#personal-info"
              class="nav-link"
            >{{ $t('user_dashboard.personal_information') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#account-info"
              class="nav-link"
            >{{ $t('user_dashboard.account_information') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#personal-work-done"
              class="nav-link"
            >{{ $t('object.work_done') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#personal-productivity"
              class="nav-link"
            >{{ $t('user_dashboard.personal_productivity') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#statisticize-personal-error"
              class="nav-link"
            >{{ $t('technical_error.statisticize_error') }}</a>
          </li>
          <li class="nav-item">
            <a
              data-toggle="tab"
              href="#quotes"
              class="nav-link"
            >{{ $t('user_dashboard.quotes') }}</a>
          </li>
        </ul>

        <div class="tab-content clearfix">
          <div class="tab-pane in active pl-3 pr-3 pt-2 pb-2" id="user-dashboard-notification">
            <notification></notification>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="personal-info">
            <personal-info></personal-info>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="account-info">
            <account-info></account-info>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="personal-work-done">
            <personal-work-done></personal-work-done>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="personal-productivity">
            <personal-productivity></personal-productivity>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="statisticize-personal-error">
            <personal-error></personal-error>
          </div>
          <div class="tab-pane fade pl-3 pr-3 pt-2 pb-2" id="quotes">
            <quotes></quotes>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script src="../js/userdashboard.js"></script>