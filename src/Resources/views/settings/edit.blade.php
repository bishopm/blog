@extends('blog::templates.backend')

@section('css')
@if (strpos($setting->setting_key, 'colour')!==false)
    <link href="{{ asset('/vendor/bishopm/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css" />
@endif
@stop

@section('content_header')
{{ Form::pgHeader('Edit setting','Settings',route('settings.index',$username)) }}
@endsection

@section('content')
    
    @include('blog::templates.errors')    
    {!! Form::open(['route' => ['settings.update',$username,$setting->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('blog::settings.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('settings.index',$username)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
@if (strpos($setting->setting_key, 'colour')!==false)
<script src="{{ asset('/vendor/bishopm/colorpicker/bootstrap-colorpicker.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
      $("#cp").colorpicker({ color: '{{$setting->setting_value or 000000}}' });
    });    
</script>
@endif
@endsection