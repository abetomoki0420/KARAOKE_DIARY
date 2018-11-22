<template>
  <div class="column" >
    <div class="tile is-ancestor">
      <div class="tile is-parent is-6">
        <router-link :to="{
          name: 'artists' ,
        }" class="tile is-child notification is-primary box">
          <p class="title">アーティスト</p>
        </router-link>
      </div>
      <div class="tile is-parent is-6">
        <router-link :to="{
          name: 'categories' ,
        }" class="tile is-child notification is-primary box">
        <p class="title">ジャンル</p>
      </router-link>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
      name: "ContentMain" ,
      data: function(){
        return{
          user : null ,
          isLogin: false ,
        }
      },
      created(){
        firebase.auth().onAuthStateChanged( user => {
          this.user = user ? user : null ;
          if(this.user){
            this.isLogin = true
          }else{
            this.isLogin = false
          }
        })
      },
      methods : {
      }
  }
</script>

<style scoped>
.tile.is-ancestor{
  flex-wrap: wrap;
}
</style>
