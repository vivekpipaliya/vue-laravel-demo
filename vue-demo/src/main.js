import Vue from 'vue'
import App from './App.vue'
import { BootstrapVue, IconsPlugin, BVToastPlugin } from 'bootstrap-vue'
import Vuelidate from 'vuelidate'
import VueRouter from 'vue-router'

Vue.use(Vuelidate)

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(BVToastPlugin)
Vue.use(VueRouter)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
