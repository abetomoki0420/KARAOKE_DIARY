<template>
    <ModalBase @close="closeModal" v-if="modal">
      <div class="field">
        <label class="label has-text-grey">YoutubeのURL</label>
        <div class="control">
          <input id="input" v-model="youtubeURL" class="input is-primary" type="text" placeholder="https://www.youtube...">
        </div>
        <p v-if="isURLError" class="help is-danger">URLに誤りがあります</p>
      </div>
      <template slot="submit">
        <button :class="{'button is-primary is-loading': isLoading , 'button is-primary': !isLoading}" @click.prevent="editKikimimi">更新</button>
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
      youtubeURL : '' ,
      isURLError: false ,
      isLoading: false ,
    }
  },
  props: {
    songId: {
      type: Number ,
      required: true ,
    },
  },
  methods: {
    closeModal: function() {
      this.score = ''
      this.comment = ''
      this.$emit('close')
      this.modal = false
    },
    editKikimimi: function(){
      const validationURL = 'https://www.youtube.com/watch?v='
      if( this.youtubeURL.indexOf( validationURL ) === -1 ){
        this.isURLError = true
        return
      }

      if(this.isLoading){
        return
      }
      this.isLoading = true

      axios.post('/api/songs/updateURL'  ,{
        id: this.songId ,
        youtubeURL: this.youtubeURL ,
      })
      .then( (res) => {
        this.youtubeURL = ""
        this.isURLError = false
        this.isLoading = false
        this.closeModal()
        this.$emit('edited')
      })
    },
    deleteSongDetail: function(){
      if( !confirm( 'このデータを削除しますか？' ) ){
        return
      }

      if(this.isLoading){
        return
      }
      this.isLoading = true
      axios.delete('/api/song_details/' + this.songDetailId )
      .then( (res) => {
        this.isLoading = false
        this.closeModal()
        this.$emit('deleted')
      });
    }

  }
}
</script>

<style scoped>
</style>
