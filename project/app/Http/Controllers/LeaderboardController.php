<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Database\Seeders\SeedTracks;

class LeaderboardController extends Controller
{
    /**
     * Display the specified resource.
     *
     */
    public function showAll()
    {
        // ensure DB is populated if empty
        $this->populateTop50();

        // show the dashboard page
        return view('dashboard', ['tracks' => Track::all()->toArray()]);
    }

    /**
     * Populates tracks with top 50 tracks
     *
     */
    private function populateTop50()
    {
        // get the current tracks
        $currTracks = Track::all();

        // if no current tracks, seed the db with tracks
        if (count($currTracks) == 0) {
            $seeder = new SeedTracks();
            $seeder->run();
        }
    }
}
