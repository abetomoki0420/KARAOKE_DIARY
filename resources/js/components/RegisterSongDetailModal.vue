<template>
  <span>
    <span @click="openModal" class="icon is-medium has-text-success addbtn">
      <i class="fas fa-plus-circle"></i>
    </span>
    <ModalBase @close="closeModal" v-if="modal">
      <div class="field">
        <label class="label">点数</label>
        <div class="control">
          <input id="input" v-model="score" class="input" type="text">
        </div>
      </div>

      <div class="field">
        <label class="label">コメント</label>
        <div class="control">
          <textarea v-model="comment" class="textarea"></textarea>
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

export default {
  components: { ModalBase },
  data() {
    return {
      modal: false,
      score : '' ,
      comment: ''
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
      this.modal = false
    },
    registerSongDetail: function(){
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
