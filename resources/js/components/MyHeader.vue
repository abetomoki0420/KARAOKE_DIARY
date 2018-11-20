<template>
<div>
  <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
          <router-link class="navbar-item" to="/">
            <p>KaraokeApp</p>
          </router-link>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
            </a>
            <div class="navbar-dropdown">
              <router-link
                to="/register-artist"
                class="navbar-item">アーティスト登録</router-link>
              <router-link
                to="/register-song"
                class="navbar-item">曲登録</router-link>
            </div>
          </div>
          <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
          </a>
      </div>
  </nav>
</div>
</template>

<script>
  export default {
      name: "MyHeader"
  }
</script>
