<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sortAuthor', 'HomeController@sortAuthor')->name('sortAuthor');

// show new book form
Route::get('/books/add','BookController@create')->name('new-book');

// save new book
Route::post('/books/add','BookController@store')->name('new-book');

// display book
Route::get('/books/{slug}', 'BookController@show');

// edit book form
Route::get('edit/{slug}','BookController@edit');

// update book
Route::post('update','BookController@update');

// delete book
Route::get('delete/{id}','BookController@destroy');

// display user's all posts
Route::get('list-books','UserController@list');


