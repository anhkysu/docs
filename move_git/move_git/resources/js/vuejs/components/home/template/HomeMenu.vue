<template>
  <ul id="home-main-menu" class="row nav mb-2">
    <li class="nav-item" >
        <router-link data-toggle="tab" class="nav-link" :to="{ name: 'userDashboard' }">
        <img src="/application/image/personal-information-icon.png" />
        {{ currentUserName }}
        <span class="badge badge-danger">{{ numberOfNotification }}</span>
        </router-link>
    </li> 
    <li class="nav-item" >
      <router-link data-toggle="tab" class="nav-link" :to="{ name: 'projectManagement' }">
        <img src="/application/image/project-management-icon.png" />
        {{ $t('projectmng.page_name') }}</router-link>
    </li>
    <li class="nav-item">
      <router-link data-toggle="tab" class="nav-link" :to="{ name: 'translate' }">
        <img src="/application/image/translate-icon.png" />
        {{ $t('translate.page_name') }}</router-link>
    </li>
    <li class="nav-item">
      <router-link data-toggle="tab" class="nav-link" :to="{ name: 'qualityManagement' }">
        <img src="/application/image/check-icon.png" />
        {{ $t('qualitymng.page_name') }}</router-link>
    </li>
  </ul>
</template>

<script src="../js/homemenu.js"></script>