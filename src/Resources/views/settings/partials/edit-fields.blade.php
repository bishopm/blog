{{ Form::bsText('setting_key','Setting','Setting',$setting->setting_key) }}
{{ Form::bsText('setting_value','Setting value','Setting value',$setting->setting_value) }}
{{ Form::label('Scope')}}
<div class="form-group">
    <select class='form-control' name='scope' id='scope'>
        @foreach ($scopearray as $key=>$val)
            @if ($key==$setting->scope)
                <option selected value="{{$key}}">{{$val}}</option>
            @else
                <option value="{{$key}}">{{$val}}</option>
            @endif
        @endforeach
    </select>
</div>