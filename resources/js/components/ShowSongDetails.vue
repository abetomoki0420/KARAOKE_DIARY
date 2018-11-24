<template>
<div class="column">
  <div class="level">
    <div class="level-left">
      <div class="level-item title">
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
    </div>
  </div>
  <!-- Kikimimi -->
  <div class="content">
    <div class="field is-grouped is-grouped-multiline">
      <div class="control">
        <span @click="editKikimimi" class="tag is-primary editbtn">聞き耳編集</span>
        <edit-kikimimi-modal v-if="isKikimimiEditing" :song-id="+$route.params.id" @close="close"></edit-kikimimi-modal>
        <span @click="showKikimimi" :class="{'icon is-medium has-text-primary editbtn': hasEmbedURL , 'icon is-medium has-text-grey':!hasEmbedURL}">
          <i class="fas fa-headphones"></i>
        </span>
        <show-kikimimi-modal v-if="isKikimimiModal" :URL="youtubeURL" @close="close"></show-kikimimi-modal>
      </div>
    </div>
  </div>
  <!-- kikimimi end -->

  <!-- tags -->
  <div class="content">
    <div class="field is-grouped is-grouped-multiline">
      <div class="control">
        <span class="tag is-primary editbtn" @click="categoryEdit">タグ編集</span>
      </div>
      <div class="control" v-for="category in categories">
        <div class="tags has-addons are-small">
          <router-link :to="{
            name: 'categories_songs' ,
            params:{
              category_id: category.id ,
              category_name: category.name ,
            }
            }" class="tags has-addons">

            <a class="tag is-link">{{ category.name }}</a>
            <a class="tag is-delete" v-if="isCategoryEditing" @click.prevent="deleteCategory(category.id)"></a>
          </router-link>
        </div>
      </div>

      <div class="field has-addons" v-if="isCategoryEditing">
        <p class="control">
          <input class="input is-small" type="text" v-model="categoryName"></input>
        </p>
        <p class="control">
          <span class="button is-small" v-if="isCategoryEditing"  @click="addCategory">追加</span>
        </p>
      </div>
    </div>
  </div>
  <!-- tags end -->
  <!-- Detail table -->
  <table class="table is-fullwidth is-hoverable is-narrow is-bordered details">
    <thead>
      <tr>
        <th>登録日</th>
        <th>点数</th>
        <th>コメント</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="songdetail in dividedSongDetails" @click="editDetail(songdetail)">
        <th>{{ songdetail.created_at }}</th>
        <td>{{ songdetail.score }}</td>
        <td>{{ songdetail.comment }}</td>
        <edit-song-detail-modal v-if="songdetail.edit" @edited="reload" @deleted="reload" @close="close" :songDetailId="songdetail.id" :oldScore="songdetail.score" :oldComment="songdetail.comment"></edit-song-detail-modal>
      </tr>
    </tbody>
  </table>
  <!-- Detail table End -->
  <!-- Pagination -->
  <nav v-if="totalNumberOfPages > 0" class="pagination" role="navigation" aria-label="pagination">
    <ul class="pagination-list">
      <li>
        <a :class="{
          'pagination-link is-current': 1 === currentPage ,
          'pagination-link': 1 !== currentPage}"
           @click="setDividedSongDetails(1)">1</a>
      </li>
      <li v-if="isDispLeftEllipsis()">
        <span class="pagination-ellipsis">&hellip;</span>
      </li>
      <li v-if="isDispCenterSide(pageNum)" v-for="pageNum in totalNumberOfPages">
        <a :class="{
          'pagination-link is-current': pageNum === currentPage ,
          'pagination-link': pageNum !== currentPage}"
          @click="setDividedSongDetails(pageNum)"
          >
          {{pageNum}}
        </a>
      </li>
      <li v-if="isDispRightEllipsis()">
        <span class="pagination-ellipsis">&hellip;</span>
      </li>
      <li>
        <a v-if="totalNumberOfPages != 1 && totalNumberOfPages > 0" :class="{
          'pagination-link is-current': totalNumberOfPages === currentPage ,
          'pagination-link': totalNumberOfPages !== currentPage}"
           @click="setDividedSongDetails(totalNumberOfPages)">{{totalNumberOfPages}}</a>
      </li>
    </ul>
  </nav>
  <!-- Pagination End -->

  <!-- <loading-display-modal v-if="isDetailsLoading || isCategoriesLoading"></loading-display-modal> -->
  <loading-display-modal v-if="isSomeLoading"></loading-display-modal>
</div>
</template>

<script>
import RegisterSongDetailModal from './RegisterSongDetailModal.vue'
import EditSongDetailModal from './EditSongDetailModal.vue'
import LoadingDisplayModal from './LoadingDisplayModal.vue'
import EditKikimimiModal from './EditKikimimiModal.vue'
import ShowKikimimiModal from './ShowKikimimiModal.vue'

export default {
  data: function() {
    return {
      songdetails: [] ,
      categories: null ,
      isDetailsLoading: false ,
      isCategoriesLoading: false,
      isCategoryEditing: false ,
      isCategoryAdding: false ,
      isCategoryDeleting: false ,
      categoryName : "" ,
      dividedSongDetails : null ,
      currentPage : 1 ,
      DIVIDEDBY: 5 ,
      isKikimimiEditing : false ,
      isKikimimiLoading : false ,
      hasEmbedURL : false ,
      embedURL: '' ,
      isKikimimiModal : false ,
    }
  },
  components: {
    RegisterSongDetailModal,
    EditSongDetailModal,
    LoadingDisplayModal,
    EditKikimimiModal ,
    ShowKikimimiModal ,
  },
  created() {
    this.getDatas()
  },
  computed: {
    isSomeLoading: function(){
      return ( this.isDetailsLoading || this.isCategoriesLoading || this.isCategoryAdding || this.isCategoryDeleting  || this.isKikimimiLoading )
    },
    totalNumberOfPages : function(){
      let total = 0
      const song_details_count = this.songdetails.length
      total += Math.floor( song_details_count / this.DIVIDEDBY )
      if( song_details_count % this.DIVIDEDBY !== 0 ){
        total += 1
      }
      return total
    },
  },
  methods: {
    editKikimimi: function(){
      this.isKikimimiEditing = true
    },
    showKikimimi: function(){
      if(!this.hasEmbedURL){
        return
      }
      this.isKikimimiModal = true
    },
    getKikimimi: function(){
      if(this.isKikimimiLoading){
        return
      }
      this.isKikimimiLoading = true

      axios.get('/api/songs/' + this.$route.params.id + '/URL')
      .then( (res) => {
        const URL = res.data
        if( URL.length > 0 ){
          this.youtubeURL = URL
          this.hasEmbedURL = true
        }else{
          this.youtubeURL = ''
          this.hasEmbedURL = false
        }

        this.isKikimimiLoading = false
      })
    },
    setDividedSongDetails: function(pageNum){
      this.currentPage = pageNum

      this.dividedSongDetails = this.songdetails.slice(
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
    close: function() {
      this.reload()

      this.isKikimimiModal = false
      this.isKikimimiEditing = false
    },
    editDetail: function(songdetail) {
      songdetail.edit = true
    },
    getSongDetails: function() {
      if (this.isDetailsLoading) {
        return
      }
      this.isDetailsLoading = true
      axios.get('/api/songs/' + this.$route.params.id)
        .then((res) => {
          this.isDetailsLoading = false
          this.songdetails = res.data.data

          this.setDividedSongDetails(1)
        })
    },
    getSongCategories: function() {
      if (this.isCategoriesLoading) {
        return
      }
      this.isCategoriesLoading = true
      axios.get('/api/categories/' + this.$route.params.id)
        .then((res) => {
          this.isCategoriesLoading = false
          this.categories = res.data.data;

        });
    },
    getDatas: function() {
      this.getSongCategories()
      this.getSongDetails()
      this.getKikimimi()
    },
    reload: function() {
      this.getDatas()
    },
    categoryEdit: function() {
      this.isCategoryEditing = !this.isCategoryEditing
    },
    addCategory: function(){
      if( this.categoryName.length == 0 ){
        return
      }

      if(this.categories.length >= 5){
        return
      }

      if(this.isCategoryAdding){
        return
      }

      this.isCategoryAdding = true
      axios.post('/api/categories' , {
        song_id : this.$route.params.id ,
        name: this.categoryName ,
      })
      .then( (res) => {
        this.categoryName = ""
        this.categories = res.data.data
        this.isCategoryAdding = false
      })
    },
    deleteCategory: function(id){
      if( !confirm( 'このタグを削除しますか？' ) ){
        return
      }
      if(this.isCategoryDeleting){
        return
      }

      this.isCategoryDeleting = true
      axios.delete('/api/categories/' + id )
      .then( (res) => {
        this.categories = this.categories = res.data.data
        this.isCategoryDeleting = false
      });
    },
  }
}
</script>

<style scoped>
tbody tr {
  cursor: pointer;
}

.editbtn{
  cursor:pointer ;
}

.kikimimi{
  margin-bottom: 0 ;
}
</style>
