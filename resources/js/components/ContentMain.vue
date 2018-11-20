<template>
  <div class="column">
    <div class="title">
      <span>アーティスト一覧</span>
      <register-artist-modal @registered="reload"></register-artist-modal>
    </div>
    <div class="tile is-ancestor">
      <div v-for="artist in artists" class="tile is-parent is-4">
        <router-link :to="{
          name: 'songs',
          params: {
            id: artist.id ,
            name: artist.name ,
            }
        }" class="tile is-child box">
          <p class="title">{{ artist.name }}</p>
        </router-link>
      </div>
    </div>
  </div>
</template>


<script>
  import RegisterArtistModal from './RegisterArtistModal.vue';

  export default {
      name: "ContentMain" ,
      data: function(){
        return{
          artists: null ,
        }
      },
      components:{
        RegisterArtistModal ,
      } ,
      created(){
        this.getArtists();
      },
      methods : {
        getArtists: function(){
          axios.get('/api/artists')
          .then( (res) => {
            console.log(res.data);
            this.artists = res.data.data ;
          });
        },
        reload: function(){
          this.getArtists() 
        }
      }
  }
</script>

<style>
.columns{
  margin-top: 1em;
}

.tile.is-ancestor{
  flex-wrap: wrap;
}
</style>
