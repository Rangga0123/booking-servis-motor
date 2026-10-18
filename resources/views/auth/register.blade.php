<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Bengkel Royal Motor</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy: #102d4d;
            --blue: #285c8b;
            --gold: #d8b77d;
            --text: #202b3a;
            --muted: #758194;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background: #f3f5f8;
        }

        a { text-decoration: none; }
        button, input { font: inherit; }

        .page {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            min-height: 100vh;
        }

        /* ===== BAGIAN KIRI ===== */
        .showcase {
            position: relative;
            isolation: isolate;
            display: flex;
            align-items: center;
            min-width: 0;
            min-height: 100vh;
            padding: 35px clamp(28px, 4vw, 60px);
            overflow: hidden;
            color: white;
            background: var(--navy);
        }

        .showcase-image {
            position: absolute;
            z-index: -3;
            inset: -3%;
            background-image:
                linear-gradient(110deg, rgba(7, 28, 49, .70), rgba(13, 45, 74, .43)),
                url("{{ asset('images/bengkel-royal.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transform: scale(1.04);
            transition: transform 1.2s ease;
        }

        .showcase:hover .showcase-image { transform: scale(1.08); }

        .showcase-overlay {
            position: absolute;
            z-index: -2;
            inset: 0;
            background: linear-gradient(0deg, rgba(5, 22, 38, .55), transparent 75%);
        }

        .light-line {
            position: absolute;
            top: 0;
            left: -40%;
            width: 25%;
            height: 100%;
            pointer-events: none;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .08), transparent);
            transform: skewX(-18deg);
            animation: lightSweep 9s ease-in-out infinite;
        }

        .showcase-content {
            position: relative;
            width: 100%;
            max-width: 520px;
            margin: auto;
        }

        .brand { display: flex; align-items: center; gap: 12px; margin-bottom: 30px; }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, .55);
            border-radius: 7px;
            color: white;
            background: rgba(255, 255, 255, .1);
            font-size: 14px;
            font-weight: 800;
        }

        .brand-name { font-size: 16px; font-weight: 700; }
        .brand-subtitle { margin-top: 4px; color: #d6e1ed; font-size: 11px; }

        .eyebrow {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 12px;
            color: var(--gold);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .eyebrow::before { content: ""; width: 24px; height: 2px; background: var(--gold); }

        .main-title {
            max-width: 460px;
            font-size: clamp(29px, 3vw, 40px);
            line-height: 1.17;
            letter-spacing: -1px;
            font-weight: 750;
        }

        .intro {
            max-width: 460px;
            margin-top: 13px;
            color: #e2e9f1;
            font-size: 13px;
            line-height: 1.75;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 23px;
        }

        .info-card {
            min-width: 0;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 7px;
            background: rgba(7, 27, 47, .52);
            backdrop-filter: blur(4px);
            transition: transform .25s ease, border-color .25s ease, background .25s ease;
        }

        .info-card:hover {
            transform: translateY(-3px);
            border-color: var(--gold);
            background: rgba(7, 27, 47, .78);
        }

        .info-label {
            margin-bottom: 6px;
            color: var(--gold);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .info-value { color: #fff; font-size: 12px; font-weight: 650; line-height: 1.6; overflow-wrap: anywhere; }
        .info-note { margin-top: 4px; color: #dce5ee; font-size: 10px; line-height: 1.6; }

        .left-footer { margin-top: 15px; color: #d0dbe6; font-size: 10px; }

        /* ===== BAGIAN KANAN ===== */
        .login-panel {
            position: relative;
            isolation: isolate;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 0;
            min-height: 100vh;
            padding: 42px clamp(25px, 5vw, 65px);
            overflow: hidden;
            background:
                radial-gradient(ellipse at 90% 12%, rgba(69, 145, 235, .16), transparent 36%),
                linear-gradient(145deg, #f5f9ff 0%, #e8f1fc 100%);
        }

        .login-panel::before {
            content: "";
            position: absolute;
            z-index: -1;
            top: -145px;
            right: -100px;
            width: 390px;
            height: 245px;
            border: 1px solid rgba(40, 92, 139, .12);
            transform: rotate(-35deg);
            background: linear-gradient(135deg, rgba(255, 255, 255, .8), rgba(190, 216, 249, .3));
            pointer-events: none;
        }

        .login-panel::after {
            content: "";
            position: absolute;
            z-index: -1;
            right: -160px;
            bottom: -180px;
            width: 390px;
            height: 250px;
            transform: rotate(-35deg);
            background: linear-gradient(135deg, rgba(16, 45, 77, .95), rgba(40, 92, 139, .85));
            pointer-events: none;
        }

        .login-box {
            position: relative;
            width: 100%;
            max-width: 440px;
            padding: 36px 36px 30px;
            border: 1px solid rgba(255, 255, 255, .9);
            border-radius: 16px;
            background: rgba(255, 255, 255, .88);
            box-shadow: 0 22px 60px rgba(24, 57, 94, .10), 0 3px 12px rgba(24, 57, 94, .04);
            backdrop-filter: blur(14px);
            animation: loginEnter .7s cubic-bezier(.2, .75, .25, 1) both;
        }

        .login-heading { margin-bottom: 24px; }

        .small-heading {
            margin-bottom: 12px;
            color: #285c8b;
            font-size: 11px;
            font-weight: 750;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .login-heading h2 {
            color: #102d4d;
            font-size: clamp(27px, 2.4vw, 33px);
            font-weight: 750;
            letter-spacing: -1px;
        }

        .login-heading p { margin-top: 10px; color: #758194; font-size: 13px; line-height: 1.8; }

        .alert {
            margin-bottom: 17px;
            padding: 12px 14px;
            border: 1px solid #f1cccc;
            border-radius: 8px;
            color: #a52b2b;
            background: #fff5f5;
            font-size: 12px;
            line-height: 1.7;
        }

        .alert strong { display: block; margin-bottom: 4px; }
        .alert ul { padding-left: 18px; }

        .field { margin-bottom: 17px; }

        .field label { display: block; margin-bottom: 8px; color: #263b55; font-size: 12px; font-weight: 700; }

        .input-wrap { position: relative; }

        .field input[type="email"],
        .field input[type="password"],
        .field input[type="text"],
        .field input[type="tel"] {
            width: 100%;
            height: 48px;
            padding: 0 14px;
            border: 1px solid #d6e1ef;
            border-radius: 8px;
            outline: none;
            color: #203650;
            background: #f6f9fd;
            font-size: 13px;
            transition: border-color .25s ease, background .25s ease, box-shadow .25s ease;
        }

        .field input::placeholder { color: #9aa8ba; }
        .field input:hover { border-color: #a9c2df; }

        .field input:focus {
            border-color: #397bb8;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(40, 92, 139, .10);
        }

        .field.has-error input { border-color: #e3a1a1; background: #fffafa; }

        .field .password-input { padding-right: 105px; }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 13px;
            transform: translateY(-50%);
            padding: 5px 0 5px 8px;
            border: 0;
            color: #285c8b;
            background: transparent;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: color .2s ease;
        }

        .toggle-password:hover { color: #102d4d; }

        .hint { margin-top: 6px; color: #8794a6; font-size: 11px; line-height: 1.6; }
        .field-error { margin-top: 6px; color: #b83232; font-size: 11px; line-height: 1.6; }

        .link { color: #285c8b; font-size: 12px; font-weight: 700; transition: color .2s ease; }
        .link:hover { color: #102d4d; text-decoration: underline; }

        .submit-button {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            min-height: 49px;
            margin-top: 8px;
            overflow: hidden;
            border: 1px solid #244f7c;
            border-radius: 8px;
            color: #fff;
            background: linear-gradient(105deg, #102d4d, #285c8b);
            box-shadow: 0 7px 16px rgba(16, 45, 77, .15);
            font-size: 13px;
            font-weight: 750;
            cursor: pointer;
            transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
        }

        .submit-button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -120%;
            width: 65%;
            height: 100%;
            transform: skewX(-22deg);
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .24), transparent);
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 11px 23px rgba(16, 45, 77, .22);
            background: linear-gradient(105deg, #173e66, #356fa5);
        }

        .submit-button:hover::before { animation: buttonShine .8s ease; }
        .submit-button:active { transform: translateY(0); }
        .submit-button:disabled { opacity: .75; cursor: wait; }

        .button-arrow { display: inline-block; transition: transform .25s ease; }
        .submit-button:hover .button-arrow { transform: translateX(5px); }

        .register-text { margin-top: 21px; color: #7c8795; text-align: center; font-size: 12px; line-height: 1.8; }
        .bottom-note { margin-top: 22px; color: #98a5b5; text-align: center; font-size: 10px; letter-spacing: .15px; }

        /* ===== ANIMASI ===== */
        .reveal {
            opacity: 0;
            transform: translateY(13px);
            transition: opacity .65s ease, transform .65s ease;
            transition-delay: var(--delay, 0ms);
        }

        .reveal.is-visible { opacity: 1; transform: translateY(0); }

        @keyframes lightSweep { 0%, 65% { left: -40%; } 100% { left: 130%; } }
        @keyframes buttonShine { from { left: -120%; } to { left: 150%; } }
        @keyframes loginEnter { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }

        /* ===== TABLET ===== */
        @media (max-width: 900px) {
            .page { display: flex; flex-direction: column; min-height: 100vh; min-height: 100svh; }
            .showcase { order: 1; min-height: auto; padding: 24px; }
            .showcase-content { width: 100%; max-width: 560px; margin: auto; }
            .login-panel { order: 2; min-height: auto; padding: 24px; }
            .login-box { width: 100%; max-width: 460px; margin: auto; }
            .main-title { font-size: clamp(27px, 5vw, 35px); }
            .brand { margin-bottom: 18px; }
        }

        /* ===== HP ===== */
        @media (max-width: 480px) {
            .showcase { padding: 15px 18px 12px; }
            .brand { gap: 9px; margin-bottom: 12px; }
            .brand-logo { width: 35px; height: 35px; font-size: 12px; }
            .brand-name { font-size: 14px; }
            .brand-subtitle { font-size: 10px; }
            .eyebrow { margin-bottom: 6px; font-size: 9px; letter-spacing: 1.2px; }
            .main-title { font-size: 26px; line-height: 1.15; letter-spacing: -.5px; }
            .intro { margin-top: 7px; font-size: 11px; line-height: 1.5; }
            .info-grid { gap: 7px; margin-top: 12px; }
            .info-card { padding: 8px; }
            .info-label { margin-bottom: 4px; font-size: 8px; letter-spacing: .5px; }
            .info-value { font-size: 10px; line-height: 1.4; }
            .info-note { margin-top: 3px; font-size: 9px; line-height: 1.4; }
            .left-footer { display: none; }

            .login-panel { padding: 12px 14px 18px; }
            .login-box { max-width: 420px; padding: 20px 19px 17px; border-radius: 13px; }
            .login-heading { margin-bottom: 15px; }
            .small-heading { margin-bottom: 7px; font-size: 9px; letter-spacing: 1.2px; }
            .login-heading h2 { font-size: 24px; }
            .login-heading p { margin-top: 5px; font-size: 11px; line-height: 1.5; }
            .field { margin-bottom: 13px; }
            .field label { margin-bottom: 6px; font-size: 11px; }

            .field input[type="email"],
            .field input[type="password"],
            .field input[type="text"],
            .field input[type="tel"] { height: 44px; font-size: 16px; }

            .submit-button { min-height: 44px; font-size: 12px; }
            .register-text { margin-top: 13px; font-size: 11px; }
            .bottom-note { margin-top: 13px; font-size: 9px; }
        }

        @media (max-width: 360px) {
            .showcase { padding: 12px 13px 10px; }
            .main-title { font-size: 23px; }
            .info-card { padding: 7px; }
            .login-panel { padding: 10px 10px 14px; }
            .login-box { padding: 17px 15px; }
            .login-heading h2 { font-size: 22px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            .reveal { opacity: 1; transform: none; }
        }
    </style>
</head>

<body>
<div class="page">

    {{-- ================= KIRI ================= --}}
    <section class="showcase">
        <div class="showcase-image"></div>
        <div class="showcase-overlay"></div>
        <div class="light-line"></div>

        <div class="showcase-content">

            <div class="brand reveal" style="--delay: 0ms">
                <div class="brand-logo">RM</div>
                <div>
                    <div class="brand-name">Bengkel Royal Motor</div>
                    <div class="brand-subtitle">Sistem Booking Servis Motor</div>
                </div>
            </div>

            <div class="reveal" style="--delay: 100ms">
                <p class="eyebrow">Daftar Pelanggan</p>

                <h1 class="main-title">Mulai Servis Motor dengan Lebih Mudah</h1>

                <p class="intro">
                    Buat akun untuk menggunakan layanan booking servis
                    dan memantau status servis motor Anda.
                </p>
            </div>

            <div class="info-grid">
                <div class="info-card reveal" style="--delay: 180ms">
                    <p class="info-label">Booking Online</p>
                    <p class="info-value">Pesan jadwal servis</p>
                    <p class="info-note">Tanpa antre, pilih waktu kedatangan sendiri.</p>
                </div>

                <div class="info-card reveal" style="--delay: 260ms">
                    <p class="info-label">Pantau Status</p>
                    <p class="info-value">Riwayat booking</p>
                    <p class="info-note">Lihat perkembangan servis motor Anda.</p>
                </div>

                <div class="info-card reveal" style="--delay: 340ms">
                    <p class="info-label">Satu Akun</p>
                    <p class="info-value">Gmail dan No. HP unik</p>
                    <p class="info-note">Satu Gmail dan satu nomor HP hanya untuk satu akun.</p>
                </div>

                <div class="info-card reveal" style="--delay: 420ms">
                    <p class="info-label">Jam Operasional</p>
                    <p class="info-value">Senin – Minggu</p>
                    <p class="info-note">13.00 – 22.00 WIB</p>
                </div>
            </div>

            <p class="left-footer reveal" style="--delay: 500ms">
                &copy; {{ date('Y') }} Bengkel Royal Motor
            </p>

        </div>
    </section>

    {{-- ================= KANAN ================= --}}
    <main class="login-panel">
        <div class="login-box">

            <div class="login-heading reveal" style="--delay: 80ms">
                <p class="small-heading">Area Pelanggan</p>
                <h2>Buat Akun Baru</h2>
                <p>Isi data berikut untuk mendaftar sebagai pelanggan.</p>
            </div>

            @if ($errors->any())
                <div class="alert">
                    <strong>Pendaftaran belum berhasil.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="formDaftar">
                @csrf

                <div class="field reveal @error('name') has-error @enderror" style="--delay: 140ms">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        required autofocus autocomplete="name">
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field reveal @error('phone') has-error @enderror" style="--delay: 190ms">
                    <label for="phone">Nomor HP</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                        placeholder="Contoh: 081234567890"
                        required autocomplete="tel" inputmode="numeric" maxlength="16">
                    @error('phone')
                        <p class="field-error">{{ $message }}</p>
                    @else
                        <p class="hint">Satu nomor HP hanya untuk satu akun.</p>
                    @enderror
                </div>

                <div class="field reveal @error('email') has-error @enderror" style="--delay: 240ms">
                    <label for="email">Email / Gmail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        placeholder="nama@gmail.com"
                        required autocomplete="username">
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @else
                        <p class="hint">Gmail yang sama tidak bisa didaftarkan dua kali.</p>
                    @enderror
                </div>

                <div class="field reveal @error('password') has-error @enderror" style="--delay: 290ms">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrap">
                        <input class="password-input" id="password" type="password" name="password"
                            placeholder="Minimal 8 karakter"
                            required autocomplete="new-password">
                        <button type="button" class="toggle-password" data-target="password" aria-pressed="false">Lihat</button>
                    </div>
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field reveal" style="--delay: 340ms">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="input-wrap">
                        <input class="password-input" id="password_confirmation" type="password"
                            name="password_confirmation"
                            placeholder="Ulangi kata sandi"
                            required autocomplete="new-password">
                        <button type="button" class="toggle-password" data-target="password_confirmation" aria-pressed="false">Lihat</button>
                    </div>
                </div>

                <div class="reveal" style="--delay: 390ms">
                    <button type="submit" class="submit-button" id="btnDaftar">
                        Daftar Sekarang
                        <span class="button-arrow" aria-hidden="true">→</span>
                    </button>
                </div>
            </form>

            <div class="register-text reveal" style="--delay: 440ms">
                Sudah punya akun?
                <a class="link" href="{{ route('login') }}">Login sekarang</a>
            </div>

            <div class="bottom-note reveal" style="--delay: 490ms">
                Sistem Informasi Booking Servis Motor
            </div>

        </div>
    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Animasi muncul bertahap
    const elements = document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.05 });

        elements.forEach(function (el) { observer.observe(el); });
    } else {
        elements.forEach(function (el) { el.classList.add('is-visible'); });
    }

    // Foto mengikuti mouse di laptop
    const showcase = document.querySelector('.showcase');
    const photo = document.querySelector('.showcase-image');

    if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        showcase.addEventListener('mousemove', function (e) {
            const r = showcase.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - 0.5;
            const y = (e.clientY - r.top) / r.height - 0.5;
            photo.style.transform = 'scale(1.08) translate(' + (x * -7) + 'px, ' + (y * -7) + 'px)';
        });

        showcase.addEventListener('mouseleave', function () { photo.style.transform = ''; });
    }

    // Lihat / sembunyikan kata sandi (dua kolom)
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(btn.dataset.target);
            if (!input) return;
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.textContent = show ? 'Sembunyikan' : 'Lihat';
            btn.setAttribute('aria-pressed', String(show));
        });
    });

    // Nomor HP: hanya angka dan tanda +
    const phone = document.getElementById('phone');
    if (phone) {
        phone.addEventListener('input', function () {
            phone.value = phone.value.replace(/[^0-9+]/g, '');
        });
    }

    // Cegah klik ganda
    const form = document.getElementById('formDaftar');
    const btn = document.getElementById('btnDaftar');
    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.firstChild.textContent = 'Memproses... ';
        });
    }
});
</script>

</body>
</html>