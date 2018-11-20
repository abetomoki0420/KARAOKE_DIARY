<template>
  <span>
    <span @click="openModal" class="icon is-medium has-text-success">
      <i class="fas fa-plus-circle"></i>
    </span>
    <ModalBase @close="closeModal" v-if="modal">
      <div class="field">
        <label class="label">曲名</label>
        <div class="control">
          <input v-model="title" class="input is-success" type="text" placeholder="例 HANABI" autofocus>
        </div>
      </div>
      <template slot="submit">
        <button class="button is-primary" @click.prevent="registerSong">登録</button>
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
      title : ''
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
    },
    closeModal() {
      this.modal = false
    },
    registerSong: function(){
      axios.post('/api/songs' , {
        artist_id: this.artistId ,
        title: this.title
      })
      .then( (res) => {
        this.closeModal() ;
        this.title = ""
      })
    }
  }
}
</script>
