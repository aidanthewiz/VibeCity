<x-jet-action-section>
    <div class="min-h-screen md:min-h-0 lg:min-w-full sm:max-w-4xl sm:p-8 md:p-4 md:grid md:grid-cols-3 gap-2">
        <div class="p-4 text-center md:text-left md:justify-items-start min-w-full min-h-full">
            <!-- card title -->
            <x-slot name="title">
                <div class="pl-4 pt-4 text-black font-bold text-lg">
                    {{ __('Two Factor Authentication') }}
                </div>
            </x-slot>
            <!-- card description -->
            <x-slot name="description">
                <div class="pl-4 pt-4 pb-4 text-gray-800 font-bold text-md">
                    {{ __('Add additional security to your account using two factor authentication.') }}
                </div>
            </x-slot>
        </div>

        <x-slot name="content">
            <div class="min-w-full col-span-6 h-full mb-2 content-center justify-center rounded bg-gray-900 shadow-md">
                <!-- tfa confirmation or denial -->
                <h3 class="block p-4 text-white text-left text-lg">
                    @if ($this->enabled)
                        {{ __('You have enabled two factor authentication.') }}
                    @else
                        {{ __('You have not enabled two factor authentication.') }}
                    @endif
                </h3>
                <!-- tfa explanation -->
                <div class="block p-2 text-md text-gray-400 m-2">
                    <p>
                        {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
                    </p>
                </div>
                <!-- if tfa enabled, say it is and get QR codes -->
                @if ($this->enabled)
                    @if ($showingQrCode)
                        <div class="block p-2 text-md text-gray-400 m-2">
                            <p class="font-semibold">
                                {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
                            </p>
                        </div>

                        <div class="ml-2 mr-2 mt-4 p-2 dark:p-4 dark:w-56 dark:bg-white">
                            {!! $this->user->twoFactorQrCodeSvg() !!}
                        </div>
                    @endif
                    <!-- if show recovery codes, explain them and show all the codes generated -->
                    @if ($showingRecoveryCodes)
                        <div class="block ml-2 mr-2 mt-4 p-2 text-md text-gray-400 m-2">
                            <p class="font-semibold">
                                {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                            </p>
                        </div>

                        <div class="block ml-4 mr-2 mt-4 p-2 grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm text-yellow-600 rounded-lg">
                            @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                                <div>{{ $code }}</div>
                            @endforeach
                        </div>
                    @endif
                @endif

                <div class="mt-5 ml-4">
                    <!-- if tfa not enabled, show button to enable tfa. otherwise, show recovery code and disable buttons -->
                    @if (! $this->enabled)
                        <x-jet-confirms-password wire:then="enableTwoFactorAuthentication">
                            <button type="button" dusk="enable-tfa-btn" wire:loading.attr="disabled" class="bg-gray-100 hover:bg-gray-400 text-black font-bold mr-3 py-1 px-4 rounded mb-2">
                                {{ __('Enable') }}
                            </button>
                        </x-jet-confirms-password>
                    @else
                        @if ($showingRecoveryCodes)
                            <x-jet-confirms-password wire:then="regenerateRecoveryCodes">
                                <button dusk="gen-recovery-btn" class="bg-gray-100 hover:bg-gray-400 text-black font-bold mr-3 py-1 px-4 rounded mb-2 mr-3">
                                    {{ __('Regenerate Recovery Codes') }}
                                </button>
                            </x-jet-confirms-password>
                        @else
                            <x-jet-confirms-password wire:then="showRecoveryCodes">
                                <button dusk="show-recovery-btn" class="bg-gray-100 hover:bg-gray-400 text-black font-bold mr-3 py-1 px-4 rounded mb-2 mr-3Z">
                                    {{ __('Show Recovery Codes') }}
                                </button>
                            </x-jet-confirms-password>
                        @endif
                        <!-- disable tfa button. if password not entered, startup a modal to enter password on press -->
                        <x-jet-confirms-password wire:then="disableTwoFactorAuthentication">
                            <button dusk="disable-tfa-btn" wire:loading.attr="disabled" class="bg-gray-100 hover:bg-gray-400 text-black font-bold py-1 px-4 rounded mb-2 mr-3">
                                {{ __('Disable') }}
                            </button>
                        </x-jet-confirms-password>
                    @endif
                </div>
            </div>
        </x-slot>
    </div>
</x-jet-action-section>
