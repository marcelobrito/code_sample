<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-6">
        <div class="card card-default">
          <div class="card-header">
            Login
          </div>
          <div class="card-body">
            <form
              autocomplete="off"
              method="post"
              @submit.prevent="login"
            >
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  id="email"
                  type="email"
                  class="form-control"
                  placeholder="user@example.com"
                  @input="inputEmail"
                >
                <small
                  v-if="errors['email']"
                  class="form-text text-danger"
                >{{ errors['email'] }}</small>
              </div>
              <div class="form-group">
                <label for="password">Senha</label>
                <input
                  id="password"
                  type="password"
                  class="form-control"
                  @input="inputPassword"
                >
                <small
                  v-if="errors['password']"
                  class="form-text text-danger"
                >{{ errors['password'] }}</small>
              </div>
              <small
                v-if="errors['response']"
                class="form-text text-danger"
              >{{ errors['response'] }}</small>
              <button
                type="submit"
                class="btn btn-primary"
              >
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import {mapGetters, mapActions} from 'vuex'

  export default {
    computed: mapGetters('login',[
      'email',
      'password',
      'errors',
    ]),
    methods: mapActions('login',[
        'inputEmail',
        'inputPassword',
        'login',
        'loadUser'
      ])
  }
  </script>
