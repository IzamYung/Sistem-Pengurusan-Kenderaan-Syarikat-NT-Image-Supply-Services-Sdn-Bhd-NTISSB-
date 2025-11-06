<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-50 font-sans">
    <div class="fixed top-4 left-4 px-4 py-2 z-10 max-w-xs max-h-auto">
        <span class="font-medium">NT Image Supply & Services SDN BHD</span>
    </div>

    <div class="flex min-h-screen items-center justify-center p-4">
        <form action="{{ route('loginUser') }}" method="POST" class="w-full max-w-md bg-white p-8">
            @csrf
            <div class="mb-6 text-left">
                <h1 class="text-3xl sm:text-1xl font-bold">Selamat Datang!</h1>
                <h3 class="text-justify mt-2 text-1xl">Log masuk untuk akses dashboard dan teruskan urusan kenderaan syarikat anda.</h3>
            </div>

            @if(Session::has('fail'))
                <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
                    {{ Session::get('fail') }}
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2 mt-1 focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" class="w-full border rounded p-2 mt-1 focus:ring focus:ring-blue-200" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white rounded p-2 font-semibold">Log Masuk</button>
        </form>
    </div>
</body>
</html>