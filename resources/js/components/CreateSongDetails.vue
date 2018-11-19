<template >
<div class="column">
  <div class="field">
    <label class="label">点数</label>
    <div class="control">
      <input v-model="score" class="input" type="text">
    </div>
  </div>

  <div class="field">
    <label class="label">コメント</label>
    <div class="control">
      <textarea v-model="comment" class="textarea"></textarea>
    </div>
  </div>

  <div class="field is-grouped">
    <div class="control">
      <button class="button is-primary" @click.prevent="create">登録</button>
    </div>
  </div>

</div>
</template>

<script>
export default {
  data: function(){
    return{
      score: "" ,
      comment: ""
    }
  },
  methods:{
    create: function(){
      axios.post('/api/song_details' , {
        id: this.$route.params.id ,
        score: this.score ,
        comment: this.comment ,
      })
      .then( (res) => {
        this.score = ""
        this.comment = ""
        console.log("created details");
      })
    }
  }
}
</script>

<style lang="css">
</style>
