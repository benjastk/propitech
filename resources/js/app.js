require('./bootstrap');
import Vue from 'vue';
import moment from 'moment';
import Draggable from 'vuedraggable';
import './assets/css/tailwind.css';
window.Vue = require('vue');

//window.csrfToken = document.querySelector('meta[name="csrf-token"]').content;

Vue.component('indexventas', require('./components/Index.vue').default);
Vue.component('user-card', require('./components/UserCard.vue').default);

Vue.filter('formatDate', function(value) {
  if (value) {
      return moment(String(value)).format('MM/DD/YYYY');
  }
});

Vue.filter('miles', function(value) {
  if (value) {
      return new Intl.NumberFormat('es-CL').format(value);
  }
});

const app = new Vue({
    el: '#app',
    data:{
        exampleModalShowing: false,
    },
    methods: {
    
  }
});