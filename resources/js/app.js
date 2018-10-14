
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import 'babel-polyfill'
window.Vue = require('vue');

import Lightbox from 'vue-pure-lightbox'
Vue.use(Lightbox)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('file-upload-button', require('./components/FileUploadButton.vue'));
Vue.component('file-upload-component', require('./components/FileUploadComponent.vue'));
Vue.component('gallery-index', require('./components/GalleryIndex.vue'));

const app = new Vue({
    el: '#app'
});
