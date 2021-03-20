<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartyController;

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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [LeaderboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/dashboard/{track_id}', [LeaderboardController::class, 'showTrackComments'])->name('trackComments');
    Route::post('/dashboard/addComment', [LeaderboardController::class, 'addTrackComment'])->name('addTrackComment');
    Route::post('/dashboard/deleteComment', [LeaderboardController::class, 'deleteTrackComment'])->name('deleteTrackComment');
    Route::get('/spotifyDashboard', [LeaderboardController::class, 'showSpotify'])->name('spotifyDashboard');
    Route::get('/party', 'App\Http\Controllers\PartyController@show')->name('party');
    Route::get('/party/createJoinCode', 'App\Http\Controllers\JoinCodeController@createJoinCode')->name('/party/createJoinCode');
    Route::get('/refreshSpotifyToken', [UserController::class, 'refreshSpotifyToken'])->name('refreshSpotifyToken');
    Route::post('/party/createParty', 'App\Http\Controllers\PartyController@createParty')->name('/party/createParty');
    Route::post('/party/joinWithCode', 'App\Http\Controllers\PartyController@joinWithCode')->name('/party/joinWithCode');
    Route::post('/party/deleteParty/{partyID}', 'App\Http\Controllers\PartyController@deleteParty')->name('/party/deleteParty');
    Route::post('/party/leaveParty/', 'App\Http\Controllers\PartyController@leaveParty')->name('/party/leaveParty');
    Route::post('/dashboard/rateTrack/{track_id}', [LeaderboardController::class, 'rate'])->name('rateTrack');
    Route::post('/party/closeParty/{party_id}', 'App\Http\Controllers\PartyController@closeParty')->name('/party/closeParty');
    Route::post('/party/openParty/{party_id}', 'App\Http\Controllers\PartyController@openParty')->name('/party/openParty');
});

Route::get('/linkSpotify', [UserController::class, 'linkSpotify'])->name('linkSpotify');
