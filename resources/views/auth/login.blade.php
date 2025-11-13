<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPKS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo_syarikat.png') }}">
</head>
<body class="min-h-screen bg-white font-sans flex flex-col justify-center items-center">

    <!-- 🏢 Company name (top left corner) -->
    <div class="fixed top-4 left-4 flex items-center gap-3 px-4 py-2 z-10 bg-white border border-gray-200 rounded-xl shadow">
        <img src="{{ asset('images/logo_syarikat.png') }}" alt="Company Logo" class="w-15 h-15 object-contain">
        <span class="font-semibold text-gray-800 leading-tight">
            NT Image Supply & Services<br>SDN BHD
        </span>
    </div>

    <!-- 💻 Login Form -->
    <form action="{{ route('loginUser') }}" method="POST" class="w-full max-w-md bg-white border border-gray-200 rounded-xl shadow-md p-8">
        @csrf
        <div class="mb-6 text-left">
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang!</h1>
            <p class="mt-2 text-base text-gray-600">
                Log masuk untuk akses dashboard dan teruskan urusan kenderaan syarikat anda.
            </p>
        </div>

        @if(Session::has('fail'))
            <div class="bg-red-50 text-red-600 border border-red-200 p-2 rounded mb-4 text-sm">
                {{ Session::get('fail') }}
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email"
                class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300"
                required>
        </div>

        <div class="mb-6 relative">
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password"
                class="w-full border border-gray-300 rounded p-2 mt-1 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-300"
                required>

            <!-- 👁 Toggle Password -->
            <button type="button" id="togglePassword"
                class="absolute inset-y-0 right-3 top-7 flex items-center">
                <img id="toggleIcon" src="{{ asset('images/hide_password.png') }}" alt="Show Password" class="w-5 h-5 opacity-70">
            </button>
        </div>

        <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white rounded p-2 font-semibold transition-all duration-200">
            Log Masuk
        </button>
    </form>

</body>
</html>
