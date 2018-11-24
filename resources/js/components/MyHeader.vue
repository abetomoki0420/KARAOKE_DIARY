<template>
<nav class="navbar is-primary" role="navigation" aria-label="main navigation">

  <div class="navbar-brand">
    <router-link class="navbar-item" to="/">
      <span><i class="fas fa-microphone fa-2x"></i></span>
      <span class="logo">KARAOKE DIARY</span>
    </router-link>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarTarget">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>

    <show-app-information v-if="isInformationModal" @close="close"></show-app-information>
  </div>
  <div id="navbarTarget" class="navbar-menu">
    <div class="navbar-start">
      <div class="navbar-item">
        <div class="button is-primary is-small" @click="showInformation">このアプリについて</div>
      </div>
    </div>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="button is-primary" @click="login" v-if="!isLogin">
          <i class="fab fa-google"></i>
          Login with Google
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
import ShowAppInformation from './ShowAppInformation.vue'

export default {
  name: "MyHeader",
  data: function() {
    return {
      user: null,
      isInformationModal: false ,
    }
  },
  components: {
    ShowAppInformation ,
  },
  created() {
    firebase.auth().onAuthStateChanged(user => {
      this.user = user ? user : null
      if (this.user) {
        this.getUser(this.user.uid, this.user.displayName)
      }
    })

    //To Bulma Navbar
    document.addEventListener('DOMContentLoaded', () => {

      // Get all "navbar-burger" elements
      const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

      // Check if there are any navbar burgers
      if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach(el => {
          el.addEventListener('click', () => {

            // Get the target from the "data-target" attribute
            const target = el.dataset.target;
            const $target = document.getElementById(target);

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');

          });
        });
      }

    });
  },
  computed: {
    isLogin: function() {
      return this.user != null
    }
  },
  methods: {
    login: function() {
      const provider = new firebase.auth.GoogleAuthProvider()
      firebase.auth().signInWithRedirect(provider)
    },
    logout: async function() {
        await firebase.auth().signOut();
      },
      getUser: function(uid, displayName) {
        axios.post('/api/users', {
            uid: uid,
            displayName: displayName,
          })
          .then((res) => {})
      },
      showInformation: function(){
        this.isInformationModal = true
      },
      close: function(){
        this.isInformationModal = false
      },
  }
}
</script>

<style >
.logo {
  margin-left: 10px;
}

.columns {
  margin-top: 1em;
}

.dltbtn {
  z-index: 10;
  position: absolute;
  top: 20;
  right: 20;
}

.navbar {
  flex-wrap: nowrap;
}

.user-icon {
  display: inline-block;
  margin-left: 0.1em;
  height: auto;
  width: auto;
  max-height: 100%;
  max-width: 100%;
}
</style>
