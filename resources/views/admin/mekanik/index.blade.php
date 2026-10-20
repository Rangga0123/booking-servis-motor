@extends('admin.layouts.app')

@section('title', 'Data Mekanik')

@section('content')
    <section class="page-heading">
        <div>
            <div class="breadcrumb">Admin / Data Mekanik</div>
            <h1 class="page-title">Data Mekanik</h1>
            <p class="page-description">Kelola data mekanik Bengkel Royal Motor dengan mudah.</p>
        </div>

        <a href="{{ route('admin.mekanik.create') }}" class="btn btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Mekanik
        </a>
    </section>

    @if(session('success'))
        <div class="notice notice-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="notice notice-error">{{ session('error') }}</div>
    @endif

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

    <section class="stats">
        <div class="stat-card">
            <div class="stat-icon stat-blue">
                <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="8" r="4"/>
                    <path d="M2 21c0-4 3-7 7-7s7 3 7 7"/>
                    <path d="M16 5a4 4 0 0 1 0 7M18 14c2 .8 4 3 4 7"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Total Mekanik</div>
                <div class="stat-number">{{ $mekaniks->count() }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-green">
                <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m5 12 4 4L19 6"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Mekanik Aktif</div>
                <div class="stat-number">{{ $mekaniks->where('status', 'aktif')->count() }}</div>
            </div>
        </div>
    </section>

    <section class="panel">
        <form action="{{ route('admin.mekanik.index') }}" method="GET" class="search-form">
            <input type="text" name="cari" value="{{ request('cari') }}"
                   placeholder="Cari nama atau spesialisasi mekanik..." class="search-input">

            <button type="submit" class="btn btn-dark">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
                </svg>
                Cari
            </button>

            <a href="{{ route('admin.mekanik.index') }}" class="btn btn-light">Reset</a>
        </form>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-title">Daftar Mekanik</div>
            <div class="panel-subtitle">Data mekanik yang terdaftar di Bengkel Royal Motor.</div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Nama Mekanik</th>
                        <th>Spesialisasi</th>
                        <th>Status</th>
                        <th>Pesanan Terkait</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($mekaniks as $mekanik)
                        <tr>
                            <td class="col-no">{{ $loop->iteration }}</td>

                            <td>
                                <div class="mechanic-name">{{ $mekanik->nama_mekanik }}</div>
                                <div class="mechanic-id">ID Mekanik: #{{ $mekanik->id }}</div>
                            </td>

                            <td>{{ $mekanik->spesialisasi ?: '-' }}</td>

                            <td>
                                @if($mekanik->status === 'aktif')
                                    <span class="status status-active">● Aktif</span>
                                @else
                                    <span class="status status-inactive">● Nonaktif</span>
                                @endif
                            </td>

                            <td>{{ $mekanik->bookings_count ?? 0 }}</td>

                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.mekanik.edit', $mekanik->id) }}" class="btn btn-sm btn-edit">Edit</a>

                                    <form action="{{ route('admin.mekanik.destroy', $mekanik->id) }}"
                                          method="POST" class="delete-form"
                                          onsubmit="return confirm('Yakin ingin menghapus mekanik ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <strong>Belum ada data mekanik</strong>
                                    <p style="margin-top: 7px;">Tekan tombol Tambah Mekanik untuk menambahkan data baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            Menampilkan {{ $mekaniks->count() }} data mekanik.
        </div>
    </section>
@endsection