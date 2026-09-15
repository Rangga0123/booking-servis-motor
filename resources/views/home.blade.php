<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Pelanggan') }}
            </h2>
            <span class="text-sm text-gray-500">Selamat datang, <b>{{ Auth::user()->name }}</b>!</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Banner Sambutan -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8 mb-6 flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Mau Servis Motor Hari Ini? 🏍️</h3>
                    <p class="text-gray-600 text-sm max-w-xl">
                        Daftarkan jadwal servis motor Anda secara online. Pantau status pengerjaan kendaraan Anda langsung dari halaman ini tanpa perlu mengantre lama di bengkel.
                    </p>
                </div>
                <div>
                    <a href="{{ route('booking.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-200 inline-flex items-center space-x-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                        + Buat Booking Baru
                    </a>
                </div>
            </div>

            <!-- KOTAK STATISTIK RINGKAS (Terinspirasi dari referensi tapi tetap simple) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Kartu 1: Total Booking Saya -->
                <div class="bg-white border-l-4 border-blue-600 overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Total Booking Saya</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ $bookings->count() }}</div>
                </div>

                <!-- Kartu 2: Menunggu Persetujuan -->
                <div class="bg-white border-l-4 border-amber-500 overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Status Menunggu</div>
                    <div class="text-3xl font-extrabold text-amber-600">{{ $bookings->where('status', 'menunggu')->count() }}</div>
                </div>

                <!-- Kartu 3: Selesai Diservis -->
                <div class="bg-white border-l-4 border-emerald-500 overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Servis Selesai</div>
                    <div class="text-3xl font-extrabold text-emerald-600">{{ $bookings->where('status', 'selesai')->count() }}</div>
                </div>
            </div>

            <!-- Bagian Tabel Riwayat Pesanan Servis -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Riwayat Pesanan Servis Anda
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Motor</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Plat Nomor</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Keluhan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($bookings as $index => $booking)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $booking->nama_motor }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">{{ $booking->plat_nomor }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $booking->keluhan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                                @if($booking->status == 'menunggu') bg-amber-100 text-amber-800 
                                                @elseif($booking->status == 'disetujui') bg-sky-100 text-sky-800 
                                                @else bg-emerald-100 text-emerald-800 @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium">
                                            @if($booking->status == 'menunggu')
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('booking.edit', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">Edit</a>
                                                    
                                                    <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition">Hapus</button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-xs italic bg-gray-100 px-3 py-1 rounded-md">Terkunci (Diproses)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                                <p class="text-gray-500 font-medium">Belum ada riwayat booking servis.</p>
                                                <p class="text-gray-400 text-xs mt-1">Silakan klik tombol "Buat Booking Baru" di atas untuk mendaftar.</p>
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
    </div>
</x-app-layout>