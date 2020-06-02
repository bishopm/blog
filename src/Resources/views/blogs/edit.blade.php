@extends('blog::templates.backend')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <link href="{{ asset('/vendor/bishopm/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop 

@section('content_header')
    {{ Form::pgHeader('Edit blog post','Blogs',route('blogs.index',$username)) }}
@stop

@section('content')
    @include('blog::templates.errors')
    {!! Form::open(['route' => array('blogs.update',$username,$blog->id), 'method' => 'put','files'=>'true']) !!}
    <div class="row">
        <div class="col">
            <div class="card"> 
                <div class="card-body">
                    @include('blog::blogs.partials.edit-fields')
                </div>
                <div class="card-footer">
                    {{Form::pgButtons('Update',route('blogs.index',$username)) }}
                    {!! Form::close() !!}
                    {!! Form::open(['method'=>'delete','style'=>'display:inline;','route'=>['blogs.destroy', $username, $blog->id]]) !!}
                    {!! Form::submit('Delete',array('class'=>'btn btn-danger','onclick'=>'return confirm("Are you sure you want to delete this post?")')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
    <script src="{{ asset('/vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
        });    
        $( document ).ready(function() {
            $('.input-tags').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0,
              maxOptions: 30,
              dropdownParent: "body",
              create: function(value) {
                  return {
                      value: value,
                      text: value
                  }
              },
              onItemAdd: function(value,$item) {
                @if (env('APP_ENV')=="local")
                    $.ajax({ url: "{{url('/')}}/{{$username}}/blogs/addtag/{{$blog->id}}/" + value })
                @else
                    $.ajax({ url: "{{url('/')}}/blogs/addtag/{{$blog->id}}/" + value })
                @endif
              },
              onItemRemove: function(value,$item) {  
                @if (env('APP_ENV')=="local")
                    $.ajax({ url: "{{url('/')}}/{{$username}}/blogs/removetag/{{$blog->id}}/" + value })
                @else
                    $.ajax({ url: "{{url('/')}}/blogs/removetag/{{$blog->id}}/" + value })
                @endif
              }
            });
            $('#created_at').datetimepicker({
                format: 'YYYY-MM-DD HH:mm'
            });
            $('#body').summernote({ 
              height: 250,
              popover: {image: [],link: [],air: []},
              toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['table', ['table']],
                ['link', ['linkDialogShow', 'unlink']],
                ['view', ['fullscreen', 'codeview']],
                ['para', ['ul', 'ol', 'paragraph']]
              ]
            });
            $('.selectize').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0
            });
            $('#title').on('input', function() {
                var slug = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
                $("#slug").val(slug);
            });
        });
        $("#removeMedia").on('click',function(e){
        e.preventDefault();
        $.ajax({
            type : 'GET',
            @if (env('APP_ENV')=="local")
                url : '{{url('/')}}/{{$username}}/blogs/<?php echo $blog->id;?>/removemedia', 
            @else
                url : '{{url('/')}}/blogs/<?php echo $blog->id;?>/removemedia', 
            @endif
            success: function(){
              $('#thumbdiv').hide();
              $('#filediv').show();
            }
        });
    });
    </script>
@stop