<x-guest-layout>
    <div class="p-3 md:p-0 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-800">
        <div class="min-h-screen md:min-h-0 w-full sm:max-w-4xl sm:m-8 md:m-4 bg-gray-900 shadow-md overflow-hidden sm:rounded-lg grid md:grid-cols-2 gap-4">
            <div class="h-full md:h-auto bg-gradient-to-t from-red-700 to-yellow-400 justify-center align-content content-center items-center md:rounded-tr-lg md:rounded-br-lg grid grid-rows-2 gap-1">
                <!-- tagline words -->
                <div class="social-text text-center z-10">
                    <div class="text-2xl font-bold pb-2">SOCIALLY DISTANCED</div>
                    <div class="text-2xl font-bold">MUSICAL LISTENING</div>
                </div>
                <style>
                    .tower-logo {
                        /*align-items: flex-end;*/
                        display: flex;
                        /*overflow: hidden;*/
                        /*opacity: 0.8;*/
                    }
                    .tower-logo .tower {
                        flex:1;
                        height: 100%;
                    }
                    .tower-logo .tower div{
                        animation-name: city-eq-animation;
                        animation-timing-function: linear;
                        animation-iteration-count: infinite;
                        animation-direction: alternate;
                        /*width: 100%;*/
                        /*height: 100%;*/
                        bottom: 0px;
                        transform: translateY(-50%);
                        will-change: transform;
                    }
                    @keyframes city-eq-animation {
                        0% {
                            transform: translateY(-50%);
                            /*transform: scaleY(1);*/
                        }
                        100% {
                            /*transform: scaleY(0);*/
                            transform: translateY(-10%);
                        }
                    }
                </style>
                <!-- Animated Towers logo -->
                <div>
                    <div class="tower-logo flex justify-around absolute">
                        <div class="font-mono text-white text-4xl font-bold z-20 justify-center items-center text-center absolute mt-2"><a href="/" dusk="home-link">VibeCity</a></div>
                        <div class="tower flex items-end z-1 relative">
                            <div id="tower-1" class="w-5 h-4 bg-red-500 border-2 border-yellow-100" style="animation-duration: .3s"></div>
                            <div id="tower-2" class="w-5 h-10 bg-red-500 border-2 border-yellow-100" style="animation-duration: .6s"></div>
                            <div id="tower-3" class="w-5 h-6 bg-red-500 border-2 border-yellow-100" style="animation-duration: .4s"></div>
                            <div id="tower-4" class="w-5 h-12 bg-red-500 border-2 border-yellow-100" style="animation-duration: .6s"></div>
                            <div id="tower-5" class="w-5 h-24 bg-red-500 border-2 border-yellow-100" style="animation-duration: .5s"></div>
                            <div id="tower-6" class="w-5 h-9 bg-red-500 border-2 border-yellow-100" style="animation-duration: .35s"></div>
                            <div id="tower-7" class="w-5 h-5 bg-red-500 border-2 border-yellow-100" style="animation-duration: .4s"></div>
                            <div id="tower-8" class="w-5 h-9 bg-red-500 border-2 border-yellow-100" style="animation-duration: .45s"></div>
                            <div id="tower-9" class="w-5 h-24 bg-red-500 border-2 border-yellow-100" style="animation-duration: .6s"></div>
                            <div id="tower-10" class="w-5 h-12 bg-red-500 border-2 border-yellow-100" style="animation-duration: .36s"></div>
                            <div id="tower-11" class="w-5 h-6 bg-red-500 border-2 border-yellow-100" style="animation-duration: .26s"></div>
                            <div id="tower-12" class="w-5 h-10 bg-red-500 border-2 border-yellow-100" style="animation-duration: .46s"></div>
                            <div id="tower-13" class="w-5 h-4 bg-red-500 border-2 border-yellow-100" style="animation-duration: .26s"></div>
                        </div>
                    </div>
                    <div class="tower-logo-a flex justify-around z-0 relative">
                        <div class="towera flex items-end z-0 relative">
                            <div id="tower-1a" class="w-5 h-4 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-2a" class="w-5 h-10 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-3a" class="w-5 h-6 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-4a" class="w-5 h-12 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-5a" class="w-5 h-24 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-6a" class="w-5 h-9 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-7a" class="w-5 h-5 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-8a" class="w-5 h-9 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-9a" class="w-5 h-24 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-10a" class="w-5 h-12 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-11a" class="w-5 h-6 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2border-yellow-100"></div>
                            <div id="tower-12a" class="w-5 h-10 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                            <div id="tower-13a" class="w-5 h-4 bg-gradient-to-t to-red-500 from-yellow-200 border-l-2 border-r-2 border-b-2 border-yellow-100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- login form -->
            <form method="POST" action="{{ route('login') }}" class="p-4 m-2 content-center justify-center">
            @csrf
            <!-- prompt -->
                <div class="content-center flex justify-between gap-0 items-center mb-3 mt-2">
                    <div class="border-b-2 border-t-2 h-2 w-1/4 border-white align-bottom"></div>
                    <div class="text-white text-center font-bold">LOGIN</div>
                    <div class="border-b-2 border-t-2 h-2 w-1/4 border-white"></div>
                </div>
                <!-- email -->
                <div>
                    <label for="email_input" class="sr-only">Email</label>
                    <input id="email_input" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" type="email" name="email" placeholder="Email*" required autofocus />
                </div>
                <!-- password -->
                <div class="mt-4">
                    <label for="password_input" class="sr-only">Password</label>
                    <input id="password_input" class="block mt-1 w-full bg-transparent border-0 border-b-2 border-white text-gray-200" type="password" name="password" placeholder="Password*" required autocomplete="current-password" />
                </div>
                <!-- remember me -->
                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- login, register buttons -->
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a dusk="password-link" class="underline text-sm text-yellow-600 hover:text-white" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button dusk="login-button" class="ml-2 bg-gray-100 hover:bg-gray-400 text-black font-bold py-1 px-4 rounded">
                        {{ __('Login') }}
                    </button>
                </div>
                <!-- error notifiers for incorrect fields -->
                <div dusk="spotify-link" />
                    <x-jet-validation-errors class="mb-4" />
                    @if (JoelButcher\Socialstream\Socialstream::show())
                        <x-socialstream-providers />
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
