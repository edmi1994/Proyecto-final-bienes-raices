/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import {ValidationObserver, ValidationProvider, extend, localize} from "vee-validate";
import es from "vee-validate/dist/locale/es.json";
import * as rules from "vee-validate/dist/rules";
require('./bootstrap');

window.Vue = require('vue');

Vue.use(BootstrapVue)
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

localize("es", es);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component("ValidationObserver", ValidationObserver);
Vue.component("ValidationProvider", ValidationProvider);
Vue.component('menu-component', require('./components/MenuComponent.vue').default);
Vue.component('home-component', require('./components/HomeComponent.vue').default);

//Vue.component('propiedades-page', require('./pages/propiedades/CategoriasPage.vue').default);
Vue.component('propiedades-create-page', require('./pages/propiedades/PropiedadesCreatePage.vue').default);
Vue.component('propiedades-edit-page', require('./pages/propiedades/PropiedadesEditPage.vue').default);
Vue.component('propiedades-page', require('./pages/propiedades/PropiedadesPage.vue').default);


Vue.component('clientes-create-page', require('./pages/clientes/ClientesCreatePage.vue').default);
Vue.component('clientes-edit-page', require('./pages/clientes/ClientesEditPage.vue').default);
Vue.component('clientes-page', require('./pages/clientes/ClientesPage.vue').default);

Vue.component('ventas-create-page', require('./pages/ventas/VentasCreatePage.vue').default);
Vue.component('ventas-page', require('./pages/ventas/VentasPage.vue').default);

Vue.component('reservas-create-page', require('./pages/reservas/ReservasCreatePage.vue').default);
Vue.component('reservas-page', require('./pages/reservas/ReservasPage.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 
const app = new Vue({
    el: '#app',
});
