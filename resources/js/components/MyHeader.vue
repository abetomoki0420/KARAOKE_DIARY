<template>
  <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
          <router-link class="navbar-item" to="/">
            <p>KaraokeApp</p>
          </router-link>

          <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
          </a>
      </div>
  </nav>
</template>

<script>
  export default {
      name: "MyHeader"
  }
</script>
