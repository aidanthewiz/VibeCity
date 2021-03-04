<x-app-layout>
    <x-slot name="header sr-only">
        <h2 class="font-semibold text-xl text-yellow-600 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-900 h-screen">
            <div class="overflow-hidden shadow-xl">
                <div class="p-6 sm:px-20 border-b border-red-500 grid grid-cols-2">
                    <div class="text-xl font-bold text-white">
                        Track Name
                    </div>
                    <div class="text-xl font-bold text-white">
                        Artist
                    </div>
                </div>
                <div class="p-4 sm:px-20 bg-gray-900 border-b border-l border-yellow-600 grid grid-cols-2 text-lg">
                    <div class="font-bold text-gray-200">
                        drivers license
                    </div>
                    <div class="text-gray-200">
                        Olivia Rodrigo
                    </div>
                </div>
                <div class="p-4 sm:px-20 bg-gray-900 border-b border-r border-red-500 grid grid-cols-2 text-lg">
                    <div class="font-bold text-gray-200">
                        Save Your Tears
                    </div>
                    <div class="text-gray-200">
                        The Weeknd
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
