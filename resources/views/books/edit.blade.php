@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
	tinymce.init(
	{
		selector : "textarea",
		plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste jbimages"],
		toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	}); 
</script>

<form method="POST" action='{{ url("/update") }}' class="container">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="{{ $book->id }}{{ old('id') }}">
	<div class="form-group">
		<p>Title</p>
		<input required="required" placeholder="Enter title here" type="text" name = "title" class="form-control" value="@if(!old('title')){{$book->title}}@endif{{ old('title') }}"/>
	</div>

	<div class="form-group">
		<p>Author</p>
		<input required="required" placeholder="Enter title here" type="text" name = "author" class="form-control" value="@if(!old('author')){{$book->author}}@endif{{ old('author') }}"/>
	</div>
	
	<div class="form-group">
		<p>Details</p>
		<textarea name='body'class="form-control">
			@if(!old('details'))
			{!! $book->details !!}
			@endif
			{!! old('details') !!}
		</textarea>
	</div>
	
	<div class="form-group">
		{!! Form::label('Select a genre') !!}<br />
		{!! Form::select('genre', 
		$genres, 
		$genreID, 
		['class' => 'form-control']) !!}
	</div>	
	
	<div class="form-group">
		{!! Form::label('Date Published (DD/MM/YYYY)') !!}<br />
		{!! Form::text('published', 
			date('m/d/Y', strtotime($book->published)),
			['id' => 'datepicker', 'class' => 'form-control']) !!}
	</div>
	
	<input type="submit" name='publish' class="btn btn-success" value = "Update"/>
	<input type="submit" name='cancel' class="btn btn-danger" value = "Cancel" />	
		
	<a href="{{  url('delete/'.$book->id.'?_token='.csrf_token()) }}" style="float:right" class="btn btn-danger">Delete</a>
</form>
@endsection
