<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpotifyController extends Controller
{
    /**
     * Save the current party playback state.
     *
     * @return \Illuminate\Http\Response
     */
    public function setState(Request $request)
    {
        $spotify_state = $request->all();

        Party::where('id', '=', Auth::user()->party_id)
            ->update($spotify_state);
    }

    /**
     * Get the current party playback state.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getState(): \Illuminate\Http\JsonResponse
    {
        $spotify_state = Party::select('song_uri', 'song_start_time', 'playing', 'position')->where('id', '=', Auth::user()->party_id)->first();
        return response()
            ->json($spotify_state);
    }
}
