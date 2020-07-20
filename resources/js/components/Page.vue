<template>
  <div>
    <nav-bar />
    <div class="container">
      <slot />
    </div>
  </div>
</template>
<script>
import NavBar from './NavBar'

export default {
    components: {
        NavBar
    }
}
</script>