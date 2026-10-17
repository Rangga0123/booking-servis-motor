
<x-app-layout>
    <div class="booking-page min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="booking-enter mx-auto max-w-3xl">

            <div class="mb-7">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-blue-700">
                    Royal Motor
                </p>

                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    Edit Data Booking
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Perbarui informasi kendaraan dan keluhan servis kamu.
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

                <div class="border-b border-slate-200 px-6 py-5 sm:px-8">
                    <h2 class="text-lg font-bold text-slate-900">
                        Formulir Edit Booking
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Periksa kembali data sebelum menyimpan perubahan.
                    </p>
                </div>

                <form
                    action="{{ route('booking.update', $booking->id) }}"
                    method="POST"
                    class="space-y-6 p-6 sm:p-8"
                >
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama_motor" class="mb-2 block text-sm font-medium text-slate-700">
                            Merek / Tipe Motor *
                        </label>

                        <input
                            type="text"
                            name="nama_motor"
                            id="nama_motor"
                            value="{{ old('nama_motor', $booking->nama_motor) }}"
                            maxlength="255"
                            required
                            class="booking-input w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none"
                            placeholder="Contoh: Honda Vario 160"
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
                            value="{{ old('plat_nomor', $booking->plat_nomor) }}"
                            maxlength="20"
                            required
                            class="booking-input w-full rounded-xl border border-slate-300 px-4 py-3 text-sm uppercase text-slate-800 outline-none"
                            placeholder="Contoh: B 1234 ABC"
                        >

                        @error('plat_nomor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="keluhan" class="mb-2 block text-sm font-medium text-slate-700">
                            Keluhan Kendaraan *
                        </label>

                        <textarea
                            name="keluhan"
                            id="keluhan"
                            rows="5"
                            required
                            placeholder="Jelaskan kendala motor yang ingin diperiksa..."
                            class="booking-input w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none"
                        >{{ old('keluhan', $booking->keluhan) }}</textarea>

                        @error('keluhan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                            Simpan Perubahan
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
            .booking-button {
                animation: none;
                transition: none;
            }
        }
    </style>
</x-app-layout>