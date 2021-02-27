<x-jet-action-section>
    <div class="min-h-screen md:min-h-0 lg:min-w-full sm:max-w-4xl sm:p-8 md:p-4 md:grid md:grid-cols-3 gap-2">
        <div class="p-4 text-center md:text-left md:justify-items-start min-w-full min-h-full rounded">
            <x-slot name="title">
                <!-- card title -->
                <x-slot name="title">
                    <div class="pl-4 pt-4 text-black font-bold text-lg">
                        {{ __('Delete Account') }}
                    </div>
                </x-slot>
                <!-- card description -->
                <x-slot name="description">
                    <div class="pl-4 pt-4 text-black font-bold text-lg">
                        {{ __('Permanently delete your account.') }}
                    </div>
                </x-slot>
            </x-slot>
        </div>

        <x-slot name="content">
                <div class="min-w-full col-span-6 h-full mb-2 content-center justify-center rounded bg-gray-900 shadow-md rounded">
                    <!-- account delete explanation -->
                    <div class="block p-4 text-white text-left text-lg">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                    </div>
                    <!-- delete account button -->
                    <div class="mt-5 ml-4 mb-2">
                        <button dusk="delete-act-btn" class="bg-red-600 hover:bg-red-800 text-black font-bold mr-3 py-1 px-4 rounded mb-2 mr-3" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                            {{ __('Delete Account') }}
                        </button>
                    </div>

                    <!-- Delete User Confirmation Modal -->
                    <x-jet-dialog-modal wire:model="confirmingUserDeletion">
                        <!-- modal title -->
                        <x-slot name="title">
                            {{ __('Delete Account') }}
                        </x-slot>

                        <x-slot name="content">
                            <!-- account delete explanation, password input, and password errors -->
                            {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                            <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                                <label for="delete-user-password-input" class="sr-only">{{ __('Password') }}</label>
                                <input type="password" class="block mt-1 w-3/4 bg-transparent border-0 border-b-2 border-white text-gray-200" placeholder="{{ __('Password') }}"
                                            placeholder="{{ __('Password') }}"
                                            x-ref="password"
                                            wire:model.defer="password"
                                            wire:keydown.enter="deleteUser"
                                            name="delete-user-password-input"
                                            id="delete-user-password-input"/>

                                <x-jet-input-error for="password" class="mt-2" />
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <!-- confirm account delete and exit buttons -->
                            <button class="bg-gray-500 hover:bg-gray-200 text-black font-bold py-1 px-4 rounded " dusk="delete-nevermind-btn" wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                                {{ __('Nevermind') }}
                            </button>

                            <button class="bg-red-600 hover:bg-red-800 text-black font-bold py-1 px-4 rounded ml-2" dusk="delete-confirm-btn" wire:click="deleteUser" wire:loading.attr="disabled">
                                {{ __('Delete Account') }}
                            </button>
                        </x-slot>
                    </x-jet-dialog-modal>
                </div>
        </x-slot>
    </div>
</x-jet-action-section>
