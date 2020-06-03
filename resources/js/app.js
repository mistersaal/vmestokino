import './bootstrap';

import AppComponent from './App.vue';
Vue.component('app', AppComponent);

import store from "./store";

import routes from './routes';
const router = new VueRouter({
    routes
})
router.afterEach((to, from, next) => {
    if (store.state.historyIsEmpty && to.path !== from.path) {
        store.commit('historyPushed');
    }
})

const app = new Vue({
    el: '#app',
    router,
    store
});
