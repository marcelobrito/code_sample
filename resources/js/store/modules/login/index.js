import http from '../../../util/http'
import * as mutation_types from './mutation_types'
import router from '../../../router'

const state = {
    email: '',
    password: '',
    user: {},
    errors: {}
}

const getters = {
    email: state => state.email,
    password: state => state.password,
    errors: state => state.errors,
    username: state => state.user.name,
}

const actions = {
    inputEmail({commit},event) {
        commit(mutation_types.INPUT_EMAIL,event.target.value)
    },
    inputPassword({commit},event) {
        commit(mutation_types.INPUT_PASSWORD,event.target.value)
    },
    async login({dispatch,state,commit}) {

        if(!await dispatch('validate'))
            return

        const user = {
                email: state.email,
                password: state.password
        }
        http.post('login',user)
        .then((response) => {
            window.localStorage.setItem('token',response.data.access_token)
            commit(mutation_types.UPDATE_TOKEN,response.data.access_token)
            dispatch('loadUser')
            router.push('/')
          
          }).catch(function(response) {
            commit(mutation_types.UPDATE_ERRORS,{index:'response',value:'Invalid credentials'})
          });
      },
      loadUser({commit}) {
        http.get('user')
        .then((response) => {
            commit(mutation_types.SET_USER_DATA,response.data)
        })
      },
      validate({commit,state}) {

        commit(mutation_types.RESET_ERRORS)

        if(state.email == '') {
            commit(mutation_types.UPDATE_ERRORS,{index: 'email', value: 'Please fill out the email field'})
        }

        if(state.password == '') {
            commit(mutation_types.UPDATE_ERRORS,{index: 'password',value: 'Please fill out the password field'})
        }
        
        if(state.password.length && state.password.length < 6) {
            commit(mutation_types.UPDATE_ERRORS,{index: 'password',value: 'The password field should have at least 6 characters'})
        }

        return Object.keys(state.errors).length == 0;
      }
}

const mutations = {
    [mutation_types.INPUT_EMAIL](state,value) {
        state.email = value
    },
    [mutation_types.INPUT_PASSWORD](state,value) {
        state.password = value
    },
    [mutation_types.UPDATE_TOKEN](state,token) {
        state.token = token
    },
    [mutation_types.SET_USER_DATA](state,user) {
        state.user = user
    },
    [mutation_types.UPDATE_ERRORS](state,{index, value}) {
        Vue.set(state.errors,index,value)
    },
    [mutation_types.RESET_ERRORS](state) {
        state.errors = {}
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}