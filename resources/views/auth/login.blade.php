<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Booking Servis Motor</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 font-sans antialiased">

    <!-- Container Utama: Full Background Gambar Estetik Jepang -->
    <div class="min-h-screen relative flex items-center justify-center p-4 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1503899036084-c55cdd92da26?q=80&w=1920&auto=format&fit=crop');">
        
        <!-- Efek Gelap Transparan di atas Background agar Form Lebih Menonjol -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <!-- Kotak Form Login di Tengah (Card Glassmorphism Elegan) -->
        <div class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8 sm:p-10 border border-white/20">
            
            <!-- Header / Judul Form -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-red-50 text-red-600 mb-3 shadow-inner text-2xl">
                    🌸
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Selamat Datang Di Bengkel Royal Motor</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Silakan masuk menggunakan akun terdaftar Anda.</p>
            </div>

            <!-- Session Status / Pesan Sukses -->
            @if (session('status'))
                <div class="mb-4 text-xs font-medium text-emerald-600 bg-emerald-50 p-3 rounded-xl text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-100 transition outline-none text-sm"
                        placeholder="nama@email.com">
                    @error('email')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-100 transition outline-none text-sm"
                        placeholder="••••••••">
                    @error('password')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me & Lupa Password -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="text-gray-600 font-medium">Ingatkan saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-bold text-red-600 hover:text-red-800 transition">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <!-- Tombol Login -->
                <button type="submit" class="w-full py-3.5 px-4 bg-gray-900 hover:bg-red-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 text-sm uppercase tracking-wider mt-2">
                    Masuk ke Halaman
                </button>

                <!-- Link Register -->
                <p class="text-center text-xs text-gray-500 pt-3">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-red-600 font-bold hover:underline">Daftar sekarang</a>
                </p>
            </form>

        </div>

    </div>

</body>
</html>