<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'MTS') - Laravel</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>

<!--     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="/">MTS</a>
        <ul class="navbar-nav justify-content-end">
          <li class="nav-item"><a class="nav-link" href="/help">帮助</a></li>
          <li class="nav-item" ><a class="nav-link" href="#">登录</a></li>
        </ul>
      </div>
    </nav> -->
    @include('layouts._header')
    <br/>
    <div class="container">
        <div class="offset-md-1 col-md-10">
        @include('shared._messages')
        @yield('content')
        @include('layouts._footer')
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
