@extends('blog::templates.backend')

@section('css')
    @parent
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
@stop

@section('content')
    <div class="container-fluid ma-3">
        @include('blog::templates.errors') 
        <div class="row">
            <div class="col">
                <div class="card mt-5 border-0">
                    <div class="card-heading">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h4>Settings
                                <a href="{{route('settings.create',$username)}}" class="btn btn-primary float-right"><i class="fa fa-pencil"></i> Add a new setting</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed w-100" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Setting</th><th>Value</th><th>Description</th><th>Scope</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Setting</th><th>Value</th><th>Description</th><th>Scope</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($settings as $setting)
                                    <tr>
                                        <td><a href="{{route('settings.edit',array($username,$setting->id))}}">{{strtoupper(str_replace('_',' ',$setting->setting_key))}}</a></td>
                                        <td><a href="{{route('settings.edit',array($username,$setting->id))}}">{{substr($setting->setting_value,0,40)}}</a></td>
                                        <td><a href="{{route('settings.edit',array($username,$setting->id))}}">{{$setting->description}}</a></td>
                                        <td><a href="{{route('settings.edit',array($username,$setting->id))}}">{{$setting->scopename}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No settings have been added yet</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@parent
<script language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script language="javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script language="javascript">
$(document).ready(function() {
        $('#indexTable').DataTable( {
            "order": [[ 0, "desc" ]]
        } );
    } );
</script>
@endsection