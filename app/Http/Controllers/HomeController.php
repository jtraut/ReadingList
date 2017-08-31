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
		$books = Books::where('userID', $id)->orderBy('listOrder','asc')->paginate(15);
		return view('home')->withBooks($books);
    }
    
    public function sortAuthor()
    {
		$id = auth()->user()->id;
		$books = Books::where('userID', $id)->orderBy('author','asc')->paginate(15);
		return view('home')->withBooks($books);		
	}

    public function sortTitle()
    {
		$id = auth()->user()->id;
		$books = Books::where('userID', $id)->orderBy('title','asc')->paginate(15);
		return view('home')->withBooks($books);		
	}
	
	public function moveUp($listOrder)
	{
		$id = auth()->user()->id;
		$books = Books::where('userID', $id)->orderBy('listOrder','asc')->paginate(30);
		foreach ($books as $book){
			if ($book->listOrder == $listOrder){
				$book->listOrder = $prevBook->listOrder;
				$prevBook->listOrder = $listOrder;
				$book->save();
				$prevBook->save();
				return redirect('/home')->withBooks($books);			
			}
			$prevBook = $book;
		}
		return redirect('/home')->withBooks($books);
	}
	
	public function moveDown($listOrder)
	{
		$id = auth()->user()->id;
		$books = Books::where('userID', $id)->orderBy('listOrder','asc')->paginate(30);	
		for ($i = 0; $i < sizeof($books)-1; $i++){
			$book = $books[$i];
			if ($book->listOrder == $listOrder){
				$nextBook = $books[$i+1];
				$book->listOrder = $nextBook->listOrder;
				$nextBook->listOrder = $listOrder;
				$book->save();
				$nextBook->save();
				return redirect('/home')->withBooks($books);			
			}
		}
		return redirect('/home')->withBooks($books);		
	}
}
