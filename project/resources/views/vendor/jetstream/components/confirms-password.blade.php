@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

<!-- check attributes -->
@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<!-- start confirm password -->
<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
<x-jet-dialog-modal wire:model="confirmingPassword">
    <!-- modal title -->
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <!--  modal description, password input, and password errors -->
    <x-slot name="content">
        {{ $content }}

        <div class="mt-4" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <label for="conf-password-modal-input" class="sr-only">{{ __('Password') }}</label>
            <input type="password" class="block mt-1 w-3/4 bg-transparent border-0 border-b-2 border-white text-gray-200" placeholder="{{ __('Password') }}"
                        x-ref="confirmable_password"
                        wire:model.defer="confirmablePassword"
                        wire:keydown.enter="confirmPassword"
                        name="conf-password-modal-input"
                        id="conf-password-modal-input"/>
            <x-jet-input-error for="confirmable_password" class="mt-2" />
        </div>
    </x-slot>

    <!-- exit and confirm password button -->
    <x-slot name="footer">
        <button class="bg-gray-500 hover:bg-gray-200 text-black font-bold py-1 px-4 rounded " dusk="confirm-password-nevermind-btn" wire:click="stopConfirmingPassword" wire:loading.attr="disabled">
            {{ __('Nevermind') }}
        </button>

        <button class="bg-gray-100 hover:bg-gray-400 text-black font-bold py-1 px-4 rounded ml-2" dusk="confirm-password-btn" wire:click="confirmPassword" wire:loading.attr="disabled">
            {{ $button }}
        </button>
    </x-slot>
</x-jet-dialog-modal>
@endonce
