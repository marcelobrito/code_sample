import Vue from 'vue'
import Vuex from 'vuex'

import login from './modules/login/index'
import employees from './modules/employees/index'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        login,
        employees
    }
})