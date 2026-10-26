<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mechanic;
use App\Models\Service;
use App\Models\InformasiBengkel;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // Status yang masih boleh diedit atau dibatalkan pelanggan.
    private const STATUS_BISA_DIUBAH = ['menunggu', 'pending'];

    private function bisaDiubah(Booking $booking): bool
    {
        return in_array(
            strtolower((string) $booking->status),
            self::STATUS_BISA_DIUBAH,
            true
        );
    }

    // Rapikan input jam dan nomor HP sebelum divalidasi.
    private function normalisasi(Request $request): void
    {
        if ($request->filled('jam_booking')) {
            $request->merge([
                'jam_booking' => str_replace(
                    ',',
                    ':',
                    trim($request->jam_booking)
                ),
            ]);
        }

        $request->merge([
            'no_hp' => preg_replace(
                '/[^0-9+]/',
                '',
                (string) $request->no_hp
            ),
        ]);
    }

    // Validasi umum untuk data pelanggan.
    private function validasiBooking(Request $request): array
    {
        return $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'no_hp'             => ['required', 'regex:/^(\+62|62|0)8[0-9]{7,13}$/'],
            'email_pelanggan'   => 'nullable|email|max:255',
            'nama_motor'        => 'required|string|max:255',
            'plat_nomor'        => 'required|string|max:20',
            'tanggal_booking'   => 'required|date',
            'jam_booking'       => 'required|date_format:H:i',
            'keluhan'           => 'required|string',
            'mechanic_id'       => 'nullable|exists:mechanics,id',
            'metode_pembayaran' => 'required|string|max:100',
        ], [
            'no_hp.regex' => 'Nomor HP tidak valid. Contoh: 081234567890.',
        ]);
    }

    // Validasi pilihan layanan dari tabel services.
    private function validasiLayanan(Request $request): array
    {
        return $request->validate([
            'service_id' => 'required|exists:services,id',
        ], [
            'service_id.required' => 'Silakan pilih layanan servis.',
            'service_id.exists'   => 'Layanan yang dipilih tidak ditemukan.',
        ]);
    }

    // DASHBOARD PELANGGAN.
    public function dashboard()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $bookings = Booking::with(['mechanic', 'service'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $totalBooking = $bookings->count();

        $statusDiproses = $bookings->filter(function ($item) {
            return in_array(strtolower($item->status ?? ''), [
                'proses',
                'diproses',
                'sedang dikerjakan',
                'dikerjakan',
                'disetujui',
            ]);
        })->count();

        $servisSelesai = $bookings->filter(function ($item) {
            return strtolower($item->status ?? '') === 'selesai';
        })->count();

        $informasiBengkel = InformasiBengkel::first();

        $namaBengkel = $informasiBengkel?->nama_bengkel
            ?? 'Bengkel Royal Motor';

        $jamOperasional = $informasiBengkel
            ? substr($informasiBengkel->jam_buka, 0, 5)
                . ' - '
                . substr($informasiBengkel->jam_tutup, 0, 5)
                . ' WIB'
            : '13.00 - 22.00 WIB';

        $pengumuman = Pengumuman::where('aktif', true)
            ->latest()
            ->get();

        $statusOperasional = 'belum diatur';

        if ($informasiBengkel) {
            $statusPengaturan = strtolower(
                $informasiBengkel->status_operasional ?? 'otomatis'
            );

            if (in_array($statusPengaturan, ['buka', 'tutup', 'libur'])) {
                $statusOperasional = $statusPengaturan;
            } else {
                $hariSekarang = strtolower(now()->locale('id')->dayName);

                $daftarHariBuka = array_map(
                    fn ($hari) => strtolower(trim($hari)),
                    explode(',', $informasiBengkel->hari_operasional ?? '')
                );

                $jamSekarang = now()->format('H:i:s');

                $hariSesuai = in_array(
                    $hariSekarang,
                    $daftarHariBuka
                );

                $dalamJam = $informasiBengkel->jam_buka <= $jamSekarang
                    && $jamSekarang < $informasiBengkel->jam_tutup;

                $statusOperasional = ($hariSesuai && $dalamJam)
                    ? 'buka'
                    : 'tutup';
            }
        }

        return view('dashboard', compact(
            'bookings',
            'totalBooking',
            'statusDiproses',
            'servisSelesai',
            'informasiBengkel',
            'namaBengkel',
            'jamOperasional',
            'statusOperasional',
            'pengumuman'
        ));
    }

    // DAFTAR BOOKING PELANGGAN.
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $bookings = Booking::with(['mechanic', 'service'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $totalBooking = $bookings->count();

        $statusDiproses = $bookings->filter(function ($item) {
            return in_array(strtolower($item->status ?? ''), [
                'proses',
                'diproses',
                'sedang dikerjakan',
                'dikerjakan',
                'disetujui',
            ]);
        })->count();

        $servisSelesai = $bookings->filter(function ($item) {
            return strtolower($item->status ?? '') === 'selesai';
        })->count();

        return view('booking.index', compact(
            'bookings',
            'totalBooking',
            'statusDiproses',
            'servisSelesai'
        ));
    }

    // FORM BOOKING PELANGGAN.
    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $mechanics = Mechanic::whereRaw('LOWER(status) = ?', ['aktif'])
            ->orderBy('nama_mekanik')
            ->get();

        $services = Service::orderBy('nama_servis')->get();

        return view('booking.create', compact(
            'mechanics',
            'services'
        ));
    }

    // SIMPAN BOOKING BARU.
    public function store(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $this->normalisasi($request);

        $data = $request->validate([
            'service_id'        => 'required|exists:services,id',
            'nama_pelanggan'    => 'required|string|max:255',
            'no_hp'             => ['required', 'regex:/^(\+62|62|0)8[0-9]{7,13}$/'],
            'email_pelanggan'   => 'nullable|email|max:255',
            'nama_motor'        => 'required|string|max:255',
            'plat_nomor'        => 'required|string|max:20',
            'tanggal_booking'   => 'required|date',
            'jam_booking'       => 'required|date_format:H:i',
            'keluhan'           => 'required|string',
            'mechanic_id'       => 'nullable|exists:mechanics,id',
            'metode_pembayaran' => 'required|string|max:100',
        ], [
            'no_hp.regex' => 'Nomor HP tidak valid. Contoh: 081234567890.',
            'service_id.required' => 'Silakan pilih layanan servis.',
            'service_id.exists' => 'Layanan yang dipilih tidak ditemukan.',
        ]);

        // Ambil harga asli dari database.
        $service = Service::findOrFail($data['service_id']);

        $hargaBarang = (int) $service->harga_barang;
        $biayaJasa = (int) $service->biaya_jasa;
        $totalHarga = $hargaBarang + $biayaJasa;

        Booking::create([
            'user_id'           => auth()->id(),
            'service_id'        => $service->id,
            'mechanic_id'       => $data['mechanic_id'] ?? null,
            'nama_pelanggan'    => $data['nama_pelanggan'],
            'no_hp'             => $data['no_hp'],
            'email_pelanggan'   => $data['email_pelanggan'] ?? null,
            'nama_motor'        => $data['nama_motor'],
            'plat_nomor'        => $data['plat_nomor'],
            'jenis_servis'      => $service->nama_servis,
            'tanggal_booking'   => $data['tanggal_booking'],
            'jam_booking'       => $data['jam_booking'],
            'keluhan'           => $data['keluhan'],
            'metode_pembayaran' => $data['metode_pembayaran'],
            'harga_barang'      => $hargaBarang,
            'biaya_jasa'        => $biayaJasa,
            'harga'             => $totalHarga,
            'status'            => 'menunggu',
        ]);

        return redirect()
            ->route('booking.index')
            ->with(
                'success',
                'Booking berhasil dibuat! Menunggu persetujuan Admin.'
            );
    }

    // DETAIL BOOKING.
    public function show($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::with(['mechanic', 'service'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('booking.show', compact('booking'));
    }

    // FORM EDIT BOOKING.
    public function edit($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::with(['mechanic', 'service'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if (! $this->bisaDiubah($booking)) {
            return redirect()
                ->route('booking.show', $booking->id)
                ->with(
                    'error',
                    'Booking ini sudah diproses sehingga tidak bisa diedit.'
                );
        }

        $mechanics = Mechanic::whereRaw('LOWER(status) = ?', ['aktif'])
            ->when($booking->mechanic_id, function ($query, $mechanicId) {
                $query->orWhere('id', $mechanicId);
            })
            ->orderBy('nama_mekanik')
            ->get();

        // Gunakan daftar layanan yang sama dengan halaman create.
        $services = Service::orderBy('nama_servis')->get();

        return view('booking.edit', compact(
            'booking',
            'mechanics',
            'services'
        ));
    }

    // UPDATE BOOKING PELANGGAN.
    public function update(Request $request, $id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($id);

        if (! $this->bisaDiubah($booking)) {
            return redirect()
                ->route('booking.show', $booking->id)
                ->with(
                    'error',
                    'Booking ini sudah diproses sehingga tidak bisa diedit.'
                );
        }

        $this->normalisasi($request);

        // Validasi data umum dan pilihan layanan.
        $data = $this->validasiBooking($request);
        $layanan = $this->validasiLayanan($request);

        // Pastikan layanan benar-benar tersedia di database.
        $service = Service::findOrFail($layanan['service_id']);

        // Harga selalu mengikuti data terbaru di database.
        $hargaBarang = (int) $service->harga_barang;
        $biayaJasa = (int) $service->biaya_jasa;
        $totalHarga = $hargaBarang + $biayaJasa;

        $booking->update([
            'service_id'        => $service->id,
            'mechanic_id'       => $data['mechanic_id'] ?? null,
            'nama_pelanggan'    => $data['nama_pelanggan'],
            'no_hp'             => $data['no_hp'],
            'email_pelanggan'   => $data['email_pelanggan'] ?? null,
            'nama_motor'        => $data['nama_motor'],
            'plat_nomor'        => $data['plat_nomor'],
            'jenis_servis'      => $service->nama_servis,
            'tanggal_booking'   => $data['tanggal_booking'],
            'jam_booking'       => $data['jam_booking'],
            'keluhan'           => $data['keluhan'],
            'metode_pembayaran' => $data['metode_pembayaran'],
            'harga_barang'      => $hargaBarang,
            'biaya_jasa'        => $biayaJasa,
            'harga'             => $totalHarga,
        ]);

        return redirect()
            ->route('booking.index')
            ->with('success', 'Data booking berhasil diperbarui!');
    }

    // HAPUS BOOKING.
    public function destroy($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($id);

        $booking->delete();

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil dihapus!');
    }

    // BATALKAN BOOKING.
    public function cancel($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($id);

        if (! $this->bisaDiubah($booking)) {
            return redirect()
                ->route('booking.index')
                ->with(
                    'error',
                    'Booking ini sudah diproses sehingga tidak bisa dibatalkan.'
                );
        }

        $booking->update([
            'status' => 'dibatalkan',
        ]);

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil dibatalkan!');
    }

    // DASHBOARD ADMIN.
    public function indexAdmin()
    {
        $bookings = Booking::with(['mechanic', 'service'])
            ->latest()
            ->get();

        $mechanics = Mechanic::orderBy('nama_mekanik')
            ->get();

        return view(
            'admin.dashboard',
            compact('bookings', 'mechanics')
        );
    }

    // JADWAL SERVIS ADMIN.
    public function jadwal()
    {
        $bookings = Booking::with(['user', 'mechanic', 'service'])
            ->whereIn(DB::raw('LOWER(status)'), [
                'menunggu',
                'pending',
                'disetujui',
            ])
            ->latest()
            ->paginate(9);

        $mechanics = Mechanic::orderBy('nama_mekanik')->get();

        return view(
            'admin.jadwal-servis',
            compact('bookings', 'mechanics')
        );
    }

    // UPDATE BOOKING DARI ADMIN.
    public function updateStatus(Request $request, $id)
    {
        if ($request->filled('jam_booking')) {
            $request->merge([
                'jam_booking' => str_replace(
                    ',',
                    ':',
                    trim($request->jam_booking)
                ),
            ]);
        }

        $ditolak = strtolower((string) $request->status) === 'ditolak';

        $request->validate([
            'status'           => 'required|string',
            'mechanic_id'      => 'nullable|exists:mechanics,id',
            'tanggal_booking'  => 'nullable|date',
            'jam_booking'      => 'nullable|date_format:H:i',
            'alasan_penolakan' => $ditolak
                ? 'required|string|max:500'
                : 'nullable|string|max:500',
        ], [
            'alasan_penolakan.required' =>
                'Alasan penolakan wajib diisi supaya pelanggan tahu kenapa pesanannya ditolak.',
        ]);

        $booking = Booking::findOrFail($id);

        $booking->status = $request->status;
        $booking->alasan_penolakan = $ditolak
            ? $request->alasan_penolakan
            : null;

        if ($request->filled('mechanic_id')) {
            $booking->mechanic_id = $request->mechanic_id;
        }

        if ($request->filled('tanggal_booking')) {
            $booking->tanggal_booking = $request->tanggal_booking;
        }

        if ($request->filled('jam_booking')) {
            $booking->jam_booking = $request->jam_booking;
        }

        $booking->save();

        $pesan = $ditolak
            ? 'Pesanan ditolak. Alasan sudah disimpan dan bisa dilihat pelanggan.'
            : 'Pesanan berhasil diperbarui!';

        return redirect()
            ->back()
            ->with('success', $pesan);
    }

    // AKSI ADMIN LAMA.
    public function adminUpdate(Request $request, $id)
    {
        return $this->updateStatus($request, $id);
    }
}