<template>
  <div class="column">
    <div class="title">
      <router-link :to="{
         name: 'main'}">
        <span class="icon is-medium has-text-success">
          <i class="fas fa-arrow-circle-left"></i>
        </span>
      </router-link>
      <span>{{ $route.params.name }}</span>
      <!-- <span class="icon is-medium has-text-success">
        <i class="fas fa-plus-circle"></i>
      </span> -->
      <register-song-modal :artist-id="$route.params.id" @registered="reload"></register-song-modal>
    </div>

    <div v-if="!loading" class="tile is-ancestor">
      <div v-for="song in songs" class="tile is-parent is-4">
        <router-link :to="{
          name: 'song_detail',
          params:{
            id: song.id ,
            artist_id : $route.params.id ,
            song_name: song.name ,
            artist_name: $route.params.name ,
          }
        }" class="tile is-child box">
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
            console.log(res);
          });
        },
        reload: function(){
          this.getSongs()
        },
      }
  }
</script>
