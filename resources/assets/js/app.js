
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

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('voucher', require('./components/voucher.vue'));
Vue.component('generate-voucher', require('./components/modals/generate-voucher.vue'));
Vue.component('assign-user', require('./components/modals/assign-user.vue'));

const app = new Vue({
    el: '#app'
});
