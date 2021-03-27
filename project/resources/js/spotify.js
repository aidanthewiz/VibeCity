const SpotifyWebApi = require("spotify-web-api-js");

window.onSpotifyWebPlaybackSDKReady = () => {
    const VCSpotify = (() => {
        return {
            init() {
                this.spotifyAPI = new SpotifyWebApi();
                this.token = null;
                this.prevSearch = null;
                this.startTime = null;
                this.playing = null;
                this.position = null;
                this.duration = null;
                this.updateTime = null;
                this.previousState = null;
                this.inParty = document.querySelector('meta[name=inParty]').content == 'true';
                this.currentSong = null;
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
                    volume: 0.5
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
                setInterval(this.setProgessBarPosFunc, 1000);
            },
            cacheDOM() {
                this.addSongStartButton = document.getElementById("addSongStart");
                this.closeSearchButton = document.getElementById("closeSearchButton");
                this.spotifySearchButton = document.getElementById("spotifySearch");
                this.spotifyPlayPauseButton = document.getElementById("togglePlayPause");
                this.spotifyNextButton = document.getElementById("spotifyNextButton");
                this.spotifyPreviousButton = document.getElementById("spotifyPreviousButton");
                this.spotifySyncButton = document.getElementById("spotifySyncButton");
                this.albumArt = document.getElementById("albumArt");
                this.searchResults = document.getElementById("searchResults");
                this.progressBar = document.getElementById("progressBar");
                this.progressBarParent = document.getElementById("progressBar").parentElement;
                this.displayQueue = document.getElementById("displayQueue");
                this.queueItemTemplate = document.getElementById("queueItem");
                this.twitterLink = document.getElementById('twitterLink');
            },
            bindEvents() {
                this.setProgessBarPosFunc = this.setProgressBarPos.bind(this);
                this.addSongStartButton.addEventListener("click", this.addSongStart.bind(this));
                this.spotifyNextButton.addEventListener("click", this.nextSong.bind(this));
                this.spotifyPreviousButton.addEventListener("click", this.previousSong.bind(this));
                this.spotifySyncButton.addEventListener("click", this.loadCurrentPlaybackState.bind(this));
                this.closeSearchButton.addEventListener("click", this.closeSearchModal.bind(this));
                this.spotifySearchButton.addEventListener('input', this.spotifySearch.bind(this));
                this.spotifyPlayPauseButton.addEventListener('click', this.togglePlayPause.bind(this));
                this.progressBarParent.addEventListener('click', this.seek.bind(this));
                this.player.addListener('ready', ({ device_id }) => {
                    this.device_id = device_id;
                    console.log('Device ID: ' + device_id);
                    this.transferPlayback(false).then(_ => {
                        this.loadCurrentPlaybackState();
                    });
                });
                this.player.addListener('player_state_changed', state => {
                    console.log("Player State Changed: ");
                    console.table({
                        "previousState": this.previousState,
                        "newState": state
                    });
                    if (state === null && this.previousState !== null) {
                        console.log("Switched playback to another device.");
                        this.transferPlayback(true).then(_ => {
                            console.log("Switched playback back to VibeCity.");
                        });
                        return;
                    }
                    if (this.playing !== !state.paused) {
                        this.playing = !state.paused;
                        this.saveCurrentPlaybackState();
                    }
                    this.position = state.position;
                    this.duration = state.duration;
                    this.startTime = Math.floor((Date.now() - this.position) / 1000);
                    this.updateTime = performance.now();
                    this.spotifyPlayPauseButton.className = "far fa-" + (this.playing ? "pause" : "play") + "-circle fa-3x";
                    this.albumArt.style = `background-image:url(\'${state.track_window.current_track.album.images[0].url}\')`;
                    this.twitterLink.href = "https://twitter.com/intent/tweet?text=Vibing%20with%20my%20VibeCity%20party%20to%20" + state.track_window.current_track.name + "%0Avibecity.us";

                    if (this.currentSong !== state.track_window.current_track.uri) {
                        this.currentSong = state.track_window.current_track.uri;
                        this.saveCurrentPlaybackState();
                    }
                    this.previousState = state;

                    //set queue
                    this.displayQueue.innerHTML = '<h2>Upcoming Songs</h2>';
                    state.track_window.next_tracks.forEach(element => {
                        let clone = this.queueItemTemplate.content.cloneNode(true);
                        let topSongCover = clone.querySelectorAll(".song-cover")[0];
                        let topSongName = clone.querySelectorAll(".name")[0];
                        let topSongArtist = clone.querySelectorAll(".artist")[0];
                        let topSongRuntime = clone.querySelectorAll(".runtime")[0];
                        topSongCover.style.backgroundImage = "url('"+element.album.images[1].url+"')";
                        topSongName.textContent = element.name;
                        topSongArtist.textContent = element.artists[0].name;
                        topSongRuntime.textContent = new Date((element.duration_ms/1000) * 1000).toISOString().substr(14, 5);
                        this.displayQueue.appendChild(clone);
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
            async transferPlayback(play) {
                await this.spotifyAPI.transferMyPlayback([this.device_id], {
                    play: play
                });
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
            spotifySearch(eve) {
                let query = eve.target.value;
                this.prevSearch = this.spotifyAPI.searchTracks(query, { limit: 5 });
                this.prevSearch.then((data) => {
                    this.prevSearch = null;
                    this.searchResults.innerHTML = '';


                    //top result
                    let topTemplate = document.getElementById('topSearchResultTemplate');
                    let clone = topTemplate.content.cloneNode(true);
                    let topSongCover = clone.querySelectorAll(".song-cover")[0];
                    let topSongName = clone.querySelectorAll(".name")[0];
                    let topSongArtist = clone.querySelectorAll(".artist")[0];
                    let topSongRuntime = clone.querySelectorAll(".runtime")[0];
                    let topSongAddButton = clone.querySelectorAll(".add-to-queue")[0]
                    topSongCover.style.backgroundImage = "url('"+data.tracks.items[0].album.images[1].url+"')";
                    topSongName.textContent = data.tracks.items[0].name;
                    topSongArtist.textContent = data.tracks.items[0].artists[0].name;
                    topSongRuntime.textContent = new Date(data.tracks.items[0].duration_ms / 1000 * 1000).toISOString().substr(14, 5);
                    topSongAddButton.addEventListener('click', this.addToQueue.bind(this));
                    topSongAddButton.setAttribute('spotify-uri', data.tracks.items[0].uri);
                    this.searchResults.appendChild(clone);


                    //the rest
                    data.tracks.items.forEach(element => {
                        let singleTemplate = document.getElementById('singleSearchResultTemplate');
                        let cloneSingle = singleTemplate.content.cloneNode(true);
                        let singleSongCover = cloneSingle.querySelectorAll(".song-cover")[0];
                        let singleSongName = cloneSingle.querySelectorAll(".name")[0];
                        let singleSongArtist = cloneSingle.querySelectorAll(".artist")[0];
                        let singleSongRuntime = cloneSingle.querySelectorAll(".runtime")[0];
                        let singleSongAddButton = cloneSingle.querySelectorAll(".add-to-queue")[0];
                        singleSongCover.style.backgroundImage = "url('"+element.album.images[2].url+"')";
                        singleSongName.textContent = element.name;
                        singleSongArtist.textContent = element.artists[0].name;
                        console.log('asdfasdfasdf');
                        singleSongRuntime.textContent = new Date(element.duration_ms / 1000 * 1000).toISOString().substr(14, 5);
                        singleSongAddButton.addEventListener('click', this.addToQueue.bind(this));
                        singleSongAddButton.setAttribute('spotify-uri', element.uri)
                        this.searchResults.appendChild(cloneSingle);
                        // this.searchResults.innerHTML += `
                        //     <div class="single-search-result">
                        //         <div class="song-cover" style="background-image:url('`+element.album.images[1].url+`')"></div>
                        //         <div class="song-info">` + element.name + `</div>
                        //     </div>`;
                    });
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
                    console.log("Played song!");
                });
            },
            async previousSong() {
                await this.player.previousTrack().then(() => {
                  console.log('Set to previous track!');
                });
            },
            async nextSong() {
                await this.player.nextTrack().then(() => {
                  console.log('Skipped to next track!');
                });
            },
            async addToQueue(eve) {
                let uri = eve.target.getAttribute('spotify-uri');
                await this.spotifyAPI.queue(uri).then(() => {
                    console.log('Added item to queue: ' + uri);
                });
            },
            async seekToPosition(pos) {
                let newPosition = pos * this.duration;
                await this.player.seek(newPosition).then(() => {
                  console.log('Changed position!');
                  this.position = newPosition;
                  this.saveCurrentPlaybackState();
                });
            },
            async togglePlayPause() {
                await this.player.togglePlay().then(() => {
                    console.log('Toggled playback!');
                });
            },
            async saveCurrentPlaybackState() {
                if (this.inParty) {
                    const data = {
                        "song_uri": this.currentSong,
                        "song_start_time": this.startTime,
                        "playing": this.playing,
                        "position": this.position
                    };
                    await fetch("/setSpotifyState", {
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        method: "post",
                        credentials: "same-origin",
                        body: JSON.stringify(data)
                    });
                } else {
                    console.log("Not in party, playback state not saved.");
                }
            },
            async loadCurrentPlaybackState() {
                if (this.inParty) {
                    let response = await fetch("/getSpotifyState", {
                        headers: {
                            "Accepts": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        method: "get",
                        credentials: "same-origin"
                    });

                    let res = await response.json();
                    console.log("INIT SONG POS: ");
                    console.log(songPosition);
                    console.log("INIT SONG URI: ")
                    console.log(res.song_uri);
                    let songPosition;
                    if (res.playing == 1) {
                        songPosition = (Math.floor(Date.now() / 1000) - res.song_start_time) * 1000;
                    } else {
                        songPosition = res.position;
                    }
                    this.playSong(res.song_uri, songPosition).then(() => {
                        if (res.playing == 0) {
                            this.togglePlayPause();
                        }
                    });
                } else {
                    console.log("Not in party, playback state not recieved.");
                }
            },
            getPlaybackPosition() {
                if (!this.playing) {
                    return (this.position ? this.position : 0) / this.duration;
                }
                let position = this.position + (performance.now() - this.updateTime);
                return (position > this.duration ? this.duration : position) / this.duration;
            },
            setProgressBarPos() {
                let currentProgress = this.getPlaybackPosition();
                this.progressBar.style.width = (currentProgress * 100) + '%';
            },
            async seek(eve) {
                let barWidth = parseInt(window.getComputedStyle(this.progressBarParent).width);
                let clickPos = eve.offsetX;
                let percent = clickPos / barWidth;
                await this.seekToPosition(percent);
            },
        }
    })();

    let spotify = VCSpotify;
    spotify.init();
}

