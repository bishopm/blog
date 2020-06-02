{{ Form::bsText('setting_key','Setting','Setting') }}
{{ Form::bsText('setting_value','Setting value','Setting value') }}
{{ Form::label('Scope')}}
<div class="form-group">
    <select class='form-control' name='scope' id='scope'>
        @foreach ($scopearray as $key=>$val)
            @if (Auth::user()->id==$key)
                <option selected value="{{$key}}">{{$val}}</option>
            @else
                <option value="{{$key}}">{{$val}}</option>
            @endif
        @endforeach
    </select>
</div>