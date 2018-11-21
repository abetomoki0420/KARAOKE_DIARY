<template>
    <ModalBase @close="closeModal" v-if="modal">
      <div class="field">
        <label class="label has-text-grey">点数</label>
        <div class="control">
          <input id="input" v-model="score" class="input is-primary" type="text">
        </div>
        <p v-if="isScoreError" class="help is-danger">数値を入力して下さい</p>
      </div>

      <div class="field">
        <label class="label has-text-grey">コメント</label>
        <div class="control">
          <textarea v-model="comment" class="textarea is-primary"></textarea>
        </div>
      </div>
      <template slot="submit">
        <button class="button is-danger is-pulled-left" @click.prevent="deleteSongDetail">削除</button>
        <button class="button is-primary" @click.prevent="editSongDetail">変更</button>
      </template>
    </ModalBase>
</template>

<script>
import ModalBase from './ModalBase.vue'

export default {
  components: { ModalBase },
  data() {
    return {
      modal: true,
      score : '' ,
      comment: '' ,
      isScoreError: false
    }
  },
  created(){
    this.score = this.oldScore
    this.comment = this.oldComment
  },
  props: {
    songDetailId: {
      type: Number ,
      required: true ,
    },
    oldScore:{
      type: Number ,
      require: true ,
    },
    oldComment: {
      type: String ,
    }
  },
  methods: {
    closeModal() {
      this.score = ''
      this.comment = ''
      this.modal = false
    },
    editSongDetail: function(){
      const regex = new RegExp(/^[-+]?[0-9]+(\.[0-9]+)?$/);
      if( regex.test( this.score) ){
        this.isScoreError = false
      }else{
        this.isScoreError = true
        return
      }

      axios.put('/api/song_details/' + this.songDetailId , {
        score: this.score ,
        comment: this.comment ,
      })
      .then( (res) => {
        this.score = ""
        this.comment = ""
        this.isScoreError = false
        this.closeModal()
        this.$emit('edited')
      })
    },
    deleteSongDetail: function(){
      if( !confirm( 'このデータを削除しますか？' ) ){
        return
      }

      axios.delete('/api/song_details/' + this.songDetailId )
      .then( (res) => {
        this.closeModal()
        this.$emit('deleted')
      });
    }

  }
}
</script>

<style scoped>
.addbtn:hover{
  opacity: 0.8 ;
  cursor: pointer ;
}
</style>
