@extends('admin.layouts.app')

@section('title', 'Edit Mekanik')

@section('content')
    <section class="page-heading">
        <div>
            <div class="breadcrumb">Admin / Data Mekanik / Edit</div>
            <h1 class="page-title">Edit Data Mekanik</h1>
            <p class="page-description">Perbarui informasi mekanik.</p>
        </div>

        <a href="{{ route('admin.mekanik.index') }}" class="btn btn-light">← Kembali ke Data Mekanik</a>
    </section>

    @if($errors->any())
        <div class="notice notice-error">
            <strong>Periksa kembali data yang diisi.</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="panel form-card">
        <form action="{{ route('admin.mekanik.update', $mekanik->id) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_mekanik">Nama Mekanik</label>
                <input type="text" id="nama_mekanik" name="nama_mekanik"
                       value="{{ old('nama_mekanik', $mekanik->nama_mekanik) }}"
                       required maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label for="spesialisasi">Spesialisasi</label>
                <input type="text" id="spesialisasi" name="spesialisasi"
                       value="{{ old('spesialisasi', $mekanik->spesialisasi) }}"
                       required maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required class="form-control">
                    <option value="aktif" @selected(old('status', $mekanik->status) === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(old('status', $mekanik->status) === 'nonaktif')>Nonaktif</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.mekanik.index') }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </section>
@endsection