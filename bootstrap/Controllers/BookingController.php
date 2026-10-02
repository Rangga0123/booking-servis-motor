<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $bookings = Booking::where('user_id', Auth::id())
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

    public function create()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('booking.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'nama_motor' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20',
            'jenis_servis' => 'required|string',
            'tanggal_booking' => 'required|date',
            'jam_booking' => 'required',
            'keluhan' => 'required|string',
            'metode_pembayaran' => 'required|string',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'nama_motor' => $request->nama_motor,
            'plat_nomor' => $request->plat_nomor,
            'jenis_servis' => $request->jenis_servis,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_booking' => $request->jam_booking,
            'keluhan' => $request->keluhan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'menunggu',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Booking berhasil dibuat! Menunggu persetujuan Admin.');
    }

    public function edit($id)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('booking.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'nama_motor' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20',
            'keluhan' => 'required|string',
        ]);

        $booking->update([
            'nama_motor' => $request->nama_motor,
            'plat_nomor' => $request->plat_nomor,
            'keluhan' => $request->keluhan,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Data booking berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $booking = Booking::where('user_id', Auth::id())
            ->findOrFail($id);

        $booking->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Booking berhasil dibatalkan!');
    }

    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'mechanic_id' => 'nullable|exists:mechanics,id',
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

        return redirect()->back()
            ->with('success', 'Status pesanan dan mekanik berhasil diperbarui!');
    }
}