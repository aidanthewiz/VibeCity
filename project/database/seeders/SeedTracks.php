<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Aerni\Spotify\Facades\SpotifyFacade;
use App\Models\Track;

class SeedTracks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // grab the top 50 tracks for the US from spotify
        $tracks = SpotifyFacade::playlistTracks('37i9dQZEVXbMDoHDwVN2tF')->market('US')->get();

        // for each track, add to the db
        foreach ($tracks['items'] as $track) {
            $artist = $track['track']['artists']['0']['name'];
            $name = $track['track']['name'];

            // fill with the song if not already added
            Track::firstOrCreate([
                'name' => $name,
                'artist' => $artist,
            ]);
        }

    }
}
