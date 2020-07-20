<template>
  <div
    id="employeesModal"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div
      class="modal-dialog"
      role="document"
    >
      <div class="modal-content">
        <div class="modal-header">
          <h5
            id="label"
            class="modal-title"
          >
            Employees
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Name</label>
            <input
              id="name"
              class="form-control"
              type="text"
              name="name"
              :value="name"
              @input="inputName"
            >
            <small
              v-if="errors['name']"
              class="form-text text-danger"
            >{{ errors['name'] }}</small>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input
              id="email"
              class="form-control"
              type="email"
              name="email"
              :value="email"
              @input="inputEmail"
            >
            <small
              v-if="errors['email']"
              class="form-text text-danger"
            >{{ errors['email'] }}</small>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
            @click="clearForm"
          >
            Close
          </button>
          <button
            type="button"
            class="btn btn-primary"
            @click="submit"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    computed: mapGetters('employees',[
        'id',
        'name',
        'email',
        'errors'
    ]),
    methods: {
        ...mapActions('employees',[
            'clearForm',
            'inputName',
            'inputEmail',
            'submit',
        ])
    }
    
}
</script>