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
                    <a dusk="dashboard-leaderboard-btn" class="bg-transparent inline-block border-b border-r rounded border-red-500 py-2 px-4 text-yellow-600 font-semibold" href="/dashboard">Leaderboard</a>
                </li>
                <li class="mr-1">
                    <a dusk="spotify-leaderboard-btn" class="bg-transparent inline-block py-2 px-4 text-white hover:text-yellow-600 font-semibold" href="/spotifyDashboard">Spotify Leaderboard</a>
                </li>
            </ul>
        </div>
        <!-- leaderboard -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-900 h-full">
            <div class="overflow-hidden">
                <!-- rating, track, and name indicators -->
                <div class="pt-4 pb-4 md:pt-5 md:pb-5 md:pl-0 md:pr-0 sm:px-20 border-b border-red-500 grid grid-cols-3 md:grid-cols-5">
                    <div class="text-md md:text-xl font-bold text-white col-span-1 md:col-span-1 ml-2 md:ml-5 md:pl-5">
                        Rating
                    </div>
                    <div class="text-md md:text-xl font-bold text-white col-span-1 md:col-span-3">
                        Track Name
                    </div>
                    <div class="text-md md:text-xl font-bold text-white col-span-1 md:col-span-1">
                        Artist
                    </div>
                </div>
                <!-- track listings -->
                @foreach ($tracks as $index => $track)
                @if ($count++%2 == 0)
                    @if ($track_comments_id != $track->id)
                    <div class="pt-4 pb-4 pl-1 pr-1 md:pl-2 md:pr-2 sm:px-20 border-b border-l border-yellow-600 grid grid-cols-1 text-lg" dusk="orange">
                    @else
                    <div class="pt-4 pl-1 pr-1 md:pl-2 md:pr-2 sm:px-20 border-b border-l border-yellow-600 grid grid-cols-2 text-lg" dusk="orange">
                    @endif
                @else
                    @if ($track_comments_id != $track->id)
                    <div class="pt-4 pb-4 pl-1 pr-1 md:pl-2 md:pr-2 sm:px-20 border-b border-r border-red-500 grid grid-cols-1 text-lg" dusk="red">
                    @else
                    <div class="pt-4 pl-1 pr-1 md:pl-2 md:pr-2 sm:px-20 border-b border-r border-red-500 grid grid-cols-2 text-lg" dusk="red">
                    @endif
                @endif
                    <div class="grid grid-cols-3 md:grid-cols-5 text-base md:text-lg col-span-2">
                        <!-- rating -->
                        @if ($count%2 == 0)
                            <div class="font-bold text-red-500 col-span-1 md:col-span-1">
                        @else
                            <div class="font-bold text-yellow-600 col-span-1 md:col-span-1">
                        @endif
                            @if ($track_comments_id != $track->id)
                                <form method="GET" class="inline-block" action="{{ route('trackComments', [$track->id]) }}">
                                    <button dusk="track-comments-btn">&#128172;</button>
                                </form>
                            @else
                                <form method="GET" class="inline-block" action="{{ route('dashboard') }}">
                                    <button dusk="track-comments-btn">&#128172;</button>
                                </form>
                            @endif
                            <form method="POST" class="inline-block" action="{{route('rateTrack', [$track->id])}}">
                                @csrf
                                <button dusk="rate-track-btn">&#128077;</button>
                                {{ $track->rating }}
                            </form>
                            </div>
                            <!-- track name and artist -->
                            <div class="font-bold text-gray-200 col-span-1 md:col-span-3">
                                {{ $track->name }}
                            </div>
                            <div class="text-gray-200 col-span-1 ml-1 md:col-span-1">
                                {{ $track->artist }}
                            </div>
                        </div>
                        @if ($track_comments_id == $track->id)
                            <!-- comment section -->
                            @include('/dashboardComments')
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
