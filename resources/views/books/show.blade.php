@extends('layouts.app')

@section('content')

@if($book)
<div class="container">	
	<h1>{{ $book->title }}</h1>
	<p style="font-size: 16px;"> {{ $book->genre }} by {{ $book->author }}</p>
	 	
	@if($book->userID == Auth::user()->id)
		<div style="float:right;">
			<button class="btn"><a href="{{ url('edit/'.$book->slug)}}">Edit Book</a></button>
		
			<a class="btn btn-danger" href="{{ url('delete/'.$book->id.'?_token='.csrf_token())}}">Remove Book</a>
		</div>
	@endif
	
	<p>Published {{ date('M d, Y', strtotime($book->published)) }}</p>

	<div>
		{!! $book->details !!}
	</div>	
</div>
@else
Page does not exist
@endif

@endsection
