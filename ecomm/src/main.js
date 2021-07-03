import Vue from 'vue'
import BootstrapVue from "bootstrap-vue"
import App from './App.vue'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-vue/dist/bootstrap-vue.css"
import AxiosPlugin from 'vue-axios-cors';
import VueRouter from 'vue-router'
import {routes} from './router/routes'

import Vuex from "vuex";
 
Vue.use(Vuex);
Vue.use(AxiosPlugin)
Vue.use(BootstrapVue)
/* Routers */
Vue.use(VueRouter)
const router = new VueRouter({
  routes,
  mode: 'history'
})
Vue.config.productionTip = false

const store = new Vuex.Store({
  state: {
    cartNum: 0,
    isLoggedIn: false,
  },
  getters: {
    getCartCount (state) {
      return state.cartNum
    }
  },
  mutations: {},
  actions: {}
})

new Vue({
  render: h => h(App),
  router: router,
  store: store
}).$mount('#app')
