<x-app-layout>
    <div style="background-color: #f0fdfa;" class="py-8 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-teal-100 shadow-sm p-6">
                
                <div class="border-b border-slate-100 pb-4 mb-5">
                    <h2 class="text-xl font-extrabold text-slate-800">Form Booking Servis</h2>
                    <p class="text-xs text-slate-500 mt-1">Isi data kendaraan dan keluhan motor Anda untuk membuat janji servis.</p>
                </div>

                <form action="{{ route('booking.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider">Nama / Tipe Motor</label>
                        <input type="text" name="nama_motor" required class="w-full mt-1.5 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-semibold text-slate-800" placeholder="Contoh: Vario 150 / NMAX">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider">Plat Nomor</label>
                        <input type="text" name="plat_nomor" required class="w-full mt-1.5 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-semibold text-slate-800" placeholder="Contoh: B 1234 ABC">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider">Keluhan / Catatan Servis</label>
                        <textarea name="keluhan" rows="3" required class="w-full mt-1.5 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-semibold text-slate-800" placeholder="Jelaskan masalah motor (misal: ganti oli, rem berdecit, dll)"></textarea>
                    </div>

                    <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-800">Batal</a>
                        <button type="submit" style="background-color: #dc2626;" class="hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition shadow-sm">
                            Kirim Pesanan Booking
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>