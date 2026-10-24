<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'mechanic'])
            ->latest()
            ->get();

        $mechanics = Mechanic::all();

        $totalBooking = Booking::count();

        $bookingMenunggu = Booking::whereIn(
            'status',
            ['menunggu', 'pending']
        )->count();

        $totalPendapatan = Booking::where('status', 'selesai')
            ->sum('harga');

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

        $data = $request->validate([
            'status' => 'required|in:menunggu,pending,disetujui,proses,selesai,ditolak',
            'tanggal_booking' => 'nullable|date',
            'mechanic_id' => 'nullable|exists:mechanics,id',
        ]);

        $booking->status = $data['status'];

        if ($request->filled('tanggal_booking')) {
            $booking->tanggal_booking = $data['tanggal_booking'];
        }

        if ($request->filled('mechanic_id')) {
            $booking->mechanic_id = $data['mechanic_id'];
        }

        $booking->save();

        return redirect()->back()->with(
            'success',
            'Status pesanan dan mekanik berhasil diperbarui!'
        );
    }

    // DAFTAR PESANAN (pagination + filter status di server)
    public function pelangganPesanan(Request $request)
    {
        $query = Booking::with(['user', 'mechanic'])->latest();

        if ($request->filled('status')) {
            $status = strtolower($request->status);

            $query->whereIn(
                DB::raw('LOWER(status)'),
                $status === 'menunggu' ? ['menunggu', 'pending'] : [$status]
            );
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('admin.pelanggan-pesanan', compact('bookings'));
    }

    public function indexMekanik()
    {
        $mekaniks = Mechanic::withCount('bookings')
            ->when(request('cari'), function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_mekanik', 'like', '%' . request('cari') . '%')
                      ->orWhere('spesialisasi', 'like', '%' . request('cari') . '%');
                });
            })
            ->latest()
            ->get();

        return view('admin.mekanik.index', compact('mekaniks'));
    }

    public function createMekanik()
    {
        return view('admin.mekanik.create');
    }

    public function storeMekanik(Request $request)
    {
        $data = $request->validate([
            'nama_mekanik' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Mechanic::create($data);

        return redirect()->route('admin.mekanik.index')
            ->with('success', 'Data mekanik berhasil ditambahkan.');
    }

    public function editMekanik($id)
    {
        $mekanik = Mechanic::findOrFail($id);

        return view('admin.mekanik.edit', compact('mekanik'));
    }

    public function updateMekanik(Request $request, $id)
    {
        $mekanik = Mechanic::findOrFail($id);

        $data = $request->validate([
            'nama_mekanik' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $mekanik->update($data);

        return redirect()->route('admin.mekanik.index')
            ->with('success', 'Data mekanik berhasil diperbarui.');
    }

    public function destroyMekanik($id)
    {
        $mekanik = Mechanic::findOrFail($id);

        if ($mekanik->bookings()->exists()) {
            return redirect()->route('admin.mekanik.index')
                ->with(
                    'error',
                    'Mekanik masih terhubung dengan pesanan. Ubah status menjadi nonaktif saja.'
                );
        }

        $mekanik->delete();

        return redirect()->route('admin.mekanik.index')
            ->with('success', 'Data mekanik berhasil dihapus.');
    }
}