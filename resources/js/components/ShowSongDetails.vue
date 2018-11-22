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
  <!-- tags -->
  <div class="content">
    <div class="field is-grouped is-grouped-multiline">
      <div class="control">
        <span class="tag is-primary" @click="categoryEdit">タグ編集</span>
      </div>
      <div class="control" v-for="category in categories">
        <div class="tags has-addons are-small">
          <a class="tag is-link">{{ category.name }}</a>
          <a class="tag is-delete" v-if="isCategoryEditing" @click.prevent="deleteCategory(category.id)"></a>
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
        <edit-song-detail-modal v-if="songdetail.edit" @edited="reload" @deleted="reload" @close="close(songdetail)" :songDetailId="songdetail.id" :oldScore="songdetail.score" :oldComment="songdetail.comment"></edit-song-detail-modal>
      </tr>
    </tbody>
  </table>
  <!-- <loading-display-modal v-if="isDetailsLoading || isCategoriesLoading"></loading-display-modal> -->
  <loading-display-modal v-if="isSomeLoading"></loading-display-modal>
</div>
</template>

<script>
import RegisterSongDetailModal from './RegisterSongDetailModal.vue'
import EditSongDetailModal from './EditSongDetailModal.vue'
import LoadingDisplayModal from './LoadingDisplayModal.vue'

export default {
  data: function() {
    return {
      songdetails: null,
      categories: null,
      isDetailsLoading: false,
      isCategoriesLoading: false,
      isCategoryEditing: false ,
      isCategoryAdding: false ,
      isCategoryDeleting: false ,
      categoryName : "" ,
    }
  },
  components: {
    RegisterSongDetailModal,
    EditSongDetailModal,
    LoadingDisplayModal,
  },
  created() {
    // this.getSongDetails()
    // this.getSongCategories()
    this.getDatas()
  },
  computed: {
    isSomeLoading: function(){
      return ( this.isDetailsLoading || this.isCategoriesLoading || this.isCategoryAdding || this.isCategoryDeleting )
    }
  },
  methods: {
    close: function(songdetail) {
      this.reload()
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
      this.getSongDetails()
      this.getSongCategories()
    },
    reload: function() {
      this.getDatas()
    },
    categoryEdit: function() {
      this.isCategoryEditing = !this.isCategoryEditing
    },
    addCategory: function(){
      if(this.isCategoryAdding){
        return
      }
      this.isCategoryAdding = true
      axios.post('/api/categories/' , {
        song_id : this.$route.params.id ,
        name: this.categoryName ,
      })
      .then( (res) => {
        this.categoryName = ""
        this.categories = this.categories = res.data.data
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
</style>
