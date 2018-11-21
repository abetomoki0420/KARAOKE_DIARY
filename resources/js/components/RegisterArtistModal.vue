<template>
  <span>
    <register-modal-plus-button @openModal="openModal"></register-modal-plus-button>
    <ModalBase @close="closeModal" v-if="modal">
      <div class="field" >
        <label class="label has-text-grey">アーティスト名</label>
        <div class="control">
          <input id="input" v-model="name" class="input is-primary" type="text" maxlength="30"
           placeholder="例 Mr.Children" autofocus>
        </div>
      </div>
      <template slot="submit">
        <button :class="{'button is-primary is-loading' : isRegistering , 'button is-primary': !isRegistering}" @click.prevent="registerArtist">登録</button>
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
      user: null ,
      modal: false,
      name: '' ,
      isRegistering: false ,
    }
  },
  created(){
    firebase.auth().onAuthStateChanged( user => {
      this.user = user ? user : null
    })
  },
  methods: {
    openModal() {
      this.modal = true
      Vue.nextTick( ()=>{
        document.getElementById('input').focus()
      })
    },
    closeModal() {
      this.modal = false
    },
    registerArtist: function(){
      if(this.isRegistering){
        return
      }
      this.isRegistering = true

      axios.post('/api/artists' , {
        uid: this.user.uid ,
        name: this.name ,
      })
      .then( (res) => {
        this.name = ""
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
