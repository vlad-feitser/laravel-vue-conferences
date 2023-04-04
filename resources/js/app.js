import Vue from 'vue';
import vuetify from './plugins/vuetify';
import router from './router/router';
import store from './store'
import * as VueGoogleMaps from 'vue2-google-maps'
import VueEditor from "vue2-editor"
require('./bootstrap');

window.Vue = require('vue').default;
Vue.component('app', require('./App.vue').default);
Vue.component('my-button', require('./components/UI/MyButton.vue').default)
Vue.component('my-dialog', require('./components/UI/MyDialog.vue').default)
Vue.component('pagination', require('laravel-vue-pagination'))

Vue.use(require('vue-moment'))

Vue.use(VueEditor)

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyC57K7fvbKE1ik3HzrDBINpC0M4SlIzIhw'
    }
})

const app = new Vue({
    store: store,
    vuetify: vuetify,
    router: router,
    el: '#app',
});
