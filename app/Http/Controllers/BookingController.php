<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mechanic;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // =========================
    // DASHBOARD PELANGGAN
    // =========================
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

        return view('dashboard', compact(
            'bookings',
            'totalBooking',
            'statusDiproses',
            'servisSelesai'
        ));
    }


    // =========================
    // FORM BOOKING PELANGGAN
    // =========================
    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('booking.create');
    }


    // =========================
    // SIMPAN BOOKING
    // =========================
    public function store(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

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
            'nama_motor'        => 'required|string|max:255',
            'plat_nomor'        => 'required|string|max:20',
            'jenis_servis'      => 'required|string',
            'tanggal_booking'   => 'required|date',
            'jam_booking'       => 'required|date_format:H:i',
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
            ->with(
                'success',
                'Booking berhasil dibuat! Menunggu persetujuan Admin.'
            );
    }


    // =========================
    // EDIT BOOKING
    // =========================
    public function edit($id)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', auth()->id())
            ->findOrFail($id);

        return view('booking.edit', compact('booking'));
    }


    // =========================
    // UPDATE BOOKING
    // =========================
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
            ->with(
                'success',
                'Data booking berhasil diperbarui!'
            );
    }


    // =========================
    // HAPUS / BATALKAN BOOKING
    // =========================
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
            ->with(
                'success',
                'Booking berhasil dibatalkan!'
            );
    }


    // =========================
    // BATALKAN BOOKING
    // =========================
    public function cancel($id)
    {
        return $this->destroy($id);
    }


    // =========================
    // DASHBOARD ADMIN
    // =========================
    public function indexAdmin()
    {
        $bookings = Booking::with('mechanic')
            ->latest()
            ->get();

        $mechanics = Mechanic::orderBy('nama_mekanik')
            ->get();

        return view(
            'admin.dashboard',
            compact(
                'bookings',
                'mechanics'
            )
        );
    }


    // =========================
    // UPDATE BOOKING DARI ADMIN
    // =========================
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
            'status' => 'required|string',
            'mechanic_id' => 'nullable|exists:mechanics,id',
            'tanggal_booking' => 'nullable|date',
            'jam_booking' => 'nullable|date_format:H:i',
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
            ->with(
                'success',
                'Pesanan berhasil diperbarui!'
            );
    }


    // =========================
    // AKSI ADMIN LAMA
    // =========================
    public function adminUpdate(Request $request, $id)
    {
        return $this->updateStatus($request, $id);
    }
}