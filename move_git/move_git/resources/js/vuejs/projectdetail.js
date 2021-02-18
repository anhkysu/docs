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

import ProjectDetail from './components/project/template/ProjectDetail';
import i18n from './plugins/i18n';

/**
 * import the action, getters, mutation and state
 */
import store from './components/project';
import projectDetailRoutes from './router/projectdetail_rt';
import constPlugin from './consts';

Vue.use(constPlugin);
Vue.component('project-detail', ProjectDetail);

const projectDetailApp = new Vue({
    i18n,
    el: '#project-detail',
    store,
    router: projectDetailRoutes
});
