<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Books;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$id = auth()->user()->id;
		$books = Books::where('userID', $id)->orderBy('title','desc')->paginate(10);
		return view('home')->withBooks($books);
    }
}
