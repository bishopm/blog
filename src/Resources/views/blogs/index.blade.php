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
                                <h4>
                                    Blog posts
                                    <a href="{{route('blogs.create',$username)}}" class="btn btn-primary float-right"><i class="fa fa-pencil"></i> Add a new post</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed w-100" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th><th>Title</th><th>Author</th><th>Status</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th><th>Title</th><th>Author</th><th>Status</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($blogs as $blog)
                                    <tr>
                                        <td><a href="{{route('blogs.edit',array($username,$blog->id))}}">{{date("Y-m-d H:i", strtotime($blog->created_at))}}</a></td>
                                        <td><a href="{{route('blogs.edit',array($username,$blog->id))}}">{{$blog->title}}</a></td>
                                        <td><a href="{{route('blogs.edit',array($username,$blog->id))}}">{{$blog->user->name}}</a></td>
                                        <td><a href="{{route('blogs.edit',array($username,$blog->id))}}">{{$blog->status}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No posts have been added yet</td></tr>
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