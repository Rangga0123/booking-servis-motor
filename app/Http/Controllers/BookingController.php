<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // 1. Dashboard Khusus Pelanggan
    public function index()
    {
        // Jika akun yang login adalah Admin, lempar ke dashboard admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $bookings = Booking::where('user_id', auth()->id())->latest()->get();
        return view('dashboard', compact('bookings'));
    }

    // 2. Form Booking Khusus Pelanggan
    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('booking.create');
    }

    // 3. Proses Simpan Booking Pelanggan
    public function store(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Validasi input lengkap sesuai form ERD
        $request->validate([
            'nama_motor'        => 'required|string|max:255',
            'plat_nomor'        => 'required|string|max:20',
            'jenis_servis'      => 'required|string',
            'tanggal_booking'   => 'required|date',
            'jam_booking'       => 'required',
            'keluhan'           => 'required|string',
            'metode_pembayaran' => 'required|string',
        ]);

        // Gabungkan tanggal dan jam menjadi format datetime
        $waktuBooking = $request->tanggal_booking . ' ' . $request->jam_booking;

        Booking::create([
            'user_id'           => auth()->id(),
            'nama_motor'        => $request->nama_motor,
            'plat_nomor'        => $request->plat_nomor,
            'jenis_servis'      => $request->jenis_servis,
            'tanggal_booking'   => $waktuBooking,
            'keluhan'           => $request->keluhan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status'            => 'menunggu', // Menunggu persetujuan Admin
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibuat! Menunggu persetujuan Admin.');
    }

    // 4. Form Edit Booking Pelanggan
    public function edit($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        return view('booking.edit', compact('booking'));
    }

    // 5. Update Booking Pelanggan
    public function update(Request $request, $id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'nama_motor' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20',
            'keluhan'    => 'required|string',
        ]);

        $booking->update([
            'nama_motor' => $request->nama_motor,
            'plat_nomor' => $request->plat_nomor,
            'keluhan'    => $request->keluhan,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data booking berhasil diperbarui!');
    }

    // 6. Batalkan / Hapus Booking Pelanggan
    public function destroy($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        $booking->delete();

        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibatalkan!');
    }
}