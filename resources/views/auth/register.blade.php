<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Booking Servis Motor</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 font-sans antialiased">

    <!-- Container Utama: Full Background Gambar Estetik Jepang -->
    <div class="min-h-screen relative flex items-center justify-center p-4 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1503899036084-c55cdd92da26?q=80&w=1920&auto=format&fit=crop');">
        
        <!-- Efek Gelap Transparan di atas Background agar Form Lebih Menonjol -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <!-- Kotak Form Register di Tengah (Card Glassmorphism Elegan) -->
        <div class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8 sm:p-10 border border-white/20">
            
            <!-- Header / Judul Form -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-red-50 text-red-600 mb-3 shadow-inner text-2xl">
                    🌸
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Buat Akun Baru</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Lengkapi data diri Anda untuk mendaftar ke sistem.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-100 transition outline-none text-sm"
                        placeholder="Nama Lengkap Anda">
                    @error('name')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-100 transition outline-none text-sm"
                        placeholder="nama@email.com">
                    @error('email')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-100 transition outline-none text-sm"
                        placeholder="Min. 8 karakter">
                    @error('password')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-100 transition outline-none text-sm"
                        placeholder="Ulangi kata sandi">
                    @error('password_confirmation')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol Register -->
                <button type="submit" class="w-full py-3.5 px-4 bg-gray-900 hover:bg-red-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 text-sm uppercase tracking-wider mt-2">
                    Daftar Sekarang
                </button>

                <!-- Link ke Login -->
                <p class="text-center text-xs text-gray-500 pt-3">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-red-600 font-bold hover:underline">Masuk di sini</a>
                </p>
            </form>

        </div>

    </div>

</body>
</html>