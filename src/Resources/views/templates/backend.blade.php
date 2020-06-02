@extends('blog::templates.backmaster')

@if (isset($titletagtitle))
	@section('title',$titletagtitle)
@endif

@section('css')

@stop

@section('content')	
	@yield('content')
@stop

@section('js')

@stop