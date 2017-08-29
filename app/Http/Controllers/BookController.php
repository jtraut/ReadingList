<?php

namespace App\Http\Controllers;

use App\Books;
use App\User;
use App\Genre;

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
		$books = Books::where('entry', '==', 1)->orderBy('title','desc')->paginate(10);
		$title = 'Listed Books';
		return view('books')->withPosts($books)->withTitle($title);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$genres = Genre::lists('name', 'id');	
		return view('books.create')->with('genres', $genres);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if($request->has('cancel'))
		{
			return redirect('/home');
		}
				
		$book = new Books();
		$book->title = $request->get('title');
		$book->author = $request->get('author');
		$book->userID = $request->user()->id;
		
		$slugStr = $book->title . $book->userID; //could include author in slug for same title different author case
		$book->slug = str_slug($slugStr);
		$duplicate = Books::where('slug',$post->slug)->first();
		if($duplicate)
		{
			return redirect('new-post')->withErrors('Book already exists in your list.')->withInput();
		}	
		
		$book->details = $request->get('details');		
		$book->genre = Genre::where('id', $request->get('genre'))->pluck('name'); 
				
		$formatDate = date('Y-m-d', strtotime($request->get('published')));
		$book->published = new DateTime($formatDate);
		
		$message = 'Book added successfully';
		$book->save();
		return redirect('edit/'.$book->slug)->withMessage($message);
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
			return redirect('/')->withErrors('requested book not found');
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
			$genres = Genre::lists('name', 'id');
			$genreID = Genre::where('name', $book->genre)->pluck('id');
		
			return view('books.edit')->with('book',$book)->with('genres', $genres)->with('genreID', $genreID);
		}
		else 
		{
			return redirect('/')->withErrors('you do not have sufficient permissions');
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
		if($request->has('cancel'))
		{
			return redirect('/home');
		}
		
		$bookID = $request->input('bookID');
		$book = Books::find($bookID);
		if($book && $book->userID == $request->user()->id)
		{
			$title = $request->input('title');
			$slugStr = $title . $book->userID;
			$book->slug = str_slug($slugStr); 
			$duplicate = Books::where('slug',$slug)->first();
			if($duplicate)
			{
				if($duplicate->id != $bookID)
				{
					return redirect('edit/'.$post->slug)->withErrors('Duplicate book in list.')->withInput();
				}
				else 
				{
					$book->slug = $slug;
				}
			}
			
			$book->title = $title;
			$book->details = $request->input('details');
			$book->genre = Genre::where('id', $request->input('genre'))->pluck('name');
			
			$formatDate = date('Y-m-d', strtotime($request->input('published')));
			$book->published = new DateTime($formatDate);	
			
			$message = 'Book updated successfully';
			$landing = 'articles/'.$post->slug;
			
			$book->save();
	 		return redirect($landing)->withMessage($message);
		}
		else
		{
			return redirect('/')->withErrors('you do not have sufficient permissions');
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
		
		return redirect('/')->with($data);
	}
}
}
