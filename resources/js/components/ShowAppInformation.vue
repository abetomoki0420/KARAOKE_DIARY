<template>
    <ModalBase @close="closeModal" v-if="modal">
      <div class="container">
        <div class="app-information has-text-grey">
          <p>KARAOKE DIARYは</p>
          <p>カラオケレパートリーの管理を</p>
          <p>行うためのアプリです</p>
          <p>アーティスト・曲名・点数の記録</p>
          <p>Youtube動画による歌い出しの確認</p>
          <p>タグの設定</p>
          <p>を行うことが出来ます</p>
        </div>
      </div>
      <template slot="submit">
        <button class="button is-primary" @click.prevent="closeModal">閉じる</button>
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
      isLoading: false ,
    }
  },
  props: {
    URL: {
      type: String ,
      required: true ,
    },
  },
  methods: {
    closeModal: function() {
      this.$emit('close')
      this.modal = false
    },
  }
}
</script>

<style lang="scss" scoped>
</style>
