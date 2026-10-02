<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // 1. Dashboard Khusus Pelanggan
    public function dashboard()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $userId = auth()->id();
        $bookings = Booking::where('user_id', $userId)->latest()->get();

        $totalBooking = $bookings->count();

        $statusDiproses = $bookings->filter(function ($item) {
            return in_array(strtolower($item->status), [
                'proses',
                'diproses',
                'sedang dikerjakan',
                'dikerjakan',
                'disetujui'
            ]);
        })->count();

        $servisSelesai = $bookings->filter(function ($item) {
            return strtolower($item->status) === 'selesai';
        })->count();

        return view('dashboard', compact(
            'bookings',
            'totalBooking',
            'statusDiproses',
            'servisSelesai'
        ));
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

        $request->validate([
            'nama_motor'        => 'required|string|max:255',
            'plat_nomor'        => 'required|string|max:20',
            'jenis_servis'      => 'required|string',
            'tanggal_booking'   => 'required|date',
            'jam_booking'       => 'required',
            'keluhan'           => 'required|string',
            'metode_pembayaran' => 'required|string',
        ]);

        Booking::create([
            'user_id'           => auth()->id(),
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
            ->route('dashboard')
            ->with('success', 'Booking berhasil dibuat! Menunggu persetujuan Admin.');
    }

    // 4. Form Edit Booking Pelanggan
    public function edit($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($id);

        return view('booking.edit', compact('booking'));
    }

    // 5. Update Booking Pelanggan
    public function update(Request $request, $id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($id);

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

        return redirect()
            ->route('dashboard')
            ->with('success', 'Data booking berhasil diperbarui!');
    }

    // 6. Batalkan / Hapus Booking Pelanggan
    public function destroy($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($id);

        $booking->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Booking berhasil dibatalkan!');
    }

    // 6.1 Batalkan Booking dari tombol Cancel
    public function cancel($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($id);

        $booking->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Booking berhasil dibatalkan!');
    }

    // 7. Dashboard Admin
    public function indexAdmin()
    {
        $bookings = Booking::with('mechanic')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('bookings'));
    }

    // 8. Aksi Khusus Admin
    // Setujui / Tolak / Tandai Selesai + Pilih Mekanik
    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'status'          => 'required|string',
            'mechanic_id'     => 'nullable|exists:mechanics,id',
            'tanggal_booking' => 'nullable',
        ]);

        $booking = Booking::findOrFail($id);

        $booking->status = $request->status;

        if ($request->filled('mechanic_id')) {
            $booking->mechanic_id = $request->mechanic_id;
        }

        if ($request->filled('tanggal_booking')) {
            $booking->tanggal_booking = $request->tanggal_booking;
        }

        $booking->save();

        return redirect()
            ->back()
            ->with('success', 'Status pesanan dan mekanik berhasil diperbarui!');
    }
}