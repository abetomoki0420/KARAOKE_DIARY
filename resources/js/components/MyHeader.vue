<template>
  <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <router-link class="navbar-item" to="/">
        <span><i class="fas fa-microphone fa-2x"></i></span>
        <span class="logo">KARAOKE DIARY</span>
      </router-link>
    </div>
    <div class="navbar-item navbar-end">
      <div class="field is-grouped">
        <div class="button is-primary" @click="login" v-if="!isLogin">
          Login
        </div>
          <div class="button is-primary" @click="logout" v-if="isLogin">
            <span>Logout</span>
            <figure class="image is-32x32 user-icon">
              <img class="is-rounded user-icon" :src="user.photoURL">
            </figure>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
  export default {
      name: "MyHeader" ,
      data: function(){
        return{
          user: null ,
        }
      },
      created(){
        firebase.auth().onAuthStateChanged( user => {
          this.user = user ? user : null
          if(this.user){
            this.getUser(this.user.uid , this.user.displayName )
          }
        })
      },
      computed:{
        isLogin: function(){
          return this.user != null
        }
      },
      methods:{
        login: function(){
          const provider = new firebase.auth.GoogleAuthProvider()
          // await firebase.auth().signInWithPopup( provider )
          firebase.auth().signInWithRedirect( provider )
        },
        logout: async function(){
          await firebase.auth().signOut();
        },
        getUser: function(uid,displayName){
          axios.post('/api/users' , {
            uid: uid ,
            displayName: displayName ,
          })
          .then( (res) => {
          })
        }
      }
  }
</script>

<style >
.logo{
  margin-left: 10px ;
}

.columns{
  margin-top: 1em;
}

.dltbtn{
  z-index: 10 ;
  position: absolute;
  top:20 ;
  right: 20 ;
}

.navbar{
  flex-wrap: nowrap;
}

.user-icon{
  display: inline-block;
  margin-left: 0.1em ;
  height: auto;
  width: auto;
  max-height: 100% ;
  max-width: 100% ;
}
</style>
