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
                            Selamat datang kembali, <strong class="text-red-600 font-bold">{{ Auth::user()->name }}</strong>! Silakan buat janji servis atau pantau status kendaraan Anda.
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

                        <a href="{{ route('booking.create') }}" style="background-color: #dc2626;" class="hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-md transition text-sm flex items-center gap-2 whitespace-nowrap">
                            + Buat Booking Baru
                        </a>
                    </div>

                </div>
            </div>

            <!-- Cards Status (Tanpa Ikon Gambar / Emoji) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="p-5 rounded-2xl shadow-sm">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Total Booking Saya</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $bookings->count() }}</h3>
                    <p class="text-xs text-slate-700 mt-0.5">Semua riwayat pengajuan</p>
                </div>

                <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="p-5 rounded-2xl shadow-sm">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Status Diproses</p>
                    <h3 class="text-3xl font-black text-amber-800 mt-1">
                        {{ $bookings->whereIn('status', ['pending', 'proses'])->count() }}
                    </h3>
                    <p class="text-xs text-slate-700 mt-0.5">Sedang dalam pengerjaan</p>
                </div>

                <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="p-5 rounded-2xl shadow-sm">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Servis Selesai</p>
                    <h3 class="text-3xl font-black text-emerald-900 mt-1">
                        {{ $bookings->where('status', 'selesai')->count() }}
                    </h3>
                    <p class="text-xs text-slate-700 mt-0.5">Motor siap diambil</p>
                </div>
            </div>

            <!-- Tabel Riwayat Booking -->
            <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="rounded-2xl shadow-sm overflow-hidden">
                <div style="background-color: #1b4332;" class="px-6 py-4 text-white flex justify-between items-center">
                    <h3 class="font-bold text-sm">
                        Riwayat Pesanan Servis Anda
                    </h3>
                    <span class="text-xs text-emerald-300 font-semibold">Live Monitoring</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-800">
                        <thead class="text-xs uppercase text-slate-900 font-black border-b border-teal-200" style="background-color: #b7e4c7;">
                            <tr>
                                <th class="px-6 py-3.5">NO</th>
                                <th class="px-6 py-3.5">NAMA MOTOR</th>
                                <th class="px-6 py-3.5">PLAT NOMOR</th>
                                <th class="px-6 py-3.5">KELUHAN</th>
                                <th class="px-6 py-3.5 text-center">STATUS</th>
                                <th class="px-6 py-3.5 text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-teal-200">
                            @forelse($bookings as $index => $booking)
                                <tr class="hover:bg-teal-100/50 transition">
                                    <td class="px-6 py-4 font-bold">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $booking->nama_motor }}</td>
                                    <td class="px-6 py-4 font-mono font-bold">{{ $booking->plat_nomor }}</td>
                                    <td class="px-6 py-4">{{ $booking->keluhan }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-extrabold 
                                            {{ $booking->status === 'selesai' ? 'bg-emerald-200 text-emerald-900' : ($booking->status === 'proses' ? 'bg-amber-200 text-amber-900' : 'bg-slate-200 text-slate-800') }}">
                                            {{ strtoupper($booking->status ?? 'PENDING') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('booking.edit', $booking->id) }}" class="text-teal-800 hover:text-teal-950 font-bold text-xs underline">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center">
                                        <div class="max-w-xs mx-auto">
                                            <h4 class="font-bold text-slate-900 text-sm">Belum Ada Riwayat Servis</h4>
                                            <p class="text-xs text-slate-700 mt-1 mb-3">Daftarkan motor Anda untuk memulai booking servis.</p>
                                            <a href="{{ route('booking.create') }}" style="background-color: #dc2626;" class="inline-block text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-red-700 transition shadow">
                                                + Buat Pesanan Baru
                                            </a>
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