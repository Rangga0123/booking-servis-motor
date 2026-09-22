<x-app-layout>
    <!-- Background Soft Cyan-Teal -->
    <div style="background: linear-gradient(135deg, #cff4fc 0%, #e0f2fe 50%, #d1fae5 100%);" class="py-8 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="rounded-3xl shadow-lg overflow-hidden">
                <div style="background-color: #1b4332;" class="p-6 text-white">
                    <h2 class="text-xl font-extrabold tracking-wide">Edit Data Booking</h2>
                    <p class="text-xs text-emerald-200 mt-1">Ubah informasi kendaraan atau keluhan servis Anda.</p>
                </div>

                <form action="{{ route('booking.update', $booking->id) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1">Merk / Tipe Motor</label>
                        <input type="text" name="nama_motor" value="{{ old('nama_motor', $booking->nama_motor) }}" required class="w-full text-sm rounded-xl border-teal-200 focus:ring-teal-500 focus:border-teal-500 p-3">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1">Plat Nomor</label>
                        <input type="text" name="plat_nomor" value="{{ old('plat_nomor', $booking->plat_nomor) }}" required class="w-full text-sm rounded-xl border-teal-200 focus:ring-teal-500 focus:border-teal-500 p-3 uppercase font-mono font-bold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 mb-1">Keluhan Kendaraan</label>
                        <textarea name="keluhan" rows="4" required class="w-full text-sm rounded-xl border-teal-200 focus:ring-teal-500 focus:border-teal-500 p-3">{{ old('keluhan', $booking->keluhan) }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-teal-200 flex justify-between items-center">
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
                            ← Batal
                        </a>
                        <button type="submit" style="background-color: #1b4332;" class="hover:bg-emerald-900 text-white text-sm font-extrabold px-6 py-2.5 rounded-xl shadow-md transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>