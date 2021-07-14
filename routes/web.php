<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;


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

/*
Route::get('/hai', function () {
    return view('hello');
});
*/

Route::get('/', [SiteController::class, 'index']);
Route::redirect('/articles', '/');
Route::get('/logout', [SiteController::class, 'logout']);
Route::match(['get', 'post'], '/articles/new', [SiteController::class, 'newArticles']);
Route::match(['get', 'post'], '/login', [SiteController::class, 'login']);
Route::match(['get', 'post'], '/register', [SiteController::class, 'register']);
Route::get('/articles/{id}', [SiteController::class, 'getArticles']);
Route::post('/articles/{id}', [SiteController::class, 'Comment']);
Route::get('/articles/update/{id}', [SiteController::class, 'pembaharuanArticles']);
Route::post('/articles/update/{id}', [SiteController::class, 'updateArticles']);
Route::get('/articles/delete/{id}', [SiteController::class, 'deleteArticles']);
Route::get('/articles/publish/{id}', [SiteController::class, 'publishArticles']);