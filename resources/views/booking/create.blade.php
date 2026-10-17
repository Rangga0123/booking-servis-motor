
<x-app-layout>
    <div class="booking-page min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="booking-enter mx-auto max-w-4xl">

            <div class="mb-7">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-blue-700">
                    Royal Motor
                </p>

                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    Booking Servis Motor
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Lengkapi informasi kendaraan dan pilih jadwal servis yang kamu inginkan.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold">Ada data yang perlu diperbaiki.</p>

                    <ul class="mt-2 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 bg-white px-6 py-5 sm:px-8">
                    <h2 class="text-lg font-bold text-slate-900">
                        Formulir Pemesanan
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Kolom bertanda * wajib diisi.
                    </p>
                </div>

                <form action="{{ route('booking.store') }}" method="POST" class="space-y-8 p-6 sm:p-8">
                    @csrf

                    <section>
                        <h3 class="mb-4 border-b border-slate-100 pb-3 text-sm font-bold text-slate-900">
                            Data Pelanggan
                        </h3>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="nama_pelanggan" class="mb-2 block text-sm font-medium text-slate-700">
                                    Nama Pemesan
                                </label>

                                <input
                                    type="text"
                                    id="nama_pelanggan"
                                    value="{{ Auth::user()->name }}"
                                    readonly
                                    class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-600 outline-none"
                                >

                                <p class="mt-1 text-xs text-slate-400">
                                    Nama mengikuti akun yang sedang login.
                                </p>
                            </div>

                            <div>
                                <label for="email_pelanggan" class="mb-2 block text-sm font-medium text-slate-700">
                                    Email Pelanggan
                                </label>

                                <input
                                    type="email"
                                    id="email_pelanggan"
                                    value="{{ Auth::user()->email }}"
                                    readonly
                                    class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-600 outline-none"
                                >
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3 class="mb-4 border-b border-slate-100 pb-3 text-sm font-bold text-slate-900">
                            Data Kendaraan
                        </h3>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="nama_motor" class="mb-2 block text-sm font-medium text-slate-700">
                                    Merek / Tipe Motor *
                                </label>

                                <input
                                    type="text"
                                    name="nama_motor"
                                    id="nama_motor"
                                    value="{{ old('nama_motor') }}"
                                    placeholder="Contoh: Honda Vario 160"
                                    maxlength="255"
                                    required
                                    class="booking-input w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none"
                                >

                                @error('nama_motor')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="plat_nomor" class="mb-2 block text-sm font-medium text-slate-700">
                                    Nomor Polisi *
                                </label>

                                <input
                                    type="text"
                                    name="plat_nomor"
                                    id="plat_nomor"
                                    value="{{ old('plat_nomor') }}"
                                    placeholder="Contoh: B 1234 ABC"
                                    maxlength="20"
                                    required
                                    class="booking-input w-full rounded-xl border border-slate-300 px-4 py-3 text-sm uppercase text-slate-800 outline-none"
                                >

                                @error('plat_nomor')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3 class="mb-4 border-b border-slate-100 pb-3 text-sm font-bold text-slate-900">
                            Detail Servis dan Jadwal
                        </h3>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="jenis_servis" class="mb-2 block text-sm font-medium text-slate-700">
                                    Jenis Servis *
                                </label>

                                <select
                                    name="jenis_servis"
                                    id="jenis_servis"
                                    required
                                    class="booking-input w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none"
                                >
                                    <option value="">Pilih jenis servis</option>

                                    @php
                                        $jenisServis = [
                                            'Servis Biasa / Cek Kerusakan',
                                            'Servis Rutin / Berkala',
                                            'Ganti Oli Mesin / Gardan',
                                            'Ganti Aki / Baterai',
                                            'Ganti Ban / Velg',
                                            'Ganti Kampas Rem / Cakram',
                                            'Ganti Lampu / Kelistrikan',
                                            'Tune Up & CVT',
                                            'Servis Rem & Kaki-kaki',
                                            'Overhaul / Service Besar',
                                        ];
                                    @endphp

                                    @foreach ($jenisServis as $jenis)
                                        <option value="{{ $jenis }}" @selected(old('jenis_servis') === $jenis)>
                                            {{ $jenis }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('jenis_servis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_booking" class="mb-2 block text-sm font-medium text-slate-700">
                                    Tanggal Servis *
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_booking"
                                    id="tanggal_booking"
                                    value="{{ old('tanggal_booking') }}"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    class="booking-input w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none"
                                >

                                @error('tanggal_booking')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jam_booking" class="mb-2 block text-sm font-medium text-slate-700">
                                    Jam Servis *
                                </label>

                                <input
                                    type="time"
                                    name="jam_booking"
                                    id="jam_booking"
                                    value="{{ old('jam_booking') }}"
                                    required
                                    class="booking-input w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none"
                                >

                                <p id="ket_waktu" class="mt-2 text-xs text-slate-500"></p>

                                @error('jam_booking')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="keluhan" class="mb-2 block text-sm font-medium text-slate-700">
                                    Keluhan / Catatan Kendaraan *
                                </label>

                                <textarea
                                    name="keluhan"
                                    id="keluhan"
                                    rows="4"
                                    required
                                    placeholder="Jelaskan kendala motor yang ingin diperiksa..."
                                    class="booking-input w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none"
                                >{{ old('keluhan') }}</textarea>

                                @error('keluhan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3 class="mb-4 border-b border-slate-100 pb-3 text-sm font-bold text-slate-900">
                            Metode Pembayaran
                        </h3>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                            @foreach ([
                                'Bayar di Kasir (Cash)' => 'Bayar di Tempat',
                                'QRIS / E-Wallet' => 'QRIS / E-Wallet',
                                'Transfer Bank' => 'Transfer Bank',
                            ] as $value => $label)
                                <label class="payment-option flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-4 transition">
                                    <input
                                        type="radio"
                                        name="metode_pembayaran"
                                        value="{{ $value }}"
                                        @checked(old('metode_pembayaran', 'Bayar di Kasir (Cash)') === $value)
                                        required
                                        class="border-slate-300 text-blue-700 focus:ring-blue-600"
                                    >

                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        @error('metode_pembayaran')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </section>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                        <a
                            href="{{ route('booking.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                        >
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="booking-button rounded-xl bg-blue-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-800"
                        >
                            Kirim Booking
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-5 text-center text-xs text-slate-400">
                Royal Motor · Booking Servis Motor
            </p>
        </div>
    </div>

    <style>
        .booking-enter {
            animation: bookingEnter .5s ease-out both;
        }

        .booking-input {
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .booking-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        .booking-button {
            transition: transform .2s ease, background-color .2s ease, box-shadow .2s ease;
        }

        .booking-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(37, 99, 235, .18);
        }

        .payment-option:has(input:checked) {
            border-color: #2563eb;
            background: #eff6ff;
        }

        @keyframes bookingEnter {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .booking-enter,
            .booking-input,
            .booking-button,
            .payment-option {
                animation: none;
                transition: none;
            }
        }
    </style>

    <script>
        const jamInput = document.getElementById('jam_booking');
        const keteranganWaktu = document.getElementById('ket_waktu');

        function perbaruiKeteranganWaktu() {
            if (!jamInput || !keteranganWaktu) {
                return;
            }

            if (!jamInput.value) {
                keteranganWaktu.textContent = '';
                return;
            }

            const jam = Number(jamInput.value.split(':')[0]);

            if (jam < 11) {
                keteranganWaktu.textContent = 'Pagi';
            } else if (jam < 15) {
                keteranganWaktu.textContent = 'Siang';
            } else if (jam < 18) {
                keteranganWaktu.textContent = 'Sore';
            } else {
                keteranganWaktu.textContent = 'Malam';
            }
        }

        if (jamInput) {
            jamInput.addEventListener('input', perbaruiKeteranganWaktu);
            perbaruiKeteranganWaktu();
        }
    </script>
</x-app-layout>