<?php

namespace App\Http\Controllers;

use Aerni\Spotify\Facades\SpotifyFacade;
use App\Models\Rating;
use App\Models\Track;
use Database\Seeders\SeedTracks;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    /**
     * Displays a database populated leaderboard
     *
     *  @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showDashboard()
    {
        // ensure DB is populated if empty
        $this->populatePredetermined50();

        // order the tracks by their names, then sort by descending rating so highest track with first name is at top
        $tracks = Track::all()->sortby('name')->sortByDesc('rating');

        // counter to help keep track of color swapping
        $count = 0;

        // show the dashboard page with the tracks
        return view('dashboard', ['tracks' => $tracks, 'count' => $count]);
    }

    /**
     * Displays a spotify populated leaderboard
     *
     *  @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showSpotify()
    {
        // grab the top 50 tracks for the US from spotify
        $tracks = $this->getSpotifyTracks();

        // counter to help keep track of color swapping
        $count = 0;

        // show the dashboard page with the tracks
        return view('spotifyDashboard', ['tracks' => $tracks['items'], 'count' => $count]);
    }

    /**
     * Populates tracks with top 50 tracks from spotify
     *
     * @return void
     */
    public static function populateTop50()
    {
        // get the current tracks
        $currTracks = Track::all();

        // if no current tracks, seed the db with tracks
        if (count($currTracks) == 0) {
            $seeder = new SeedTracks();
            $seeder->run();
        }
    }

    /**
     * Populates tracks with top 50 tracks from predetermined spreadsheet
     *
     * @return void
     */
    public static function populatePredetermined50()
    {
        // get the current tracks
        $currTracks = Track::all();

        // if no current tracks, seed the db with tracks
        if (count($currTracks) == 0) {
            $seeder = new SeedTracks();
            $seeder->seedWithPredetermined();
        }
    }

    /**
     * Grabs the spotify top 50 tracks
     *
     */
    public static function getSpotifyTracks()
    {
        // grab the top 50 tracks for the US from spotify and return
        return SpotifyFacade::playlistTracks('37i9dQZEVXbMDoHDwVN2tF')->market('US')->get();
    }

    /**
     * Adds a way to save a new rating for a particular track
     * @param $trackId
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function rate($trackId)
    {
        // search for a rating for this track and user combo
        $rating = Rating::query()->where('track_id', '=', $trackId)
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        // if no rating for this track & user combo, upvote. Otherwise, downvote
        if (!$rating) {
            // create a new rating for the user/track
            Rating::Create([
                'rating' => 1,
                'user_id' => Auth::user()->id,
                'track_id' => $trackId,
            ]);

            // save the rating in the track so that it doesnt have to be searched for a sum
            $track = Track::query()->where('id', '=', $trackId)->first();
            $track->rating = $track->rating + 1;
            $track->save();
        } else {
            $track = Track::query()->where('id', '=', $rating->track->id)->first();
            $track->rating = $track->rating - 1;
            $track->save();
            $rating->delete();
        }

        // return to the dashboard screen
        return back()->withInput();
    }
}
