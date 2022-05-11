<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\TweetTagController;

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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resources([
    'users' => UserController::class,
    'profiles' => ProfileController::class ,
    'tweets' => TweetController::class,
    'tweet-tags' => TweetTagController::class
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profiles/search/{pro}', [ProfileController::class, 'search']);
Route::get('/profiles/{user}/followlist', [FollowController::class, 'show'])->name('followlist');
Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow') ;
