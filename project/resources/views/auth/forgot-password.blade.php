<!DOCTYPE html>
<html lang="en">
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

        .btn {
            @apply font-bold py-5 px-5 rounded;
        }

        .btn-background {
            @apply bg-black text-black;
        }

        .btn-black:hover {
            @apply bg-black;
        }
    </style>
</head>
<body>
<div class="font-sans text gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-0 bg-gray-800">
        <div name="logo justify-center align-content">
            <a href="/" class="w-full"><img src="img/VibeCity-150.png"/></a>
        </div>
        <div
            class="bg-gradient-to-t from-red-700 to-yellow-400 p-4 justify-center align-content content-center items-center rounded-tl-lg rounded-bl-lg rounded-tr-lg rounded-br-lg mt-2 mb-20">
            <div class="social-text text-center">
                <div class="text-xl font-bold pb-2 social-text text-center grid grid-row-2">Reset Your Password</div>
                <form>
                    <label for="email" class="sr-only">Email</label>
                    <input class="placeholder-white" type="email" id="email" name="email" placeholder="Email*">
                    <button class="bg-gray-900 hover:bg-gray-800 text-gray-400 font-bold py-2 px-4 rounded-full">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
