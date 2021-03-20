// https://github.com/jmperez/spotify-web-api-js
const SpotifyWebApi = require("spotify-web-api-js");

window.onSpotifyWebPlaybackSDKReady = () => {
    const spotifyAPI = new SpotifyWebApi();
    const player = new Spotify.Player({
        name: 'VibeCity',
        getOAuthToken: callback => {
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch("/refreshSpotifyToken", {
                headers: {
                    "Accept": "text/plain",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": csrfToken
                },
                method: "get",
                credentials: "same-origin"
            }).then(async res => {
                const token = await res.text();
                spotifyAPI.setAccessToken(token);
                callback(token);
            });
        },
        volume: 1.0
    });

    player.connect().then(success => {
        if (success) {
            console.log('The Web Playback SDK successfully connected to Spotify!');
            spotifyAPI.getArtistAlbums('43ZHCT0cAZBISjO8DG9PnE', function (err, data) {
              if (err) console.error(err);
              else console.log('Artist albums', data);
            });
        }
    })
};
