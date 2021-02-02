import Vue from "vue";
import router from "./routes";

require('./bootstrap');


window.Vue = Vue.default;

const app = new Vue({
    el: '#app',
    router
});
