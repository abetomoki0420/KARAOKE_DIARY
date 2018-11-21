<template>
  <span>
    <register-modal-plus-button @openModal="openModal"></register-modal-plus-button>
    <ModalBase @close="closeModal" v-if="modal">
      <div class="field">
        <label class="label has-text-grey">曲名</label>
        <div class="control">
          <input id="input" v-model="title" class="input is-primary" type="text" maxlength="40"
          placeholder="例 HANABI" autofocus>
        </div>
      </div>
      <template slot="submit">
        <button :class="{'button is-primary is-loading':isRegistering , 'button is-primary': !isRegistering}" @click.prevent="registerSong">登録</button>
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
      title : '' ,
      isRegistering : false ,
    }
  },
  props:{
    artistId :{
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
    registerSong: function(){
      if(this.isRegistering){
        return
      }
      this.isRegistering = true

      axios.post('/api/songs' , {
        artist_id: this.artistId ,
        title: this.title
      })
      .then( (res) => {
        this.title = ""
        this.closeModal()
        this.isRegistering = false
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
