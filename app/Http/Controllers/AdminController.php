<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Mengambil semua data booking terbaru untuk tabel
        $bookings = Booking::latest()->get();

        // 2. Menghitung data untuk kartu statistik di dashboard
        $totalBooking = Booking::count();
        $bookingMenunggu = Booking::where('status', 'menunggu')->count();
        $totalPendapatan = Booking::where('status', 'selesai')->sum('harga'); 

        // Kirim semua variabel ke view admin.dashboard
        return view('admin.dashboard', compact(
            'bookings', 
            'totalBooking', 
            'bookingMenunggu', 
            'totalPendapatan'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // PERBAIKAN: Tambahkan 'ditolak' ke dalam validasi agar tombol tolak berfungsi
        $request->validate([
            'status' => 'required|in:disetujui,selesai,ditolak',
        ]);

        $booking->status = $request->status;
        $booking->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}