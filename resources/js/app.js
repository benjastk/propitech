require('./bootstrap');
import Vue from 'vue';
import Draggable from 'vuedraggable';
import './assets/css/tailwind.css';
window.Vue = require('vue');

//window.csrfToken = document.querySelector('meta[name="csrf-token"]').content;

Vue.component('indexventas', require('./components/Index.vue').default);
Vue.component('user-card', require('./components/UserCard.vue').default);

const app = new Vue({
    el: '#app',
    data:{
        exampleModalShowing: false,
    },
    methods: {
    
  }
});