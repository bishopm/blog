<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text" value="{{$blog->title}}">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text" value="{{$blog->slug}}">
</div>
{{ Form::bsText('image_title','Image title','Image title', $blog->image_title) }}
<div class='form-group '>
  <label for="tags">Tags</label>
  <select name="tags[]" class="input-tags" multiple>
  @foreach ($tags as $tag)
    @if ((count($btags)) and (in_array($tag->name,$btags)))
        <option selected value="{{$tag->name}}">{{$tag->name}}</option>
    @else
        <option value="{{$tag->name}}">{{$tag->name}}</option>
    @endif
  @endforeach
  </select>
</div>
{{ Form::bsSelect('status','Status',array('Draft','Published'),$blog->status) }}
{{ Form::bsText('created_at','Publication date','Publication date', $blog->created_at) }}
{{ Form::bsHidden('user_id',$blog->user_id) }}
@if (!$media)
  {{ Form::bsFile('image') }}
@else
  <div id="thumbdiv">
    {{ Form::bsImgpreview(url('/storage/blogs') . '/' . $media->basename,120,'Image') }}
  </div>
  <div id="filediv" style="display:none;">
    {{ Form::bsFile('image') }}
  </div>
@endif
{{ Form::bsTextarea('summary','Summary','Summary', $blog->summary) }}
{{ Form::bsTextarea('body','Body','Body',$blog->body) }}