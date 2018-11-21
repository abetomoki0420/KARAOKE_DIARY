<template>
  <div class="column">
    <div class="title">
      <router-link :to="{
        name: 'songs' ,
        params: {
          name: $route.params.artist_name ,
          id: $route.params.artist_id ,
        }
      }">
        <span class="icon is-medium has-text-primary">
          <i class="fas fa-arrow-circle-left"></i>
        </span>
      </router-link>
      <span class="has-text-grey">{{ $route.params.song_name }}</span>
      <register-song-detail-modal :song-id="+$route.params.id" @registered="reload"></register-song-detail-modal>
    </div>
    タグ ｶﾜｲｲ　カッコいい　好き
    <table class="table is-fullwidth is-hoverable is-narrow is-bordered details">
      <thead>
        <tr>
          <th>登録日</th>
          <th>点数</th>
          <th>コメント</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="songdetail in songdetails" @click="editDetail(songdetail)">
          <th>{{ songdetail.created_at }}</th>
          <td>{{ songdetail.score }}</td>
          <td>{{ songdetail.comment }}</td>
          <edit-song-detail-modal v-if="songdetail.edit" @edited="reload" @deleted="reload"
            :songDetailId="songdetail.id"
            :oldScore="songdetail.score"
            :oldComment="songdetail.comment"
            ></edit-song-detail-modal>
        </tr>
      </tbody>
    </table>
</div>
</template>

<script>
  import RegisterSongDetailModal from './RegisterSongDetailModal.vue'
  import EditSongDetailModal from './EditSongDetailModal.vue'
  export default {
      data: function(){
        return{
          songdetails: null ,
          loading: true ,
        }
      },
      components: {
        RegisterSongDetailModal ,
        EditSongDetailModal ,
      } ,
      created(){
        this.getSongDetails();
      },
      methods : {
        editDetail: function(songdetail){
          songdetail.edit = true
        },
        getSongDetails: function(){
          axios.get('/api/songs/' + this.$route.params.id )
          .then( (res) => {
            this.songdetails = res.data.data ;
            this.loading = false ;
          });
        },
        reload: function(){
          this.getSongDetails()
        }
      }
  }
</script>

<style media="screen">
  tbody tr{
    cursor: pointer ;
  }
</style>
