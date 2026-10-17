<x-app-layout>
    <div class="booking-page min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="booking-enter mx-auto max-w-7xl">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <p class="font-semibold">Periksa kembali data yang kamu masukkan.</p>
                    <ul class="mt-2 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                <div>
                    <p class="mb-2 text-sm font-semibold uppercase tracking-widest text-blue-700">
                        Royal Motor
                    </p>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                        Booking Servis
                    </h1>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">
                        Buat jadwal servis dan pantau perkembangan pesanan servis motormu.
                    </p>
                </div>

                <a href="{{ route('booking.create') }}"
                   class="booking-button inline-flex items-center justify-center rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-800">
                    Buat Booking Baru
                </a>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="booking-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Total Booking</p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ $totalBooking }}
                    </p>
                    <p class="mt-2 text-xs text-slate-400">Semua pesanan milikmu</p>
                </div>

                <div class="booking-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Sedang Diproses</p>
                    <p class="mt-3 text-3xl font-bold text-blue-700">
                        {{ $statusDiproses }}
                    </p>
                    <p class="mt-2 text-xs text-slate-400">Pesanan dalam penanganan</p>
                </div>

                <div class="booking-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Servis Selesai</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-700">
                        {{ $servisSelesai }}
                    </p>
                    <p class="mt-2 text-xs text-slate-400">Pesanan yang telah selesai</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
                    <h2 class="text-lg font-bold text-slate-900">Riwayat Booking Saya</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Informasi dan status booking yang tersimpan.
                    </p>
                </div>

                @if ($bookings->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <h3 class="text-lg font-semibold text-slate-800">Belum ada booking</h3>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            Pesanan servis yang kamu buat akan muncul di halaman ini.
                        </p>
                        <a href="{{ route('booking.create') }}"
                           class="booking-button mt-5 inline-flex rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                            Buat Booking Pertama
                        </a>
                    </div>
                @else
                    <div class="hidden overflow-x-auto md:block">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Kendaraan</th>
                                    <th class="px-6 py-4 font-semibold">Jenis Servis</th>
                                    <th class="px-6 py-4 font-semibold">Jadwal</th>
                                    <th class="px-6 py-4 font-semibold">Mekanik</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                    <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($bookings as $booking)
                                    @php
                                        $status = strtolower($booking->status ?? 'menunggu');

                                        $statusClass = match ($status) {
                                            'selesai' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                            'ditolak', 'dibatalkan' => 'bg-red-50 text-red-700 ring-red-600/20',
                                            'diproses', 'proses', 'sedang dikerjakan', 'dikerjakan', 'disetujui' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                            default => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                        };
                                    @endphp
                                    <tr class="booking-row transition-colors hover:bg-slate-50">
                                        <td class="px-6 py-5">
                                            <p class="font-semibold text-slate-900">{{ $booking->nama_motor }}</p>
                                            <p class="mt-1 text-xs text-slate-500">{{ $booking->plat_nomor }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-slate-600">
                                            {{ $booking->jenis_servis }}
                                        </td>
                                        <td class="px-6 py-5">
                                            <p class="font-medium text-slate-800">
                                                {{ \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ substr((string) $booking->jam_booking, 0, 5) }} WIB
                                            </p>
                                        </td>
                                        <td class="px-6 py-5 text-slate-600">
                                            {{ $booking->mechanic->nama_mekanik ?? 'Belum ditentukan' }}
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClass }}">
                                                {{ ucfirst($booking->status ?? 'Menunggu') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex justify-end gap-3">
                                                @if (in_array($status, ['menunggu', 'pending']))
                                                    <a href="{{ route('booking.edit', $booking->id) }}"
                                                       class="font-semibold text-blue-700 hover:text-blue-900">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('booking.cancel', $booking->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-semibold text-red-600 hover:text-red-800">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-slate-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="space-y-4 p-4 md:hidden">
                        @foreach ($bookings as $booking)
                            @php
                                $status = strtolower($booking->status ?? 'menunggu');

                                $statusClass = match ($status) {
                                    'selesai' => 'bg-emerald-50 text-emerald-700',
                                    'ditolak', 'dibatalkan' => 'bg-red-50 text-red-700',
                                    'diproses', 'proses', 'sedang dikerjakan', 'dikerjakan', 'disetujui' => 'bg-blue-50 text-blue-700',
                                    default => 'bg-amber-50 text-amber-700',
                                };
                            @endphp
                            <div class="booking-card rounded-xl border border-slate-200 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-slate-900">{{ $booking->nama_motor }}</h3>
                                        <p class="mt-1 text-xs text-slate-500">{{ $booking->plat_nomor }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                        {{ ucfirst($booking->status ?? 'Menunggu') }}
                                    </span>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-4 border-t border-slate-100 pt-4 text-sm">
                                    <div>
                                        <p class="text-xs text-slate-500">Jenis Servis</p>
                                        <p class="mt-1 font-medium text-slate-800">{{ $booking->jenis_servis }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Jadwal</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                        </p>
                                        <p class="text-xs text-slate-500">{{ substr((string) $booking->jam_booking, 0, 5) }} WIB</p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-xs text-slate-500">Mekanik</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $booking->mechanic->nama_mekanik ?? 'Belum ditentukan' }}
                                        </p>
                                    </div>
                                </div>

                                @if (in_array($status, ['menunggu', 'pending']))
                                    <div class="mt-4 flex gap-4 border-t border-slate-100 pt-4">
                                        <a href="{{ route('booking.edit', $booking->id) }}"
                                           class="text-sm font-semibold text-blue-700">Edit Booking</a>
                                        <form action="{{ route('booking.cancel', $booking->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-semibold text-red-600">
                                                Batalkan
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <p class="mt-5 text-center text-xs text-slate-400">
                Royal Motor · Booking Servis Motor
            </p>
        </div>
    </div>

    <style>
        .booking-enter {
            animation: bookingEnter .55s ease-out both;
        }

        .booking-card {
            animation: bookingEnter .5s ease-out both;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .booking-card:hover {
            transform: translateY(-2px);
            border-color: #cbd5e1;
            box-shadow: 0 8px 22px rgba(15, 23, 42, .05);
        }

        .booking-button {
            transition: background-color .2s ease, transform .2s ease, box-shadow .2s ease;
        }

        .booking-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(37, 99, 235, .18);
        }

        .booking-row {
            animation: bookingEnter .45s ease-out both;
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
            .booking-enter, .booking-card, .booking-row {
                animation: none;
                transition: none;
            }
        }
    </style>
</x-app-layout>