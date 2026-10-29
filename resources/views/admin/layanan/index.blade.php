@extends('admin.layouts.app')

@section('title', 'Kelola Layanan & Harga')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .dt-page,
    .dt-page * { box-sizing: border-box; }
    .dt-page { color: #212529; }

    /* ===== CARD ===== */
    .dt-page .panel { background: #fff; border: 1px solid #e9ecef; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,.06); margin-bottom: 18px; overflow: hidden; }
    .dt-page .panel-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; padding: 14px 20px; background: #fff; border-bottom: 1px solid #e9ecef; }
    .dt-page .panel-title { margin: 0; color: #212529; font-size: 16px; font-weight: 400; }
    .dt-page .empty-state { padding: 44px 15px; color: #6c757d; text-align: center; font-size: 13px; }

    .dt-page .dt-notice { padding: 13px 16px; margin-bottom: 16px; border: 1px solid transparent; border-radius: 6px; font-size: 13px; line-height: 1.6; }
    .dt-page .dt-notice ul { padding-left: 20px; margin: 6px 0 0; }
    .dt-page .dt-notice-success { color: #155724; background: #d4edda; border-color: #c3e6cb; }
    .dt-page .dt-notice-error { color: #721c24; background: #f8d7da; border-color: #f5c6cb; }

    /* ===== TOMBOL ===== */
    .dt-page .dt-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 4px 9px; border: 1px solid transparent; border-radius: 4px; font-family: inherit; font-size: 12px; font-weight: 600; line-height: 1.5; white-space: nowrap; text-decoration: none; cursor: pointer; transition: filter .15s ease; }
    .dt-page .dt-btn:hover { filter: brightness(.92); }
    .dt-page .dt-btn-add { padding: 6px 12px; color: #fff; background: #007bff; border-color: #007bff; }
    .dt-page .dt-btn-detail { color: #fff; background: #17a2b8; border-color: #17a2b8; }
    .dt-page .dt-btn-edit { color: #212529; background: #ffc107; border-color: #ffc107; }
    .dt-page .dt-btn-delete { color: #fff; background: #dc3545; border-color: #dc3545; }

    /* ===== TABEL ===== */
    .dt-page .table-wrapper { width: 100%; padding: 20px; overflow-x: auto; }
    .dt-page .dt-strong { color: #212529; font-size: 14px; line-height: 1.5; overflow-wrap: anywhere; }
    .dt-page .dt-small { margin-top: 2px; color: #6c757d; font-size: 11px; line-height: 1.5; overflow-wrap: anywhere; }

    .dt-page table.dt-table { width: 100% !important; margin: 0 !important; border-collapse: collapse; border: 1px solid #dee2e6; background: #fff; }
    .dt-page table.dt-table thead th,
    .dt-page table.dt-table tfoot th { padding: 14px 12px; color: #212529; background: #fff; border: 1px solid #dee2e6; font-size: 14px; font-weight: 700; text-align: left; white-space: nowrap; }
    .dt-page table.dt-table thead th { border-bottom: 2px solid #dee2e6; }
    .dt-page table.dt-table tfoot th { border-top: 2px solid #dee2e6; }
    .dt-page table.dt-table tbody td { padding: 14px 12px; color: #212529; border: 1px solid #dee2e6; font-size: 14px; vertical-align: middle; white-space: nowrap; }
    .dt-page table.dt-table tbody td.col-wrap { white-space: normal; }
    .dt-page table.dt-table tbody td.t-center,
    .dt-page table.dt-table thead th.t-center,
    .dt-page table.dt-table tfoot th.t-center { text-align: center; }
    .dt-page table.dt-table tbody tr:hover { background: #f1f1f1; }
    .dt-page table.dataTable.no-footer { border-bottom: 1px solid #dee2e6; }

    /* ===== DATATABLES (toolbar, search, pagination) ===== */
    .dt-page .dataTables_wrapper { font-size: 14px; color: #212529; }
    .dt-page .dt-top, .dt-page .dt-bottom { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; }
    .dt-page .dt-top { margin-bottom: 14px; }
    .dt-page .dt-bottom { margin-top: 14px; }

    .dt-page .dt-buttons { display: flex; flex-wrap: wrap; float: none; margin: 0; }
    .dt-page .dt-button { margin: 0 !important; padding: 8px 12px !important; color: #fff !important; background: #6c757d !important; background-image: none !important; border: none !important; border-radius: 0 !important; font-size: 14px !important; box-shadow: none !important; }
    .dt-page .dt-button:first-child { border-radius: 4px 0 0 4px !important; }
    .dt-page .dt-button:last-child { border-radius: 0 4px 4px 0 !important; }
    .dt-page .dt-button:only-child { border-radius: 4px !important; }
    .dt-page .dt-button:hover { background: #5a6268 !important; background-image: none !important; }

    .dt-page .dataTables_filter { float: none; margin: 0; }
    .dt-page .dataTables_filter input { margin-left: 6px; width: 180px; padding: 6px 10px; color: #495057; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; outline: none; }
    .dt-page .dataTables_filter input:focus { border-color: #80bdff; box-shadow: 0 0 0 3px rgba(0,123,255,.2); }
    .dt-page .dataTables_info { float: none; padding: 0; color: #212529; }
    .dt-page .dataTables_paginate { float: none; padding: 0; }
    .dt-page .dataTables_paginate .paginate_button { padding: 6px 12px !important; margin: 0 0 0 -1px !important; color: #6c757d !important; background: #fff !important; background-image: none !important; border: 1px solid #dee2e6 !important; border-radius: 0 !important; box-shadow: none !important; }
    .dt-page .dataTables_paginate .paginate_button:first-child { border-radius: 4px 0 0 4px !important; }
    .dt-page .dataTables_paginate .paginate_button:last-child { border-radius: 0 4px 4px 0 !important; }
    .dt-page .dataTables_paginate .paginate_button.current { color: #fff !important; background: #007bff !important; border-color: #007bff !important; }
    .dt-page .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) { color: #0056b3 !important; background: #e9ecef !important; }
    .dt-page .dataTables_paginate .paginate_button.disabled { color: #adb5bd !important; cursor: default; }

    div.dt-button-background { background: transparent !important; }
    div.dt-button-collection { padding: 6px 0; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 6px 18px rgba(0,0,0,.15); }
    div.dt-button-collection .dt-button { display: block; width: 100%; color: #212529 !important; background: #fff !important; border: none !important; border-radius: 0 !important; text-align: left; }
    div.dt-button-collection .dt-button.active, div.dt-button-collection .dt-button.dt-button-active { color: #fff !important; background: #007bff !important; }

    /* ===== STATUS & TOTAL ===== */
    .dt-page .status { display: inline-flex; align-items: center; justify-content: center; padding: 5px 9px; border: 1px solid transparent; border-radius: 4px; font-size: 11px; font-weight: 700; line-height: 1.5; white-space: nowrap; }
    .dt-page .status.info { color: #0c5460; background: #d1ecf1; border-color: #bee5eb; }
    .dt-page .dt-total { color: #007bff; font-size: 14px; font-weight: 700; white-space: nowrap; }

    .dt-page .dt-actions { display: flex; align-items: center; justify-content: center; gap: 4px; flex-wrap: nowrap; }
    .dt-page .dt-actions form { display: inline-flex; margin: 0; padding: 0; }

    /* ===== KARTU MOBILE ===== */
    .dt-page .dt-mobile { display: none; padding: 14px; }
    .dt-page .dt-card { padding: 15px; margin-bottom: 12px; background: #fff; border: 1px solid #ced4da; border-left: 3px solid #007bff; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
    .dt-page .dt-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; padding-bottom: 12px; border-bottom: 1px solid #ced4da; }
    .dt-page .dt-card-grid { display: block; margin-top: 2px; }
    .dt-page .dt-card-grid > div { display: flex; justify-content: space-between; align-items: flex-start; gap: 14px; padding: 10px 0; border-bottom: 1px solid #e9ecef; }
    .dt-page .dt-card-grid > div:last-child { border-bottom: none; }
    .dt-page .dt-card-grid > div.full { flex-direction: column; gap: 4px; }
    .dt-page .dt-card-grid > div.full .dt-card-value { text-align: left; }
    .dt-page .dt-card-label { flex: 0 0 auto; color: #6c757d; font-size: 12px; line-height: 1.6; }
    .dt-page .dt-card-value { min-width: 0; margin-top: 0; color: #212529; font-size: 13px; font-weight: 600; line-height: 1.6; text-align: right; overflow-wrap: anywhere; }
    .dt-page .dt-card-total { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 0; padding: 12px 0; border-top: 1px solid #ced4da; border-bottom: 1px solid #e9ecef; }
    .dt-page .dt-card-total span:first-child { color: #212529; font-size: 13px; font-weight: 700; }
    .dt-page .dt-card-total .dt-total { font-size: 16px; }
    .dt-page .dt-card-actions { display: flex; gap: 8px; margin-top: 4px; padding-top: 14px; border-top: 1px solid #ced4da; }
    .dt-page .dt-card-actions > a, .dt-page .dt-card-actions > form { flex: 1; margin: 0; }
    .dt-page .dt-card-actions .dt-btn { width: 100%; min-height: 40px; font-size: 13px; }
    .dt-page .dt-m-search { width: 100%; margin-bottom: 12px; padding: 10px 12px; color: #495057; background: #fff; border: 1px solid #ced4da; border-radius: 4px; font-family: inherit; font-size: 16px; outline: none; }
    .dt-page .dt-m-search:focus { border-color: #80bdff; box-shadow: 0 0 0 3px rgba(0,123,255,.2); }
    .dt-page .dt-m-more { display: none; width: 100%; min-height: 44px; margin-top: 12px; color: #fff; background: #007bff; border: 1px solid #007bff; border-radius: 4px; font-family: inherit; font-size: 14px; font-weight: 600; cursor: pointer; }
    .dt-page .dt-m-empty { display: none; padding: 22px 10px; color: #6c757d; font-size: 13px; text-align: center; }

    @media (max-width: 800px) {
        .dt-page .table-wrapper { display: none; }
        .dt-page .dt-mobile { display: block; }
    }
    @media (max-width: 650px) {
        .dt-page .panel-header { padding: 12px 14px; }
        .dt-page .dt-mobile { padding: 10px; }
    .dt-page .dt-card { padding: 13px; }
    }
</style>
@endpush

@section('content')
@php
    $rp = fn ($n) => 'Rp' . number_format((float) $n, 0, ',', '.');
    $totalOf = fn ($s) => (float) ($s->harga ?? (($s->harga_barang ?? 0) + ($s->biaya_jasa ?? 0)));

    // Bisa paginator ataupun collection (di controller sebaiknya pakai ->get())
    $items = method_exists($services, 'items') ? collect($services->items()) : collect($services);
    $totalData = $items->count();
@endphp

<div class="content dt-page">

    <section class="page-heading">
        <div>
            <div class="breadcrumb">Admin / Data Master / Kelola Layanan</div>
            <h1 class="page-title">Kelola Layanan &amp; Harga</h1>
            <p class="page-description">Atur daftar servis dan rincian harga layanan Bengkel Royal Motor.</p>
        </div>
    </section>

    @if (session('success'))
        <div class="dt-notice dt-notice-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="dt-notice dt-notice-error">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="dt-notice dt-notice-error">
            <strong>Periksa kembali data yang diisi.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Tabel Data Seluruh Layanan</h2>
            <a href="{{ route('admin.layanan.create') }}" class="dt-btn dt-btn-add">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Tambah Layanan
            </a>
        </div>

        @if ($items->isEmpty())
            <div class="empty-state">Belum ada data layanan.</div>
        @else

            {{-- TABEL DESKTOP --}}
            <div class="table-wrapper">
                <table id="tabelLayanan" class="dt-table display">
                    <thead>
                        <tr>
                            <th class="t-center">No</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Harga Barang</th>
                            <th>Biaya Jasa</th>
                            <th>Total Harga</th>
                            <th class="t-center">Estimasi</th>
                            <th class="t-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $service)
                            <tr>
                                <td class="t-center">{{ $loop->iteration }}</td>
                                <td class="col-wrap" style="min-width:180px">
                                    <div class="dt-strong">{{ $service->nama_servis }}</div>
                                    <div class="dt-small">ID Layanan: #{{ $service->id }}</div>
                                </td>
                                <td class="col-wrap" style="min-width:220px">{{ $service->deskripsi ?: '-' }}</td>
                                <td data-order="{{ (float) ($service->harga_barang ?? 0) }}">{{ $rp($service->harga_barang ?? 0) }}</td>
                                <td data-order="{{ (float) ($service->biaya_jasa ?? 0) }}">{{ $rp($service->biaya_jasa ?? 0) }}</td>
                                <td data-order="{{ $totalOf($service) }}"><span class="dt-total">{{ $rp($totalOf($service)) }}</span></td>
                                <td class="t-center" data-order="{{ (int) $service->estimasi_waktu }}"><span class="status info">{{ $service->estimasi_waktu }} menit</span></td>
                                <td>
                                    <div class="dt-actions">
                                        <a href="{{ route('admin.layanan.show', $service->id) }}" class="dt-btn dt-btn-detail">Detail</a>
                                        <a href="{{ route('admin.layanan.edit', $service->id) }}" class="dt-btn dt-btn-edit">Edit</a>
                                        <form action="{{ route('admin.layanan.destroy', $service->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dt-btn dt-btn-delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="t-center">No</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Harga Barang</th>
                            <th>Biaya Jasa</th>
                            <th>Total Harga</th>
                            <th class="t-center">Estimasi</th>
                            <th class="t-center">Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- KARTU MOBILE --}}
            <div class="dt-mobile" id="dtMobile">
                <input type="search" id="dtMSearch" class="dt-m-search"
                       placeholder="Cari nama atau deskripsi layanan" autocomplete="off">

                @foreach ($items as $service)
                    <article class="dt-card"
                             data-search="{{ strtolower(($service->nama_servis ?? '') . ' ' . ($service->deskripsi ?? '')) }}">
                        <div class="dt-card-top">
                            <div>
                                <div class="dt-strong">{{ $service->nama_servis }}</div>
                                <div class="dt-small">ID Layanan: #{{ $service->id }}</div>
                            </div>
                            <span class="status info">{{ $service->estimasi_waktu }} menit</span>
                        </div>

                        <div class="dt-card-grid">
                            <div class="full">
                                <div class="dt-card-label">Deskripsi</div>
                                <div class="dt-card-value">{{ $service->deskripsi ?: '-' }}</div>
                            </div>
                            <div>
                                <div class="dt-card-label">Harga Barang</div>
                                <div class="dt-card-value">{{ $rp($service->harga_barang ?? 0) }}</div>
                            </div>
                            <div>
                                <div class="dt-card-label">Biaya Jasa</div>
                                <div class="dt-card-value">{{ $rp($service->biaya_jasa ?? 0) }}</div>
                            </div>
                        </div>

                        <div class="dt-card-total">
                            <span>Total harga</span>
                            <span class="dt-total">{{ $rp($totalOf($service)) }}</span>
                        </div>

                        <div class="dt-card-actions">
                            <a href="{{ route('admin.layanan.show', $service->id) }}" class="dt-btn dt-btn-detail">Detail</a>
                            <a href="{{ route('admin.layanan.edit', $service->id) }}" class="dt-btn dt-btn-edit">Edit</a>
                            <form action="{{ route('admin.layanan.destroy', $service->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dt-btn dt-btn-delete">Hapus</button>
                            </form>
                        </div>
                    </article>
                @endforeach

                <div class="dt-m-empty" id="dtMEmpty">Data tidak ditemukan</div>
                <button type="button" class="dt-m-more" id="dtMMore">Tampilkan lebih banyak</button>
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
var CFG = { table: { table: '#tabelLayanan', hasActions: true }, cards: { cards: '#dtMobile .dt-card', search: '#dtMSearch', more: '#dtMMore', empty: '#dtMEmpty' } };
(function () {
    function loadScript(src, cb) {
        var s = document.createElement('script');
        s.src = src; s.onload = cb;
        document.body.appendChild(s);
    }
    function chain(list, done) {
        if (!list.length) return done();
        loadScript(list[0], function () { chain(list.slice(1), done); });
    }

    // Kartu di HP: pencarian + tampil 5 data dulu
    function initCards(o) {
        var cards = Array.prototype.slice.call(document.querySelectorAll(o.cards));
        if (!cards.length) return;
        var input = document.querySelector(o.search);
        var more = document.querySelector(o.more);
        var empty = document.querySelector(o.empty);
        var step = 5, limit = step;

        function render() {
            var q = (input.value || '').toLowerCase().trim();
            var matched = cards.filter(function (c) { return c.getAttribute('data-search').indexOf(q) !== -1; });
            cards.forEach(function (c) { c.style.display = 'none'; });
            matched.slice(0, limit).forEach(function (c) { c.style.display = ''; });
            more.style.display = matched.length > limit ? 'block' : 'none';
            empty.style.display = matched.length ? 'none' : 'block';
        }
        input.addEventListener('input', function () { limit = step; render(); });
        more.addEventListener('click', function () { limit += step; render(); });
        render();
    }

    // Tabel desktop: Copy, PDF, Column visibility, cari, urutkan, pagination
    function initTable(o) {
        if (!document.querySelector(o.table)) return;
        var hasAct = o.hasActions !== false;
        var exportCols = { columns: hasAct ? ':visible:not(:last-child)' : ':visible' };

        var colBtn = { extend: 'colvis', text: 'Column visibility', background: false };
        if (hasAct) colBtn.columns = ':not(:last-child)';

        var defs = [{ targets: 0, width: '40px' }];
        if (hasAct) defs.push({ targets: -1, orderable: false, searchable: false });

        jQuery(o.table).DataTable({
            dom: "<'dt-top'<'dt-btns'B><'dt-search'f>>rt<'dt-bottom'<'dt-info'i><'dt-paging'p>>",
            stateSave: true,
            pageLength: 10,
            order: [],
            autoWidth: false,
            buttons: [
                { extend: 'copy', text: 'Copy', exportOptions: exportCols },
                { extend: 'pdf',  text: 'PDF',  title: 'Data Layanan & Harga', orientation: 'landscape', pageSize: 'A4', exportOptions: exportCols },
                colBtn
            ],
            columnDefs: defs,
            language: {
                search: 'Search:',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(dari _MAX_ data)',
                zeroRecords: 'Tidak ada data yang cocok',
                paginate: { previous: 'Previous', next: 'Next' },
                buttons: { copyTitle: 'Tersalin', copySuccess: { _: '%d baris tersalin' } }
            }
        });
    }

    function start() {
        chain([
            'https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js'
        ], function () { initTable(CFG.table); });
    }

    initCards(CFG.cards);

    if (window.jQuery) start();
    else loadScript('https://code.jquery.com/jquery-3.7.1.min.js', start);
})();
</script>
@endpush