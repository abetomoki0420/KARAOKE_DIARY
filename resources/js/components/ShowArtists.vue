<template>
<div class="column" >
  <nav class="level">
    <div class="level-left">
      <div class="level-item title" v-if="isLogin">
        <router-link :to="{
          name: 'main'}">
          <span class="icon is-medium has-text-primary">
            <i class="fas fa-arrow-circle-left"></i>
          </span>
        </router-link>
        <span class="title has-text-grey">アーティスト一覧</span>
        <register-artist-modal @registered="reload"></register-artist-modal>
      </div>
    </div>
    <div class="level level-right is-mobile">
      <div class="level-right">
        <div class="level-item" @click="sortArtistsByAlpha">
          <span v-if="isSortAlphaDown" :class="{'icon is-medium has-text-primary': isSortTypeByAlpha , 'icon is-medium has-text-grey': !isSortTypeByAlpha}">
            <i class="fas fa-sort-alpha-down"></i>
          </span>
          <span v-if="!isSortAlphaDown" :class="{'icon is-medium has-text-primary': isSortTypeByAlpha , 'icon is-medium has-text-grey': !isSortTypeByAlpha}">
            <i class="fas fa-sort-alpha-up"></i>
          </span>
        </div>
        <div class="level-item" @click="sortArtistsByDate">
          <span v-if="!isSortDateDown" :class="{'icon is-medium has-text-primary': isSortTypeByDate , 'icon is-medium has-text-grey': !isSortTypeByDate}">
            <i class="fas fa-sort-amount-down"></i>
          </span>
          <span v-if="isSortDateDown" :class="{'icon is-medium has-text-primary': isSortTypeByDate , 'icon is-medium has-text-grey': !isSortTypeByDate}">
            <i class="fas fa-sort-amount-up"></i>
          </span>
        </div>
      </div>
    </div>
  </nav>
  <div v-if="!isLogin">
    <span>ログインして下さい</span>
  </div>
  <div class="tile is-ancestor">
    <!-- Aritsts List -->
    <div v-for="artist in dividedArtists" class="tile is-parent is-4 artist">
      <button class="delete dltbtn" v-on:click="deleteArtist(artist)"></button>
      <router-link :to="{
        name: 'songs',
        params: {
          id: artist.id ,
          name: artist.name ,
          }
      }" class="tile is-child notification is-primary box">
        <p class="title is-3">{{ artist.name }}</p>
        <p class="subtitle is-5">登録曲数: {{ artist.songs_count }}</p>
      </router-link>
    </div>
    <!-- Aritsts List End -->
  </div>
  <nav v-if="artists.length > 0" class="pagination" role="navigation" aria-label="pagination">
    <ul class="pagination-list">
      <li>
        <a :class="{
          'pagination-link is-current': 1 === currentPage ,
          'pagination-link': 1 !== currentPage}"
           @click="setDividedArtists(1)">1</a>
      </li>
      <li v-if="isDispLeftEllipsis()">
        <span class="pagination-ellipsis">&hellip;</span>
      </li>
      <li v-if="isDispCenterSide(pageNum)" v-for="pageNum in totalNumberOfPages">
        <a :class="{
          'pagination-link is-current': pageNum === currentPage ,
          'pagination-link': pageNum !== currentPage}"
          @click="setDividedArtists(pageNum)"
          >
          {{pageNum}}
        </a>
      </li>
      <li v-if="isDispRightEllipsis()">
        <span class="pagination-ellipsis">&hellip;</span>
      </li>
      <li>
        <a v-if="totalNumberOfPages != 1" :class="{
          'pagination-link is-current': totalNumberOfPages === currentPage ,
          'pagination-link': totalNumberOfPages !== currentPage}"
           @click="setDividedArtists(totalNumberOfPages)">{{totalNumberOfPages}}</a>
      </li>

    </ul>
  </nav>
  <loading-display-modal v-if="isLoading"></loading-display-modal>
</div>
</template>

<script>
  import RegisterArtistModal from './RegisterArtistModal.vue'
  import LoadingDisplayModal from './LoadingDisplayModal.vue'

  export default {
      data: function(){
        return{
          artists: [] ,
          artists_org: [] ,
          user : null ,
          isLogin: false ,
          isLoading: false ,
          currentPage : 1 ,
          DIVIDEDBY : 6 ,
          dividedArtists: null ,
          isSortTypeByAlpha : false,
          isSortAlphaDown: true ,
          isSortTypeByDate : true ,
          isSortDateDown : true ,
        }
      },
      components:{
        RegisterArtistModal ,
        LoadingDisplayModal ,
      } ,
      computed:{
        totalNumberOfPages : function(){
          let total = 0
          const artists_count = this.artists.length
          total += Math.floor( artists_count / this.DIVIDEDBY )
          if( artists_count % this.DIVIDEDBY !== 0 ){
            total += 1
          }
          return total
        },
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
        setDividedArtists: function(pageNum){
          this.currentPage = pageNum

          this.dividedArtists = this.artists.slice(
            (this.currentPage - 1 ) * this.DIVIDEDBY ,
            this.DIVIDEDBY * this.currentPage
          )
        },
        isDispLeftEllipsis: function(){
          if(this.currentPage > 3 &&
              5 < this.totalNumberOfPages ){
            return true
          }else{
            return false
          }
        },
        isDispRightEllipsis: function(){
          if( this.currentPage < this.totalNumberOfPages - 2 &&
              5 < this.totalNumberOfPages ){
            return true
          }else{
            return false
          }
        },
        isDispCenterSide: function(pageNum){
          if( pageNum === 1 ){ return false}
          if( (this.currentPage === 1 || this.currentPage === 2 ) &&
            ( pageNum != this.totalNumberOfPages ) &&
            (pageNum === 3 || pageNum === 4 ))
            { return true }

          if( pageNum === this.totalNumberOfPages ){ return false }
          //現在のページが最後かその直前の場合、
          //最後から2つ前と3つ前のページを表示させる
          if( (this.currentPage === this.totalNumberOfPages || this.currentPage === this.totalNumberOfPages - 1 ) &&
            (pageNum === this.totalNumberOfPages - 2 || pageNum === this.totalNumberOfPages - 3 ))
            { return true }

          if( pageNum === this.currentPage - 1 ||
              pageNum === this.currentPage ||
              pageNum === this.currentPage + 1){
            return true
          }else{
            return false
          }
        },
        getArtists: function(){
          this.isLoading = true
          axios.get('/api/users/' + this.user.uid )
          .then( (res) => {
            this.artists = res.data.data
            this.artists_org = this.artists
            this.pageNum = 1
            this.setDividedArtists(1)
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
        },
        sortArtistsByAlpha: function(){
          const katakanaToHiragana = (src)=>{
            return src.replace(/[\u30a1-\u30f6]/g, function(match) {
              var chr = match.charCodeAt(0) - 0x60;
              return String.fromCharCode(chr);
            });
          }

          const sortAlphaUp = (a,b) => {
            a = katakanaToHiragana( a.toString() )
            b = katakanaToHiragana( b.toString() )
            if( a < b ){
              return -1
            }else if( a > b ){
              return 1
            }else{
              return 0
            }
          }

          const sortAlphaDown = (a,b) => {
            a = katakanaToHiragana( a.toString() )
            b = katakanaToHiragana( b.toString() )
            if( b < a ){
              return -1
            }else if( b > a ){
              return 1
            }else{
              return 0
            }
          }

          this.isSortTypeByAlpha = true
          this.isSortTypeByDate = false

          this.isSortAlphaDown = !this.isSortAlphaDown
          const unordered = this.artists.map( (artist) => {
            return artist.name
          })
          if(this.isSortAlphaDown){
            unordered.sort(sortAlphaDown)
          }else{
            unordered.sort(sortAlphaUp)
          }

          const ordered = []
          unordered.forEach( u => {
            this.artists.forEach( artist => {
              if( u === artist.name ){
                ordered.push(artist)
              }
            })
          })

          this.artists = ordered
          this.setDividedArtists(this.currentPage)
        },
        sortArtistsByDate:function(){

          this.isSortTypeByDate = true
          this.isSortTypeByAlpha = false

          this.isSortDateDown = !this.isSortDateDown

          this.artists = this.artists_org.reverse()

          this.setDividedArtists(this.currentPage)
        },

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
