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

    // SIMPAN PERUBAHAN INFORMASI BENGKEL (TERMASUK UPLOAD FOTO)
    public function update(Request $request)
    {
        $request->validate([
            'nama_bengkel' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deskripsi_foto_1' => 'nullable|string',
            'foto_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deskripsi_foto_2' => 'nullable|string',
            'hari_operasional' => 'required|string|max:255',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i',
            'status_operasional' => 'required|in:otomatis,buka,tutup,libur',
            'informasi_layanan' => 'nullable|string',
        ], [
            'foto_1.image' => 'Foto 1 harus berupa gambar.',
            'foto_1.mimes' => 'Foto 1 harus berformat JPG, PNG, atau WebP.',
            'foto_1.max' => 'Ukuran Foto 1 maksimal 2 MB.',
            'foto_2.image' => 'Foto 2 harus berupa gambar.',
            'foto_2.mimes' => 'Foto 2 harus berformat JPG, PNG, atau WebP.',
            'foto_2.max' => 'Ukuran Foto 2 maksimal 2 MB.',
        ]);

        $informasiBengkel = InformasiBengkel::first();

        if (!$informasiBengkel) {
            $informasiBengkel = new InformasiBengkel();
        }

        // Field teks (foto diproses terpisah di bawah)
        $informasiBengkel->fill($request->only([
            'nama_bengkel',
            'deskripsi',
            'deskripsi_foto_1',
            'deskripsi_foto_2',
            'hari_operasional',
            'jam_buka',
            'jam_tutup',
            'status_operasional',
            'informasi_layanan',
        ]));

        // Pastikan folder tujuan ada
        if (!is_dir(public_path('images'))) {
            mkdir(public_path('images'), 0775, true);
        }

        // Proses upload foto_1 dan foto_2
        foreach (['foto_1', 'foto_2'] as $field) {
            if ($request->hasFile($field)) {
                // Hapus foto lama (hanya jika file-nya ada)
                $lama = $informasiBengkel->$field;
                if ($lama && file_exists(public_path($lama))) {
                    @unlink(public_path($lama));
                }

                $file = $request->file($field);
                $namaFile = $field . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $namaFile);

                $informasiBengkel->$field = 'images/' . $namaFile;
            }
            // Jika tidak ada file baru, foto lama dibiarkan
        }

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