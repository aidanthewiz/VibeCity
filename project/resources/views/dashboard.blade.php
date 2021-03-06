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

                <!-- track and name indicators -->
                <div class="p-6 sm:px-20 border-b border-red-500 grid grid-cols-2">
                    <div class="text-xl font-bold text-white">
                        Track Name
                    </div>
                    <div class="text-xl font-bold text-white">
                        Artist
                    </div>
                </div>
                <!-- track listings -->
                @foreach ($tracks as $track)
                    @if ($track['id']%2 == 1)
                    <div class="p-4 sm:px-20 border-b border-l border-yellow-600 grid grid-cols-2 text-lg" dusk="orange">
                        <!-- track name and artist -->
                        <div class="font-bold text-gray-200">
                            {{ $track['name'] }}
                        </div>
                        <div class="text-gray-200">
                            {{ $track['artist'] }}
                        </div>
                    </div>
                    @else
                    <div class="p-4 sm:px-20 border-b border-r border-red-500 grid grid-cols-2 text-lg" dusk="red">
                        <!-- track name and artist -->
                        <div class="font-bold text-gray-200">
                            {{ $track['name'] }}
                        </div>
                        <div class="text-gray-200">
                            {{ $track['artist'] }}
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
