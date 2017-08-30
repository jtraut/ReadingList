@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reading List</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
					<div class="col-md-6" style="float:right">
						<p><img src="http://images.clipartpanda.com/book-20clip-20art-Book4.jpg" alt="Stack of books"></p>
					</div>
					@if(!Auth::guest())
						@if(Auth::user()->hasBooks()) <!-- if list not empty-->
							 <div class="">
								@foreach( $books as $book )
									<div>
										<p style="font-size: 14px;">	
											<a href="{{ url('/books/'.$book->slug) }}">{{ $book->title }}</a>
											 by {{ $book->author }}
										</p>										
									</div>
								@endforeach
								{!! $books->render() !!}
							</div>
						@else
							Your reading list is empty, go add some new books!
						@endif
					@else
						Please register or log in to get started on your reading list
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
