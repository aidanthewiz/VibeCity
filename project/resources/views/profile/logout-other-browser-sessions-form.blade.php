<x-jet-action-section>
    <div class="min-h-screen md:min-h-0 lg:min-w-full sm:max-w-4xl sm:p-8 md:p-4 md:grid md:grid-cols-3 gap-2">
        <div class="p-4 text-center md:text-left md:justify-items-start min-w-full min-h-full">
            <!-- card title -->
            <x-slot name="title">
                <div class="pl-4 pt-4 text-black font-bold text-lg">
                    {{ __('Browser Sessions') }}
                </div>
            </x-slot>
            <!-- card description -->
            <x-slot name="description">
                <div class="pl-4 pt-4 pb-4 text-gray-800 font-bold text-md">
                   {{ __('Manage and logout your active sessions on other browsers and devices.') }}
                </div>
            </x-slot>
        </div>

        <x-slot name="content">
            <div class="min-w-full col-span-6 h-full mb-2 content-center justify-center rounded bg-gray-900 shadow-md rounded">
                <!-- explanation of browser session logout -->
                <div class="block p-4 text-white text-left text-lg">
                    {{ __('If necessary, you may logout of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
                </div>

                <!-- if more than one session, show every session -->
                @if (count($this->sessions) > 0)
                    <div class="mt-5 space-y-6 ml-4">
                        <!-- Other Browser Sessions -->
                        <!-- for each session, show a symbol for it and what it is -->
                        @foreach ($this->sessions as $session)
                            <div class="flex items-center">
                                <div>
                                    <!-- session symbol -->
                                    @if ($session->agent->isDesktop())
                                        <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                            <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-gray-500">
                                            <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- session ip, device status, last active -->
                                <div class="ml-3">
                                    <div class="text-sm text-gray-300">
                                        {{ $session->agent->platform() }} - {{ $session->agent->browser() }}
                                    </div>

                                    <div>
                                        <div class="text-xs text-gray-300">
                                            {{ $session->ip_address }},

                                            @if ($session->is_current_device)
                                                <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                            @else
                                                {{ __('Last active') }} {{ $session->last_active }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- logout button and completion message on finish -->
                <div class="flex items-center mt-5 ml-4">
                    <button class="bg-gray-200 hover:bg-gray-500 text-black font-bold py-1 px-4 rounded mb-2" dusk="logout-browser-button" wire:click="confirmLogout" wire:loading.attr="disabled">
                        {{ __('Logout Other Browser Sessions') }}
                    </button>

                    <x-jet-action-message class="ml-3" on="loggedOut">
                        {{ __('Done.') }}
                    </x-jet-action-message>
                </div>

                <!-- Logout Other Devices Confirmation Modal -->
                <x-jet-dialog-modal wire:model="confirmingLogout">
                    <!-- modal title -->
                    <x-slot name="title">
                        {{ __('Logout Other Browser Sessions') }}
                    </x-slot>
                    <!-- password prompt, input, and errors -->
                    <x-slot name="content">
                        {{ __('Please enter your password to confirm you would like to logout of your other browser sessions across all of your devices.') }}

                        <div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                            <label for="logout-browser-password-input" class="sr-only">{{ __('Password') }}</label>
                            <input type="password" class="block mt-1 w-3/4 bg-transparent border-0 border-b-2 border-white text-gray-200" placeholder="{{ __('Password') }}"
                                        placeholder="{{ __('Password') }}"
                                        x-ref="password"
                                        wire:model.defer="password"
                                        wire:keydown.enter="logoutOtherBrowserSessions"
                                        name="logout-browser-password-input"
                                        id="logout-browser-password-input"/>

                            <x-jet-input-error for="password" class="mt-2" />
                        </div>
                    </x-slot>
                    <!-- confirm or exit buttons -->
                    <x-slot name="footer">
                        <button class="bg-gray-500 hover:bg-gray-200 text-black font-bold py-1 px-4 rounded" dusk="session-logout-nevermind-btn" wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                            {{ __('Nevermind') }}
                        </button>

                        <button class="bg-gray-100 hover:bg-gray-400 text-black font-bold py-1 px-4 rounded ml-2" dusk="session-logout-confirm-btn"
                                    wire:click="logoutOtherBrowserSessions"
                                    wire:loading.attr="disabled">
                            {{ __('Logout Other Browser Sessions') }}
                        </button>
                    </x-slot>
                </x-jet-dialog-modal>
            </div>
        </x-slot>
    </div>
</x-jet-action-section>
