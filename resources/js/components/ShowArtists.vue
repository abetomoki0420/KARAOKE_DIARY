<template>
<div class="container">
  <div class="column">
    <ul v-if="!loading" v-for="artist in artists">
      <li>
        <router-link :to="{
          name: 'songs',
          params: {
            id: artist.id ,
            name: artist.name ,
            }
          }">{{artist.name}}</router-link>
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
          artists: null ,
          loading: true ,
        }
      },
      created(){
        this.getArtists();
        this.initialLoading();
      },
      methods : {
        getArtists: function(){
          axios.get('/api/artists')
          .then( (res) => {
            this.artists = res.data.data ;
            this.loading = false ;
          });
        },
        initialLoading: function(){
          this.loading = true ;
        }
      }
  }
</script>
