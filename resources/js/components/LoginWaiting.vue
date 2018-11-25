<template>
  <div class="column">
    <loading-display-modal></loading-display-modal>
  </div>
</template>

<script>
  import LoadingDisplayModal from './LoadingDisplayModal.vue'

  export default {
      data: function(){
        return{
          user : null ,
        }
      },
      components:{
        LoadingDisplayModal ,
      },
      created(){
        firebase.auth().onAuthStateChanged( user => {
          this.user = user ? user : null ;
          if(this.user){
            this.$router.push({name:'main'})
          }else{
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
