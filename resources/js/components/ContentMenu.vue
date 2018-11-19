<template>
  <div class="column is-one-fifth has-background-white-ter">
    <aside class="menu">
      <p class="menu-label">
        メニュー
      </p>
      <ul class="menu-list">
        <li><router-link to="/register-artist">アーティスト登録</router-link></li>
        <li><router-link to="/register-song">曲登録</router-link></li>
        <li><router-link to="/artists">アーティスト一覧</router-link></li>
      </ul>
    </aside>
  </div>
</template>


<script>
  export default {
      name: "ContentMenu" ,
  }
</script>
