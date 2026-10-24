<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $services = Service::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_servis', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('admin.layanan.index', compact(
            'services',
            'search'
        ));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateService($request);

        $validated['harga'] =
            (int) $validated['harga_barang']
            + (int) $validated['biaya_jasa'];

        Service::create($validated);

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.layanan.show', compact('service'));
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.layanan.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $this->validateService($request);

        $validated['harga'] =
            (int) $validated['harga_barang']
            + (int) $validated['biaya_jasa'];

        $service->update($validated);

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->bookings()->exists()) {
            return redirect()
                ->route('admin.layanan.index')
                ->with(
                    'error',
                    'Layanan tidak bisa dihapus karena sudah digunakan dalam pemesanan.'
                );
        }

        $service->delete();

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    private function validateService(Request $request): array
    {
        return $request->validate([
            'nama_servis' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'harga_barang' => ['required', 'integer', 'min:0'],
            'biaya_jasa' => ['required', 'integer', 'min:0'],
            'estimasi_waktu' => ['required', 'integer', 'min:1'],
        ], [
            'nama_servis.required' => 'Nama servis wajib diisi.',
            'deskripsi.required' => 'Deskripsi servis wajib diisi.',
            'harga_barang.required' => 'Harga barang wajib diisi.',
            'harga_barang.integer' => 'Harga barang harus berupa angka bulat.',
            'harga_barang.min' => 'Harga barang tidak boleh kurang dari 0.',
            'biaya_jasa.required' => 'Biaya jasa wajib diisi.',
            'biaya_jasa.integer' => 'Biaya jasa harus berupa angka bulat.',
            'biaya_jasa.min' => 'Biaya jasa tidak boleh kurang dari 0.',
            'estimasi_waktu.required' => 'Estimasi waktu wajib diisi.',
            'estimasi_waktu.integer' => 'Estimasi waktu harus berupa angka bulat.',
            'estimasi_waktu.min' => 'Estimasi waktu minimal 1 menit.',
        ]);
    }
}