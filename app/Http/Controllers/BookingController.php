<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->latest()->get();
        return view('dashboard', compact('bookings'));
    }

    public function create()
    {
        return view('booking.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_motor' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20',
            'keluhan'    => 'required|string',
        ]);

        Booking::create([
            'user_id'    => auth()->id(),
            'nama_motor' => $request->nama_motor,
            'plat_nomor' => $request->plat_nomor,
            'keluhan'    => $request->keluhan,
            'status'     => 'pending', // Status awal saat pertama kali dibooking
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibuat!');
    }
}