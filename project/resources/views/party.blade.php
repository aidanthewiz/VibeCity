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
        <div class="flex-1 flex flex-col bg-gray-900 min-w-full md:p-7 pt-3 pb-3 rounded sm:max-w-4xl sm:m-8 md:m-4 bg-gray-900 shadow-md sm:rounded-lg">
            <div>
                @if (!$party)
                    <div class="grid grid-cols-10">
                        <form method="POST" action="{{'/party/createParty'}}">
                            @csrf
                            <button dusk="party-button" class="mt-2 mb-4 ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                                {{ __('Create Party') }}
                            </button>
                        </form>
                        <div class="col-start-2 col-end-5">
                            <form method="POST" action="{{ route('/party/joinWithCode') }}">
                                @csrf
                                <div class="grid grid-cols-2">
                                    <div>
                                        <button dusk="join-with-code-button" class="mt-2 mb-4 ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                                            {{__('Join Party With This Code')}}
                                        </button>
                                    </div>
                                    <div>
                                        <label for="party_join_code" class="sr-only">Party Join Code</label>
                                        <input id="party_join_code" class="placeholder-white block mt-1 w-full bg-transparent text-gray-200" type="text" name="party_join_code" placeholder="Party Join Code*" required />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                @if ($party)
                <!-- Delete party button && Kick User Button -->
                    @if($party[0]['partyCreator'] == Auth::user()->id)
                        <form method="POST" action="{{ route('/party/deleteParty', [$party[0]['id']]) }}" class="inline-block">
                            @csrf
                            <button dusk="delete-party-button" class="mb-4 ml-2 bg-red-600 hover:bg-red-800 text-black font-bold py-1 px-4 rounded">
                                {{ __('Delete Party') }}
                            </button>
                        </form>
                        @if($party[0]['kickEnabled'] == false && $party[0]['joinCode'] != null)
                            <form method="POST" action="{{ route('/party/enableKick', [$party[0]['id']]) }}" class="inline-block">
                                @csrf
                                <button dusk="kick-user-button" class="mb-4 ml-2 bg-red-600 hover:bg-red-800 text-black font-bold py-1 px-4 rounded">
                                    Show Kick
                                </button>
                            </form>
                        @elseif($party[0]['joinCode'] != null)
                            <form method="POST" action="{{ route('/party/disableKick', [$party[0]['id']]) }}" class="inline-block">
                                @csrf
                                <button dusk="hide-kick-user-button" class="mb-4 ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
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
                        <div dusk="twitterButton" class="closeAndOpenButton">
                             <a class="btn" href="https://twitter.com/intent/tweet?text=Hey%20join%20my%20VibeCity%20Party%20.%20The%20code%20is -> {{\App\Models\JoinCode::query()->where('id','=',$party[0]['joinCode'])->first()->code}}%20vibecity.us" target="_blank">
                                 <i class="fab fa-twitter"></i>
                             </a>
                        </div>
                        @if($party[0]['partyOpen'] == true && $party[0]['partyCreator'] == Auth::user()->id)
                            <form method="POST" action="{{ route('/party/closeParty', [$party[0]['id']]) }}" class="closeAndOpenButton inline-block">
                                @csrf
                                <button dusk="close-party-button" class="closeAndOpenButton ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                                    {{ __('Close Party') }}
                                </button>
                            </form>
                        @elseif($party[0]['partyOpen'] == false && $party[0]['partyCreator'] == Auth::user()->id)
                            <form method="POST" action="{{ route('/party/openParty', [$party[0]['id']]) }}" class="closeAndOpenButton inline-block">
                                @csrf
                                <button dusk="open-party-button" class="closeAndOpenButton ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
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
                    width:calc(100% - 100px);
                    position:absolute;
                    left:100px;
                    bottom:0;
                }
                .progress-bar .progress {
                    width:50%;
                    max-width:100;
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
                #spotifySearch {

                }
                #searchResults {

                }
            </style>
            <div class="flex flex-1 min-w-full">
                <!-- Grid for song and party -->
                <!-- Current Song -->
                <div class="flex-grow-4 min-h-full items-center justify-center sm:items-center text-center content-center">
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
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                                        Search Song
                                                    </h3>
                                                    <div>
                                                        <input type="text" id="spotifySearch" palceholde="Search...">
                                                    </div>
                                                    <div id="searchResults">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Add
                                            </button>
                                            <button id="closeSearchButton" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="host-controls">
                            <!-- song cover -->
                            <div class="song-cover" id="albumArt"></div>
                            <div class="controls">
                                <a class="far fa-pause-circle fa-3x" href="javascript:void(0);" id="togglePlayPause"></a>
{{--                                <a href="javascript:void(0);" id="addSongStart">Search Song</a>--}}
                            </div>
{{--                            <div class="progress-bar"><div class="progress"></div></div>--}}
                        </div>
                    </div>
                </div>

                <!-- In Party -->
                <div class="flex-grow grid grid-rows-4 min-h-full">
                    <div class="flex text-white md:text-4xl text-lg border-l-2 border-b-2 border-white items-center align-center justify-center content-center">
                        <div class="md:ml-4 md:mr-4 md:mb-2">
                            In Party
                        </div>
                    </div>
                    <div class="row-span-3 text-yellow-600 border-l-2 border-white">
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
