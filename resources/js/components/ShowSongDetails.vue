<template>
<div class="container">
  <div class="column">
    <div>{{ $route.params.song_name }}</div>
    <router-link :to="{
      name: 'create_songdetail',
      params:{
          id: $route.params.id ,
          song_name: $route.params.song_name ,
          artist_name: $route.params.artist_name ,
      }
    }">新規登録</router-link>
    <ul v-for="songdetail in songdetails">
      <li>{{ songdetail.score }} {{ songdetail.comment }} {{ songdetail.created_at.date }} </li>
    </ul>
  </div>
</div>
</template>

<script>
  export default {
      data: function(){
        return{
          songdetails: null ,
          loading: true ,
        }
      },
      created(){
        this.getSongDetails();
      },
      methods : {
        getSongDetails: function(){
          axios.get('/api/songs/' + this.$route.params.id )
          .then( (res) => {
            this.songdetails = res.data.data ;
            this.loading = false ;
            console.log(res);
          });
        },
      }
  }
</script>
