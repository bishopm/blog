<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <script src="https://use.fontawesome.com/51082e9b56.js"></script>
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
    <h1 class="text-center text-white">{{Setting::get('blog_title',$userid)}}</h1>
    <h5 class="text-center text-white">{{Setting::get('blog_subtitle',$userid)}}</h5>
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
