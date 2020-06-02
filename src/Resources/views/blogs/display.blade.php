@extends('blog::templates.gfrontend')
@section('title',$title)
@section('css')
    @parent
    <style>
    .jumbotron.frontjumbo {
        background: url({!! Setting::get('header_image',$userid ?? 1) !!}) fixed center no-repeat;
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
@include('blog::blogs.partials.facebook')
<div class="container-fluid">
    <div class="row mt-sm-5">
        <div class="col-md-9">
            <div class="card-columns">
                <div class="mx-auto mb-4 d-md-none">
                    @include('blog::templates.searchform')
                </div>
                @forelse ($blogs as $blog)
                    <div class="card">
                        @if($blog->getMedia('image')->first())
                            <img class="card-img-top" src="{{url('/storage/blogs')}}/{{$blog->getMedia('image')->first()->basename}}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a style="text-decoration:none;" href="{{route('blogs.show', [$username,date('Y',strtotime($blog->created_at)),date('m',strtotime($blog->created_at)),$blog->slug])}}">{{$blog->title}}</a>
                                <small>{{date("d M Y",strtotime($blog->created_at))}}</small>
                                <span class="text-secondary fa fa-comments"></span>&nbsp;<span class="fb-comments-count" style="font-size: 75%" data-href="{{route('blogs.show', [$username,date('Y',strtotime($blog->created_at)),date('m',strtotime($blog->created_at)),$blog->slug])}}"></span>
                            </h5>
                            {!! $blog->summary !!}
                        </div>
                    </div>
                @empty
                    No posts yet
                @endforelse
            </div>
            {{ $blogs->links() }}
        </div>
        <div class="col-md-3 mt-1">
            <div class="d-none d-md-block">
                @include('blog::templates.searchform')
            </div>
            <h5 class="text-center mt-3">{{Setting::get('blogger_name',$userid)}}</h5>
            <div class="text-center">
                <img class="img-thumbnail rounded-circle img-fluid" width="60%" src="{{Setting::get('avatar_link',$userid)}}">
                @if (Setting::get('about_me',$userid))
                    <div class="text-center mt-3">
                        {{Setting::get('about_me',$userid)}}
                    </div>
                @endif
            </div>
            @if (Setting::get('twitter_profile',$userid))
                <div class="text-center mt-3">
                    <a target="_blank" href="{{Setting::get('twitter_profile',$userid)}}"><i class="fa fa-lg fa-twitter-square"></i></a>
                </div>
            @endif
            <div class=text-center mt-3" style="line-height: 180%">
                @foreach ($tags as $tag)
                    <a class="mb-2 btn btn-sm btn-primary" href="{{route('blogs.subject',array($username,$tag['slug']))}}"><small>{{$tag['name']}}</small>&nbsp;<span class="badge badge-dark"><small>{{$tag['count']}}</small></span></a>
                @endforeach
            </div>
            @if($links)
                <div class="mt-3">
                    <li class="list-unstyled text-center"><a target="_blank" href="{!! $links->link !!}">{{$links->name}}</a></li>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
@parent
@endsection
