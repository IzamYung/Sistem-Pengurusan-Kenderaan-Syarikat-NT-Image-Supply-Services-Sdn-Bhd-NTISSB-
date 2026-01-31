<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk | NTISSB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo_syarikat.png') }}">
</head>
<body
    class="min-h-screen font-sans flex items-center justify-center px-4 sm:px-6 md:px-8 relative"
    style="
        background-image: url('{{ asset('images/bangunan_ntissb.svg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
    "
>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-950/80 via-slate-900/75 to-black/80 z-0 h-full w-full"></div>

    <div class="absolute top-[-20%] left-[-20%] w-[70%] h-[70%] md:w-[40%] md:h-[40%] bg-blue-100/50 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-20%] w-[70%] h-[70%] md:w-[40%] md:h-[40%] bg-blue-50/50 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="fixed top-4 sm:top-6 left-4 sm:left-6 flex items-center gap-3 sm:gap-4 z-20 bg-white/95 backdrop-blur p-2 sm:p-3 rounded-2xl shadow-sm border border-gray-100">
        <img src="{{ asset('images/logo_syarikat.png') }}" alt="Company Logo" class="w-9 h-9 sm:w-10 sm:h-10 lg:w-12 lg:h-12 object-contain">
        <span class="font-black text-[#1e3a8a] leading-tight text-[10px] sm:text-xs uppercase tracking-tighter">
            NT Image Supply & Services<br>
            <span class="text-gray-400 font-bold text-[9px] sm:text-[10px]">Sdn Bhd</span>
        </span>
    </div>

    <div class="w-full max-w-sm sm:max-w-md relative z-20 mt-20 sm:mt-24">
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
            <div class="h-2 bg-[#1e3a8a]"></div>

            <div class="p-6 sm:p-8 md:p-10 lg:p-12">
                <div class="mb-8 sm:mb-10">
                    <h1 class="text-3xl sm:text-4xl font-black text-gray-800 uppercase tracking-tighter leading-none">
                        Selamat <br><span class="text-[#1e3a8a]">Datang!</span>
                    </h1>
                    <p class="mt-4 text-xs sm:text-sm text-gray-500 font-medium leading-relaxed">
                        Log masuk untuk akses dashboard dan teruskan urusan kenderaan syarikat anda.
                    </p>
                </div>

                @if(Session::has('fail'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 text-xs font-bold animate-pulse">
                        {{ Session::get('fail') }}
                    </div>
                @endif

                <form action="{{ route('loginUser') }}" method="POST" class="space-y-5 sm:space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Alamat Email</label>
                        <div class="relative group">
                            <input type="email" name="email"
                                class="w-full bg-gray-50 border border-gray-100 rounded-xl sm:rounded-2xl py-3 sm:py-4 px-4 sm:px-5 text-xs sm:text-sm font-bold text-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-50 focus:border-[#1e3a8a] focus:bg-white transition-all duration-300 shadow-sm"
                                placeholder="nama@email.com"
                                required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Kata Laluan</label>
                        <div class="relative group">
                            <input id="password" type="password" name="password"
                                class="w-full bg-gray-50 border border-gray-100 rounded-xl sm:rounded-2xl py-3 sm:py-4 px-4 sm:px-5 text-xs sm:text-sm font-bold text-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-50 focus:border-[#1e3a8a] focus:bg-white transition-all duration-300 shadow-sm"
                                placeholder="••••••••"
                                required>

                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-4 flex items-center group-hover:scale-110 transition-transform">
                                <img id="toggleIcon" src="{{ asset('images/hide_password.png') }}" alt="Show Password" class="w-4 h-4 sm:w-5 sm:h-5 opacity-40 hover:opacity-100 transition-opacity">
                            </button>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-[#1e3a8a] hover:bg-blue-800 text-white rounded-xl sm:rounded-2xl py-3 sm:py-4 font-black uppercase text-[10px] sm:text-xs tracking-[0.2em] shadow-xl shadow-blue-100 transform active:scale-[0.98] transition-all duration-200">
                            Log Masuk Sistem
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center mt-6 sm:mt-8 text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">
            © {{ date('Y') }} NTISSB Management System
        </p>
    </div>

</body>
</html>
