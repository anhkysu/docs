
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
import router from './router/collection_rt.js'

import CollectionMenu from './components/collection/template/CollectionMenu.vue'
import PageView from './components/collection/template/PageView.vue'

/**
 * import the action, getters, mutation and state
 */
//import store from '../js/store';
import store from './components/collection'

Vue.component('collection-menu', CollectionMenu);
Vue.component('page-view', PageView);

const app = new Vue({
    el: '#collection',
    router,
    store
});