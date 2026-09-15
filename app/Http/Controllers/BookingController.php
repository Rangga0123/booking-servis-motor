<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        // Mengambil data booking milik user yang sedang login
        $bookings = Booking::where('user_id', auth()->id())->latest()->get();
        return view('home', compact('bookings'));
    }
}