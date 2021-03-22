const SpotifyWebApi = require("spotify-web-api-js");

window.onSpotifyWebPlaybackSDKReady = () => {
    const VCSpotify = (function () {
        return {
            init() {
                this.spotifyAPI = new SpotifyWebApi();
                this.token = null;
                this.prevSearch = null;
                this.playing = true;
                this.currentSong = 'spotify:track:4kzvAGJirpZ9ethvKZdJtg';
                this.player = new Spotify.Player({
                    name: 'VibeCity',
                    getOAuthToken: async callback => {
                        const response = await fetch("/refreshSpotifyToken", {
                            headers: {
                                "Accept": "text/plain",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            method: "get",
                            credentials: "same-origin"
                        });

                        this.token = await response.text();
                        console.log("Spotify Token: " + this.token);
                        callback(this.token);
                    },
                    volume: 1.0
                });
                this.connectPlayer();
                let x = setInterval(() => {
                    if (this.token !== null) {
                        clearInterval(x);
                        this.spotifyAPI.setAccessToken(this.token);
                        document.getElementById('loader').style.display = 'none';
                    }
                }, 100);
                this.cacheDOM();
                this.bindEvents();
            },
            cacheDOM() {
                // this.addSongStartButton = document.getElementById("addSongStart");
                // this.closeSearchButton = document.getElementById("closeSearchButton");
                // this.spotifySearchButton = document.getElementById("spotifySearch");
                this.spotifyPlayPauseButton = document.getElementById("togglePlayPause");
                this.albumArt = document.getElementById("albumArt");
            },
            bindEvents() {
                // this.addSongStartButton.addEventListener("click", this.addSongStart.bind(this));
                // this.closeSearchButton.addEventListener("click", this.closeSearchModal.bind(this));
                // this.spotifySearchButton.addEventListener('input', this.spotifySearch.bind(this));
                this.spotifyPlayPauseButton.addEventListener('click', this.togglePlayPause.bind(this));
                this.player.addListener('ready', ({ device_id }) => {
                    this.device_id = device_id;
                    console.log('Device ID: ' + device_id);
                    this.spotifyAPI.transferMyPlayback([this.device_id], {
                        play: false
                    }).then(_ => {
                        this.playSong(this.currentSong);
                    });
                });
            },
            connectPlayer() {
                const iframe = document.querySelector('iframe[src="https://sdk.scdn.co/embedded/index.html"]');
                if (iframe) {
                    iframe.style.display = 'block';
                    iframe.style.position = 'absolute';
                    iframe.style.top = '-1000px';
                    iframe.style.left = '-1000px';
                }
                this.player.connect().then(success => {
                    if (success) {
                        console.log('The Web Playback SDK successfully connected to Spotify!');
                    }
                });
            },
            getCurrentSong() {

            },
            async getPlaybackInfo() {
              let info = await this.spotifyAPI.getMyCurrentPlaybackState();
              return info;
            },
            addSongStart() {
                console.log('adding song');
                document.getElementById('searchModal').style.display= "block";
            },
            closeSearchModal() {
                document.getElementById('searchModal').style.display= "";
            },
            spotifySearch(query) {
                this.prevSearch = this.spotifyAPI.searchTracks(query, { limit: 5 });
                this.prevSearch.then((data) => {
                    this.prevSearch = null;
                    console.log(data)
                }, (err) => {
                    this.prevSearch.abort();
                    console.error(err);
                });
            },
            async playSong(uri, position = 0) {
                await this.spotifyAPI.play({
                    uris: [uri],
                    position_ms: position
                }).then(() => {
                    this.getPlaybackInfo().then((res) => {
                        this.albumArt.style = `background-image:url(\'${res.item.album.images[0].url}\')`;
                    });
                });
            },
            togglePlayPause() {
                this.player.togglePlay().then(() => {
                    console.log('Toggled playback!');
                    if (this.playing) {
                        this.spotifyPlayPauseButton.className = "far fa-pause-circle fa-3x";
                    } else {
                        this.spotifyPlayPauseButton.className = "far fa-play-circle fa-3x";
                    }
                    this.playing = !this.playing;
                });
            }
        }
    }());

    let spotify = VCSpotify;
    spotify.init();
}

