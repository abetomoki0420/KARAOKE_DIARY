<template>
<div class="column" >
  <div class="title">
    <router-link :to="{
       name: 'main'}">
      <span class="icon is-medium has-text-link">
        <i class="fas fa-arrow-circle-left"></i>
      </span>
    </router-link>
    <span class="title has-text-grey">タグ一覧</span>
  </div>
  <div class="field is-grouped is-grouped-multiline">
    <div class="control" v-for="category in categories">
      <router-link :to="{
        name: 'categories_songs' ,
        params:{
          category_id: category.id ,
          category_name: category.name ,
        }
        }" class="tags has-addons">
        <span class="tag is-link ">{{ category.name }}</span>
        <span class="tag ">{{ category.count }}</span>
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
          categories: null ,
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
          if(this.isLoading){
            return
          }
          this.isLoading = true
          axios.get('/api/users/' + this.user.uid  + '/categories/' )
          .then( (res) => {
            this.categories = this.categoryCount(res.data.data)
            this.isLoading = false
          });
        },
        reload: function(){
          this.getCategories()
        },
        categoryCount: function(categoryDatas){
          let cats = [];
          categoryDatas.forEach( (category) => {
            const id = +category.id
            const name = category.name
            const idx = cats.map( cat => {
              return cat.name
            }).indexOf( name )

            if(cats[idx]){
              cats[idx].count += 1
            }else{
              cats.push({
                count: 1 ,
                id: id ,
                name: name ,
              })
            }
          });

          cats.sort()
          return cats
        }
      },
  }
</script>

<style scoped>

</style>
