<x-app-layout>
    <div style="background-color: #f0fdfa;" class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Header Halaman Admin -->
            <div class="bg-white rounded-2xl border border-teal-100 shadow-sm p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800">Halaman Admin</h2>
                    <p class="text-xs text-slate-500 mt-1">Kelola persetujuan, tentukan jadwal pengerjaan, dan atur status booking pelanggan.</p>
                </div>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-semibold shadow-sm flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Kartu Statistik Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Booking -->
                <div class="bg-white rounded-2xl border border-teal-100 p-6 shadow-sm">
                    <div class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Booking</div>
                    <div class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalBooking }}</div>
                </div>

                <!-- Booking Menunggu -->
                <div class="bg-white rounded-2xl border border-teal-100 p-6 shadow-sm">
                    <div class="text-slate-500 text-xs font-bold uppercase tracking-wider">Booking Menunggu</div>
                    <div class="text-3xl font-extrabold text-amber-600 mt-2">{{ $bookingMenunggu }}</div>
                </div>

                <!-- Total Pendapatan -->
                <div class="bg-white rounded-2xl border border-teal-100 p-6 shadow-sm">
                    <div class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Pendapatan (Selesai)</div>
                    <div class="text-3xl font-extrabold text-emerald-600 mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Tabel Daftar Booking -->
            <div class="bg-white rounded-2xl border border-teal-100 shadow-sm p-6">
                <div class="border-b border-slate-100 pb-4 mb-5">
                    <h3 class="text-lg font-extrabold text-slate-800">Daftar Pesanan Servis Masuk</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Atur jadwal dan konfirmasi pesanan pelanggan.</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-700">
                        <thead class="bg-teal-50/80 text-xs uppercase font-extrabold text-slate-700 tracking-wider border-b border-teal-100">
                            <tr>
                                <th class="px-4 py-3.5">No</th>
                                <th class="px-4 py-3.5">Nama Motor & Plat</th>
                                <th class="px-4 py-3.5">Keluhan</th>
                                <th class="px-4 py-3.5">Jadwal Pengerjaan</th>
                                <th class="px-4 py-3.5 text-center">Status</th>
                                <th class="px-4 py-3.5 text-center">Tentukan Waktu & Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($bookings as $index => $booking)
                                <tr class="hover:bg-teal-50/30 transition">
                                    <td class="px-4 py-4 font-bold text-slate-500">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4">
                                        <div class="font-extrabold text-slate-900">{{ $booking->nama_motor }}</div>
                                        <div class="text-xs font-mono font-bold text-slate-500">{{ $booking->plat_nomor }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600">{{ $booking->keluhan }}</td>
                                    <td class="px-4 py-4 text-slate-700 font-semibold">
                                        {{ $booking->tanggal_booking ? \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y - H:i') . ' WIB' : 'Belum diatur' }}
                                    </td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-extrabold rounded-full border 
                                            @if($booking->status == 'menunggu' || $booking->status == 'pending') bg-amber-100 text-amber-800 border-amber-200 
                                            @elseif($booking->status == 'disetujui' || $booking->status == 'proses') bg-blue-100 text-blue-800 border-blue-200 
                                            @elseif($booking->status == 'selesai') bg-emerald-100 text-emerald-800 border-emerald-200 
                                            @else bg-rose-100 text-rose-800 border-rose-200 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <form action="{{ route('admin.booking.status', $booking->id) }}" method="POST" class="inline-flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            
                                            @if($booking->status == 'menunggu' || $booking->status == 'pending')
                                                <!-- Pilih tanggal & jam sebelum disetujui -->
                                                <input type="datetime-local" name="tanggal_booking" value="{{ $booking->tanggal_booking }}" required class="text-xs rounded-lg border-slate-300 py-1.5 px-2 focus:ring-teal-500 focus:border-teal-500">
                                                
                                                <button type="submit" name="status" value="disetujui" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm">
                                                    Setujui
                                                </button>
                                                <button type="submit" name="status" value="ditolak" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm" formnovalidate>
                                                    Tolak
                                                </button>
                                            @elseif($booking->status == 'disetujui' || $booking->status == 'proses')
                                                <button type="submit" name="status" value="selesai" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm">
                                                    Tandai Selesai
                                                </button>
                                            @else
                                                <span class="text-xs text-slate-400 font-semibold">-</span>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500 font-semibold">
                                        Belum ada data booking servis.
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>