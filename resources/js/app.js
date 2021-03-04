import Vue from "vue";
import router from "./routes";
import VueQrcode from '@chenfengyuan/vue-qrcode';

require('./bootstrap');

Vue.component(VueQrcode.name, VueQrcode);

window.Vue = Vue.default;

const app = new Vue({
    el: '#app',
    router
});


