<x-app-layout>
    <!-- page header -->
    <x-slot name="header sr-only">
        <h2 class="font-semibold text-xl text-yellow-600 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- leaderboard body -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-900 h-full">
            <div class="overflow-hidden">

                <!-- rating, track, and name indicators -->
                <div class="p-6 sm:px-20 border-b border-red-500 grid grid-cols-5">
                    <div class="text-xl font-bold text-white col-span-1">
                        Rating
                    </div>
                    <div class="text-xl font-bold text-white col-span-3">
                        Track Name
                    </div>
                    <div class="text-xl font-bold text-white col-span-1">
                        Artist
                    </div>
                </div>
                <!-- track listings -->
                @foreach ($tracks as $index => $track)
                    @if ($count++%2 == 0)
                    <div class="pt-4 pb-4 pl-2 pr-2 sm:px-20 border-b border-l border-yellow-600 grid grid-cols-5 text-lg" dusk="orange">
                        <!-- rating -->
                        <div class="font-bold text-yellow-600 col-span-1">
                            <form method="POST" action="{{route('rateTrack', [$track->id])}}">
                                @csrf
                                <button dusk="rate-track-btn">&#128077;</button>
                                {{ $track->rating }}
                            </form>

                        </div>
                        <!-- track name and artist -->
                        <div class="font-bold text-gray-200 col-span-3">
                            {{ $track->name }}
                        </div>
                        <div class="text-gray-200 col-span-1">
                            {{ $track->artist }}
                        </div>
                    </div>
                    @else
                    <div class="pt-4 pb-4 pl-2 pr-2 sm:px-20 border-b border-r border-red-500 grid grid-cols-5 text-lg" dusk="red">
                        <!-- rating -->
                        <div  class="font-bold text-red-500 col-span-1">
                            <form method="POST" action="{{ route('rateTrack', [$track->id]) }}">
                                @csrf
                                <button dusk="rate-track-btn">&#128077;</button>
                                {{ $track->rating }}
                            </form>
                        </div>
                        <!-- track name and artist -->
                        <div class="font-bold text-gray-200 col-span-3">
                            {{ $track->name }}
                        </div>
                        <div class="text-gray-200 col-span-1">
                            {{ $track->artist }}
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
