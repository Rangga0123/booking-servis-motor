<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- HEADER PAGE -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h2 class="text-2xl font-bold text-slate-800">Halaman Admin Bengkel</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola persetujuan, tentukan mekanik, dan atur jadwal pengerjaan servis pelanggan.</p>
            </div>

            <!-- CARDS STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- CARD 1 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">TOTAL BOOKING</div>
                    <div class="text-4xl font-extrabold text-slate-800 mt-2">
                        {{ $bookings->count() }}
                    </div>
                </div>

                <!-- CARD 2 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">BOOKING MENUNGGU</div>
                    <div class="text-4xl font-extrabold text-amber-600 mt-2">
                        {{ $bookings->whereIn('status', ['menunggu', 'Menunggu', 'pending'])->count() }}
                    </div>
                </div>

                <!-- CARD 3 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">SERVIS SELESAI</div>
                    <div class="text-4xl font-extrabold text-emerald-600 mt-2">
                        {{ $bookings->whereIn('status', ['selesai', 'Selesai'])->count() }}
                    </div>
                </div>
            </div>

            <!-- TABEL DAFTAR PESANAN SERVIS MASUK -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Daftar Pesanan Servis Masuk</h3>
                    <p class="text-xs text-slate-500">Atur jadwal, pilih mekanik, dan konfirmasi pesanan pelanggan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-bold uppercase text-slate-500">
                                <th class="py-3 px-2 text-center">NO</th>
                                <th class="py-3 px-3">NAMA MOTOR & PLAT</th>
                                <th class="py-3 px-3">KELUHAN</th>
                                <th class="py-3 px-3">JADWAL PENGERJAAN</th>
                                <th class="py-3 px-3 text-center">STATUS</th>
                                <th class="py-3 px-3 text-center">TENTUKAN WAKTU, MEKANIK & AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($bookings as $index => $item)
                                @php
                                    $status = strtolower($item->status);
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-2 text-center font-bold text-slate-700">{{ $index + 1 }}</td>
                                    
                                    <!-- NAMA MOTOR & PLAT -->
                                    <td class="py-4 px-3">
                                        <div class="font-bold text-slate-800">{{ $item->nama_motor }}</div>
                                        <div class="text-xs text-slate-400 font-mono uppercase">{{ $item->plat_nomor }}</div>
                                    </td>

                                    <!-- KELUHAN -->
                                    <td class="py-4 px-3 text-slate-700">
                                        {{ $item->keluhan }}
                                    </td>

                                    <!-- JADWAL PENGERJAAN & MEKANIK -->
                                    <td class="py-4 px-3 font-semibold text-slate-800">
                                        @if($item->tanggal_booking)
                                            <div class="flex items-center gap-1.5">
                                                <span>🗓️ {{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y - H:i') }} WIB</span>
                                            </div>
                                            @if($item->mechanic)
                                                <div class="text-xs text-emerald-600 font-bold mt-1 flex items-center gap-1">
                                                    👨‍🔧 Mekanik: {{ $item->mechanic->nama_mekanik }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-slate-400 italic font-normal">Belum diatur</span>
                                        @endif
                                    </td>

                                    <!-- STATUS BADGE -->
                                    <td class="py-4 px-3 text-center">
                                        @if($status == 'menunggu' || $status == 'pending')
                                            <span class="bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full border border-amber-200/60">
                                                Menunggu
                                            </span>
                                        @elseif($status == 'disetujui')
                                            <span class="bg-sky-50 text-sky-700 text-xs font-semibold px-3 py-1 rounded-full border border-sky-200/60">
                                                Disetujui
                                            </span>
                                        @elseif($status == 'selesai')
                                            <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full border border-emerald-200/60">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="bg-rose-50 text-rose-700 text-xs font-semibold px-3 py-1 rounded-full border border-rose-200/60">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- TENTUKAN WAKTU, MEKANIK & AKSI -->
                                    <td class="py-4 px-3 text-center whitespace-nowrap">
                                        @if($status == 'menunggu' || $status == 'pending')
                                            <form action="{{ route('admin.booking.update', $item->id) }}" method="POST" class="inline-flex items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                
                                                <!-- INPUT DATETIME LOCAL (24 JAM) -->
                                                <input type="datetime-local" name="tanggal_booking" 
                                                       value="{{ $item->tanggal_booking ? \Carbon\Carbon::parse($item->tanggal_booking)->format('Y-m-d\TH:i') : '' }}" 
                                                       required 
                                                       class="text-xs px-2.5 py-1.5 border border-slate-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-slate-700">

                                                <!-- DROPDOWN MEKANIK -->
                                                <select name="mechanic_id" required class="text-xs px-2.5 py-1.5 border border-slate-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-slate-700">
                                                    <option value="">-- Pilih Mekanik --</option>
                                                    @foreach($mechanics as $mechanic)
                                                        <option value="{{ $mechanic->id }}" {{ $item->mechanic_id == $mechanic->id ? 'selected' : '' }}>
                                                            {{ $mechanic->nama_mekanik }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <!-- TOMBOL SETUJUI -->
                                                <button type="submit" name="status" value="Disetujui" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm transition">
                                                    Setujui
                                                </button>

                                                <!-- TOMBOL TOLAK -->
                                                <button type="submit" name="status" value="Ditolak" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm transition">
                                                    Tolak
                                                </button>
                                            </form>

                                        @elseif($status == 'disetujui')
                                            <div class="flex items-center justify-center gap-2">
                                                <form action="{{ route('admin.booking.update', $item->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="status" value="Selesai" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-4 py-1.5 rounded-xl shadow-sm transition">
                                                        Tandai Selesai
                                                    </button>
                                                </form>
                                            </div>

                                        @else
                                            <span class="text-xs text-slate-400 font-medium bg-slate-100 px-3 py-1 rounded-full">- Terkunci -</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-slate-400 text-xs">Belum ada pesanan servis masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>