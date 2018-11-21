import firebase from 'firebase'

// Initialize Firebase
const config = {
  apiKey: "AIzaSyABrDl5QY5R6Oxm1ui5UxTK0NmEgdFAk4c",
  authDomain: "karaoke-diary.firebaseapp.com",
  databaseURL: "https://karaoke-diary.firebaseio.com",
  projectId: "karaoke-diary",
  storageBucket: "",
  messagingSenderId: "117251275064"
};

firebase.initializeApp(config);

export default firebase ;
