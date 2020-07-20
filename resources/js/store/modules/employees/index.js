import * as mutation_types from './mutation_types'
import {testEmail} from '../../../util/functions'
import employees from "../../../services/employees"

const state = {
    employees: [],
    id: null,
    name: '',
    email: '',
    errors: {}
}

const getters = {
    employees: state => state.employees,
    id: state => state.id,
    name: state => state.name,
    email: state => state.email,
    errors: state => state.errors,
}

const actions = {

    loadEmployees({commit}) {
        employees.all().then(response => {
            commit(mutation_types.SET_EMPLOYEES,response.data)
        });
    },
    inputName({commit},event) {
        commit(mutation_types.INPUT_NAME,event.target.value)
    },
    inputEmail({commit},event) {
        commit(mutation_types.INPUT_EMAIL,event.target.value)
    },
    validate({commit,state}) {
        commit(mutation_types.RESET_ERRORS)

        if(state.name == '') {
            commit(mutation_types.UPDATE_ERRORS,{index: 'name', value: 'Please fill out the name field'})
        }

        if(state.email == '') {
            commit(mutation_types.UPDATE_ERRORS,{index: 'email', value: 'Please fill out the email field'})
        }

        if(state.email != '' && !testEmail(state.email)) {
            commit(mutation_types.UPDATE_ERRORS,{index: 'email', value:'Invalid email address'})
        }

        return Object.keys(state.errors).length == 0
    },

    async submit({dispatch,state}) {
        if(!await dispatch('validate')) {
            return
        }
        
        if(state.id == null)
            dispatch('addEmployee')
        else
            dispatch('editEmployee')
    },

    addEmployee({commit,state}) {
        employees.create({
            name: state.name,
            email: state.email
        }).then(response => {
            commit(mutation_types.CLEAR_FORM)
            $('#employeesModal').modal('hide');
            commit(mutation_types.PUSH_EMPLOYEE,response.data)
        });
    },

    editEmployee({commit,state}) {
        employees.edit(state.id,{
            name: state.name,
            email: state.email
        }).then(response => {
            commit(mutation_types.CLEAR_FORM)
            $('#employeesModal').modal('hide')
            commit(mutation_types.UPDATE_EMPLOYEE,response.data)
        });
    },
    edit({commit},id) {
        employees.find(id).then(response  => {
            const employee = {
                id: response.data.id,
                name: response.data.name,
                email: response.data.email
            }
            commit(mutation_types.SET_EMPLOYEE,employee)
            $('#employeesModal').modal('show');
        })
    },
    deleteEmployee({commit},id) {
        employees.delete(id).then(response => {
            commit(mutation_types.DELETE_EMPLOYEE,id)
        })
    },
    clearForm({commit}) {
        commit(mutation_types.CLEAR_FORM)
    }
}

const mutations = {
    [mutation_types.SET_EMPLOYEES](state,employees) {
        state.employees = employees
    },
    [mutation_types.INPUT_NAME](state,value) {
        state.name = value
    },
    [mutation_types.INPUT_EMAIL](state,value) {
        state.email = value
    },
    [mutation_types.RESET_ERRORS](state) {
        state.errors = {}
    },
    [mutation_types.UPDATE_ERRORS](state,{index,value}) {
        Vue.set(state.errors,index,value)
    },
    [mutation_types.PUSH_EMPLOYEE](state,employee) {
        state.employees = [...state.employees,employee]
    },
    [mutation_types.UPDATE_EMPLOYEE](state,employee) {
        let employees = [...state.employees]
        const index = state.employees.findIndex(item => item.id == employee.id)
        employees[index] = employee
        state.employees = employees
    },
    [mutation_types.CLEAR_FORM](state) {
        state.id = null
        state.name = ''
        state.email = ''
    },
    [mutation_types.SET_EMPLOYEE](state,employee) {
        state.id = employee.id
        state.name = employee.name
        state.email = employee.email
    },
    [mutation_types.DELETE_EMPLOYEE](state,id) {
        state.employees = state.employees.filter(item => item.id != id)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}