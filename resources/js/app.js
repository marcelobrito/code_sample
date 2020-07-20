import './bootstrap'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUser,faEnvelope,faPencilAlt,faStepForward,faList,faTrashAlt} from '@fortawesome/free-solid-svg-icons'
import { faLinkedinIn, faGitlab } from '@fortawesome/free-brands-svg-icons'
import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './router'
import store from './store'
import Index from './views/Index'
import { mapActions } from 'vuex'

const routerPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
  return routerPush.call(this, location).catch(error=> error)
}


library.add(faUser)
library.add(faEnvelope)
library.add(faPencilAlt)
library.add(faTrashAlt)

window.Vue = Vue
Vue.router = router

Vue.use(VueRouter)

Vue.config.productionTip = false
Vue.config.devtools = false

Vue.component('Index', Index)
Vue.component('FontAwesomeIcon', FontAwesomeIcon)

export const app = new Vue({
  el: '#app',
  router,
  store,
  computed: {
    token() {
      return window.localStorage.getItem('token')
    }
  },
  created() {
    if(this.token)
      this.loadUser()
  },
  methods: mapActions('login',['loadUser'])
});