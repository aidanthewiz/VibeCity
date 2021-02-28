<x-app-layout>
    <div class="flex min-w-full min-h-full p-4 justify-center items-center content-center align-content justify-self-center align-center self-center">
        <div class="grid grid-rows-1 bg-gray-900 min-h-full min-w-full md:p-7 pt-3 pb-3 rounded sm:max-w-4xl sm:m-8 md:m-4 bg-gray-900 shadow-md sm:rounded-lg self-center align-center items-center align-content content-center">
            <div class="border-b-2 border-white">
                <button dusk="party-button" class="mb-4 ml-2 bg-yellow-600 hover:bg-yellow-800 text-black font-bold py-1 px-4 rounded">
                    {{ __('Create Party') }}
                </button>
            </div>
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
                                <div class="ml-4 mr-4 mt-2 md:text-xl text-md p-3">
                                    {{ Auth::user()->name }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>