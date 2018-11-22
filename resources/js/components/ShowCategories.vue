<template>
<div class="column" >
  <div class="title" v-if="isLogin">
    <span class="title has-text-grey">ジャンル一覧</span>
  </div>
  <div class="tile is-ancestor">
    <div v-for="artist in artists" class="tile is-parent is-4 artist">
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
          artists: [] ,
          user : null ,
          isLogin: false ,
          isLoading: false ,
        }
      },
      components:{
        RegisterArtistModal ,
        LoadingDisplayModal ,
      } ,
      computed:{
        artists_count: function(){
          if(this.artists){
            return this.artists.length ;
          }else{
            return 0 ;
          }
        }
      },
      created(){
        firebase.auth().onAuthStateChanged( user => {
          this.user = user ? user : null ;
          if(this.user){
            this.isLogin = true
            this.getArtists();
          }else{
            this.isLogin = false
            this.artists = null
          }
        })
      },
      methods : {
        getArtists: function(){
          this.isLoading = true
          axios.get('/api/users/' + this.user.uid )
          .then( (res) => {
            this.artists = res.data.data ;
            this.isLoading = false
          });
        },
        reload: function(){
          this.getArtists()
        },
        deleteArtist: function( artist){
          if( !confirm( artist.name +' を削除しますか？') ){
            return
          }
          axios.delete('/api/artists/'+ artist.id)
          .then( (res) => {
              this.reload()
          });

        }
      }
  }
</script>

<style scoped>
.tile.is-ancestor{
  flex-wrap: wrap;
}

.artist{
  position: relative;
}
</style>
