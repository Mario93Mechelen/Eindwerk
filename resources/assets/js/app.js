
/**
 * First we will load all of this project's JavaScript dependencies which
 * partials Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.VueLogin = require('vue');

window.VueRouter = require('vue-router');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

VueLogin.component('login', require('./views/login.vue'));

const app = new VueLogin({
    el: '#login'
});
