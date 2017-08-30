@extends('layouts.app')

@section('content')

<script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
	tinymce.init(
	{
		selector : "textarea",
		plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste jbimages"],
		toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	}); 
</script>

<form action="{{ route('new-book') }}" method="POST" class="container">
	<h3>Add New Book</h3>
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<p>Title</p>
		<input required="required" placeholder="Enter title here" type="text" name="title" class="form-control" value="{{ old('title') }}"/>
	</div>
	<div class="form-group">
		<p>Author</p>
		<input required="required" placeholder="Written by" type="text" name="author" class="form-control" value="{{ old('author') }}"/>
	</div>	
	
	<div class="form-group">
		<p>Details</p>
		<textarea name='details'class="form-control">{{ old('details') }}</textarea>
	</div>

	<div class="form-group">
		{!! Form::label('Select genre') !!}<br />
		{!! Form::select('genre', 
		$genres, 
		'', 
		['class' => 'form-control']) !!}		
	</div>	
	
	<div class="form-group">
		
		{!! Form::label('Date Published') !!}<br />
		{!! Form::text('published', 
			'',
			['id' => 'datepicker', 'class' => 'form-control']) !!}
	</div>
	
	<input type="submit" name='publish' class="btn btn-success" value = "Add"/>
	<input type="submit" name='cancel' class="btn btn-danger" value = "Cancel" />	
</form>
@endsection
