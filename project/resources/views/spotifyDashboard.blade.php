<x-app-layout>
    <!-- page header -->
    <x-slot name="header sr-only">
        <h2 class="font-semibold text-xl text-yellow-600 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- leaderboard body -->
    <div class="py-10">
        <!-- tabs for different leaderboards -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
            <ul class="list flex">
                <li class="-mb-px mr-1">
                    <a dusk="dashboard-leaderboard-btn" class="bg-transparent inline-block py-2 px-4 text-white hover:text-yellow-600" href="dashboard">Leaderboard</a>
                </li>
                <li class="mr-1">
                    <a dusk="spotify-leaderboard-btn" class="bg-transparent inline-block border-b border-l rounded border-red-500 py-2 px-4 text-yellow-600 font-semibold" href="spotifyDashboard">Spotify Leaderboard</a>
                </li>
            </ul>
        </div>
        <!-- leaderboard -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-900 h-full">
            <div class="overflow-hidden">
                <!-- rating, track, and name indicators -->
                <div class="p-6 sm:px-20 border-b border-red-500 grid grid-cols-5">
                    <div class="text-xl font-bold text-white col-span-1">
                        Ranking
                    </div>
                    <div class="text-xl font-bold text-white col-span-3">
                        Track Name
                    </div>
                    <div class="text-xl font-bold text-white col-span-1">
                        Artist
                    </div>
                </div>
                <!-- track listings -->
                @foreach ($tracks as $track)
                    @if ($count++%2 == 0)
                    <div class="pt-4 pb-4 pl-2 pr-2 sm:px-20 border-b border-l border-yellow-600 grid grid-cols-5 text-lg" dusk="orange">
                        <!-- rating -->
                        <div class="font-bold text-yellow-600 col-span-1">
                            {{ $count }}
                        </div>
                        <!-- track name and artist -->
                        <div class="font-bold text-gray-200 col-span-3">
                            {{ $track['track']['name']}}
                        </div>
                        <div class="text-gray-200 col-span-1">
                            {{ $track['track']['artists']['0']['name'] }}
                        </div>
                    </div>
                    @else
                    <div class="pt-4 pb-4 pl-2 pr-2 sm:px-20 border-b border-r border-red-500 grid grid-cols-5 text-lg" dusk="red">
                        <!-- rating -->
                        <div  class="font-bold text-red-500 col-span-1">
                            {{ $count }}
                        </div>
                        <!-- track name and artist -->
                        <div class="font-bold text-gray-200 col-span-3">
                            {{ $track['track']['name']}}
                        </div>
                        <div class="text-gray-200 col-span-1">
                            {{ $track['track']['artists']['0']['name'] }}
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
