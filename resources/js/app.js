import './bootstrap';

import AppComponent from './App.vue';
Vue.component('app', AppComponent);

import routes from './routes';
const router = new VueRouter({
    routes
})

const app = new Vue({
    el: '#app',
    router
});

bridge.send("VKWebAppInit", {});
