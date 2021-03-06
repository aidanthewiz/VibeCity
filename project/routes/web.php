<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth/register');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', 'App\Http\Controllers\LeaderboardController@showAll')->name('dashboard');

Route::get('reset-password-testpage', function () {
    return view('auth/reset-password-testpage');
});

//Route::middleware(['auth:sanctum', 'verified'])->get('/party', function () {
//    return view('party');
//})->name('party');

Route::middleware(['auth:sanctum', 'verified'])->get('/party', 'App\Http\Controllers\PartyController@show')->name('party');

// Route::post('/party/createParty', 'App\Http\Controllers\PartyController@createParty');

Route::get('/party/createParty', 'App\Http\Controllers\PartyController@createParty')->name('party/createParty');
