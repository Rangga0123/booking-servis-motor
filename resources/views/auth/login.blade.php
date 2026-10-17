
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bengkel Royal Motor</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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

        a {
            text-decoration: none;
        }

        button, input {
            font: inherit;
        }

        .page {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            min-height: 100vh;
        }

        /* BAGIAN KIRI - INFORMASI BENGKEL */
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
                linear-gradient(
                    110deg,
                    rgba(7, 28, 49, .70),
                    rgba(13, 45, 74, .43)
                ),
                url("{{ asset('images/bengkel-royal.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transform: scale(1.04);
            transition: transform 1.2s ease;
        }

        .showcase:hover .showcase-image {
            transform: scale(1.08);
        }

        .showcase-overlay {
            position: absolute;
            z-index: -2;
            inset: 0;
            background: linear-gradient(
                0deg,
                rgba(5, 22, 38, .55),
                transparent 75%
            );
        }

        .light-line {
            position: absolute;
            top: 0;
            left: -40%;
            width: 25%;
            height: 100%;
            pointer-events: none;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, .08),
                transparent
            );
            transform: skewX(-18deg);
            animation: lightSweep 9s ease-in-out infinite;
        }

        .showcase-content {
            position: relative;
            width: 100%;
            max-width: 520px;
            margin: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

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

        .brand-name {
            font-size: 16px;
            font-weight: 700;
        }

        .brand-subtitle {
            margin-top: 4px;
            color: #d6e1ed;
            font-size: 11px;
        }

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

        .eyebrow::before {
            content: "";
            width: 24px;
            height: 2px;
            background: var(--gold);
        }

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
            transition:
                transform .25s ease,
                border-color .25s ease,
                background .25s ease;
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

        .info-value {
            color: #fff;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .info-note {
            margin-top: 4px;
            color: #dce5ee;
            font-size: 10px;
            line-height: 1.6;
        }

        .pkl-note {
            margin-top: 12px;
            padding: 10px 13px;
            border-left: 2px solid var(--gold);
            background: rgba(7, 27, 47, .45);
        }

        .pkl-note strong {
            display: block;
            margin-bottom: 4px;
            font-size: 11px;
        }

        .pkl-note p {
            color: #e0e7ef;
            font-size: 11px;
            line-height: 1.6;
        }

        .left-footer {
            margin-top: 15px;
            color: #d0dbe6;
            font-size: 10px;
        }

        /* BAGIAN KANAN - LOGIN */
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
                radial-gradient(
                    ellipse at 90% 12%,
                    rgba(69, 145, 235, .16),
                    transparent 36%
                ),
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
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, .8),
                rgba(190, 216, 249, .3)
            );
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
            background: linear-gradient(
                135deg,
                rgba(16, 45, 77, .95),
                rgba(40, 92, 139, .85)
            );
            pointer-events: none;
        }

        .login-box {
            position: relative;
            width: 100%;
            max-width: 440px;
            padding: 39px 36px 32px;
            border: 1px solid rgba(255, 255, 255, .9);
            border-radius: 16px;
            background: rgba(255, 255, 255, .88);
            box-shadow:
                0 22px 60px rgba(24, 57, 94, .10),
                0 3px 12px rgba(24, 57, 94, .04);
            backdrop-filter: blur(14px);
            animation: loginEnter .7s cubic-bezier(.2, .75, .25, 1) both;
        }

        .login-heading {
            margin-bottom: 29px;
        }

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
            font-size: clamp(29px, 2.4vw, 35px);
            font-weight: 750;
            letter-spacing: -1px;
        }

        .login-heading p {
            margin-top: 10px;
            color: #758194;
            font-size: 13px;
            line-height: 1.8;
        }

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

        .alert-success {
            border-color: #bde1c8;
            color: #246a3e;
            background: #f0faf3;
        }

        .field {
            margin-bottom: 21px;
        }

        .field label {
            display: block;
            margin-bottom: 9px;
            color: #263b55;
            font-size: 12px;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .field input[type="email"],
        .field input[type="password"],
        .field input[type="text"] {
            width: 100%;
            height: 49px;
            padding: 0 14px;
            border: 1px solid #d6e1ef;
            border-radius: 8px;
            outline: none;
            color: #203650;
            background: #f6f9fd;
            font-size: 13px;
            transition:
                border-color .25s ease,
                background .25s ease,
                box-shadow .25s ease;
        }

        .field input::placeholder {
            color: #9aa8ba;
        }

        .field input:hover {
            border-color: #a9c2df;
        }

        .field input:focus {
            border-color: #397bb8;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(40, 92, 139, .10);
        }

        .field .password-input {
            padding-right: 105px;
        }

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

        .toggle-password:hover {
            color: #102d4d;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin: 0 0 24px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #68778a;
            font-size: 12px;
            cursor: pointer;
        }

        .remember input {
            width: 15px;
            height: 15px;
            accent-color: #285c8b;
            cursor: pointer;
        }

        .link {
            color: #285c8b;
            font-size: 12px;
            font-weight: 700;
            transition: color .2s ease;
        }

        .link:hover {
            color: #102d4d;
            text-decoration: underline;
        }

        .submit-button {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            min-height: 49px;
            overflow: hidden;
            border: 1px solid #244f7c;
            border-radius: 8px;
            color: #fff;
            background: linear-gradient(105deg, #102d4d, #285c8b);
            box-shadow: 0 7px 16px rgba(16, 45, 77, .15);
            font-size: 13px;
            font-weight: 750;
            cursor: pointer;
            transition:
                transform .25s ease,
                box-shadow .25s ease,
                background .25s ease;
        }

        .submit-button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -120%;
            width: 65%;
            height: 100%;
            transform: skewX(-22deg);
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, .24),
                transparent
            );
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 11px 23px rgba(16, 45, 77, .22);
            background: linear-gradient(105deg, #173e66, #356fa5);
        }

        .submit-button:hover::before {
            animation: buttonShine .8s ease;
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .button-arrow {
            display: inline-block;
            transition: transform .25s ease;
        }

        .submit-button:hover .button-arrow {
            transform: translateX(5px);
        }

        .register-text {
            margin-top: 23px;
            color: #7c8795;
            text-align: center;
            font-size: 12px;
            line-height: 1.8;
        }

        .bottom-note {
            margin-top: 29px;
            color: #98a5b5;
            text-align: center;
            font-size: 10px;
            letter-spacing: .15px;
        }

        /* ANIMASI */
        .reveal {
            opacity: 0;
            transform: translateY(13px);
            transition:
                opacity .65s ease,
                transform .65s ease;
            transition-delay: var(--delay, 0ms);
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes lightSweep {
            0%, 65% {
                left: -40%;
            }
            100% {
                left: 130%;
            }
        }

        @keyframes buttonShine {
            from {
                left: -120%;
            }
            to {
                left: 150%;
            }
        }

        @keyframes loginEnter {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        
/* TABLET */
@media (max-width: 900px) {
    .page {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        min-height: 100svh;
    }

    .showcase {
        order: 1;
        min-height: auto;
        padding: 24px;
    }

    .showcase-content {
        width: 100%;
        max-width: 560px;
        margin: auto;
    }

    .login-panel {
        order: 2;
        min-height: auto;
        padding: 24px;
    }

    .login-box {
        width: 100%;
        max-width: 460px;
        margin: auto;
    }

    .main-title {
        font-size: clamp(27px, 5vw, 35px);
    }

    .brand {
        margin-bottom: 18px;
    }

    .login-heading {
        margin-bottom: 22px;
    }
}

/* HP */
@media (max-width: 480px) {
    .page {
        min-height: 100vh;
        min-height: 100svh;
    }

    .showcase {
        padding: 15px 18px 12px;
    }

    .brand {
        gap: 9px;
        margin-bottom: 12px;
    }

    .brand-logo {
        width: 35px;
        height: 35px;
        font-size: 12px;
    }

    .brand-name {
        font-size: 14px;
    }

    .brand-subtitle {
        font-size: 10px;
    }

    .eyebrow {
        margin-bottom: 6px;
        font-size: 9px;
        letter-spacing: 1.2px;
    }

    .main-title {
        font-size: 26px;
        line-height: 1.15;
        letter-spacing: -.5px;
    }

    .intro {
        margin-top: 7px;
        font-size: 11px;
        line-height: 1.5;
    }

    .info-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 7px;
        margin-top: 12px;
    }

    .info-card {
        padding: 8px;
        border-radius: 7px;
    }

    .info-label {
        margin-bottom: 4px;
        font-size: 8px;
        letter-spacing: .5px;
    }

    .info-value {
        font-size: 10px;
        line-height: 1.4;
    }

    .info-note {
        margin-top: 3px;
        font-size: 9px;
        line-height: 1.4;
    }

    .pkl-note,
    .left-footer {
        display: none;
    }

    .login-panel {
        padding: 12px 14px 18px;
    }

    .login-box {
        max-width: 420px;
        padding: 20px 19px 17px;
        border-radius: 13px;
    }

    .login-heading {
        margin-bottom: 17px;
    }

    .small-heading {
        margin-bottom: 7px;
        font-size: 9px;
        letter-spacing: 1.2px;
    }

    .login-heading h2 {
        font-size: 26px;
    }

    .login-heading p {
        margin-top: 5px;
        font-size: 11px;
        line-height: 1.5;
    }

    .field {
        margin-bottom: 13px;
    }

    .field label {
        margin-bottom: 6px;
        font-size: 11px;
    }

    .field input[type="email"],
    .field input[type="password"],
    .field input[type="text"] {
        height: 44px;
        font-size: 16px;
    }

    .form-options {
        gap: 8px;
        margin-bottom: 15px;
    }

    .remember,
    .link {
        font-size: 10px;
    }

    .submit-button {
        min-height: 44px;
        font-size: 12px;
    }

    .register-text {
        margin-top: 13px;
        font-size: 10px;
    }

    .bottom-note {
        margin-top: 13px;
        font-size: 9px;
    }
}

/* HP KECIL */
@media (max-width: 360px) {
    .showcase {
        padding: 12px 13px 10px;
    }

    .main-title {
        font-size: 23px;
    }

    .info-card {
        padding: 7px;
    }

    .login-panel {
        padding: 10px 10px 14px;
    }

    .login-box {
        padding: 17px 15px;
    }

    .login-heading h2 {
        font-size: 24px;
    }
}

            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>

<body>
<div class="page">

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
                <p class="eyebrow">Layanan Servis Motor</p>

                <h1 class="main-title">
                    Servis Motor Lebih Mudah dan Praktis
                </h1>

                <p class="intro">
                    Masuk ke akun Anda untuk melakukan booking servis
                    dan melihat informasi layanan bengkel.
                </p>
            </div>

            <div class="info-grid">
                <div class="info-card reveal" style="--delay: 180ms">
                    <p class="info-label">Pemimpin Bengkel</p>
                    <p class="info-value">Ardi (MR.DADONE)</p>
                    <p class="info-note">Bengkel Royal Motor</p>
                </div>

                <div class="info-card reveal" style="--delay: 260ms">
                    <p class="info-label">Jam Operasional</p>
                    <p class="info-value">Senin – Minggu</p>
                    <p class="info-note">13.00 – 22.00 WIB</p>
                </div>

                <div class="info-card reveal" style="--delay: 340ms">
                    <p class="info-label">Lokasi Bengkel</p>
                    <p class="info-value">Jl. Raya Tj. Kait, Ruko</p>
                    <p class="info-note">
                        Sebelah Balai Desa Tj. Anom, Mauk,
                        Tangerang 15131. RT 01 RW 03.
                    </p>
                </div>

                <div class="info-card reveal" style="--delay: 420ms">
                    <p class="info-label">Jenis Usaha</p>
                    <p class="info-value">Bengkel & Servis Motor</p>
                    <p class="info-note">
                        Perawatan kendaraan roda dua.
                    </p>
                </div>
            </div>

            <div class="pkl-note reveal" style="--delay: 500ms">
                <strong>Informasi</strong>
                <p>
                    Tempat PKL: In Autostar’s. Sistem dirancang
                    untuk membantu pelanggan menentukan jadwal
                    kedatangan sebelum servis.
                </p>
            </div>

            <p class="left-footer reveal" style="--delay: 580ms">
                &copy; {{ date('Y') }} Bengkel Royal Motor
            </p>

        </div>
    </section>

    <main class="login-panel">
        <div class="login-box">

            <div class="login-heading reveal" style="--delay: 80ms">
                <p class="small-heading">Area Pelanggan</p>
                <h2>Selamat Datang</h2>
                <p>
                    Silakan masuk menggunakan akun yang sudah terdaftar.
                </p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field reveal" style="--delay: 150ms">
                    <label for="email">Email / Gmail</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@gmail.com"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <div class="field reveal" style="--delay: 220ms">
                    <label for="password">Kata Sandi</label>

                    <div class="input-wrap">
                        <input
                            class="password-input"
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            required
                            autocomplete="current-password"
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-pressed="false"
                        >Lihat</button>
                    </div>
                </div>

                <div class="form-options reveal" style="--delay: 290ms">
                    <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        Ingat saya
                    </label>

                    @if (Route::has('password.request'))
                        <a class="link" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <div class="reveal" style="--delay: 350ms">
                    <button type="submit" class="submit-button">
                        Masuk ke Akun
                        <span class="button-arrow" aria-hidden="true">→</span>
                    </button>
                </div>
            </form>

            <div class="register-text reveal" style="--delay: 420ms">
                Belum punya akun?
                <a class="link" href="{{ route('register') }}">
                    Daftar sekarang
                </a>
            </div>

            <div class="bottom-note reveal" style="--delay: 480ms">
                Sistem Informasi Booking Servis Motor
            </div>

        </div>
    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Animasi elemen muncul bertahap
    const elements = document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.05
        });

        elements.forEach(function (element) {
            observer.observe(element);
        });
    } else {
        elements.forEach(function (element) {
            element.classList.add('is-visible');
        });
    }

    // Efek foto mengikuti mouse di laptop
    const showcase = document.querySelector('.showcase');
    const photo = document.querySelector('.showcase-image');

    if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        showcase.addEventListener('mousemove', function (event) {
            const rect = showcase.getBoundingClientRect();
            const x = (event.clientX - rect.left) / rect.width - 0.5;
            const y = (event.clientY - rect.top) / rect.height - 0.5;

            photo.style.transform =
                'scale(1.08) translate(' +
                (x * -7) + 'px, ' +
                (y * -7) + 'px)';
        });

        showcase.addEventListener('mouseleave', function () {
            photo.style.transform = '';
        });
    }

    // Tampilkan atau sembunyikan password
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (toggle && password) {
        toggle.addEventListener('click', function () {
            const show = password.type === 'password';

            password.type = show ? 'text' : 'password';
            toggle.textContent = show ? 'Sembunyikan' : 'Lihat';
            toggle.setAttribute('aria-pressed', String(show));
        });
    }
});
</script>

</body>
</html>