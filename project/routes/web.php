<?php

use App\Models\Rating;
use App\Models\Track;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartyController;

use app\Http\Controllers\JoinCodeController;
use App\Http\Controllers\LeaderboardController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [LeaderboardController::class, 'showDashboard'])->name('dashboard');

Route::get('reset-password-testpage', function () {
    return view('auth/reset-password-testpage');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/party', 'App\Http\Controllers\PartyController@show')->name('party');

Route::post('/party/createParty', 'App\Http\Controllers\PartyController@createParty')->name('/party/createParty');

Route::post('/party/joinWithCode', 'App\Http\Controllers\PartyController@joinWithCode')->name('/party/joinWithCode');

Route::post('/party/closeParty', 'App\Http\Controllers\PartyController@closeParty')->name('/party/closeParty');

Route::get('/party/createJoinCode', 'App\Http\Controllers\JoinCodeController@createJoinCode')->name('/party/createJoinCode');

Route::post('/dashboard/rateTrack/{track_id}', [LeaderboardController::class, 'rate'])->name('rateTrack');

Route::middleware(['auth:sanctum', 'verified'])->get('/spotifyDashboard', [LeaderboardController::class, 'showSpotify'])->name('spotifyDashboard');
