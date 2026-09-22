<x-app-layout>
    <!-- Background Soft Cyan-Teal -->
    <div style="background: linear-gradient(135deg, #cff4fc 0%, #e0f2fe 50%, #d1fae5 100%);" class="py-8 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Card Utama Form -->
            <div style="background-color: #d8f3dc; border: 1px solid #b7e4c7;" class="rounded-3xl shadow-lg overflow-hidden">
                
                <!-- Header Form (Warna Hijau Gelap / Mint Senada) -->
                <div style="background-color: #1b4332;" class="p-6 text-white">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">📝</span>
                        <div>
                            <h2 class="text-xl font-extrabold tracking-wide">Formulir Booking Servis Motor</h2>
                            <p class="text-xs text-emerald-200 mt-1">Lengkapi data kendaraan, jadwal pengerjaan, dan metode pembayaran Anda.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('booking.store') }}" method="POST" class="p-6 sm:p-8 space-y-8">
                    @csrf

                    <!-- SECTION 1: DATA PELANGGAN -->
                    <div>
                        <h3 class="text-xs font-black text-emerald-950 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span>👤</span> Data Pelanggan
                        </h3>
                        <div style="background-color: #b7e4c7; border: 1px solid #74c69d;" class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-2xl">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1">Nama Pemesan</label>
                                <input type="text" value="{{ Auth::user()->name }}" readonly class="w-full bg-slate-100/80 border-slate-300 text-slate-700 text-sm rounded-xl py-2 px-3 font-semibold cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1">Email Pelanggan</label>
                                <input type="email" value="{{ Auth::user()->email }}" readonly class="w-full bg-slate-100/80 border-slate-300 text-slate-700 text-sm rounded-xl py-2 px-3 font-semibold cursor-not-allowed">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: DATA KENDARAAN -->
                    <div>
                        <h3 class="text-xs font-black text-emerald-950 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span>🛵</span> Data Kendaraan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_motor" class="block text-xs font-bold text-slate-800 mb-1">Merk / Tipe Motor <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama_motor" id="nama_motor" placeholder="Contoh: Honda Vario 160 / Yamaha NMAX" required class="w-full text-sm rounded-xl border-teal-200 focus:ring-teal-500 focus:border-teal-500 py-2.5 px-3">
                            </div>
                            <div>
                                <label for="plat_nomor" class="block text-xs font-bold text-slate-800 mb-1">Plat Nomor / No. Polisi <span class="text-rose-500">*</span></label>
                                <input type="text" name="plat_nomor" id="plat_nomor" placeholder="Contoh: B 1234 ABC" required class="w-full text-sm rounded-xl border-teal-200 focus:ring-teal-500 focus:border-teal-500 py-2.5 px-3 uppercase font-mono font-bold">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: DETAIL SERVIS & JADWAL -->
                    <div>
                        <h3 class="text-xs font-black text-emerald-950 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span>🛠️</span> Detail Servis & Jadwal
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="jenis_servis" class="block text-xs font-bold text-slate-800 mb-1">Jenis Servis <span class="text-rose-500">*</span></label>
                                <select name="jenis_servis" id="jenis_servis" required class="w-full text-sm rounded-xl border-teal-200 focus:ring-teal-500 focus:border-teal-500 py-2.5 px-3">
                                    <option value="" disabled selected>-- Pilih Jenis Servis --</option>
                                    <option value="Servis Biasa / Cek Kerusakan">Servis Biasa / Cek Kerusakan</option>
                                    <option value="Servis Rutin / Berkala">Servis Rutin / Berkala</option>
                                    <option value="Ganti Oli Mesin / Gardan">Ganti Oli Mesin / Gardan</option>
                                    <option value="Ganti Aki / Baterai">Ganti Aki / Baterai</option>
                                    <option value="Ganti Ban / Velg">Ganti Ban / Velg</option>
                                    <option value="Ganti Kampas Rem / Cakram">Ganti Kampas Rem / Cakram</option>
                                    <option value="Ganti Lampu / Kelistrikan">Ganti Lampu / Kelistrikan</option>
                                    <option value="Tune Up & CVT">Tune Up & CVT</option>
                                    <option value="Servis Rem & Kaki-kaki">Servis Rem & Kaki-kaki</option>
                                    <option value="Overhaul / Service Besar">Overhaul / Service Besar</option>
                                </select>
                            </div>
                            <div>
                                <label for="tanggal_booking" class="block text-xs font-bold text-slate-800 mb-1">Tanggal Servis <span class="text-rose-500">*</span></label>
                                <input type="date" name="tanggal_booking" id="tanggal_booking" required min="{{ date('Y-m-d') }}" class="w-full text-sm rounded-xl border-teal-200 focus:ring-teal-500 focus:border-teal-500 py-2.5 px-3">
                            </div>
                            <div>
                                <label for="jam_booking" class="block text-xs font-bold text-slate-800 mb-1">Jam Booking <span class="text-rose-500">*</span></label>
                                <input type="time" name="jam_booking" id="jam_booking" required class="w-full text-sm rounded-xl border-teal-200 focus:ring-teal-500 focus:border-teal-500 py-2.5 px-3">
                            </div>
                        </div>

                        <div>
                            <label for="keluhan" class="block text-xs font-bold text-slate-800 mb-1">Keluhan / Catatan Kendaraan <span class="text-rose-500">*</span></label>
                            <textarea name="keluhan" id="keluhan" rows="3" placeholder="Jelaskan kendala motor Anda (misal: mesin kasar, rem bunyi berdecit, mati saat jalan)..." required class="w-full text-sm rounded-xl border-teal-200 focus:ring-teal-500 focus:border-teal-500 p-3"></textarea>
                        </div>
                    </div>

                    <!-- SECTION 4: METODE PEMBAYARAN -->
                    <div>
                        <h3 class="text-xs font-black text-emerald-950 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span>💳</span> Opsi Metode Pembayaran
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="flex items-center gap-3 p-3.5 bg-white border border-teal-200 rounded-2xl cursor-pointer hover:bg-teal-50 has-[:checked]:border-emerald-700 has-[:checked]:bg-teal-100 transition shadow-sm">
                                <input type="radio" name="metode_pembayaran" value="Bayar di Kasir (Cash)" checked class="text-teal-700 focus:ring-teal-500">
                                <div>
                                    <div class="text-xs font-extrabold text-slate-900">Bayar di Tempat</div>
                                    <div class="text-[10px] text-slate-600">Tunai saat motor selesai</div>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-3.5 bg-white border border-teal-200 rounded-2xl cursor-pointer hover:bg-teal-50 has-[:checked]:border-emerald-700 has-[:checked]:bg-teal-100 transition shadow-sm">
                                <input type="radio" name="metode_pembayaran" value="QRIS / E-Wallet" class="text-teal-700 focus:ring-teal-500">
                                <div>
                                    <div class="text-xs font-extrabold text-slate-900">QRIS / E-Wallet</div>
                                    <div class="text-[10px] text-slate-600">Gopay, OVO, Dana, Shopee</div>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-3.5 bg-white border border-teal-200 rounded-2xl cursor-pointer hover:bg-teal-50 has-[:checked]:border-emerald-700 has-[:checked]:bg-teal-100 transition shadow-sm">
                                <input type="radio" name="metode_pembayaran" value="Transfer Bank" class="text-teal-700 focus:ring-teal-500">
                                <div>
                                    <div class="text-xs font-extrabold text-slate-900">Transfer Bank</div>
                                    <div class="text-[10px] text-slate-600">BCA, Mandiri, BRI, BNI</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="pt-4 border-t border-teal-200 flex items-center justify-between">
                        <a href="{{ route('dashboard') }}" class="text-xs font-extrabold text-slate-600 hover:text-slate-900 transition">
                            ← Batal & Kembali
                        </a>
                        <button type="submit" style="background-color: #1b4332;" class="hover:bg-emerald-900 text-white text-sm font-extrabold px-6 py-3 rounded-2xl shadow-md transition">
                            🚀 Kirim Pesanan Booking
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>