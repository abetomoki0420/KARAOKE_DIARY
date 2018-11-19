<template>
<div class="container">
  <div class="column">
    <div >{{ $route.params.name }} </div>
    <ul v-if="!loading" v-for="song in songs">
      <li>
        <router-link :to="{
            name: 'song_detail',
            params:{
              id: song.id ,
              song_name: song.name ,
              artist_name: $route.params.name ,
            }
          }">{{song.name}}</router-link>
      </li>
    </ul>
    <div v-if="loading">
      Now Loading...
    </div>

  </div>
</div>
</template>

<script>
  export default {
      data: function(){
        return{
          songs: null ,
          loading: true ,
        }
      },
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
      }
  }
</script>
