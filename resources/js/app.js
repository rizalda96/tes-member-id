require('./bootstrap');
import axios from 'axios'
import Vue from 'vue'

import BootstrapVue from 'bootstrap-vue'

window._token = document.head.querySelector('meta[name="csrf-token"]').content


import App from './MainApp'
import VueRouter from 'vue-router'
import Container from './Container'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import Multiselect from 'vue-multiselect'


import Login from './components/Login.vue'
import AwardList from './components/AwardList.vue'


Vue.use(BootstrapVue)
Vue.use(VueRouter)


Vue.component('multiselect', Multiselect)


export const createApp = () => {
  Vue.prototype.$app = window.settings
  Vue.prototype.$http = axios
  Vue.prototype.$app.route = window.route

  const routes = [
    {
      path: '/',
      component: Container,
      children: [
        {
          path: '/',
          name: 'login',
          component: Login,
        },
        {
          path: '/awards',
          name: 'award-list',
          component: AwardList,
        },
      ],
    },
  ]

  const router = new VueRouter({
    mode: 'history',
    base: '',
    scrollBehavior: () => ({ y: 0, x: 0 }),
    routes
  })

  const app = new Vue({
    router,
    render: h => h(App)
  })

  return {
    app,
    router
  }
}

if (document.getElementById('app')) {
  const { app } = createApp()
  app.$mount('#app')
}
