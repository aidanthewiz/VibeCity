<x-app-layout>
    <style>
        .closeAndOpenButton{
            float: right;
        }
    </style>
<div class="flex min-w-full min-h-full p-4 justify-center items-center content-center align-content justify-self-center align-center self-center">
    <div class="grid grid-rows-1 bg-gray-900 min-h-full min-w-full md:p-7 pt-3 pb-3 rounded sm:max-w-4xl sm:m-8 md:m-4 bg-gray-900 shadow-md sm:rounded-lg self-center align-center items-center align-content content-center">
        <div class="border-b-2 border-white">
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
            <!-- Delete party button -->
            @if($party[0]['partyCreator'] == Auth::user()->id)
            <form method="POST" action="{{ route('/party/deleteParty', [$party[0]['id']]) }}" class="inline-block">
                    @csrf
                    <button dusk="delete-party-button" class="mb-4 ml-2 bg-red-600 hover:bg-red-800 text-black font-bold py-1 px-4 rounded">
                        {{ __('Delete Party') }}
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
                    <button dusk="copy-button" class="mb-4 ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                        {{\App\Models\JoinCode::where('id', $party[0]['joinCode'])->get()->toArray()[0]['code']}}
                    </button>
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
    <script src="https://sdk.scdn.co/spotify-player.js"></script>
    <script>
        window.onSpotifyWebPlaybackSDKReady = () => {
          var player = new Spotify.Player({
              name: 'Spotify Player',
              getOAuthToken: callback => {
                //TODO: import spotify access token
                callback('access token here');
              },
              volume: 1.0
            });
        };
    </script>
    <div class="flex min-h-full min-w-full justify-center align-content content-center items-center sm:items-center md:rounded-tr-lg md:rounded-br-lg justify-self-center">
            <!-- Grid for song and party -->
            <div class="min-w-full min-h-full">
                <div class="grid grid-cols-3 min-h-full min-w-full items-center justify-center sm:items-center text-center align-content content-center">
                    <!-- Current Song -->
                    <div class="col-span-2 md:p-12 min-h-full min-w-full items-center justify-center sm:items-center text-center content-center">
                        <div class="grid grid-rows-1 min-h-full min-w-full md:m-12 h-full w-full items-center justify-center sm:items-center text-center content-center align-center align-content">
                            <div class="min-h-full min-w-full pt-20 pb-20">
                                <div class="text-white md:text-2xl text-lg">
                                    Current Song:
                                </div>
                                <div class="border-b-2 h-2 w-full border-white align-bottom"></div>
                                <div class="text-yellow-600 md:text-2xl text-lg">
                                    Pending
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- In Party -->
                    <div class="grid grid-rows-4 min-h-full">
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
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
