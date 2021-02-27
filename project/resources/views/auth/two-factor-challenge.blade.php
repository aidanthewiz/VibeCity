<x-guest-layout>
    <x-jet-authentication-card>
        <!-- Site logo -->
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <!-- if authentication code, prompt for code -->
            <div class="mb-4 text-sm text-gray-200" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <!-- if recovery code, prompt for code -->
            <div class="mb-4 text-sm text-gray-200" x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <!-- show any errors -->
            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <!-- prompt for one time code -->
                <div class="mt-4" x-show="! recovery">
                    <label for="code" class="white font-bold ml-2">Code</label>
                    <input id="code" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" type="text" placeholder="Authentication Code*" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                </div>

                <!-- prompt for recovery code-->
                <div class="mt-4" x-show="recovery">
                    <label for="recovery_code" class="white font-bold ml-2">Recovery Code</label>
                    <input id="recovery_code" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" type="text" placeholder="Recovery Code" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <!-- add a button to use a recovery code -->
                    <button type="button" class="text-sm text-yellow-600 hover:text-white underline cursor-pointer"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <!-- add a button to use an authentication code -->
                    <button type="button" class="text-sm text-yellow-600 hover:text-white underline cursor-pointer"
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Use an authentication code') }}
                    </button>

                    <!-- attempt to login -->
                    <button class="ml-4 bg-gray-100 hover:bg-gray-400 text-black font-bold py-1 px-4 rounded">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
