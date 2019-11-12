require('./bootstrap');

window.Vue = require('vue');
 
//import CSS of Vuetify
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';

import AdminApp from './admin/app.vue';
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
import { adminRoutes } from './admin/routes/adminRoute.js';
import { adminStore } from './admin/store/adminStore.js';

const path = window.location.pathname;
if (path.includes("admin")) {

    Vue.use(Vuetify)
    Vue.use(VueRouter)

    const adminRouter = new VueRouter({
        mode: 'history',
        base: '/admin',
        routes: adminRoutes,
    });

    const app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        render: h => h(AdminApp),
        router: adminRouter,
    });

}