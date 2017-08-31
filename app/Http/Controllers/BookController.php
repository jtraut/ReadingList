<?php

namespace App\Http\Controllers;

use App\Books;
use App\User;
use App\Genre;
use DateTime;

use Illuminate\Http\Request;

class BookController extends Controller
{
	/**
	 * Display a listing of the books.
	 *
	 * @return Response
	 */
	public function index()
	{
		$books = Books::where('userID', auth()->user()->id)->orderBy('listsOrder','desc')->paginate(15);
		return view('home')->withBooks($books);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$genres = Genre::pluck('name', 'id');	
		return view('books.add')->with('genres', $genres);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$books = Books::where('userID', auth()->user()->id)->orderBy('title','desc')->paginate(10);
		if($request->has('cancel'))
		{
			return redirect('/home');
		}
				
		$book = new Books();
		$book->title = $request->title;
		$book->author = $request->author;
		$book->userID = $request->user()->id;
		
		$slugStr = $book->title . $book->userID; //could include author in slug for same title different author case
		$book->slug = str_slug($slugStr);
		$duplicate = Books::where('slug',$book->slug)->first();
		if($duplicate)
		{
			return redirect('books/add')->withErrors('Book already exists in your list.')->withInput();
		}	
		
		$book->details = $request->details;		
		$genreArr = Genre::where('id', $request->genre)->pluck('name'); 
		$book->genre = $genreArr[0];
		$formatDate = date('Y-m-d', strtotime($request->published));
		$book->published = new DateTime($formatDate);
		
		$listInt = sizeof($books) + 1;
		$listStr = (string)$listInt;
		$listStr = (string)$book->userID . $listStr;
		$book->listOrder = (int)$listStr;
		
		$message = 'Book added successfully';
		$book->save();
		
		return redirect('/home')->withBooks($books)->withMessage($message);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$book = Books::where('slug',$slug)->first();

		if($book)
		{
			return view('books.show')->withBook($book);
		}
		else 
		{
			$books = Books::where('userID', auth()->user()->id)->orderBy('title','desc')->paginate(10);
			return redirect('/home')->withErrors('requested book not found')->withBooks($books);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Request $request,$slug)
	{
		$book = Books::where('slug',$slug)->first();
		if($book && ($request->user()->id == $book->userID))
		{
			$genres = Genre::pluck('name', 'id');
			$genreID = Genre::where('name', $book->genre)->pluck('id');
			$books = Books::where('userID', auth()->user()->id)->orderBy('title','desc')->paginate(10);
			return view('books.edit')->with('book',$book)->with('genres', $genres)->with('genreID', $genreID);
		}
		else 
		{
			$books = Books::where('userID', auth()->user()->id)->orderBy('title','desc')->paginate(10);
			return redirect('/home')->withErrors('you do not have sufficient permissions')->withBooks($books);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		$books = Books::where('userID', auth()->user()->id)->orderBy('title','desc')->paginate(10);
		if($request->has('cancel'))
		{
			return redirect('/home')->withBooks($books);
		}
		
		$bookID = $request->input('id');
		$book = Books::find($bookID);
		if($book && $book->userID == $request->user()->id)
		{
			$title = $request->input('title');
			$slugStr = $title . $book->userID;
			$slug = str_slug($slugStr); 
			$duplicate = Books::where('slug',$slug)->first();
			if($duplicate)
			{
				if($duplicate->id != $bookID)
				{
					return redirect('edit/'.$book->slug)->withErrors('Duplicate book in list.')->withInput();
				}
				else 
				{
					$book->slug = $slug;
				}
			}
			
			$book->title = $title;
			$book->details = $request->input('details');
			$genreArr = Genre::where('id', $request->input('genre'))->pluck('name');
			$book->genre = $genreArr[0];
			
			$formatDate = date('Y-m-d', strtotime($request->input('published')));
			$book->published = new DateTime($formatDate);	
			
			
			$message = 'Book updated successfully';
			$landing = 'books/'.$book->slug;
			
			$book->save();
	 		return redirect($landing)->withMessage($message);
		}
		else
		{
			return redirect('/home')->withErrors('you do not have sufficient permissions')->withBooks($books);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		$book = Books::find($id);
		if($book && $book->userID == $request->user()->id)
		{
			$book->delete();
			$data['message'] = 'Book deleted Successfully';
		}
		else 
		{
			$data['errors'] = 'Invalid Operation. You have not sufficient permissions';
		}
		$books = Books::where('userID', auth()->user()->id)->orderBy('listOrder','asc')->paginate(15);
		return redirect('/')->with($data)->withBooks($books);
	}
}
