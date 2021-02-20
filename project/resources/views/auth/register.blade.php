<x-guest-layout>
        <div class="p-3 md:p-0 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-800">
            <div class="min-h-screen md:min-h-0 w-full sm:max-w-4xl sm:m-8 md:m-4 bg-gray-900 shadow-md overflow-hidden sm:rounded-lg grid md:grid-cols-2 gap-4">
                <div class="h-full md:h-auto bg-gradient-to-t from-red-700 to-yellow-400 justify-center align-content content-center items-center md:rounded-tr-lg md:rounded-br-lg grid grid-rows-2 gap-1">
                    <!-- tagline words -->
                    <div class="social-text text-center">
                        <div class="text-2xl font-bold pb-2">SOCIALLY DISTANCED</div>
                        <div class="text-2xl font-bold">MUSICAL LISTENING</div>
                    </div>
                    <!-- Towers screen -->
                    <div class="tower-logo flex justify-around">
                        <div class="font-mono text-white text-4xl font-bold z-20 justify-center items-center text-center absolute mt-2"><a href="/">VibeCity</a></div>
                        <div class="towers flex items-end z-0 relative">
                            <div id="tower-1" class="w-5 h-4 bg-gradient-to-t to-red-600 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-2" class="w-5 h-10 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-3" class="w-5 h-6 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-4" class="w-5 h-12 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-5" class="w-5 h-24 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-6" class="w-5 h-9 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-7" class="w-5 h-5 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-8" class="w-5 h-9 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-9" class="w-5 h-24 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-10" class="w-5 h-12 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-11" class="w-5 h-6 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-12" class="w-5 h-10 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                            <div id="tower-13" class="w-5 h-4 bg-gradient-to-t to-red-500 from-yellow-200 border-2 border-yellow-100"></div>
                        </div>
                    </div>
                </div>
                <!-- login form -->
                <form method="POST" action="{{ route('register') }}" class="p-4 m-2 content-center justify-center">
                    @csrf
                    <!-- prompt -->
                    <div class="content-center flex justify-between gap-0 items-center mb-3">
                        <div class="border-b-2 border-t-2 h-2 w-1/4 border-white align-bottom"></div>
                        <div class="text-white text-center font-bold">REGISTER</div>
                        <div class="border-b-2 border-t-2 h-2 w-1/4 border-white"></div>
                    </div>
                    <!-- email -->
                    <div>
                        <label for="email_input" class="sr-only">Email</label>
                        <input id="email_input" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" type="email" name="email" placeholder="Email*" required />
                    </div>
                    <!-- name -->
                    <div class="mt-4">
                        <label for="name_input" class="sr-only">Name</label>
                        <input id="name_input" class="block mt-1 w-full bg-transparent border-0 focus:border-t-4 border-b-2 border-white text-gray-200" type="text" name="name" placeholder="Name*" required autofocus autocomplete="name" />
                    </div>
                    <!-- password -->
                    <div class="mt-4">
                        <label for="password_input" class="sr-only">Password</label>
                        <input id="password_input" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" type="password" name="password" placeholder="Password*" required autocomplete="new-password" />
                    </div>
                    <!-- password conf -->
                    <div class="mt-4">
                        <label for="password_confirmation" class="sr-only">Password Confirmation</label>
                        <input id="password_confirmation" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" type="password" name="password_confirmation" placeholder="Confirm Password*" required autocomplete="new-password" />
                    </div>
                    <!-- privacy agreement -->
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-jet-label for="terms">
                                <div class="flex items-center">
                                    <x-jet-checkbox name="terms" id="terms"/>

                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                    @endif
                    <!-- login, register buttons -->
                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-yellow-600 hover:text-white" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button class="ml-2 bg-gray-100 hover:bg-gray-400 text-black font-bold py-1 px-4 rounded">
                            {{ __('Register') }}
                        </button>
                    </div>
                    <!-- error notifiers for incorrect fields -->
                    <x-jet-validation-errors class="mb-4" />
                </form>
            </div>
        </div>
</x-guest-layout>
