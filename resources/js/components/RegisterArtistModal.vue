<template>
  <span>
    <span @click="openModal" class="icon is-medium has-text-success addbtn">
      <i class="fas fa-plus-circle"></i>
    </span>
    <ModalBase @close="closeModal" v-if="modal">
      <div class="field">
        <label class="label">アーティスト名</label>
        <div class="control">
          <input v-model="name" class="input" type="text" placeholder="例 Mr.Children" autofocus>
        </div>
      </div>
      <template slot="submit">
        <button class="button is-primary" @click.prevent="registerArtist">登録</button>
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
      name: '' ,
    }
  },
  methods: {
    openModal() {
      this.modal = true
    },
    closeModal() {
      this.modal = false
    },
    registerArtist: function(){
      axios.post('/api/artists' , {
        name: this.name ,
      })
      .then( (res) => {
        this.name = ""
        this.closeModal();
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
