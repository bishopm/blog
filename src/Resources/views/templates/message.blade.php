@extends('blog::templates.homemaster')
@section('title','Error: something went wrong!')
@section('css')
    @parent
    <style>
    .jumbotron.frontjumbo {
        background-size: cover;
    }
    body > div.jumbotron.frontjumbo > a > h1, body > div.jumbotron.frontjumbo > a > h5 {
        color: #000;
        letter-spacing: .1em;
        z-index: 1;
    }
    .card-img-top {
        width: 100%;
        height: 30vh;
        object-fit: cover;
    }
    .card-columns {
        column-count: 1;
    }
    @media (min-width: 768px) {
        .card-columns {
            column-count: 2;
        }
    }
    </style>
@stop

@section('content')
<div class="container-fluid">
    {{$message}}
</div>
@endsection

@section('js')
@parent
@endsection
