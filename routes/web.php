<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\NYTimesBooksController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books', [BookController::class, 'showBooks'])->name('books.show');
Route::get('/proxy/books', [BookController::class, 'getBooks'])->name('proxy.books');
Route::get('/', [NYTimesBooksController::class, 'fetchData']);
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
Route::get('/books/results', [BookController::class, 'results'])->name('books.results');
Route::get('/author/{authorKey}', [BookController::class, 'authorBooks'])->name('author.books');
Route::get('/books/{category}', [BookController::class, 'show'])->name('books.show');
Route::get('/book/{id}', [BookController::class, 'details'])->name('book.details');
Route::get('/book/works/{id}', [BookController::class, 'details'])->name('book.works.details');
