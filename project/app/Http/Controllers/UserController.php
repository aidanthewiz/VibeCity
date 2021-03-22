<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller
{
    /**
     * Redirect the user to the authentication page for the provider.
     *
     * @return RedirectResponse
     */
    public function linkSpotify()
    {
        return Socialite::driver('spotify')->scopes(["streaming", "user-read-email", "user-read-private", "user-read-playback-state", "user-modify-playback-state", "user-read-currently-playing", "user-read-playback-position", "user-read-recently-played", "user-top-read", "app-remote-control"])->redirect();
    }

    /**
     * Refreshes the user's spotify token.
     *
     * @return string
     */
    public function refreshSpotifyToken()
    {
        $current_refresh_token = DB::table('connected_accounts')->where('user_id', '=', Auth::user()->id)->value('refresh_token');

        $response = Http::asForm()->withHeaders([
            'Authorization' => 'Basic ' . base64_encode(config('spotify.auth.client_id') . ':' . config('spotify.auth.client_secret'))
        ])->post('https://accounts.spotify.com/api/token', [
            'refresh_token' => $current_refresh_token,
            'grant_type' => 'refresh_token',
        ]);

        return json_decode($response->body(), true)['access_token'] ?? '';
    }

     /**
     * Gets the user's spotify token.
     *
     * @return string
     */
    public function getSpotifyToken()
    {
        return DB::table('connected_accounts')->where('user_id', '=', Auth::user()->id)->value('token');
    }
}
