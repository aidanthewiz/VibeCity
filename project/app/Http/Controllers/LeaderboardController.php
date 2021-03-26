<?php

namespace App\Http\Controllers;

use Aerni\Spotify\Facades\SpotifyFacade;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Track;
use Carbon\Carbon;
use Database\Seeders\SeedTracks;
use Illuminate\Http\Request;
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
        $tracks = Track::with('comments')->with('ratings')->get()->sortby('name')->sortByDesc('rating');

        // counter to help keep track of color swapping
        $count = 0;

        // show the dashboard page with the tracks
        return view('dashboard', ['tracks' => $tracks, 'count' => $count, 'track_comments_id' => null]);
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

    /**
     * Shows a comment modal on the screen
     * @param $trackId
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public static function showTrackComments($trackId, Request $request)
    {
        // order the tracks by their names, then sort by descending rating so highest track with first name is at top
        $tracks = Track::with('comments')->with('ratings')->get()->sortby('name')->sortByDesc('rating');

        $timezone = $request->input('timezone');

        // counter to help keep track of color swapping
        $count = 0;

        // return the dashboard with the track comment id
        return view('dashboard', ['tracks' => $tracks, 'count' => $count, 'track_comments_id' => $trackId, 'timezone' => $timezone]);
    }

    /**
     * Shows a comment modal on the screen
     * @param $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public static function addTrackComment(Request $request)
    {
        // comment content and track id
        $commentContent = $request->input('comment-content');
        $track_id = $request->input('comment-track-id');

        // create a new comment for the user on the track
        Comment::Create([
            'content' => $commentContent,
            'user_id' => Auth::user()->id,
            'track_id' => $track_id,
        ]);

        // return the dashboard
        return back()->withInput();
    }

    /**
     * Shows a comment modal on the screen
     * @param $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public static function deleteTrackComment(Request $request)
    {
        // get the comment id and track id from the request
        $commentId = $request->input('comment-id');

        // find the comment and delete it
        $comment = Comment::query()->where('id', '=', $commentId)->first();
        $comment->delete();

        // return the dashboard
        return back();
    }

    /**
     * @param $value
     * @return Carbon
     */
    public static function getCreatedAtAttribute($value, $timezone)
    {
        $newTimezone = optional(auth()->user())->timezone ?? $timezone;
        return Carbon::parse($value)->timezone($newTimezone);
    }

}
