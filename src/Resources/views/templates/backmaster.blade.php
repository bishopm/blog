<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/vendor/bishopm/css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    @yield('css')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <nav class="navbar navbar-expand-lg fixed-top bg-primary">
  <a class="navbar-brand" href="{{route('blogs.display', $username)}}"><i class="fa fa-home"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        @if (Auth::user())
        <li class="nav-item dropdown ml-auto">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ucfirst(Auth::user()->name)}}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{route('blogs.index',$username)}}">View blog posts</a>
            <a class="dropdown-item" href="{{route('blogs.create',$username)}}">New blog post</a>
            <a class="dropdown-item" href="{{route('blogs.display',strtolower(Auth::user()->name))}}">My blog</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('settings.index',$username)}}">Settings</a>
            <a class="dropdown-item" href="{{route('logout')}}">Log out</a>
          </div>
        </li>
        @else
          <li class="nav-item">
            <a class="nav-link" title="Login" href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login</a>
          </li>
        @endif
      </ul>
    </div>
  </nav>
  <div class="content-wrapper container mt-5 pt-3">
    <section class="section">
      @yield('content_header')
    </section>
    <section class="section">
      @yield('content')
    </section>
  </div>
</body>
<section class="section">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
  @yield('js')
</section>
</html>