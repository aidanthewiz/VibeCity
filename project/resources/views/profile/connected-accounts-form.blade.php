<x-jet-action-section>
    <div class="min-h-screen md:min-h-0 lg:min-w-full sm:max-w-4xl sm:p-8 md:p-4 md:grid md:grid-cols-3 gap-2">
        <div class="p-4 text-center md:text-left md:justify-items-start min-w-full min-h-full">
            <!-- card title -->
            <x-slot name="title">
                <div class="pl-4 pt-4 text-black font-bold text-lg">
                    {{ __('Connected Accounts') }}
                </div>
            </x-slot>
            <!-- card description -->
            <x-slot name="description">
                <div class="pl-4 pt-4 pb-4 text-gray-800 font-bold text-md">
                    {{ __('Manage and remove your connect accounts.') }}
                </div>
            </x-slot>
        </div>

        <x-slot name="content">
            <div class="min-w-full col-span-6 h-full mb-2 content-center justify-center rounded bg-gray-900 shadow-md">
                <h3 class="block p-4 text-white text-left text-lg">
                    @if (count($this->accounts) == 0)
                        {{ __('You have no connected accounts.') }}
                    @else
                        {{ __('Your connected accounts.') }}
                    @endif
                </h3>

                <div class="block p-2 text-md text-gray-400 m-2">
                    <p>
                        {{ __('You are free to connect any social accounts to your profile and may remove any connected accounts at any time. If you feel any of your connected accounts have been compromised, you should disconnect them immediately and change your password.') }}
                    </p>
                </div>

                <div class="ml-3">
                    @foreach ($this->providers as $provider)
                        @if ($account = $this->accounts->where('provider', $provider)->first())
                            <x-connected-account provider="{{ $account->provider }}" created-at="{{ $account->created_at }}">

                                <x-slot name="action">
                                    @if ($this->accounts->count() > 1 || ! is_null($this->user->password))
                                        <x-jet-button wire:click="confirmRemove({{ $account->id }})" wire:loading.attr="disabled">
                                            {{ __('Remove') }}
                                        </x-jet-button>
                                    @endif
                                </x-slot>

                            </x-connected-account>
                        @else
                            <x-connected-account provider="{{ $provider }}">
                                <x-slot name="action">
                                    <x-action-link dusk="connect-account-link" href="{{ route('oauth.redirect', ['provider' => $provider]) }}">
                                        {{ __('Connect') }}
                                    </x-action-link>
                                </x-slot>
                            </x-connected-account>
                        @endif
                    @endforeach
                </div>

                <!-- Logout Other Devices Confirmation Modal -->
                <x-jet-dialog-modal wire:model="confirmingRemove">
                    <x-slot name="title">
                        {{ __('Remove Connected Account') }}
                    </x-slot>

                    <x-slot name="content">
                        {{ __('Please confirm your removal of this account - this action cannot be undone.') }}
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('confirmingRemove')" wire:loading.attr="disabled">
                            {{ __('Nevermind') }}
                        </x-jet-secondary-button>

                        <x-jet-button class="ml-2" wire:click="removeConnectedAccount({{ $this->selectedAccountId }})" wire:loading.attr="disabled">
                            {{ __('Remove Connected Account') }}
                        </x-jet-button>
                    </x-slot>
                </x-jet-dialog-modal>
            </div>
        </x-slot>
    </div>
</x-jet-action-section>
