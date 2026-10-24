@extends('admin.layouts.app')

@section('title', 'Kelola Layanan & Harga')

@push('styles')
<style>
    /* TABEL LAYANAN */
    .service-panel .table-wrapper {
        padding: 20px 21px 6px;
    }

    .service-panel .table-wrapper table {
        width: 100%;
        min-width: 1150px;
        table-layout: fixed;
        border-collapse: collapse;
        border: 1px solid #dee2e6;
    }

    .service-panel .table-wrapper thead {
        background: #fff;
    }

    .service-panel .table-wrapper th {
        padding: 13px 12px;
        color: #212529;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        border: 1px solid #dee2e6;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }

    .service-panel .table-wrapper td {
        padding: 12px;
        font-size: 13px;
        vertical-align: middle;
        border: 1px solid #dee2e6;
        overflow-wrap: anywhere;
    }

    /* Lebar setiap kolom */
    .service-panel .col-no {
        width: 55px;
        text-align: center !important;
    }

    .service-panel .col-name {
        width: 175px;
    }

    .service-panel .col-description {
        width: 220px;
    }

    .service-panel .col-item-price {
        width: 135px;
    }

    .service-panel .col-service-price {
        width: 125px;
    }

    .service-panel .col-total-price {
        width: 140px;
    }

    .service-panel .col-duration {
        width: 105px;
    }

    .service-panel .col-actions {
        width: 190px;
    }

    .service-panel .table-wrapper tbody tr:nth-child(even) {
        background: #fff;
    }

    .service-panel .table-wrapper tbody tr:hover {
        background: #f2f4f7;
    }

    .service-panel .table-wrapper tbody tr:last-child td {
        border-bottom: 1px solid #dee2e6;
    }

    .service-name {
        color: #212529;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.5;
    }

    .service-id {
        margin-top: 4px;
        color: #7b8492;
        font-size: 11px;
    }

    .service-description {
        color: #495463;
        line-height: 1.6;
    }

    .service-price {
        color: #495463;
        white-space: nowrap;
        font-size: 12px;
    }

    .service-total {
        color: #1d4ed8;
        font-weight: 700;
        white-space: nowrap;
    }

    .service-duration {
        display: inline-block;
        padding: 5px 8px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Tombol aksi dibuat sejajar */
    .service-panel .actions {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        flex-wrap: nowrap;
        gap: 6px;
        white-space: nowrap;
    }

    .service-panel .actions .btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-width: 48px;
        padding: 7px 9px;
        margin: 0;
        font-size: 11px;
        line-height: 1.2;
        white-space: nowrap;
        text-decoration: none;
    }

    .service-panel .actions form {
        display: inline-flex;
        flex: 0 0 auto;
        margin: 0;
        padding: 0;
    }

    .service-panel .btn-detail {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .service-panel .btn-detail:hover {
        background: #dbeafe;
    }

    .service-panel .btn-edit {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    .service-panel .btn-edit:hover {
        background: #ffedd5;
    }

    .service-panel .btn-delete {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        cursor: pointer;
    }

    .service-panel .btn-delete:hover {
        background: #fee2e2;
    }

    .service-panel .table-footer {
        padding: 14px 21px 22px;
        border-top: 0;
        background: #fff;
        color: #3c4858;
        font-size: 13px;
    }

    .service-panel .pagination-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .service-panel .pagination-area nav p {
        margin: 0;
    }

    .service-panel .pagination-area nav div:first-child {
        display: none;
    }

    .service-panel .pagination-area nav div:last-child {
        margin-top: 0;
    }

    .service-panel .pagination-area nav span,
    .service-panel .pagination-area nav a {
        border-radius: 6px;
    }

    .service-search-panel {
        padding: 16px 21px;
    }

    .service-search-panel .search-form {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .service-search-panel .search-input {
        min-width: 240px;
        flex: 1;
        padding: 10px 12px;
        border: 1px solid #dee2e6;
        border-radius: 7px;
        outline: none;
        font: inherit;
    }

    .service-search-panel .search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
    }

    .service-notice {
        padding: 13px 16px;
        margin-bottom: 16px;
        border: 1px solid transparent;
        border-radius: 8px;
        line-height: 1.6;
    }

    .service-notice ul {
        padding-left: 20px;
        margin: 6px 0 0;
    }

    .service-notice-success {
        color: #166534;
        background: #ecfdf3;
        border-color: #bbf7d0;
    }

    .service-notice-error {
        color: #991b1b;
        background: #fef2f2;
        border-color: #fecaca;
    }

    .service-empty {
        padding: 38px 20px;
        text-align: center;
    }

    .service-empty strong {
        display: block;
        color: #334155;
        font-size: 15px;
    }

    .service-empty p {
        margin: 8px 0 16px;
        color: #64748b;
        line-height: 1.6;
    }

    @media (max-width: 700px) {
        .service-panel .table-wrapper {
            padding: 14px 12px 6px;
        }

        .service-panel .table-wrapper table {
            min-width: 1150px;
        }

        .service-search-panel {
            padding: 14px;
        }

        .service-search-panel .search-form {
            align-items: stretch;
        }

        .service-search-panel .search-input {
            min-width: 100%;
            width: 100%;
        }

        .service-panel .table-footer {
            padding: 14px;
        }

        .service-panel .pagination-area {
            align-items: flex-start;
            flex-direction: column;
        }

        .service-panel .pagination-area nav {
            max-width: 100%;
            overflow-x: auto;
        }
    }
</style>
@endpush

@section('content')
<div class="content">

    {{-- Judul halaman --}}
    <section class="page-heading">
        <div>
            <div class="breadcrumb">Admin / Data Master / Kelola Layanan</div>
            <h1 class="page-title">Kelola Layanan &amp; Harga</h1>
            <p class="page-description">
                Atur daftar servis dan rincian harga layanan Bengkel Royal Motor.
            </p>
        </div>

        <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary">
            + Tambah Layanan
        </a>
    </section>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="service-notice service-notice-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="service-notice service-notice-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="service-notice service-notice-error">
            <strong>Periksa kembali data yang diisi.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Pencarian --}}
    <section class="panel service-search-panel">
        <form
            action="{{ route('admin.layanan.index') }}"
            method="GET"
            class="search-form"
        >
            <input
                type="search"
                name="search"
                class="search-input"
                placeholder="Cari nama atau deskripsi layanan..."
                value="{{ $search ?? '' }}"
                aria-label="Cari layanan"
            >

            <button type="submit" class="btn btn-dark">
                Cari
            </button>

            @if (!empty($search))
                <a href="{{ route('admin.layanan.index') }}" class="btn btn-light">
                    Reset
                </a>
            @endif
        </form>
    </section>

    {{-- Tabel layanan --}}
    <section class="panel service-panel">
        <div class="panel-header">
            <div>
                <div class="panel-title">Daftar Layanan</div>
                <div class="panel-subtitle">
                    Total {{ $services->total() }} layanan terdaftar.
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-name">Nama Layanan</th>
                        <th class="col-description">Deskripsi</th>
                        <th class="col-item-price">Harga Barang</th>
                        <th class="col-service-price">Biaya Jasa</th>
                        <th class="col-total-price">Total Harga</th>
                        <th class="col-duration">Estimasi</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td class="col-no">
                                {{ $services->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="service-name">
                                    {{ $service->nama_servis }}
                                </div>
                                <div class="service-id">
                                    ID Layanan: #{{ $service->id }}
                                </div>
                            </td>

                            <td>
                                <div class="service-description">
                                    {{ $service->deskripsi ?: '-' }}
                                </div>
                            </td>

                            <td class="service-price">
                                Rp{{ number_format($service->harga_barang ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="service-price">
                                Rp{{ number_format($service->biaya_jasa ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="service-total">
                                    Rp{{ number_format($service->harga ?? (($service->harga_barang ?? 0) + ($service->biaya_jasa ?? 0)), 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="service-duration">
                                    {{ $service->estimasi_waktu }} menit
                                </span>
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route('admin.layanan.show', $service->id) }}"
                                        class="btn btn-sm btn-detail"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        href="{{ route('admin.layanan.edit', $service->id) }}"
                                        class="btn btn-sm btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.layanan.destroy', $service->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus layanan ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-delete"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="service-empty">
                                    <strong>
                                        @if (!empty($search))
                                            Layanan tidak ditemukan
                                        @else
                                            Belum ada data layanan
                                        @endif
                                    </strong>

                                    <p>
                                        @if (!empty($search))
                                            Coba gunakan kata kunci pencarian lain.
                                        @else
                                            Tambahkan layanan pertama Bengkel Royal Motor.
                                        @endif
                                    </p>

                                    @if (!empty($search))
                                        <a
                                            href="{{ route('admin.layanan.index') }}"
                                            class="btn btn-light"
                                        >
                                            Reset Pencarian
                                        </a>
                                    @else
                                        <a
                                            href="{{ route('admin.layanan.create') }}"
                                            class="btn btn-primary"
                                        >
                                            + Tambah Layanan
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer tabel dan pagination --}}
        <div class="table-footer">
            @if ($services->total() > 0)
                <div class="pagination-area">
                    <div>
                        Menampilkan
                        <strong>{{ $services->firstItem() }}</strong>
                        sampai
                        <strong>{{ $services->lastItem() }}</strong>
                        dari
                        <strong>{{ $services->total() }}</strong>
                        layanan.
                    </div>

                    @if ($services->hasPages())
                        {{ $services->links() }}
                    @endif
                </div>
            @else
                Menampilkan 0 layanan.
            @endif
        </div>
    </section>

</div>
@endsection