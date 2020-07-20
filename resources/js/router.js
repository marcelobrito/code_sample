import VueRouter from 'vue-router'
// Pages
import Login from './views/Login'
import Home from './views/Home'
import Employees from './views/Employees'
import Logout from './views/Logout'

// Routes
const routes = [
  {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: true
        }
  },
  {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
  },
  {
    path: '/employees',
    name: 'employees',
    component: Employees,
    meta: {
        auth: true
    }
  },
  {
    path: '/logout',
    name: 'logout',
    component: Logout,
    meta: {
        auth: true
    }
  }
]

const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.auth)){
        if(window.localStorage.getItem('token') == null) { 
            next('/login')
        } else {    
            next()
        }
    } else {
        next()
    }
});

export default router