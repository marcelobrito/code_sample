<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a
      class="navbar-brand"
      href="#"
    >Code Sample</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon" />
    </button>

    <div
      id="navbarSupportedContent"
      class="collapse navbar-collapse"
    >
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <router-link
            class-active="active"
            class="nav-link"
            to="/employees"
            exact
          >
            Employees
          </router-link>
        </li>
      </ul>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a
            id="navbarDropdownMenuLink"
            class="nav-link dropdown-toggle"
            href="#"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{ username }}
          </a>
        </li>
        <li class="nav-item">
          <router-link
            class="nav-link"
            to="/logout"
          >
            Logout
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
  computed: {
    ...mapGetters('login',[
      'username'
    ])
  }
}
</script>