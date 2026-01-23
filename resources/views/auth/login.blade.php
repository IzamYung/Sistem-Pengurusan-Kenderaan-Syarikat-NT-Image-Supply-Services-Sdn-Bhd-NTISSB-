<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk | SPKS NTISSB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo_syarikat.png') }}">
</head>
<body
    class="min-h-screen font-sans flex flex-col justify-center items-center p-6 relative overflow-hidden bg-no-repeat bg-center bg-cover"
    style="background-image: url('{{ asset('images/bangunan_ntissb.svg') }}');"
>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-950/80 via-slate-900/75 to-black/80 z-0"></div>

    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100/50 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-50/50 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="fixed top-8 left-8 flex items-center gap-4 z-10 hidden md:flex bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
        <img src="{{ asset('images/logo_syarikat.png') }}" alt="Company Logo" class="w-12 h-12 object-contain">
        <span class="font-black text-[#1e3a8a] leading-tight text-xs uppercase tracking-tighter">
            NT Image Supply & Services<br>
            <span class="text-gray-400 font-bold text-[10px]">Sdn Bhd</span>
        </span>
    </div>

    <div class="w-full max-w-md relative z-20">
        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
            <div class="h-2 bg-[#1e3a8a]"></div>

            <div class="p-10 md:p-12">
                <div class="mb-10">
                    <h1 class="text-4xl font-black text-gray-800 uppercase tracking-tighter leading-none">
                        Selamat <br><span class="text-[#1e3a8a]">Datang!</span>
                    </h1>
                    <p class="mt-4 text-sm text-gray-500 font-medium leading-relaxed">
                        Log masuk untuk akses dashboard dan teruskan urusan kenderaan syarikat anda.
                    </p>
                </div>

                @if(Session::has('fail'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 text-xs font-bold animate-pulse">
                        {{ Session::get('fail') }}
                    </div>
                @endif

                <form action="{{ route('loginUser') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Alamat Email</label>
                        <div class="relative group">
                            <input type="email" name="email"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-50 focus:border-[#1e3a8a] focus:bg-white transition-all duration-300 shadow-sm"
                                placeholder="nama@email.com"
                                required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Kata Laluan</label>
                        <div class="relative group">
                            <input id="password" type="password" name="password"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-50 focus:border-[#1e3a8a] focus:bg-white transition-all duration-300 shadow-sm"
                                placeholder="••••••••"
                                required>

                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-4 flex items-center group-hover:scale-110 transition-transform">
                                <img id="toggleIcon" src="{{ asset('images/hide_password.png') }}" alt="Show Password" class="w-5 h-5 opacity-40 hover:opacity-100 transition-opacity">
                            </button>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-[#1e3a8a] hover:bg-blue-800 text-white rounded-2xl py-4 font-black uppercase text-xs tracking-[0.2em] shadow-xl shadow-blue-100 transform active:scale-[0.98] transition-all duration-200">
                            Log Masuk Sistem
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center mt-8 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">
            © {{ date('Y') }} NTISSB Management System
        </p>
    </div>

</body>
</html>