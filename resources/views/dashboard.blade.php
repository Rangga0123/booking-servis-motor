<x-app-layout>
    <!-- Background Soft Cyan-Teal -->
    <div style="background: linear-gradient(135deg, #cff4fc 0%, #e0f2fe 50%, #d1fae5 100%);" class="py-6 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Banner Utama -->
            <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="rounded-2xl p-5 md:p-6 shadow-sm">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    
                    <div class="space-y-1">
                        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                            Dashboard Pelanggan
                        </h1>
                        <p class="text-slate-800 text-sm font-medium">
                            Selamat datang kembali, <strong class="text-slate-900 font-extrabold">{{ Auth::user()->name }}</strong>! Pantau status servis kendaraan Anda di sini.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <div style="background-color: #b7e4c7; border: 1px solid #74c69d;" class="px-4 py-2 rounded-xl text-left lg:text-right shadow-sm">
                            <div class="text-[10px] font-bold text-teal-950 uppercase tracking-wider">
                                WAKTU SISTEM
                            </div>
                            <div id="live-datetime" class="text-xs font-black text-slate-900">
                                Loading waktu...
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            @php
                $totalBooking = count($bookings);$totalProses = 0;
                $totalSelesai = 0;

                foreach ($bookings as$b) {
                    $st = strtolower($b->status ?? '');
                    if (in_array($st, ['proses', 'diproses', 'sedang dikerjakan', 'dikerjakan', 'disetujui'])) {$totalProses++;
                    }
                    if ($st === 'selesai') {$totalSelesai++;
                    }
                }
            @endphp

            <!-- Cards Status -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Kartu 1: Total Booking -->
                <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="p-5 rounded-2xl shadow-sm">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Total Booking Saya</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $totalBooking }}</h3>
                    <p class="text-xs text-slate-700 mt-0.5">Semua riwayat pengajuan</p>
                </div>

                <!-- Kartu 2: Status Diproses -->
                <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="p-5 rounded-2xl shadow-sm">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Status Diproses</p>
                    <h3 class="text-3xl font-black text-amber-800 mt-1">{{ $totalProses }}</h3>
                    <p class="text-xs text-slate-700 mt-0.5">Sedang dalam pengerjaan</p>
                </div>

                <!-- Kartu 3: Servis Selesai -->
                <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="p-5 rounded-2xl shadow-sm">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Servis Selesai</p>
                    <h3 class="text-3xl font-black text-emerald-900 mt-1">{{ $totalSelesai }}</h3>
                    <p class="text-xs text-slate-700 mt-0.5">Motor siap diambil</p>
                </div>
            </div>

            <!-- Tabel Riwayat Booking -->
            <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="rounded-2xl shadow-sm overflow-hidden p-4">
                <div style="background-color: #1b4332;" class="px-6 py-4 text-white flex justify-between items-center rounded-xl mb-4">
                    <h3 class="font-bold text-sm tracking-wide">
                        Riwayat Pesanan Servis Anda
                    </h3>
                    <span class="text-xs text-emerald-300 font-semibold px-3 py-1 rounded-full bg-emerald-900/50 border border-emerald-700">
                        Live Monitoring
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-800 border-separate" style="border-spacing: 0 10px;">
                        <thead>
                            <tr class="text-xs uppercase text-slate-900 font-black">
                                <th class="px-4 py-2 text-center">NO</th>
                                <th class="px-4 py-2">NAMA MOTOR & PLAT</th>
                                <th class="px-4 py-2 text-center">JADWAL PENGERJAAN</th>
                                <th class="px-4 py-2">MEKANIK</th>
                                <th class="px-4 py-2">KELUHAN</th>
                                <th class="px-4 py-2 text-center">PEMBAYARAN</th>
                                <th class="px-4 py-2 text-center">STATUS</th>
                                <th class="px-4 py-2 text-center">PILIHAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $index =>$booking)
                                <tr style="background-color: #ffffff;" class="shadow-sm hover:shadow-md transition-all rounded-xl">
                                    <td class="px-4 py-4 font-bold text-center text-slate-700 rounded-l-xl border-y border-l border-teal-200">
                                        {{ $index + 1 }}
                                    </td>
                                    
                                    <!-- NAMA MOTOR & PLAT -->
                                    <td class="px-4 py-4 border-y border-teal-200">
                                        <div class="font-extrabold text-slate-900 capitalize">{{ $booking->nama_motor }}</div>
                                        <div class="text-xs font-bold text-slate-500 uppercase">{{ $booking->plat_nomor }}</div>
                                    </td>

                                    <!-- JADWAL PENGERJAAN -->
                                    <td class="px-4 py-4 text-center border-y border-teal-200 whitespace-nowrap">
                                        @if($booking->tanggal_booking)
                                            <div class="font-bold text-slate-900">
                                                {{ date('d M Y', strtotime($booking->tanggal_booking)) }}
                                            </div>
                                            <div class="text-xs text-emerald-700 font-extrabold">
                                                @if(!empty($booking->jam_booking))
                                                    @php
                                                        $formattedJam = str_replace([',', '.'], ':', trim($booking->jam_booking));
                                                    @endphp
                                                    {{ $formattedJam }} WIB
                                                @else
                                                    Jam Sesuai Antrean
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400 italic">Belum ditentukan</span>
                                        @endif
                                    </td>

                                    <!-- MEKANIK -->
                                    <td class="px-4 py-4 border-y border-teal-200 whitespace-nowrap">
                                        @if($booking->mechanic)
                                            <div class="font-bold text-slate-900 flex items-center gap-1">
                                                👨‍🔧 {{ $booking->mechanic->nama_mekanik ?? $booking->mechanic->name }}
                                            </div>
                                            <div class="text-[11px] text-slate-500 font-medium">
                                                {{ $booking->mechanic->spesialisasi ?? $booking->mechanic->specialization ?? 'Mekanik Umum' }}
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400 italic">Belum ditunjuk</span>
                                        @endif
                                    </td>

                                    <!-- KELUHAN -->
                                    <td class="px-4 py-4 font-medium text-slate-800 max-w-xs truncate border-y border-teal-200">
                                        {{ $booking->keluhan }}
                                    </td>

                                    <!-- PEMBAYARAN -->
                                    <td class="px-4 py-4 text-center font-bold text-slate-900 uppercase whitespace-nowrap border-y border-teal-200">
                                        {{ $booking->metode_pembayaran ?? $booking->pembayaran ?? 'CASH (KASIR)' }}
                                    </td>

                                    <!-- STATUS -->
                                    <td class="px-4 py-4 text-center whitespace-nowrap border-y border-teal-200">
                                        @php $st = strtolower($booking->status ?? 'menunggu'); @endphp

                                        @if(in_array($st, ['selesai', 'lunas']))
                                            <span style="background-color: #a7f3d0; color: #065f46; border: 1px solid #34d399;" class="px-3 py-1 rounded-full text-xs font-black inline-block uppercase">
                                                {{ $booking->status }}
                                            </span>
                                        @elseif(in_array($st, ['sedang dikerjakan', 'proses', 'diproses', 'dikerjakan']))
                                            <span style="background-color: #fef08a; color: #854d0e; border: 1px solid #facc15;" class="px-3 py-1 rounded-full text-xs font-black inline-block uppercase">
                                                {{ $booking->status }}
                                            </span>
                                        @elseif(in_array($st, ['dibatalkan', 'batal', 'ditolak']))
                                            <span style="background-color: #fecdd3; color: #9f1239; border: 1px solid #fda4af;" class="px-3 py-1 rounded-full text-xs font-black inline-block uppercase">
                                                {{ $booking->status }}
                                            </span>
                                        @elseif(in_array($st, ['disetujui', 'diterima']))
                                            <span style="background-color: #bae6fd; color: #075985; border: 1px solid #38bdf8;" class="px-3 py-1 rounded-full text-xs font-black inline-block uppercase">
                                                {{ $booking->status }}
                                            </span>
                                        @else
                                            <span style="background-color: #e2e8f0; color: #334155; border: 1px solid #cbd5e1;" class="px-3 py-1 rounded-full text-xs font-black inline-block uppercase">
                                                {{ $booking->status ?? 'MENUNGGU' }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- TOMBOL PILIHAN (DIPERBAIKI) -->
                                    <td class="px-4 py-4 text-center rounded-r-xl border-y border-r border-teal-200">
                                        @if(in_array(strtolower($booking->status ?? 'pending'), ['pending', 'menunggu']))
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('booking.edit', $booking->id) }}" 
                                                   style="background-color: #ccfbf1; color: #115e59; border: 1px solid #2dd4bf;" 
                                                   class="font-black text-xs px-3 py-2 rounded-lg shadow-sm transition inline-block hover:bg-teal-200">
                                                    Edit
                                                </a>

                                                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5;" 
                                                            class="font-black text-xs px-3 py-2 rounded-lg shadow-sm transition hover:bg-red-200">
                                                        Batalkan
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-slate-400 text-xs font-semibold italic">Terkunci</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center bg-white rounded-xl">
                                        <div class="max-w-xs mx-auto">
                                            <h4 class="font-bold text-slate-900 text-sm">Belum Ada Riwayat Servis</h4>
                                            <p class="text-xs text-slate-700 mt-1">Untuk membuat pesanan baru, silakan gunakan menu <strong>Booking Servis</strong> pada navigasi atas.</p>
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
        function updateLiveDateTime() {
            const now = new Date();
            const options = { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' };
            const dateStr = now.toLocaleDateString('id-ID', options);
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
            document.getElementById('live-datetime').innerText = `${dateStr} | ${timeStr} WIB`;
        }
        setInterval(updateLiveDateTime, 1000);
        updateLiveDateTime();
    </script>
</x-app-layout>