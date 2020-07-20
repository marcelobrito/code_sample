<template>
  <page>  
    <div class="row">
      <div class="col-sm-10 col-12">
        <h3 id="quote">
          Employees
        </h3>
      </div>
      <div class="col-sm-2 col-12">
        <a
          class="btn pull-right"
          @click="openModal"
        ><span class="text-info">Create Employee</span></a>
      </div>
    </div>

    <ul class="list-group">
      <li
        v-for="employee in employees"
        :key="employee.id"
        class="list-group-item"
      >
        <div class="float-left">
          <font-awesome-icon icon="user" /> {{ employee.name }} <font-awesome-icon icon="envelope" /> {{ employee.email }}
        </div>
        <div class="clearfix" />
        <button
          class="btn btn-danger float-right btn-sm"
          @click="deleteEmployee(employee.id)"
        >
          <font-awesome-icon icon="trash-alt" />
        </button>
        <button
          class="btn btn-primary float-right btn-sm"
          @click="edit(employee.id)"
        >
          <font-awesome-icon icon="pencil-alt" />
        </button>
      </li>
    </ul>

    <employees-modal />
  </page>
</template>
<script>
import Page from '../components/Page'
import EmployeesModal from '../components/EmployeesModal'
import { mapGetters, mapActions} from 'vuex'

export default {
    components: {
        Page,
        EmployeesModal
    },
    computed: {
        ...mapGetters('employees',['employees']),
    },
    async created() {
        this.loadEmployees();
    },
    methods: {

        ...mapActions('employees',[
            'loadEmployees',
            'edit',
            'clearForm',
            'deleteEmployee'
        ]),
        openModal: function ()
        {
            this.clearForm();
            $('#employeesModal').modal('show');
        }
    }
}
</script>
<style scoped>
    .btn {
        margin: 5px;
    }
</style>