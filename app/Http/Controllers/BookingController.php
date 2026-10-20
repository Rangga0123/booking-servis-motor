<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mechanic;
use App\Models\InformasiBengkel;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Status yang masih boleh diedit atau dibatalkan pelanggan
    private const STATUS_BISA_DIUBAH = ['menunggu', 'pending'];

    private function bisaDiubah(Booking $booking): bool
    {
        return in_array(strtolower((string) $booking->status), self::STATUS_BISA_DIUBAH, true);
    }

    // Rapikan input jam dan nomor HP sebelum divalidasi
    private function normalisasi(Request $request): void
    {
        if ($request->filled('jam_booking')) {
            $request->merge([
                'jam_booking' => str_replace(',', ':', trim($request->jam_booking)),
            ]);
        }

        // Buang spasi dan strip, sisakan angka dan tanda +
        $request->merge([
            'no_hp' => preg_replace('/[^0-9+]/', '', (string) $request->no_hp),
        ]);
    }

    // Aturan validasi yang sama untuk simpan dan update
    private function validasiBooking(Request $request): array
    {
        return $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'no_hp'             => ['required', 'regex:/^(\+62|62|0)8[0-9]{7,13}$/'],
            'email_pelanggan'   => 'nullable|email|max:255',
            'nama_motor'        => 'required|string|max:255',
            'plat_nomor'        => 'required|string|max:20',
            'jenis_servis'      => 'required|string|max:255',
            'tanggal_booking'   => 'required|date',
            'jam_booking'       => 'required|date_format:H:i',
            'keluhan'           => 'required|string',
            'mechanic_id'       => 'nullable|exists:mechanics,id',
            'metode_pembayaran' => 'required|string|max:100',
        ], [
            'no_hp.regex' => 'Nomor HP tidak valid. Contoh: 081234567890.',
        ]);
    }

    // DASHBOARD PELANGGAN
    public function dashboard()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $bookings = Booking::with('mechanic')
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
                'disetujui'
            ]);
        })->count();

        $servisSelesai = $bookings->filter(function ($item) {
            return strtolower($item->status ?? '') === 'selesai';
        })->count();

        // INFORMASI BENGKEL DARI DATABASE
        $informasiBengkel = InformasiBengkel::first();

        $namaBengkel = $informasiBengkel?->nama_bengkel
            ?? 'Bengkel Royal Motor';

        $jamOperasional = $informasiBengkel
            ? substr($informasiBengkel->jam_buka, 0, 5)
                . ' - '
                . substr($informasiBengkel->jam_tutup, 0, 5)
                . ' WIB'
            : '13.00 - 22.00 WIB';

        // PENGUMUMAN AKTIF
        $pengumuman = Pengumuman::where('aktif', true)
            ->latest()
            ->get();

        // STATUS OPERASIONAL BENGKEL
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

    // DAFTAR BOOKING PELANGGAN (RIWAYAT)
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $bookings = Booking::with('mechanic')
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

    // FORM BOOKING PELANGGAN
    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Mekanik yang berstatus aktif, untuk dipilih pelanggan
        $mechanics = Mechanic::whereRaw('LOWER(status) = ?', ['aktif'])
            ->orderBy('nama_mekanik')
            ->get();

        return view('booking.create', compact('mechanics'));
    }

    // SIMPAN BOOKING
    public function store(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $this->normalisasi($request);
        $this->validasiBooking($request);

        Booking::create([
            'user_id'           => auth()->id(),
            'mechanic_id'       => $request->filled('mechanic_id') ? $request->mechanic_id : null,
            'nama_pelanggan'    => $request->nama_pelanggan,
            'no_hp'             => $request->no_hp,
            'email_pelanggan'   => $request->email_pelanggan,
            'nama_motor'        => $request->nama_motor,
            'plat_nomor'        => $request->plat_nomor,
            'jenis_servis'      => $request->jenis_servis,
            'tanggal_booking'   => $request->tanggal_booking,
            'jam_booking'       => $request->jam_booking,
            'keluhan'           => $request->keluhan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status'            => 'menunggu',
        ]);

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil dibuat! Menunggu persetujuan Admin.');
    }

    // DETAIL BOOKING
    public function show($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::with('mechanic')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('booking.show', compact('booking'));
    }

    // EDIT BOOKING
    public function edit($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($id);

        if (! $this->bisaDiubah($booking)) {
            return redirect()
                ->route('booking.show', $booking->id)
                ->with('error', 'Booking ini sudah diproses sehingga tidak bisa diedit.');
        }

        // Mekanik aktif, ditambah mekanik yang sudah terpilih (kalau sekarang nonaktif)
        $mechanics = Mechanic::whereRaw('LOWER(status) = ?', ['aktif'])
            ->when($booking->mechanic_id, function ($query, $mechanicId) {
                $query->orWhere('id', $mechanicId);
            })
            ->orderBy('nama_mekanik')
            ->get();

        return view('booking.edit', compact('booking', 'mechanics'));
    }

    // UPDATE BOOKING
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
                ->with('error', 'Booking ini sudah diproses sehingga tidak bisa diedit.');
        }

        $this->normalisasi($request);
        $this->validasiBooking($request);

        $booking->update([
            'mechanic_id'       => $request->filled('mechanic_id') ? $request->mechanic_id : null,
            'nama_pelanggan'    => $request->nama_pelanggan,
            'no_hp'             => $request->no_hp,
            'email_pelanggan'   => $request->email_pelanggan,
            'nama_motor'        => $request->nama_motor,
            'plat_nomor'        => $request->plat_nomor,
            'jenis_servis'      => $request->jenis_servis,
            'tanggal_booking'   => $request->tanggal_booking,
            'jam_booking'       => $request->jam_booking,
            'keluhan'           => $request->keluhan,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()
            ->route('booking.index')
            ->with('success', 'Data booking berhasil diperbarui!');
    }

    // HAPUS BOOKING (tidak dipakai tombol; disimpan untuk kompatibilitas)
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

    // BATALKAN BOOKING
    // Booking tidak dihapus: statusnya diubah jadi "dibatalkan" supaya tetap ada di riwayat.
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
                ->with('error', 'Booking ini sudah diproses sehingga tidak bisa dibatalkan.');
        }

        $booking->update(['status' => 'dibatalkan']);

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil dibatalkan!');
    }

    // DASHBOARD ADMIN
    public function indexAdmin()
    {
        $bookings = Booking::with('mechanic')
            ->latest()
            ->get();

        $mechanics = Mechanic::orderBy('nama_mekanik')
            ->get();

        return view(
            'admin.dashboard',
            compact('bookings', 'mechanics')
        );
    }

    // UPDATE BOOKING DARI ADMIN
    public function updateStatus(Request $request, $id)
    {
        if ($request->filled('jam_booking')) {
            $request->merge([
                'jam_booking' => str_replace(
                    ',',
                    ':',
                    trim($request->jam_booking)
                )
            ]);
        }

        $request->validate([
            'status'          => 'required|string',
            'mechanic_id'     => 'nullable|exists:mechanics,id',
            'tanggal_booking' => 'nullable|date',
            'jam_booking'     => 'nullable|date_format:H:i',
        ]);

        $booking = Booking::findOrFail($id);

        $booking->status = $request->status;

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

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Pesanan berhasil diperbarui!');
    }

    // AKSI ADMIN LAMA
    public function adminUpdate(Request $request, $id)
    {
        return $this->updateStatus($request, $id);
    }
}