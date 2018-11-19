<template >
<div class="column">
  <div class="field">
    <label class="label">アーティスト名</label>
    <div class="control">
      <input v-model="name" class="input" type="text" placeholder="例 Mr.Children">
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
      name: "" ,
    }
  },
  methods:{
    create: function(){
      axios.post('/api/artists' , {
        name: this.name ,
      })
      .then( (res) => {
        this.name = ""
        console.log("created artist");
      })
    }
  }
}
</script>

<style lang="css">
</style>
