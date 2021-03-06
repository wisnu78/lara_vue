import Vue from 'vue';
import Vuetify from 'vuetify'
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';
import App from './App.vue';
import BootstrapVue from 'bootstrap-vue'
import router from './router'
import VueSelect from 'vue-select';

import Dashboard from './components/Dashboard.vue';
import Home from './components/Home.vue';
import Register from './components/Register.vue';
import Login from './components/Login.vue';
Vue.use(VueSelect);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);
Vue.use(Vuetify)
// axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.baseURL = 'http://localhost/laravel/lara_vue/public/index.php/api';
/*
const router = new VueRouter({
    routes: [{
        path: '/',
        name: 'home',
        component: Home
    },{
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },{
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },{
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            auth: true
        }
    }]
});
*/
Vue.router = router
Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});
App.router = Vue.router
new Vue(App).$mount('#app');