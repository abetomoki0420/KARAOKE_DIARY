<template>
<div class="container">
  <div class="column">
    <ul v-for="k in karaoke">
      <li>
        <p>{{k.artist}} {{ k.title}}</p>
      </li>
    </ul>
  </div>
</div>
</template>


<script>
  export default {
      name: "ContentMain" ,
      data: function(){
        return{
          karaoke: null ,
        }
      },
      created(){
        this.getItems();
      },
      methods : {
        getItems: function(){
          axios.get('/api/karaokes')
          .then( (res) => {
            console.log(res.data);
            this.karaoke = res.data.data ;
          });
        },
      }
  }
</script>
