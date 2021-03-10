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
                'rating' => 0,
            ]);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function seedWithPredetermined() {
        // grab the file and get tracks from it
        $file = public_path('../resources/misc/top-50-songs.csv');
        $tracks = $this->getTracksFromCsv($file);

        // if tracks isnt null, fill the db with the data for each track
        if ($tracks != null) {
            for ($idx=0; $idx < count($tracks); $idx++) {
                Track::create([
                    'name' => $tracks[$idx]['Track Name'],
                    'artist' => $tracks[$idx]['Artist'],
                    'rating' => $tracks[$idx]['Streams']
                ]);
            }
        }
    }

    /**
     * Get the tracks from a csv file
     *
     * @param $filename
     * @return array
     */
    private function getTracksFromCsv(string $filename)
    {
        // if no file, return null
        if (!file_exists($filename))
            return null;

        // setup the tracks array and starting column
        $tracks = array();
        $col = null;

        // load the csv and parse it for track info
        if (($tracksFile = fopen($filename, 'r')) !== false)
        {
            // for every row(Track), get the info for that track
            while (($row = fgetcsv($tracksFile, 600, ',')) !== false)
            {
                if (!$col)
                    $col = $row;
                else
                    $tracks[] = array_combine($col, $row);
            }

            // close the file
            fclose($tracksFile);
        }

        // return the array of tracks
        return $tracks;
    }
}
