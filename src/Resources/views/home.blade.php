@extends('blog::templates.homemaster')

@section('content')
<style>
body {
    background-color: #81b341;  
}
.center-div {
    position: absolute;
    margin: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 25%;
    height: 25%;
    background-color: #81b341;
    border-radius: 3px;
    text-align:center;
}
</style>
<div class="center-div">
    <h1>
        @if (env('APP_ENV')=="local")
            <a title="Kym's page" style="color:#4d7227; text-decoration:none;" href="http://localhost/blog/public/kym">Kym</a><br><br>
            <img src="{{ asset('/vendor/bishopm/images/Bishop-icon.png')}}"><br><br>
            <a title="Michael's page" style="color:#4d7227; text-decoration:none;" href="http://localhost/blog/public/michael">Michael</a>
        @else
            <a title="Kym's page" style="color:#4d7227; text-decoration:none;" href="https://kym.bishop.net.za">Kym</a><br><br>
            <img src="{{ asset('/vendor/bishopm/images/Bishop-icon.png')}}"><br><br>
            <a title="Michael's page" style="color:#4d7227; text-decoration:none;" href="https://michael.bishop.net.za">Michael</a>
        @endif
    </h1>
</div>
@guest
    <div class="text-right mt-4 pr-5">
        <h3><a style="color:white; text-decoration:none;" href="{{route('login')}}">Login</a></h3>
    </div>
@endguest
@stop