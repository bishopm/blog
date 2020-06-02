@extends('blog::templates.gfrontend')

@section('title',$title)

@section('css')
    @parent
    <style>
    .jumbotron.frontjumbo {
        background: url({!! Setting::get('header_image',$userid) !!}) fixed center no-repeat;
        background-size: cover;
    }
    </style>
@stop

@section('content')
<div class="container-fluid ma-3">
    <div class="row mt-5">
        <div class="col-12">
            <h4>Search results: <i>{{$search}}</i>
            @include('blog::templates.icons')
            </h4>
        </div>
    </div>    
    <div class="row">
        <div class="col-12">
            @forelse ($blogs as $blog)
                <p><a href="{{route('blogs.show', [$username,date('Y',strtotime($blog->created_at)),date('m',strtotime($blog->created_at)),$blog->slug])}}">{{$blog->title}}</a> <small>{{date("d M Y",strtotime($blog->created_at))}}</small>
                <br>{!! $blog->summary !!}</p>
            @empty
                <p>No posts found. Click <a href="{{url('/')}}">here</a> to return to the home page</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('js')
@parent
@endsection