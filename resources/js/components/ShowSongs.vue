<template>
  <div class="column">
    <nav class="level">
      <div class="level-left">
        <div class="level-item title">
          <router-link :to="{
            name: 'artists'}">
            <span class="icon is-medium has-text-primary">
              <i class="fas fa-arrow-circle-left"></i>
            </span>
          </router-link>
          <span class="has-text-grey">
            {{ $route.params.name }}
          </span>
          <register-song-modal :artist-id="+$route.params.id" @registered="reload"></register-song-modal>
        </div>
      </div>
      <!-- Sort -->
      <div class="level level-right is-mobile">
        <div class="level-right">
          <div class="level-item" @click="sortSongsByAlpha">
            <span v-if="isSortAlphaDown" :class="{'icon is-medium has-text-primary': isSortTypeByAlpha , 'icon is-medium has-text-grey': !isSortTypeByAlpha}">
              <i class="fas fa-sort-alpha-down"></i>
            </span>
            <span v-if="!isSortAlphaDown" :class="{'icon is-medium has-text-primary': isSortTypeByAlpha , 'icon is-medium has-text-grey': !isSortTypeByAlpha}">
              <i class="fas fa-sort-alpha-up"></i>
            </span>
          </div>
          <div class="level-item" @click="sortSongsByDate">
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
    <!-- Sort End -->
    <!-- Song List -->
    <div v-if="!isLoading" class="tile is-ancestor">
      <div v-for="song in dividedSongs" class="tile is-parent is-4 song">
        <button class="delete dltbtn" @click="deleteSong(song)"></button>
        <router-link :to="{
          name: 'song_detail',
          params:{
            id: song.id ,
            artist_id : $route.params.id ,
            song_name: song.name ,
            artist_name: $route.params.name ,
          }
        }" class="tile is-child notification is-primary box">
          <p class="title is-3">{{song.name}}</p>
          <p class="subtitle is-5">歌った回数: {{ song.detail_count }}</p>
        </router-link>
      </div>
    </div>
    <!-- Songs List End -->
    <!-- Pagination -->
    <nav v-if="songs.length > 0" class="pagination" role="navigation" aria-label="pagination">
      <ul class="pagination-list">
        <li>
          <a :class="{
            'pagination-link is-current': 1 === currentPage ,
            'pagination-link': 1 !== currentPage}"
             @click="setDividedSongs(1)">1</a>
        </li>
        <li v-if="isDispLeftEllipsis()">
          <span class="pagination-ellipsis">&hellip;</span>
        </li>
        <li v-if="isDispCenterSide(pageNum)" v-for="pageNum in totalNumberOfPages">
          <a :class="{
            'pagination-link is-current': pageNum === currentPage ,
            'pagination-link': pageNum !== currentPage}"
            @click="setDividedSongs(pageNum)"
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
             @click="setDividedSongs(totalNumberOfPages)">{{totalNumberOfPages}}</a>
        </li>
      </ul>
    </nav>
    <!-- Pagination End -->

    <loading-display-modal v-if="isLoading"></loading-display-modal>
  </div>
</template>

<script>
  import RegisterSongModal from './RegisterSongModal.vue'
  import LoadingDisplayModal from './LoadingDisplayModal.vue'

  export default {
      data: function(){
        return{
          songs: [] ,
          songs_org: [] ,
          isLoading : false ,
          currentPage : 1 ,
          DIVIDEDBY: 6 ,
          isSortAlphaDown: true ,
          isSortTypeByAlpha: false ,
          isSortDateDown: true ,
          isSortTypeByDate : true , //Default

        }
      },
      components:{
        RegisterSongModal ,
        LoadingDisplayModal ,
      } ,
      created(){
        this.getSongs();
      },
      computed:{
        totalNumberOfPages : function(){
          let total = 0
          const songs_count = this.songs.length
          total += Math.floor( songs_count / this.DIVIDEDBY )
          if( songs_count % this.DIVIDEDBY !== 0 ){
            total += 1
          }
          return total
        },
      },
      methods : {
        setDividedSongs: function(pageNum){
          this.currentPage = pageNum

          this.dividedSongs = this.songs.slice(
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
        getSongs: function(){
          this.isLoading = true
          axios.get('/api/artists/'+ this.$route.params.id )
          .then( (res) => {
            this.songs = res.data.data
            this.songs_org = this.songs
            this.isLoading = false
            this.currentPage = 1
            this.setDividedSongs(1)
          });
        },
        reload: function(){
          this.getSongs()
        },
        deleteSong: function(song){
          if( !confirm( song.name + ' を削除しますか？' ) ){
            return
          }

          axios.delete('/api/songs/' + song.id )
          .then( (res) => {
            this.reload()
          });
        },
        sortSongsByAlpha: function(){
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
          const unordered = this.songs.map( (song ) => {
            return song.name
          })
          if(this.isSortAlphaDown){
            unordered.sort(sortAlphaDown)
          }else{
            unordered.sort(sortAlphaUp)
          }

          const ordered = []
          unordered.forEach( u => {
            this.songs.forEach( song => {
              if( u === song.name ){
                ordered.push(song)
              }
            })
          })
          this.songs = ordered
          this.setDividedSongs(this.currentPage)
        },
        sortSongsByDate:function(){

          this.isSortTypeByDate = true
          this.isSortTypeByAlpha = false

          this.isSortDateDown = !this.isSortDateDown

          this.songs = this.songs_org.reverse()

          this.setDividedSongs(this.currentPage)
        },
      }
  }
</script>

<style media="screen">
.tile.is-ancestor{
  flex-wrap: wrap;
}

.song{
  position: relative;
}
</style>
