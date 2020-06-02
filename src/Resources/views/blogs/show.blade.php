@extends('blog::templates.gfrontend')

@section('title',$blog->title . ' - ' . $blogtitle)

@section('css')
    @parent
    <meta property="og:title" content="{{$blog->title . ' - ' . $blogtitle}}" />
    <meta property="og:type" content="article" />
    @if($blog->getMedia('image')->first())
    <meta property="og:image" content="{{url('/storage/blogs')}}/{{$blog->getMedia('image')->first()->basename}}" />
    @else
    <meta property="og:image" content="{{Setting::get('avatar_link',$userid)}}" />
    @endif
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:description" content="{{$blog->summary}}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{$blog->title . ' - ' . $blogtitle}}" />
    <meta name="twitter:description" content="{{$blog->summary}}" />
    @if($blog->getMedia('image')->first())
    <meta name="twitter:image" content="{{url('/storage/blogs')}}/{{$blog->getMedia('image')->first()->basename}}" />
    @else
    <meta name="twitter:image" content="{{Setting::get('avatar_link',$userid)}}" />
    @endif
    <style>
    .jumbotron.frontjumbo {
        background: url({!! Setting::get('header_image',$userid) !!}) fixed center no-repeat;
        background-size: cover;
    }
    body > div.jumbotron.frontjumbo > a > h1, body > div.jumbotron.frontjumbo > a > h5 {
        color: #555;
        letter-spacing: .1em;
        text-shadow: -1px -1px 1px #111, 2px 2px 1px #363636;
    }
    #social-links ul li {
        list-style-type: none; float: left;
    }
    ul li a span {
        background: #205D7A;
        color: #fff;
        width: 40px;
        height: 40px;
        border-radius: 5px;
        font-size: 25px;
        text-align: center;
        margin-right: 10px;
        padding-top: 13%;
    }
    .fa-facebook-square {
        background:#3b5998;
    }
    .fa-twitter {
        background:#00aced;
    }
    .fa-whatsapp {
        background:green;
    }
    </style>
@stop

@section('content')
@include('blog::blogs.partials.facebook')
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12">
            <div class="row">
                <article class="col-12">
                    <h4>
                        {{$blog->title}}
                        @include('blog::templates.icons')
                    </h4>
                    <p>
                        <small>
                            posted by <b>{{ucfirst($username)}}</b> on {{date('d F Y', strtotime(substr($blog->created_at,0,10)))}}. <br>
                        </small>
                    </p>
                    <div class="text-justify">
                        @if($blog->getMedia('image')->first())
                            <figure class="float-right">
                                <img class="figure-img img-fluid ml-3 mb-3" src="{{url('/storage/blogs')}}/{{$blog->getMedia('image')->first()->basename}}">
                                <figcaption class="text-right">{{$blog->image_title}}</figcaption>
                            </figure>
                        @endif
                        {!! $blog->body !!}
                        <i class="fa fa-tag"></i>
                        @foreach ($blog->tags as $tag)
                            <span class="badge badge-primary"><a style="text-decoration:none; color:white;" href="{{route('blogs.subject',array($username,$tag->slug))}}">{{$tag->name}}</a></span>
                        @endforeach
                    </div>
                    <div class="fb-comments" data-href="{{Request::url()}}" data-width="100%" data-numposts="5"></div>
                </article>
                <div><b>Share this post:</b>
                    {!!Share::page(url()->current(), $blog->title . ' - ' . $blogtitle, ['class' => 'fa-2x', 'id' => 'my-id'])->facebook()->twitter()->whatsapp()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@parent
<script src="{{ asset('js/share.js') }}"></script>
@endsection
