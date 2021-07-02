import Vue from 'vue'
import BootstrapVue from "bootstrap-vue"
import App from './App.vue'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-vue/dist/bootstrap-vue.css"
import AxiosPlugin from 'vue-axios-cors';
import VueRouter from 'vue-router'
import {routes} from './router/routes'

Vue.use(AxiosPlugin)
Vue.use(BootstrapVue)
/* Routers */
Vue.use(VueRouter)
const router = new VueRouter({
  routes,
  mode: 'history'
})
Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router: router
}).$mount('#app')
