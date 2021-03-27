@if(config('app.dusk_testing') != "true")
<script src="https://sdk.scdn.co/spotify-player.js"></script>
<script src="{{ mix('/js/spotify.js') }}"></script>
@endif
<x-app-layout>
    <script src="https://kit.fontawesome.com/d29e89fb40.js" crossorigin="anonymous"></script>
    <style>
        #loader {
            position:absolute;
            top:0;
            left:0;
            background-color:rgb(17, 24, 39);
            width:100vw;
            height:100vh;
            z-index:100;
            color:white;
            font-size:20px;
            display:flex;
            align-items:center;
            text-align:center;
        }
        #loader div {
            width:100%;
        }
    </style>
    @if(config('app.dusk_testing') != "true")
    <div id="loader">
        <div>LOADING...</div>
    </div>
    @endif
    <div class="flex flex-1 flex-col min-w-full p-4 items-center">
        <div class="flex-1 flex flex-col bg-gray-900 sm:min-w-full md:p-7 pt-3 pb-3 rounded sm:m-8 md:m-4 bg-gray-900 shadow-md sm:rounded-lg">
            <div class="pl-2 md:pl-0 border-b-2 mb-3 md:mb-0">
                @if (!$party)
                    <meta name="inParty" content="false">
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-12">
                        <form method="POST" action="{{'/party/createParty'}}" class="block col-span-2 md:col-span-1">
                            @csrf
                            <button dusk="party-button" class="sm:mt-2 sm:mb-4 pl-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                                {{ __('Create Party') }}
                            </button>
                        </form>
                        <div class="sm:mt-2 sm:mb-4 text-white col-span-2 md:col-span-1 pr-5 text-left sm:text-center font-bold">
                            OR
                        </div>
                        <div class="col-span-2 md:col-span-4">
                            <form method="POST" action="{{ route('/party/joinWithCode') }}" class="block float-left">
                                @csrf
                                <div class="grid grid-cols-3">
                                    <div class="col-span-1">
                                        <button dusk="join-with-code-button" class="mt-2 mb-4 pl-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                                            {{__('Join Party')}}
                                        </button>
                                    </div>
                                    <div class="ml-2 col-span-2">
                                        <label for="party_join_code" class="sr-only">Party Join Code</label>
                                        <input id="party_join_code" class="placeholder-white block mt-1 w-full bg-transparent text-gray-200" type="text" name="party_join_code" placeholder="Party Join Code*" required />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                @if ($party)
                        <div class="md:invisible mb-2 md:mb-0 mr-2 md:mr-0 ml-2 bg-red-600 text-black font-bold py-1 px-2 rounded">
                            <p style="text-align:center">PARTY PAGE IS NOT OPTIMIZED FOR MOBILE</p>
                        </div>
                    <meta name="inParty" content="true">
                    <!-- Delete party button && Kick User Button -->
                    @if($party[0]['partyCreator'] == Auth::user()->id)
                        <form method="POST" action="{{ route('/party/deleteParty', [$party[0]['id']]) }}" class="inline-block">
                            @csrf
                            <button dusk="delete-party-button" class="md:mb-4 ml-2 bg-red-600 hover:bg-red-800 text-black font-bold py-1 px-4 rounded">
                                {{ __('Delete Party') }}
                            </button>
                        </form>
                        @if($party[0]['kickEnabled'] == false && $party[0]['joinCode'] != null)
                            <form method="POST" action="{{ route('/party/enableKick', [$party[0]['id']]) }}" class="inline-block">
                                @csrf
                                <button dusk="kick-user-button" class="md:mb-4 ml-2 bg-red-600 hover:bg-red-800 text-black font-bold py-1 px-4 rounded">
                                    Show Kick
                                </button>
                            </form>
                        @elseif($party[0]['joinCode'] != null)
                            <form method="POST" action="{{ route('/party/disableKick', [$party[0]['id']]) }}" class="inline-block">
                                @csrf
                                <button dusk="hide-kick-user-button" class="md:mb-4 ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                                    Hide Kick
                                </button>
                            </form>
                        @endif
                    @endif
                    <!-- Leave Party button -->
                    @if($party[0]['partyCreator'] != Auth::user()->id)
                        <form method="POST" action="{{ route('/party/leaveParty') }}" class="inline-block">
                            @csrf
                            <button dusk="leave-party-button" class="mb-4 ml-2 bg-red-600 hover:bg-red-800 text-black font-bold py-1 px-4 rounded">
                                {{ __('Leave Party') }}
                            </button>
                        </form>
                    @endif

                    @if ($party[0]['joinCode'] == null)
                        @if ($party[0]['partyCreator'] == Auth::user()->id)
                            <form method="GET" action="{{'/party/createJoinCode'}}" class="inline-block">
                                <button dusk="join-code-button" class="mb-4 ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                                    {{ __('Create Join Code') }}
                                </button>
                            </form>
                        @endif
                    @endif
                    @if ($party[0]['joinCode'] != null)

                        <!-- Join Code Button -->
                        <button dusk="copy-button" class="mb-4 ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                            {{\App\Models\JoinCode::where('id', $party[0]['joinCode'])->get()->toArray()[0]['code']}}
                        </button>

                        <!-- Twitter Button -->
                        <div dusk="twitterButton" class="md:float-right inline-block">
                             <a class="btn" href="https://twitter.com/intent/tweet?text=Hey%20join%20my%20VibeCity%20Party%20.%20The%20code%20is -> {{\App\Models\JoinCode::query()->where('id','=',$party[0]['joinCode'])->first()->code}}%20vibecity.us" target="_blank">
                                 <i class="fab fa-twitter"></i>
                             </a>
                        </div>
                        @if($party[0]['partyOpen'] == true && $party[0]['partyCreator'] == Auth::user()->id)
                            <form method="POST" action="{{ route('/party/closeParty', [$party[0]['id']]) }}" class="md:float-right inline-block">
                                @csrf
                                <button dusk="close-party-button" class=" ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                                    {{ __('Close Party') }}
                                </button>
                            </form>
                        @elseif($party[0]['partyOpen'] == false && $party[0]['partyCreator'] == Auth::user()->id)
                            <form method="POST" action="{{ route('/party/openParty', [$party[0]['id']]) }}" class="md:float-right inline-block">
                                @csrf
                                <button dusk="open-party-button" class=" ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                                    {{ __('Open Party') }}
                                </button>
                            </form>
                        @endif
                    @endif
                @endif
            </div>
            <style>
                .host-controls {
                    display:flex;
                    position:relative;
                    padding:0;
                }
                .host-controls .song-cover {
                    width:100px;
                    height:100px;
                    background-color:rgb(17, 24, 39);
                    background-position:center;
                    background-size:cover;
                }
                .host-controls .controls {
                    display:flex;
                    flex:1;
                    justify-content: space-evenly;
                    align-items: center;
                }
                .progress-bar {
                    height:5px;
                    width:100%;
                    position:absolute;
                    left:0;
                    bottom:0;
                    transition: height 0.5s;
                }
                .progress-bar:hover {
                    height:15px;
                }
                .progress-bar .progress {
                    width:0%;
                    max-width:100%;
                    min-width:0%;
                    height:100%;
                    background-color:rgb(217, 119, 6);
                }
                .add-song {
                    position:absolute;
                    left:0;
                    top:0;
                    height:100vh;
                    width:100vw;
                    background-color:#00000000;
                    display:none;
                }
                .alt-controls {
                    width:100px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                }
                #spotifySearch {

                }
                .search-bar-container {
                    margin: 0 0 5px 0;
                    width:100%;
                }
                .search-bar-container input {
                    border-radius:5px;
                    border:1px solid #ccc;
                    width:100%;
                }
                #searchResults {
                    display:flex;
                    flex-direction: column;
                }
                .single-search-result {
                    display:flex;
                    margin:5px 0;
                    align-items: center;
                }
                .song-cover {
                    width:69px;
                    height:69px;
                    background-size: cover;
                    background-position: center;
                    margin-right:0px;
                }
                #searchResults h2 {
                    margin-top:5px;
                    font-size:24px;
                    font-weight:bold
                }
                #searchResults h2.all {
                    margin-top:15px;
                }
                .song-info {
                    flex:1
                }
                .top-result .song-info .name {
                    font-size:25px;
                }
                .top-result .song-info .artist {
                    font-size:16px;
                }
                .top-result .song-cover {
                    width:100px;
                    height:100px;
                }
                .queue-song {
                    display:flex;
                    margin:5px 0;
                    align-items: center;
                    color:white;
                    border-top:2px solid #ccc;
                    padding:15px 0;
                }
                .queue-song .song-info{
                    text-align:left;
                }
                .queue-song:first-of-type {
                    border-top:0;
                }
                #displayQueue h2 {
                    color:white;
                    font-size:24px;
                    text-align:left;
                    font-weight:bold;
                    margin-top:5px;
                }
                .host-controls {
                    background-color:rgba(217, 119, 6, 0.5);
                }
            </style>
            <div class="flex flex-1 min-w-full grid grid-cols-1 sm:grid-cols-5">
                <!-- Grid for song and party -->
                <!-- Current Song -->
                <div class="flex-grow-4 min-h-full items-center justify-center sm:items-center text-center content-center col-span-1 sm:col-span-3">
                    <div class="flex flex-col min-h-full">
                        <!-- Host Controls -->
                        <div id="searchModal" class="add-song">
                            <div class="fixed z-10 inset-0 overflow-y-auto">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline" style="margin-bottom:10px;font-weight:bold;font-size:24px;">
                                                Search For A Song
                                            </h3>
                                            <div class="search-bar-container">
                                                <label class="sr-only" for="spotifySearch">Search Spotify Songs</label>
                                                <input type="text" id="spotifySearch" placeholder="Search...">
                                            </div>
                                            <div id="searchResults">

                                            </div>
                                            <template id="topSearchResultTemplate">
                                                <h2>Top Result</h2>
                                                <div class="single-search-result top-result">
                                                    <div class="song-cover"></div>
                                                    <div class="song-info">
                                                        <div class="name"></div>
                                                        <div class="artist"></div>
                                                        <div class="runtime"></div>
                                                    </div>
                                                    <div class="searchControls"><a title="Add Song" class="fas fa-plus fa-3x add-to-queue" href="javascript:void(0);" id="addSongStart"></a></div>
                                                </div>
                                                <h2 class="all">All Results</h2>
                                            </template>
                                            <template id="singleSearchResultTemplate">
                                                <div class="single-search-result">
                                                    <div class="song-cover"></div>
                                                    <div class="song-info">
                                                        <div class="name"></div>
                                                        <div class="artist"></div>
                                                        <div class="runtime"></div>
                                                    </div>
                                                    <div class="searchControls"><a title="Add Song" class="fas fa-plus fa-3x add-to-queue" href="javascript:void(0);" id="addSongStart"></a></div>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button id="closeSearchButton" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Done
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="host-controls">
                            <!-- song cover -->
                            <div class="song-cover" id="albumArt"></div>
                            <a class="bg-blue-500 mr-8" id="twitterLink" style="width:18px;" href="javascript:void(0);" target="_blank">
                                <div class="grid grid-rows-1 text-sm font-bold font-sans text-white">
                                    <div>T</div>
                                    <div>W</div>
                                    <div>E</div>
                                    <div>E</div>
                                    <div>T</div>
                                </div>
                            </a>
                            <div class="controls">
                                <a title="Back" class="fas fa-backward fa-2x" href="javascript:void(0);" id="spotifyPreviousButton"></a>
                                <a class="far fa-play-circle fa-2x" href="javascript:void(0);" id="togglePlayPause"></a>
                                <a title="Forward" class="fas fa-forward fa-2x" href="javascript:void(0);" id="spotifyNextButton"></a>
                                <a class="fas fa-sync fa-2x" href="javascript:void(0);" id="spotifySyncButton"></a>
                            </div>
                            <div class="progress-bar"><div class="progress" id="progressBar"></div></div>
                            <div class="alt-controls">
                                <a title="Add Song" class="fas fa-plus fa-2x" href="javascript:void(0);" id="addSongStart"></a>
                            </div>
                        </div>
                        <div id="displayQueue">

                        </div>
                        <template id="queueItem">
                            <div class="queue-song">
                                <div class="song-cover"></div>
                                <div class="song-info">
                                    <div class="name"></div>
                                    <div class="artist"></div>
                                    <div class="runtime"></div>
                                </div>
                                <div class="searchControls"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- In Party -->
                <div class="mt-2 md:mt-0 md:flex-grow grid grid-rows-6 min-h-full col-span-1 sm:col-span-2">
                    <div class="flex text-white md:text-4xl text-lg border-t-2 md:border-t-0 md:border-l-2 border-b-2 border-white items-center align-center justify-center content-center
                                   row-span-1">
                        <div class="md:ml-4 md:mr-4 md:mb-2">
                            In Party
                        </div>
                    </div>
                    <div class="row-span-5 text-yellow-600 md:border-l-2 border-white">
                        @if ($party)
                            @foreach ($party[0]['users'] as $user)
                                <div class="ml-4 mr-4 mt-2 md:text-xl text-md p-3">
                                    {{$user['name']}}
                                    @if($party[0]['kickEnabled'] == true && $party[0]['partyCreator'] != $user['id'] && Auth::user()->id == $party[0]['partyCreator'])
                                    <form method="POST" action="{{ route('/party/kickUser', [$user['id']])}}" class="inline-block">
                                        @csrf
                                        <input type="hidden" id="user-kicking" name="user-kicking" value="{{ $user['id'] }}">
                                        <button dusk="kick-individual-button" class="ml-1 text-red-500 hover:text-red-800 font-bold">
                                            X
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
