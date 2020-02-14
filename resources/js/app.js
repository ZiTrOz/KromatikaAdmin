/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.$ = window.jQuery = require('jquery');
window.axios = require('axios');
require('./bootstrap');
require( 'bootstrap-datepicker');
require( 'datatables.net-bs4');
require( 'datatables.net-buttons-bs4');
require( 'datatables.net-select-bs4');
require( 'jquery-loading');


import Vue from "vue";
window.Vue = Vue;


//window.Swal = require('sweetalert2');
window.moment = (require("moment"));
import 'vue-select/dist/vue-select.css';
import "vue-multiselect/dist/vue-multiselect.min.css";
import es from 'vee-validate/dist/locale/es';
import Multiselect from 'vue-multiselect';
import VeeValidate, { Validator } from 'vee-validate';
import VRuntimeTemplate from "v-runtime-template";
import vSelect from 'vue-select';
import Datepicker from 'vuejs-datepicker';
import { esp } from 'vuejs-datepicker/dist/locale';
//var DatatableFactory  = require('vuejs-datatable');
//import { VuejsDatatableFactory } from 'vuejs-datatable';

Validator.localize({ es: es });
Vue.use(VeeValidate, {locale: 'es'});
Vue.component('multiselect', Multiselect);
Vue.component('v-select', vSelect);
Vue.component('datepicker', Datepicker);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('main-component', require('./components/layouts/main.vue').default);
Vue.component('footer-component', require('./components/layouts/footer.vue').default);
// Vue.component('content-component', require('./components/layouts/content.vue').default);

// Orden de Compra
Vue.component('index-oc-component', require('./components/oc/index.vue').default);
Vue.component('create-oc-component', require('./components/oc/create.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Fire = new Vue();
window.csrf_token = $('meta[name="csrf-token"]').attr('content');
window.VRuntimeTemplate = VRuntimeTemplate;

const app = new Vue({
    el: '#app',
});
