<template >
<div class="column">
  <div class="field">
    <label class="label">アーティスト名</label>
    <div class="control">
      <div class="select">
        <select v-model="selected">
          <option v-for="artist in artists" >{{ artist.name }}</option>
        </select>
      </div>
    </div>
  </div>

  <div class="field">
    <label class="label">曲名</label>
    <div class="control">
      <input v-model="title" class="input is-success" type="text" placeholder="例 HANABI">
    </div>
  </div>

  <div class="field is-grouped">
    <div class="control">
      <button class="button is-primary" @click.prevent="registerSong">登録</button>
    </div>
  </div>

</div>
</template>

<script>
export default {
  data: function(){
    return{
      artists: null ,
      title: "" ,
      selected : null ,
    }
  },
  created(){
    this.getArtists()
  },
  computed: {
    selectedId: function(){
      if( this.selected != null ){
        return this.artists.find( (artist) => {
          if( artist.name == this.selected ){
            return artist ;
          }
        }).id ;
      }else{
        return 0 ;
      }
    }
  } ,
  methods:{
    getArtists: function(){
      axios.get('/api/artists')
      .then( (res) => {
        this.artists = res.data.data ;
      })
    },
    registerSong: function(){
      if( this.selectedId == 0 ){
        return ;
      }

      axios.post('/api/songs' , {
        artist_id: this.selectedId ,
        title: this.title
      })
      .then( (res) => {
        this.title = ""
      })
    }
  }
}
</script>

<style lang="css">
</style>
