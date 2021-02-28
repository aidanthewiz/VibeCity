<!DOCTYPE html>
</html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="fVQxVsNDVQHS54a2NwbpnRwyVoJnkSy9EHdk4iKO">

    <title>VibeCity</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css">

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>
    <style>
        input[type=email] {
            font-weight: bold;
            color: black;
            background: rgba(0.0, 0.0, 0.0, 0.1);
            border: black;
            text: black;
        }
        input[type=password] {
            font-weight: bold;
            color: black;
            background: rgba(0.0, 0.0, 0.0, 0.1);
            border: black;
            text: black;
        } input[type=password_confirmation] {
              font-weight: bold;
              color: black;
              background: rgba(0.0, 0.0, 0.0, 0.1);
              border: black;
              text: black;
          }
        form label {font-weight:bold}
    </style>
</head>
<body>
<div class="font-sans text gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-0 bg-gray-800">
        <div name="logo justify-center align-content">
            <a href="/" dusk="vibecity-logo" class="w-full"><img src="img/VibeCity-150.png"/></a>
        </div>
        <div
            class="bg-gradient-to-t from-red-700 to-yellow-400 p-4 justify-center align-content content-center items-center rounded-tl-lg rounded-bl-lg rounded-tr-lg rounded-br-lg mt-2 mb-20">
            <div class="social-text text-center">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token')}}">
                    <div class="content-center flex justify-between gap-0 items-center mb-3">
                        <div class="border-b-2 border-t-3 h-2 w-1/4 border-white align-bottom"></div>
                        <div class="text-white text-center font-bold">RESET YOUR PASSWORD</div>
                        <div class="border-b-2 border-t-3 h-2 w-1/4 border-white align-top"></div>
                    </div>
                    <!-- EMAIL INPUT BOX -->
                    <div class="mt-4">
                        <label for="email" value="{{ __('Email') }}">Email:</label>
                        <input id="email" class="block mnt-1 w-full placeholder-white" type="email" name="email" :value="old('email', $request->email)" required autofocus placeholder="Email*"/>
                        <div>
                            <!-- PASSWORD INPUT BOX -->
                            <div class="mt-4">
                                <label for="password" value="{{__('Password') }}">New Password:</label>
                                <input id="password" class="block mnt-1 w-full placeholder-white" type="password" name="password" required autocomplete="new-password" placeholder="New Password*"/>
                            </div>
                            <!-- PASSWORD CONFIRMATION BOX -->
                            <div class="mt-4">
                                <label for="password_confirmation" value="{{__('Confirm Password') }}">Confirm New Password:</label>
                                <input id="password_confirmation" class="block mnt-1 w-full placeholder-white" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password*"/>
                            </div>
                            <button onclick="https://vibecity.us/login" dusk="reset-button" class="bg-gray-900 hover:bg-gray-800 text-gray-400 font-bold py-2 px-4 mt-4 rounded-full">
                                Submit
                            </button>
                            <x-jet-validation-errors class="mb-4" />
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
