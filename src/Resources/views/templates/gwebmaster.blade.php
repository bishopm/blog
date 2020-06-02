<!DOCTYPE html>
<html>
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123876505-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-123876505-1');
    </script>
    <script src="https://use.fontawesome.com/51082e9b56.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/vendor/bishopm/css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    @yield('css')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <div class="jumbotron frontjumbo">
    <div style="background-color: #fff;opacity:0.6;padding:10px;">
        <a style="text-decoration:none; color:black;" href="{{route('blogs.display',$username)}}">
        <h1 class="text-center">{{Setting::get('blog_title',$userid)}}</h1>
        <h5 class="text-center">{{Setting::get('blog_subtitle',$userid)}}</h5>
        </a>
    </div>
  </div>
  <div class="content-wrapper container">
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
