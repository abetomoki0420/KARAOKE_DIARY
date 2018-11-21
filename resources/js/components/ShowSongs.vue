<template>
  <div class="column">
    <div class="title">
      <router-link :to="{
         name: 'main'}">
        <span class="icon is-medium has-text-primary">
          <i class="fas fa-arrow-circle-left"></i>
        </span>
      </router-link>
      <span class="has-text-grey">{{ $route.params.name }}</span>
      <register-song-modal :artist-id="+$route.params.id" @registered="reload"></register-song-modal>
    </div>
    <div v-if="!loading" class="tile is-ancestor">
      <div v-for="song in songs" class="tile is-parent is-4 song">
        <button class="delete dltbtn" @click="deleteSong(song)"></button>
        <router-link :to="{
          name: 'song_detail',
          params:{
            id: song.id ,
            artist_id : $route.params.id ,
            song_name: song.name ,
            artist_name: $route.params.name ,
          }
        }" class="tile is-child notification is-primary box">
          <p class="title">{{song.name}}</p>
        </router-link>
      </div>
    </div>
    <div v-if="loading">
      Now Loading...
    </div>
  </div>
</template>

<script>
  import RegisterSongModal from './RegisterSongModal.vue'
  export default {
      data: function(){
        return{
          songs: null ,
          loading: true ,
        }
      },
      components:{
        RegisterSongModal ,
      } ,
      created(){
        this.getSongs();
      },
      methods : {
        getSongs: function(){
          axios.get('/api/artists/'+ this.$route.params.id )
          .then( (res) => {
            this.songs = res.data.data ;
            this.loading = false ;
          });
        },
        reload: function(){
          this.getSongs()
        },
        deleteSong: function(song){
          if( !confirm( song.name + ' を削除しますか？' ) ){
            return
          }

          axios.delete('/api/songs/' + song.id )
          .then( (res) => {
            this.reload()
          });
        }
      }
  }
</script>

<style media="screen">
.song{
  position: relative;
}
</style>
