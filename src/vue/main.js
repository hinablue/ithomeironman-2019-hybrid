import Vue from 'vue'
import router from '@/router'
import store from '@/store'
import App from '@/App.vue'

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  store,
  router,
  render: h => h(App)
}).$mount('#app', true)
