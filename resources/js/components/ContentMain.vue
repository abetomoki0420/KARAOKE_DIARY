<template>
<div class="column" >
  <div class="title" v-if="isLogin">
    <span class="title has-text-grey">アーティスト一覧</span>
    <register-artist-modal @registered="reload"></register-artist-modal>
  </div>
  <div v-if="!isLogin">
    <span>ログインして下さい</span>
  </div>
  <div class="tile is-ancestor">
    <div v-for="artist in artists" class="tile is-parent is-4 artist">
      <button class="delete dltbtn" v-on:click="deleteArtist(artist)"></button>
      <router-link :to="{
        name: 'songs',
        params: {
          id: artist.id ,
          name: artist.name ,
          }
      }" class="tile is-child notification is-primary box">
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
          user : null ,
          isLogin: false ,
        }
      },
      components:{
        RegisterArtistModal ,
      } ,
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
          axios.get('/api/users/' + this.user.uid )
          .then( (res) => {
            this.artists = res.data.data ;
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
