<template>
<div class="column" >
  <div class="title">
    <router-link :to="{
       name: 'main'}">
      <span class="icon is-medium has-text-primary">
        <i class="fas fa-arrow-circle-left"></i>
      </span>
    </router-link>
    <span class="title has-text-grey">ジャンル一覧</span>
  </div>

  <div class="field is-grouped is-grouped-multiline">
    <div class="control" v-for="category in categories">
      <router-link to="#" class="tags has-addons">
        <span class="tag is-link ">{{ category.name }}</span>
        <span class="tag "></span>
      </router-link>
    </div>
  </div>

  <loading-display-modal v-if="isLoading"></loading-display-modal>
</div>
</template>

<script>
  import LoadingDisplayModal from './LoadingDisplayModal.vue'

  export default {
      data: function(){
        return{
          categories: [] ,
          user : null ,
          isLoading: false ,
        }
      },
      components:{
        LoadingDisplayModal ,
      } ,
      created(){
        firebase.auth().onAuthStateChanged( user => {
          this.user = user ? user : null ;
          if(this.user){
            this.getCategories()
          }else{
            this.categories = null
          }
        })
      },
      methods : {
        getCategories: function(){
          console.log("ggg")
          this.isLoading = true
          axios.get('/api/users/' + this.user.uid  + '/categories/' )
          .then( (res) => {
            console.log(res)
            this.categories = res.data.data ;
            this.isLoading = false
          });
        },
        reload: function(){
          this.getCategories()
        },
      }
  }
</script>

<style scoped>

</style>
