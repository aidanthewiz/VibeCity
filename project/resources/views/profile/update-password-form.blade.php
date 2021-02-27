<x-jet-form-section submit="updatePassword">
    <div class="min-h-screen md:min-h-0 lg:min-w-full sm:max-w-4xl sm:p-8 md:p-4 md:grid md:grid-cols-3 gap-2">
        <div class="p-4 text-center md:text-left md:justify-items-start min-w-full min-h-full">
            <!-- title to the card -->
            <x-slot name="title">
                <div class="pl-4 pt-4 text-black font-bold text-lg">
                    {{ __('Update Password') }}
                </div>
            </x-slot>
            <!-- card description -->
            <x-slot name="description">
                <div class="pl-4 pt-4 pb-4 text-gray-800 font-bold text-md">
                    {{ __('Change your password to a new one here. Ensure that it is at least 8 characters long, not more than 100 characters, and has uppercase, numeric, and special characters.') }}
                </div>
            </x-slot>
        </div>
    </div>
    <!-- password change form -->
    <x-slot name="form">
        <div class="min-w-full col-span-6 h-full mb-2 content-center justify-center rounded bg-gray-900 shadow-md">
            <!-- current password -->
            <div class="col-span-6 m-4 sm:col-span-4 grid md:grid-cols-2 gap-1">
                <label for="current_password_input" class="block mt-4 sm: ml-2 md:ml-0 text-white font-bold text-md h-full text-left md:text-center">Current Password</label>
                <input id="current_password_input" type="password"  class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" placeholder="Current Password"  wire:model.defer="state.current_password" autocomplete="current-password" />
            </div>
            <!-- new password -->
            <div class="col-span-6 m-4 sm:col-span-4 grid md:grid-cols-2 gap-1">
                <label for="password_input" class="block mt-4 sm: ml-2 md:ml-0 text-white font-bold text-md h-full text-left md:text-center">New Password</label>
                <input id="password_input" type="password"  class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" placeholder="New Password*"  wire:model.defer="state.password" autocomplete="new-password" />
            </div>
            <!-- new password confirmation -->
            <div class="col-span-6 m-4 sm:col-span-4 grid md:grid-cols-2 gap-1">
                <label for="password_confirmation_input" class="block mt-4 sm: ml-2 md:ml-0 text-white font-bold text-md h-full text-left md:text-center">Confirm Password</label>
                <input id="password_confirmation_input" type="password"  class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" placeholder="Confirm Password*"  wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            </div>
            <!-- save new info button -->
            <button dusk="save-password-btn" class="bg-gray-100 hover:bg-gray-400 text-black font-bold py-1 px-4 rounded float-right mb-2 mr-3">
                {{ __('Save') }}
            </button>
            <!-- any errors pop up below submission -->
            <x-jet-input-error for="current_password" class="mt-2" />
            <x-jet-input-error for="password" class="mt-2" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>
</x-jet-form-section>
