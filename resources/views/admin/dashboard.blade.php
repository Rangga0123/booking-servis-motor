<x-app-layout>

    <div class="min-h-screen py-8"
         style="background: linear-gradient(135deg, #d9f3fa 0%, #d8f3dc 100%);">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">


            {{-- HEADER --}}
            <div class="rounded-2xl p-6 shadow-sm"
                 style="background-color: #d8f3dc; border: 2px solid #95d5b2;">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>

                        <h2 class="text-2xl font-bold text-slate-900">
                            Halaman Admin Bengkel
                        </h2>

                        <p class="text-sm text-slate-700 mt-1">
                            Kelola pesanan servis pelanggan, mekanik, jadwal, dan status pengerjaan.
                        </p>

                    </div>

                    <div class="px-5 py-3 rounded-xl"
                         style="background-color: #b7e4c7; border: 2px solid #74c69d;">

                        <p class="text-xs font-bold text-slate-700 uppercase">
                            Waktu Sistem
                        </p>

                        <p id="live-datetime"
                           class="text-sm font-semibold text-slate-900 mt-1">
                            Memuat waktu...
                        </p>

                    </div>

                </div>

            </div>


            {{-- STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="p-5 rounded-2xl shadow-sm"
                     style="background-color: #d8f3dc; border: 2px solid #95d5b2;">

                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Total Booking
                    </p>

                    <h3 class="text-3xl font-black text-slate-900 mt-1">
                        {{ $bookings->count() }}
                    </h3>

                    <p class="text-xs text-slate-700 mt-1">
                        Semua pesanan pelanggan
                    </p>

                </div>


                <div class="p-5 rounded-2xl shadow-sm"
                     style="background-color: #d8f3dc; border: 2px solid #95d5b2;">

                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Booking Menunggu
                    </p>

                    <h3 class="text-3xl font-black text-amber-800 mt-1">

                        {{ $bookings->filter(function ($booking) {
                            return in_array(
                                strtolower($booking->status ?? ''),
                                ['menunggu', 'pending']
                            );
                        })->count() }}

                    </h3>

                    <p class="text-xs text-slate-700 mt-1">
                        Menunggu persetujuan admin
                    </p>

                </div>


                <div class="p-5 rounded-2xl shadow-sm"
                     style="background-color: #d8f3dc; border: 2px solid #95d5b2;">

                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Servis Selesai
                    </p>

                    <h3 class="text-3xl font-black text-emerald-900 mt-1">

                        {{ $bookings->filter(function ($booking) {
                            return strtolower($booking->status ?? '') === 'selesai';
                        })->count() }}

                    </h3>

                    <p class="text-xs text-slate-700 mt-1">
                        Pesanan yang sudah selesai
                    </p>

                </div>

            </div>


            {{-- DAFTAR PESANAN --}}
            <div class="rounded-2xl shadow-sm p-4"
                 style="background-color: #c8e6cf; border: 2px solid #74c69d;">

                <div class="px-6 py-4 text-white flex flex-col md:flex-row md:items-center md:justify-between gap-3 rounded-xl mb-4"
                     style="background-color: #1b4332;">

                    <div>

                        <h3 class="font-bold text-base tracking-wide">
                            Daftar Pesanan Servis Masuk
                        </h3>

                        <p class="text-xs text-emerald-100 mt-1">
                            Atur jadwal, pilih mekanik, dan konfirmasi pesanan pelanggan.
                        </p>

                    </div>

                    <span class="text-xs font-semibold px-3 py-1.5 rounded-full"
                          style="background-color: #245c45; border: 1px solid #52b788;">

                        {{ $bookings->count() }} Pesanan

                    </span>

                </div>


                {{-- TABEL --}}
                <div class="overflow-x-auto rounded-xl"
                     style="border: 2px solid #52796f;">

                    <table class="w-full text-sm text-left"
                           style="border-collapse: collapse; background-color: #d8f3dc;">

                        <thead>

                            <tr style="background-color: #95d5b2;">

                                <th style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                    class="py-4 px-4 text-center w-14 font-bold text-slate-900">
                                    No
                                </th>

                                <th style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                    class="py-4 px-5 min-w-[170px] font-bold text-slate-900">
                                    Nama Motor & Plat
                                </th>

                                <th style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                    class="py-4 px-5 min-w-[230px] font-bold text-slate-900">
                                    Keluhan
                                </th>

                                <th style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                    class="py-4 px-5 min-w-[260px] font-bold text-slate-900">
                                    Jadwal Pengerjaan
                                </th>

                                <th style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                    class="py-4 px-5 text-center min-w-[130px] font-bold text-slate-900">
                                    Status
                                </th>

                                <th style="border-bottom: 2px solid #52796f;"
                                    class="py-4 px-5 text-center min-w-[330px] font-bold text-slate-900">
                                    Aksi Admin
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($bookings as $index => $item)

                                @php

                                    $status = strtolower($item->status ?? '');

                                    $jamBooking = $item->jam_booking
                                        ? str_replace(',', ':', trim($item->jam_booking))
                                        : '';

                                @endphp


                                <tr style="background-color: #e6f4ea;">


                                    {{-- NO --}}
                                    <td style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                        class="py-7 px-4 text-center font-bold text-slate-900 align-top">

                                        {{ $index + 1 }}

                                    </td>


                                    {{-- MOTOR --}}
                                    <td style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                        class="py-7 px-5 align-top">

                                        <div class="font-bold text-slate-900 break-words">
                                            {{ $item->nama_motor }}
                                        </div>

                                        <div class="text-xs text-slate-700 font-mono uppercase mt-3 whitespace-nowrap">
                                            {{ $item->plat_nomor }}
                                        </div>

                                    </td>


                                    {{-- KELUHAN --}}
                                    <td style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                        class="py-7 px-5 text-slate-800 align-top">

                                        <div class="max-w-[300px] break-words leading-relaxed">
                                            {{ $item->keluhan }}
                                        </div>

                                    </td>


                                    {{-- JADWAL --}}
                                    <td style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                        class="py-7 px-5 align-top">

                                        @if($item->tanggal_booking)

                                            {{-- TANGGAL --}}
                                            <div class="rounded-xl border-2 border-slate-300 bg-white p-3 shadow-sm">

                                                <div class="flex items-center gap-3">

                                                    <div class="w-9 h-9 rounded-lg bg-emerald-100 border border-emerald-300 flex items-center justify-center text-base">
                                                        📅
                                                    </div>

                                                    <div>

                                                        <p class="text-[10px] font-bold uppercase text-slate-500">
                                                            Tanggal
                                                        </p>

                                                        <p class="text-sm font-bold text-slate-900 whitespace-nowrap">
                                                            {{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y') }}
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- JAM --}}
                                            @if($jamBooking)

                                                @php

                                                    $jamAngka = intval(
                                                        substr($jamBooking, 0, 2)
                                                    );

                                                    if ($jamAngka >= 5 && $jamAngka < 11) {
                                                        $periode = 'Pagi';
                                                    } elseif ($jamAngka >= 11 && $jamAngka < 15) {
                                                        $periode = 'Siang';
                                                    } elseif ($jamAngka >= 15 && $jamAngka < 18) {
                                                        $periode = 'Sore';
                                                    } else {
                                                        $periode = 'Malam';
                                                    }

                                                @endphp


                                                <div class="rounded-xl border-2 border-slate-300 bg-white p-3 shadow-sm mt-3">

                                                    <div class="flex items-center gap-3">

                                                        <div class="w-9 h-9 rounded-lg bg-sky-100 border border-sky-300 flex items-center justify-center text-base">
                                                            🕐
                                                        </div>

                                                        <div>

                                                            <p class="text-[10px] font-bold uppercase text-slate-500">
                                                                Jam Servis
                                                            </p>

                                                            <div class="flex items-center gap-2">

                                                                <p class="text-sm font-bold text-slate-900">
                                                                    {{ $jamBooking }}
                                                                </p>

                                                                <span class="text-[10px] font-bold text-slate-600">
                                                                    WIB
                                                                </span>

                                                                <span class="text-[10px] font-bold text-emerald-700">
                                                                    {{ $periode }}
                                                                </span>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            @endif


                                            {{-- MEKANIK --}}
                                            @if($item->mechanic)

                                                <div class="rounded-xl border-2 border-slate-300 bg-white p-3 shadow-sm mt-3">

                                                    <div class="flex items-center gap-3">

                                                        <div class="w-9 h-9 rounded-lg bg-amber-100 border border-amber-300 flex items-center justify-center text-base">
                                                            👨‍🔧
                                                        </div>

                                                        <div>

                                                            <p class="text-[10px] font-bold uppercase text-slate-500">
                                                                Mekanik
                                                            </p>

                                                            <p class="text-sm font-bold text-slate-900">
                                                                {{ $item->mechanic->nama_mekanik }}
                                                            </p>

                                                        </div>

                                                    </div>

                                                </div>

                                            @endif

                                        @else

                                            <span class="text-xs text-slate-600 italic">
                                                Belum diatur
                                            </span>

                                        @endif

                                    </td>


                                    {{-- STATUS --}}
                                    <td style="border-right: 2px solid #52796f; border-bottom: 2px solid #52796f;"
                                        class="py-7 px-5 text-center align-top">

                                        @if($status == 'menunggu' || $status == 'pending')

                                            <span class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-4 py-2 rounded-full border-2 border-amber-300 whitespace-nowrap">
                                                Menunggu
                                            </span>

                                        @elseif($status == 'disetujui')

                                            <span class="inline-block bg-sky-100 text-sky-800 text-xs font-bold px-4 py-2 rounded-full border-2 border-sky-300 whitespace-nowrap">
                                                Disetujui
                                            </span>

                                        @elseif($status == 'selesai')

                                            <span class="inline-block bg-emerald-100 text-emerald-800 text-xs font-bold px-4 py-2 rounded-full border-2 border-emerald-300 whitespace-nowrap">
                                                Selesai
                                            </span>

                                        @elseif($status == 'ditolak')

                                            <span class="inline-block bg-rose-100 text-rose-800 text-xs font-bold px-4 py-2 rounded-full border-2 border-rose-300 whitespace-nowrap">
                                                Ditolak
                                            </span>

                                        @else

                                            <span class="inline-block bg-slate-100 text-slate-700 text-xs font-bold px-4 py-2 rounded-full border-2 border-slate-300 whitespace-nowrap">
                                                {{ ucfirst($item->status) }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- AKSI --}}
                                    <td style="border-bottom: 2px solid #52796f;"
                                        class="py-7 px-5 align-top">


                                        {{-- MENUNGGU --}}
                                        @if($status == 'menunggu' || $status == 'pending')

                                            <form action="{{ route('admin.booking.update', $item->id) }}"
                                                  method="POST">

                                                @csrf
                                                @method('PUT')


                                                {{-- TANGGAL --}}
                                                <div class="rounded-xl border-2 border-slate-300 bg-white p-3 shadow-sm">

                                                    <label class="block text-[10px] font-bold uppercase text-slate-600 mb-2">
                                                        📅 Tanggal Servis
                                                    </label>

                                                    <input
                                                        type="date"
                                                        name="tanggal_booking"
                                                        value="{{ $item->tanggal_booking ? \Carbon\Carbon::parse($item->tanggal_booking)->format('Y-m-d') : '' }}"
                                                        required
                                                        class="w-full h-[42px] text-xs px-3 rounded-lg border-2 border-slate-300 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-500"
                                                    >

                                                </div>


                                                {{-- JAM --}}
                                                <div class="rounded-xl border-2 border-slate-300 bg-white p-3 shadow-sm mt-3">

                                                    <label class="block text-[10px] font-bold uppercase text-slate-600 mb-2">
                                                        🕐 Jam Servis
                                                    </label>


                                                    <div class="flex gap-2">


                                                        {{-- INPUT JAM + WIB --}}
                                                        <div class="relative w-full h-[42px] rounded-lg border-2 border-slate-300 bg-slate-50 focus-within:ring-2 focus-within:ring-emerald-400 focus-within:border-emerald-500">

                                                            <input
                                                                type="text"
                                                                name="jam_booking"
                                                                id="jam_booking_{{ $item->id }}"
                                                                value="{{ $jamBooking }}"
                                                                placeholder="08:00"
                                                                maxlength="5"
                                                                required
                                                                autocomplete="off"
                                                                oninput="formatJam(this, {{ $item->id }})"
                                                                class="w-full h-full pl-3 pr-14 text-xs rounded-lg border-0 bg-transparent text-slate-800 focus:ring-0 focus:outline-none"
                                                            >

                                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-slate-600 pointer-events-none">
                                                                WIB
                                                            </span>

                                                        </div>


                                                        {{-- PERIODE --}}
                                                        <span
                                                            id="periode_{{ $item->id }}"
                                                            class="min-w-[65px] h-[42px] flex items-center justify-center text-[10px] font-bold rounded-lg bg-emerald-50 text-emerald-700 border-2 border-emerald-200"
                                                        >
                                                            Malam
                                                        </span>

                                                    </div>


                                                    <p class="text-[10px] text-slate-500 mt-2">
                                                        Format 24 jam
                                                    </p>

                                                </div>


                                                {{-- MEKANIK --}}
                                                <div class="rounded-xl border-2 border-slate-300 bg-white p-3 shadow-sm mt-3">

                                                    <label class="block text-[10px] font-bold uppercase text-slate-600 mb-2">
                                                        👨‍🔧 Mekanik
                                                    </label>

                                                    <select
                                                        name="mechanic_id"
                                                        required
                                                        class="w-full h-[42px] text-xs px-3 rounded-lg border-2 border-slate-300 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-500"
                                                    >

                                                        <option value="">
                                                            -- Pilih Mekanik --
                                                        </option>

                                                        @foreach($mechanics as $mechanic)

                                                            <option
                                                                value="{{ $mechanic->id }}"
                                                                {{ $item->mechanic_id == $mechanic->id ? 'selected' : '' }}
                                                            >
                                                                {{ $mechanic->nama_mekanik }}
                                                            </option>

                                                        @endforeach

                                                    </select>

                                                </div>


                                                {{-- TOMBOL --}}
                                                <div class="grid grid-cols-2 gap-3 mt-4">

                                                    <button
                                                        type="submit"
                                                        name="status"
                                                        value="Disetujui"
                                                        style="background-color: #15803d;"
                                                        class="w-full text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow hover:bg-green-800 transition"
                                                    >
                                                        ✓ Setujui
                                                    </button>


                                                    <button
                                                        type="submit"
                                                        name="status"
                                                        value="Ditolak"
                                                        style="background-color: #e11d48;"
                                                        class="w-full text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow hover:bg-rose-700 transition"
                                                    >
                                                        ✕ Tolak
                                                    </button>

                                                </div>

                                            </form>


                                        {{-- DISETUJUI --}}
                                        @elseif($status == 'disetujui')

                                            <div class="flex justify-center">

                                                <form action="{{ route('admin.booking.update', $item->id) }}"
                                                      method="POST">

                                                    @csrf
                                                    @method('PUT')

                                                    <button
                                                        type="submit"
                                                        name="status"
                                                        value="Selesai"
                                                        style="background-color: #0f766e;"
                                                        class="text-white text-xs font-bold px-6 py-2.5 rounded-lg shadow hover:bg-teal-800 transition whitespace-nowrap"
                                                    >
                                                        ✓ Tandai Selesai
                                                    </button>

                                                </form>

                                            </div>


                                        {{-- SELESAI --}}
                                        @elseif($status == 'selesai')

                                            <div class="flex justify-center">

                                                <span class="inline-block text-xs text-emerald-800 font-bold bg-emerald-100 px-4 py-2 rounded-full border-2 border-emerald-300 whitespace-nowrap">
                                                    ✓ Servis Selesai
                                                </span>

                                            </div>


                                        {{-- DITOLAK --}}
                                        @elseif($status == 'ditolak')

                                            <div class="flex justify-center">

                                                <span class="inline-block text-xs text-rose-800 font-bold bg-rose-100 px-4 py-2 rounded-full border-2 border-rose-300 whitespace-nowrap">
                                                    ✕ Pesanan Ditolak
                                                </span>

                                            </div>


                                        @else

                                            <div class="flex justify-center">

                                                <span class="inline-block text-xs text-slate-600 font-semibold bg-slate-100 px-4 py-2 rounded-full border-2 border-slate-300 whitespace-nowrap">
                                                    Terkunci
                                                </span>

                                            </div>

                                        @endif

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="6"
                                        style="border-bottom: 2px solid #52796f;"
                                        class="py-12 text-center">

                                        <div class="bg-white rounded-xl p-8 border-2 border-slate-300">

                                            <div class="text-4xl mb-3">
                                                📋
                                            </div>

                                            <h4 class="font-bold text-slate-900">
                                                Belum Ada Pesanan Servis
                                            </h4>

                                            <p class="text-xs text-slate-500 mt-1">
                                                Pesanan pelanggan yang masuk akan muncul di sini.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <script>

        /* =========================
           WAKTU SISTEM
        ========================== */

        function updateLiveDateTime() {

            const now = new Date();

            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };

            const dateStr = now.toLocaleDateString(
                'id-ID',
                options
            );

            const timeStr = now
                .toLocaleTimeString(
                    'id-ID',
                    {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    }
                )
                .replace(/\./g, ':');

            document.getElementById(
                'live-datetime'
            ).innerText =
                `${dateStr} | ${timeStr} WIB`;

        }

        setInterval(
            updateLiveDateTime,
            1000
        );

        updateLiveDateTime();


        /* =========================
           FORMAT JAM
        ========================== */

        function formatJam(input, id) {

            let value = input.value.replace(
                /[^0-9]/g,
                ''
            );


            if (value.length > 4) {

                value = value.substring(
                    0,
                    4
                );

            }


            if (value.length >= 3) {

                value =
                    value.substring(0, 2)
                    + ':'
                    + value.substring(2);

            }


            input.value = value;


            const periode =
                document.getElementById(
                    'periode_' + id
                );


            if (!periode) {
                return;
            }


            if (value.length !== 5) {

                periode.innerText =
                    'Waktu';

                return;

            }


            const jam =
                parseInt(
                    value.substring(0, 2),
                    10
                );


            if (jam >= 5 && jam < 11) {

                periode.innerText =
                    'Pagi';

            } else if (jam >= 11 && jam < 15) {

                periode.innerText =
                    'Siang';

            } else if (jam >= 15 && jam < 18) {

                periode.innerText =
                    'Sore';

            } else {

                periode.innerText =
                    'Malam';

            }

        }


        /* =========================
           LOAD PERIODE SAAT HALAMAN DIBUKA
        ========================== */

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                document
                    .querySelectorAll(
                        'input[name="jam_booking"]'
                    )
                    .forEach(
                        function (input) {

                            const id =
                                input.id.replace(
                                    'jam_booking_',
                                    ''
                                );

                            formatJam(
                                input,
                                id
                            );

                        }
                    );

            }
        );

    </script>

</x-app-layout>