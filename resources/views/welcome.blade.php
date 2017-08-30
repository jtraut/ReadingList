<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>My Books</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel Book List
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>

<!--BACKUP HOME-->

@extends('app')

@if ( Auth::guest() )
	@section('content')
		<center><div class="containerBody">
			<div class="row">
				<!-- Text Area -->
				<div class="col-md-6" style="padding-left:80px">
					<h1 style="font-size: 28px;font-weight: bold;">Create an account or log in to make the perfect reading list.
					</font>
				</div>
				<!-- Image on Homepage -->
				<div class="col-md-6">
					<p><img src="http://images.clipartpanda.com/book-20clip-20art-Book4.jpg" alt="Stack of books"></p>
				</div>
				
			</div>
		</div></center>
	@endsection
@else
	@section('title')
		<p style="text-align:center">Welcome to Your New Reading List</p>
	@endsection

	@section('content')
		<div class="col-md-6">
			<a href="{{ url('/new-book') }}"><button class="btn" style="width:100%; margin-bottom:15px; font-size:large">Add New Book</button></a>
			<p>Or view your profile:</p>
			<a href="{{ url('/user/'.Auth::id()) }}"><button class="btn" style="width:100%; font-size:large">View Profile</button></a>				

		</div>
		<!-- Image on Homepage -->
		<div class="col-md-6">
			<p><img src="http://cuucomm.colorado.edu/images/UsingApp.png" alt="Using App"></p>
		</div>
	@endsection
@endif
