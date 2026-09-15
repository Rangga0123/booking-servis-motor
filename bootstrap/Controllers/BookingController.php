<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman Dashboard Pelanggan (Form Booking & Riwayat)
     */
    public function dashboard()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $services = Service::all();
        
        $bookings = Booking::with('service')
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('dashboard', compact('services', 'bookings'));
    }

    /**
     * Menyimpan data booking dari form ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'tanggal_booking' => 'required|date',
            'keluhan' => 'required|string',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'tanggal_booking' => $request->tanggal_booking,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu', 
        ]);

        return redirect()->back()->with('success', 'Jadwal servis berhasil dipesan! Silakan tunggu konfirmasi bengkel.');
    }

    /**
     * Menampilkan halaman Dashboard Admin (Daftar Semua Pesanan & Statistik)
     */
    public function indexAdmin()
    {
        $bookings = Booking::with(['user', 'service'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        $totalBooking = Booking::count();
        $bookingMenunggu = Booking::where('status', 'menunggu')->count();
        
        $totalPendapatan = Booking::where('status', 'selesai')
                            ->join('services', 'bookings.service_id', '=', 'services.id')
                            ->sum('services.harga');

        return view('admin.dashboard', compact('bookings', 'totalBooking', 'bookingMenunggu', 'totalPendapatan'));
    }

    /**
     * Mengubah status pesanan oleh Admin (disetujui atau selesai)
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = $request->status; 
        $booking->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}