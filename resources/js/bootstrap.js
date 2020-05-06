import _ from 'lodash';
window._ = _;

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-Vk-Auth-Url'] = window.location.href;

import Vue from 'vue';
window.Vue = Vue;
import VueRouter from 'vue-router'
window.VueRouter = VueRouter;
Vue.use(VueRouter)

import Echo from "laravel-echo"

import io from 'socket.io-client';
window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    auth: {
        headers: {
            'X-Vk-Auth-Url': window.location.href
        }
    }
});

import Buefy from 'buefy'
import 'buefy/dist/buefy.css'
Vue.use(Buefy)

import bridge from '@vkontakte/vk-bridge';
window.bridge = bridge;
