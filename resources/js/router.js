import VueRouter from 'vue-router' ;

//Routing
export default new VueRouter({
  mode: 'history',
  routes:[
    {
      path: '/' ,
      component: require('./components/ContentMain.vue') ,
      name: 'main'
    },
    {
      path: '/register-song' ,
      component: require('./components/RegisterSong.vue') ,
      name: 'register-song'
    },
    {
      path: '/register-artist' ,
      component: require('./components/RegisterArtist.vue') ,
      name: 'register-artist'
    },
    {
      path: '/artists' ,
      component: require('./components/ShowArtists.vue') ,
      name: 'artists'
    },
    {
      path: '/artists/songs/:name' ,
      component: require('./components/ShowSongs.vue') ,
      name: 'songs'
    },
    {
      path: '/artists/songs/:artist_name/:song_name' ,
      component: require('./components/ShowSongDetails.vue') ,
      name: 'song_detail'
    },
    {
      path: '/artists/songs/:artist_name/:song_name/create' ,
      component: require('./components/CreateSongDetails.vue') ,
      name: 'create_songdetail'
    },
  ]
})
