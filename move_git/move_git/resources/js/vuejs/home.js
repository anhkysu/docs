
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**
 import the template
 */

import router from './router/home_rt';
import i18n from './plugins/i18n';
import HomeMenu from './components/home/template/HomeMenu.vue';
import PageView from './components/home/template/PageView.vue';

/**
 * import the action, getters, mutation and state
 */
//import store from '../js/store';
import store from './components/home';
import constPlugin from './consts';

Vue.use(constPlugin);

Vue.component('home-menu', HomeMenu);
Vue.component('page-view', PageView);

const app = new Vue({
    i18n,
    el: '#home',
    router,
    store
});