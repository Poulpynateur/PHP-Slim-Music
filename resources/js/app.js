import Vue from 'vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Notifications from 'vue-notification';
import VueAuth from '@websanova/vue-auth';

import auth from './auth';
import router from './router';
import store from './store';

import App from "./views/App";

window.Vue = Vue;
window._ = require('lodash');
window.axios = require('axios');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;

Vue.router = router;
Vue.use(VueRouter);
Vue.use(Notifications);
Vue.use(VueAxios, axios);

Vue.use(VueAuth, auth);

const app = new Vue({
    el: '#app',
    router,
    data: store,
    components: {
        App
    }
});
