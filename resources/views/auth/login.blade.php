<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <form action="{{ route('loginUser') }}" method="POST" class="bg-white p-8 rounded-2xl shadow w-96">
        @csrf
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

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

        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white rounded p-2 font-semibold">Login</button>
    </form>

</body>
</html>
