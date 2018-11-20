<template>
<div class="container">
  <div class="column">
    <div class="title">
      <router-link :to="{
        name: 'songs' ,
        params: {
          name: $route.params.artist_name ,
          id: $route.params.artist_id ,
        }
      }">
        <span class="icon is-medium has-text-success">
          <i class="fas fa-arrow-circle-left"></i>
        </span>
      </router-link>
      <span>{{ $route.params.song_name }}</span>

      <!-- <span class="icon is-medium has-text-success">
        <i class="fas fa-plus-circle"></i>
      </span> -->
      <register-song-detail-modal :song-id="$route.params.id" @registered="reload"></register-song-detail-modal>
    </div>
    <!-- <router-link :to="{
      name: 'create_songdetail',
      params:{
          id: $route.params.id ,
          song_name: $route.params.song_name ,
          artist_name: $route.params.artist_name ,
      }
    }" class="is-pulled-right">新規登録</router-link> -->

    <table class="table is-fullwidth is-hoverable is-narrow is-bordered">
      <thead>
        <tr>
          <th>登録日</th>
          <th>点数</th>
          <th>コメント</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="songdetail in songdetails">
          <th>{{ songdetail.created_at }}</th>
          <td>{{ songdetail.score }}</td>
          <td>{{ songdetail.comment }}</td>
        </tr>
      </tbody>
    </table>

  </div>
</div>
</template>

<script>
  import RegisterSongDetailModal from './RegisterSongDetailModal.vue'
  export default {
      data: function(){
        return{
          songdetails: null ,
          loading: true ,
        }
      },
      components: {
        RegisterSongDetailModal
      } ,
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
        reload: function(){
          this.getSongDetails()
        }
      }
  }
</script>
