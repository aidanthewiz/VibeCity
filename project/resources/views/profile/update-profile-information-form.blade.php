<x-jet-form-section submit="updateProfileInformation">
    <div class="min-h-screen md:min-h-0 lg:min-w-full sm:max-w-4xl sm:p-8 md:p-4 md:grid md:grid-cols-3 gap-2">
        <div class="p-4 text-center md:text-left md:justify-items-start min-w-full min-h-full">
            <!-- title to the card -->
            <x-slot name="title">
                <div class="pl-4 pt-4 text-black font-bold text-lg">
                    {{ __('Profile Information') }}
                </div>
            </x-slot>
            <!-- card description -->
            <x-slot name="description">
                <div class="pl-4 pt-4 pb-4 text-gray-800 font-bold text-md">
                {{ __('Here you can view and update your account\'s profile information and email address.') }}
                </div>
            </x-slot>
        </div>
        <!-- password change form -->
        <x-slot name="form" >
            <div class="min-w-full col-span-6 h-full mb-2 content-center justify-center rounded bg-gray-900 shadow-md">
                <!-- Name -->
                <div class="col-span-6 m-4 sm:col-span-4 grid md:grid-cols-2 gap-1">
                    <label for="name" class="block mt-4 sm: ml-2 md:ml-0 text-white font-bold text-md h-full text-left md:text-center">Name</label>
                    <input id="name" type="text" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" placeholder="New Name*" wire:model.defer="state.name" autocomplete="name" />
                </div>

                <!-- Email -->
                <div class="col-span-6 m-4 sm:col-span-4 grid md:grid-cols-2 gap-1">
                    <label for="name" class="block mt-4 sm: ml-2 md:ml-0 text-white font-bold text-md h-full text-left md:text-center">Email</label>
                    <input id="email" type="email" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" placeholder="New Email*" wire:model.defer="state.email" />
                </div>

                <!-- save button -->
                <button dusk="save-info-btn" wire:loading.attr="disabled" wire:target="photo" class="bg-gray-100 hover:bg-gray-400 text-black font-bold py-1 px-4 rounded float-right mb-2 mr-3">
                    {{ __('Save') }}
                </button>

                <!-- potential errors -->
                <x-jet-input-error for="name" class="mt-2" />
                <x-jet-input-error for="email" class="mt-2" />
            </div>
        </x-slot>
    </div>
</x-jet-form-section>
