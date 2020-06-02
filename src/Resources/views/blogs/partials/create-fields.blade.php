<div class="form-group">
  <label for="name">Title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text">
</div>
{{ Form::bsText('image_title','Image title','Image title') }}
{{ Form::bsSelect('status','Status',array('Draft','Published')) }}
{{ Form::bsText('created_at','Publication date','Publication date', date('Y-m-d H:i')) }}
{{ Form::bsTextarea('summary','Summary','Summary') }}
{{ Form::bsTextarea('body','Body','Body') }}
{{ Form::bsFile('image') }}
{{ Form::bsHidden('user_id',Auth::user()->id) }}
<div class='form-group '>
  <label for="tags">Tags</label>
  <select name="tags[]" class="input-tags" multiple>
	@foreach ($tags as $tag)
	  <option value="{{$tag->name}}">{{$tag->name}}</option>
	@endforeach
  </select>
</div>