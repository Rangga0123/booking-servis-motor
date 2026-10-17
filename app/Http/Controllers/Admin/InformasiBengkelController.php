<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiBengkel;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class InformasiBengkelController extends Controller
{
    // HALAMAN PENGATURAN INFORMASI BENGKEL
    public function index()
    {
        $informasiBengkel = InformasiBengkel::first();

        if (!$informasiBengkel) {
            $informasiBengkel = InformasiBengkel::create([
                'nama_bengkel' => 'Bengkel Royal Motor',
                'deskripsi' => 'Selamat datang di Bengkel Royal Motor.',
                'hari_operasional' => 'Senin, Selasa, Rabu, Kamis, Jumat, Sabtu, Minggu',
                'jam_buka' => '13:00',
                'jam_tutup' => '22:00',
                'status_operasional' => 'otomatis',
            ]);
        }

        $pengumuman = Pengumuman::latest()->get();

        return view('admin.informasi-bengkel', compact(
            'informasiBengkel',
            'pengumuman'
        ));
    }

    // SIMPAN PERUBAHAN INFORMASI BENGKEL
    public function update(Request $request)
    {
        $request->validate([
            'nama_bengkel' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto_1' => 'nullable|string|max:255',
            'deskripsi_foto_1' => 'nullable|string',
            'foto_2' => 'nullable|string|max:255',
            'deskripsi_foto_2' => 'nullable|string',
            'hari_operasional' => 'required|string|max:255',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i',
            'status_operasional' => 'required|in:otomatis,buka,tutup,libur',
            'informasi_layanan' => 'nullable|string',
        ]);

        $informasiBengkel = InformasiBengkel::first();

        if (!$informasiBengkel) {
            $informasiBengkel = new InformasiBengkel();
        }

        $informasiBengkel->fill($request->only([
            'nama_bengkel',
            'deskripsi',
            'foto_1',
            'deskripsi_foto_1',
            'foto_2',
            'deskripsi_foto_2',
            'hari_operasional',
            'jam_buka',
            'jam_tutup',
            'status_operasional',
            'informasi_layanan',
        ]));

        $informasiBengkel->save();

        return redirect()
            ->route('admin.informasi-bengkel.index')
            ->with('success', 'Informasi bengkel berhasil disimpan.');
    }

    // TAMBAH PENGUMUMAN
    public function storePengumuman(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'aktif' => 'nullable|boolean',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'aktif' => $request->boolean('aktif'),
        ]);

        return redirect()
            ->route('admin.informasi-bengkel.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    // UBAH PENGUMUMAN
    public function updatePengumuman(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'aktif' => 'nullable|boolean',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        $pengumuman->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'aktif' => $request->boolean('aktif'),
        ]);

        return redirect()
            ->route('admin.informasi-bengkel.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    // HAPUS PENGUMUMAN
    public function destroyPengumuman($id)
    {
        Pengumuman::findOrFail($id)->delete();

        return redirect()
            ->route('admin.informasi-bengkel.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}