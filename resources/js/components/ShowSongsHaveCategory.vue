<template>
  <div class="column">
    <div class="title">
      <router-link :to="{
         name: 'categories'}">
        <span class="icon is-medium has-text-link">
          <i class="fas fa-arrow-circle-left"></i>
        </span>
      </router-link>
      <span class="has-text-grey">
        {{ $route.params.category_name }}
      </span>
    </div>
    <div v-if="!isLoading" class="tile is-ancestor">
      <div v-for="song in songs" class="tile is-parent is-4 song">
        <router-link :to="{
          name: 'song_detail',
          params:{
            id: song.id ,
            artist_id : song.artist_id ,
            song_name: song.name ,
            artist_name: song.artist_name ,
          }
        }" class="tile is-child notification is-link box">
          <p class="title is-2">{{song.name}}</p>
          <p class="subtitle is-5">{{song.artist_name}}</p>
        </router-link>
      </div>
    </div>
    <loading-display-modal v-if="isLoading"></loading-display-modal>
  </div>
</template>

<script>
  import RegisterSongModal from './RegisterSongModal.vue'
  import LoadingDisplayModal from './LoadingDisplayModal.vue'

  export default {
      data: function(){
        return{
          songs: [] ,
          isLoading : false ,
        }
      },
      components:{
        RegisterSongModal ,
        LoadingDisplayModal ,
      } ,
      created(){
        this.getSongsHaveCategory();
      },
      methods : {
        getSongsHaveCategory: function(){
          this.isLoading = true
          axios.get('/api/categories/'+ this.$route.params.category_id + '/songs' )
          .then( (res) => {
            this.songs = res.data.data
            this.isLoading = false
          });
        },
        reload: function(){
          this.getSongsHaveCategory()
        },
      }
  }
</script>

<style media="screen">
.song{
  position: relative;
}
</style>
