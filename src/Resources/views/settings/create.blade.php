@extends('blog::templates.backend')

@section('content_header')
    {{ Form::pgHeader('Add setting','Settings',route('settings.index',$username)) }}
@stop

@section('content')
    @include('blog::templates.errors')
    {!! Form::open(['route' => array('settings.store',$username), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('blog::settings.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('settings.index',$username)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop