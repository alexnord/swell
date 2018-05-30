
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

import BootstrapVue from 'bootstrap-vue';
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue);

Vue.component('create-entry-component', require('./components/CreateEntryComponent.vue'));
Vue.component('list-reports-component', require('./components/ListReportsComponent.vue'));
Vue.component('show-report-component', require('./components/ShowReportComponent.vue'));

const app = new Vue({
    el: '#app'
});

