<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>KARAOKE DIARY</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <!-- <script>
    ( () => {
      if('serviceWorker' in navigator ){
        navigator.serviceWorker.register("{{ asset('service-worker.js') }}")
        .then( () =>{
          console.log("Service Worker Registered")
        })
      }
    })();
  </script> -->
</head>
<body>

<div id="app">
  <my-header></my-header>
  <div class="container">
    <div class="columns">
      <router-view></router-view>
    </div>
  </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
