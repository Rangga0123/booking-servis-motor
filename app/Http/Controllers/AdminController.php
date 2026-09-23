<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mechanic;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Mengambil semua data booking terbaru beserta data user & mechanic
        $bookings = Booking::with(['user', 'mechanic'])->latest()->get();

        // 2. Mengambil semua data mekanik untuk pilihan dropdown di dashboard admin
        $mechanics = Mechanic::all();

        // 3. Menghitung data untuk kartu statistik di dashboard
        $totalBooking    = Booking::count();
        $bookingMenunggu = Booking::whereIn('status', ['menunggu', 'pending'])->count();
        $totalPendapatan = Booking::where('status', 'selesai')->sum('harga'); 

        // Kirim semua variabel ke view admin.dashboard
        return view('admin.dashboard', compact(
            'bookings', 
            'mechanics',
            'totalBooking', 
            'bookingMenunggu', 
            'totalPendapatan'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Validasi input status, tanggal, dan mekanik
        $request->validate([
            'status'          => 'required|in:menunggu,pending,disetujui,proses,selesai,ditolak',
            'tanggal_booking' => 'nullable|date',
            'mechanic_id'     => 'nullable|exists:mechanics,id',
        ]);

        // Update status booking
        $booking->status = $request->status;

        // Update tanggal jika diisi oleh admin
        if ($request->filled('tanggal_booking')) {
            $booking->tanggal_booking = $request->tanggal_booking;
        }

        // Update mekanik jika diisi/dipilih oleh admin
        if ($request->filled('mechanic_id')) {
            $booking->mechanic_id = $request->mechanic_id;
        }

        $booking->save();

        return redirect()->back()->with('success', 'Status pesanan dan mekanik berhasil diperbarui!');
    }
}