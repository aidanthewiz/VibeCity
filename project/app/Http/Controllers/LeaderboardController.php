<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Track;
use Database\Seeders\SeedTracks;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    /**
     * Display the specified resource.
     *
     *  @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAll()
    {
        // ensure DB is populated if empty
        $this->populateTop50();

        // order the tracks by their names, then sort by descending rating so highest track with first name is at top
        $tracks = Track::all()->sortby('name')->sortByDesc('rating');

        // counter to help keep track of color swapping
        $count = 0;

        // show the dashboard page with the tracks
        return view('dashboard', ['tracks' => $tracks, 'count' => $count]);
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

        // if no rating for this track & user combo
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
        }

        // return to the dashboard screen
        return back()->withInput();
    }
}
