@extends('blog::templates.webmaster')

@if (isset($titletagtitle))
	@section('title',$titletagtitle)
@endif

@section('content')
	@yield('content')
@stop

@section('js')

@stop