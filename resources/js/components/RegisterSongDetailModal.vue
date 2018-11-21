<template>
  <span>
    <register-modal-plus-button @openModal="openModal"></register-modal-plus-button>
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
        <button class="button is-primary" @click.prevent="registerSongDetail">登録</button>
      </template>
    </ModalBase>
  </span>
</template>

<script>
import ModalBase from './ModalBase.vue'
import RegisterModalPlusButton from './RegisterModalPlusButton.vue'

export default {
  components: { ModalBase , RegisterModalPlusButton },
  data() {
    return {
      modal: false,
      score : '' ,
      comment: '' ,
      isScoreError: false
    }
  },
  props: {
    songId: {
      type: Number ,
      required: true ,
    }
  },
  methods: {
    openModal() {
      this.modal = true
      Vue.nextTick( () => {
        document.getElementById('input').focus()
      })
    },
    closeModal() {
      this.score = ''
      this.comment = ''
      this.modal = false
    },
    registerSongDetail: function(){
      const regex = new RegExp(/^[-+]?[0-9]+(\.[0-9]+)?$/);
      if( regex.test( this.score) ){
        this.isScoreError = false
      }else{
        this.isScoreError = true
        return
      }

      axios.post('/api/song_details' , {
        id: this.songId ,
        score: this.score ,
        comment: this.comment ,
      })
      .then( (res) => {
        this.score = ""
        this.comment = ""
        this.closeModal()
        this.$emit('registered')
      })
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
