
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Bengkel Royal Motor</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .background-bengkel {
            background:
                linear-gradient(135deg, rgba(5, 23, 45, .88), rgba(12, 48, 85, .80)),
                url('https://images.unsplash.com/photo-1558981806-ec527fa84c39?q=80&w=1920&auto=format&fit=crop');

            background-size: cover;
            background-position: center;
        }

        .form-masuk {
            animation: muncul .6s ease-out both;
        }

        @keyframes muncul {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-form {
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .input-form:focus {
            outline: none;
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .tombol-daftar {
            transition: background .2s, transform .2s;
        }

        .tombol-daftar:hover {
            background: #1d4f87;
            transform: translateY(-1px);
        }

        @media (prefers-reduced-motion: reduce) {
            .form-masuk {
                animation: none;
            }

            .input-form,
            .tombol-daftar {
                transition: none;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100">

    <div class="grid min-h-screen lg:grid-cols-2">

        <!-- Bagian Kiri -->
        <section class="background-bengkel relative flex min-h-[270px] items-center overflow-hidden px-7 py-10 text-white sm:px-12 lg:min-h-screen lg:px-16">

            <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full border border-white/10"></div>
            <div class="absolute -bottom-24 -left-16 h-72 w-72 rounded-full border border-white/10"></div>

            <div class="relative z-10 mx-auto w-full max-w-lg">

                <div class="mb-10 flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 text-2xl">
                        🏍️
                    </div>

                    <div>
                        <h1 class="font-bold">Bengkel Royal Motor</h1>
                        <p class="text-sm text-blue-200">Booking Servis Motor</p>
                    </div>
                </div>

                <p class="mb-3 text-sm font-semibold uppercase tracking-widest text-blue-300">
                    Daftar Pelanggan
                </p>

                <h2 class="mb-4 text-3xl font-bold leading-tight sm:text-4xl">
                    Mulai Servis Motor dengan Lebih Mudah
                </h2>

                <p class="max-w-md text-sm leading-7 text-blue-100 sm:text-base">
                    Buat akun untuk menggunakan layanan booking servis
                    dan memantau status servis motor Anda.
                </p>

                <div class="mt-8 space-y-5">

                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-white/10">
                            📅
                        </div>
                        <div>
                            <p class="font-semibold">Booking Online</p>
                            <p class="text-sm text-blue-200">Pesan layanan dengan praktis</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-white/10">
                            🔧
                        </div>
                        <div>
                            <p class="font-semibold">Layanan Servis</p>
                            <p class="text-sm text-blue-200">Informasi layanan bengkel lebih mudah</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-white/10">
                            🛡️
                        </div>
                        <div>
                            <p class="font-semibold">Data Akun Terjaga</p>
                            <p class="text-sm text-blue-200">Satu Gmail untuk satu akun</p>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- Bagian Kanan -->
        <main class="flex items-center justify-center px-5 py-10 sm:px-10 lg:min-h-screen lg:px-14">

            <div class="form-masuk w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-9">

                <div class="mb-7">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-2xl">
                        👤
                    </div>

                    <h2 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                        Buat Akun Baru
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Isi data berikut untuk mendaftar sebagai pelanggan.
                    </p>
                </div>

                <!-- Pesan Error -->
                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                            Nama Lengkap
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            autofocus
                            autocomplete="name"
                            class="input-form w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-3 text-sm"
                        >
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">
                            Nomor HP
                        </label>

                        <input
                            id="phone"
                            type="tel"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Contoh: 081234567890"
                            required
                            autocomplete="tel"
                            inputmode="numeric"
                            class="input-form w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-3 text-sm"
                        >

                        <p class="mt-1 text-xs text-slate-400">
                            Satu nomor HP hanya untuk satu akun.
                        </p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                            Gmail
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@gmail.com"
                            required
                            autocomplete="email"
                            class="input-form w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-3 text-sm"
                        >

                        <p class="mt-1 text-xs text-slate-400">
                            Gmail yang sama tidak bisa didaftarkan dua kali.
                        </p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
                            Kata Sandi
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                            autocomplete="new-password"
                            class="input-form w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-3 text-sm"
                        >
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
                            Konfirmasi Kata Sandi
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi kata sandi"
                            required
                            autocomplete="new-password"
                            class="input-form w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-3 text-sm"
                        >
                    </div>

                    <!-- Tombol -->
                    <button
                        type="submit"
                        class="tombol-daftar mt-2 w-full rounded-lg bg-[#10345f] px-4 py-3.5 text-sm font-semibold text-white shadow-sm"
                    >
                        Daftar Sekarang →
                    </button>

                </form>

                <div class="mt-6 border-t border-slate-100 pt-5">
                    <p class="text-center text-sm text-slate-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:underline">
                            Login sekarang
                        </a>
                    </p>
                </div>

                <p class="mt-7 text-center text-xs text-slate-400">
                    © {{ date('Y') }} Bengkel Royal Motor
                </p>

            </div>

        </main>

    </div>

</body>
</html>