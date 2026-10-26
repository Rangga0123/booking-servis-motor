@extends('admin.layouts.app')

@section('title', 'Kelola Layanan & Harga')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .dt-page,
    .dt-page * { box-sizing: border-box; }
    .dt-page { color: #192740; }

    .dt-page .panel { overflow: hidden; background: #fff; border: 1px solid #e3e9f2; border-radius: 18px; box-shadow: 0 5px 22px rgba(31,52,88,.045); margin-bottom: 18px; }
    .dt-page .panel-header { padding: 21px 23px; background: linear-gradient(135deg, #fff, #f8faff); border-bottom: 1px solid #edf1f7; }
    .dt-page .panel-header-top { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
    .dt-page .panel-heading { display: flex; align-items: center; gap: 14px; }
    .dt-page .panel-heading-icon { width: 45px; height: 45px; display: grid; place-items: center; flex-shrink: 0; border-radius: 14px; background: linear-gradient(145deg, #527fff, #3158cb); color: #fff; }
    .dt-page .panel-title { margin: 0; color: #1a2943; font-size: 15px; font-weight: 800; }
    .dt-page .panel-subtitle { margin-top: 5px; color: #8794a9; font-size: 12px; }
    .dt-page .panel-tag { flex-shrink: 0; padding: 7px 10px; color: #3264d8; background: #edf3ff; border: 1px solid #dce7ff; border-radius: 7px; font-size: 11px; font-weight: 750; }
    .dt-page .empty-state { padding: 44px 15px; color: #8a97ab; text-align: center; font-size: 13px; }

    .dt-page .dt-notice { padding: 13px 16px; margin-bottom: 16px; border: 1px solid transparent; border-radius: 10px; font-size: 13px; line-height: 1.6; }
    .dt-page .dt-notice ul { padding-left: 20px; margin: 6px 0 0; }
    .dt-page .dt-notice-success { color: #087647; background: #e1f8eb; border-color: #bcebd0; }
    .dt-page .dt-notice-error { color: #bb2942; background: #ffedf0; border-color: #ffd0d8; }

    .dt-page .table-wrapper { width: 100%; padding: 18px 22px 20px; }
    .dt-page .dt-strong { color: #14213d; font-size: 13px; font-weight: 750; line-height: 1.6; overflow-wrap: anywhere; }
    .dt-page .dt-small { margin-top: 4px; color: #8491a8; font-size: 11px; line-height: 1.6; overflow-wrap: anywhere; }

    .dt-page table.dt-table { width: 100%; border-collapse: collapse; border-spacing: 0; border: 1px solid #e2e9f3; text-align: left; background: #fff; }
    .dt-page table.dt-table thead th { padding: 15px 14px; color: #60708a; background: #f5f8fd; border-bottom: 1px solid #e2e9f3; border-right: 1px solid #e2e9f3; font-size: 11px; font-weight: 800; letter-spacing: .35px; text-transform: uppercase; white-space: nowrap; }
    .dt-page table.dt-table tbody td { padding: 11px 14px; color: #52647b; border-bottom: 1px solid #e2e9f3; border-right: 1px solid #e2e9f3; font-size: 12px; line-height: 1.7; vertical-align: middle; white-space: nowrap; }
    .dt-page table.dt-table tbody td.col-wrap { white-space: normal; }
    .dt-page table.dt-table tbody td.t-center { text-align: center; }
    .dt-page table.dt-table thead th:last-child,
    .dt-page table.dt-table tbody td:last-child { border-right: none; }
    .dt-page table.dt-table tbody tr:nth-child(even) { background: #fbfcff; }
    .dt-page table.dt-table tbody tr:hover { background: #f2f6ff; }
    .dt-page table.dataTable.no-footer { border-bottom: 1px solid #e2e9f3; }

    .dt-page .dataTables_wrapper { font-size: 12px; color: #52647b; }
    .dt-page .dt-top, .dt-page .dt-bottom { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; }
    .dt-page .dt-top { margin-bottom: 14px; }
    .dt-page .dt-bottom { margin-top: 14px; }
    .dt-page .dt-buttons { display: flex; flex-wrap: wrap; gap: 0; float: none; margin: 0; }
    .dt-page .dt-button { margin: 0 !important; padding: 8px 15px !important; color: #fff !important; background: #3b4752 !important; background-image: none !important; border: 1px solid #2f3a45 !important; border-radius: 0 !important; font-size: 12px !important; font-weight: 700 !important; box-shadow: none !important; }
    .dt-page .dt-button:first-child { border-radius: 7px 0 0 7px !important; }
    .dt-page .dt-button:last-child { border-radius: 0 7px 7px 0 !important; }
    .dt-page .dt-button:only-child { border-radius: 7px !important; }
    .dt-page .dt-button:hover { background: #2b343d !important; background-image: none !important; }
    .dt-page .dataTables_filter, .dt-page .dataTables_length { float: none; margin: 0; }
    .dt-page .dataTables_filter input, .dt-page .dataTables_length select { padding: 7px 10px; color: #14213d; border: 1px solid #d3dcea; border-radius: 7px; font-size: 12px; outline: none; }
    .dt-page .dataTables_filter input:focus { border-color: #3264d8; box-shadow: 0 0 0 3px rgba(50,100,216,.12); }
    .dt-page .dataTables_info { float: none; padding: 0; color: #7182a3; }
    .dt-page .dataTables_paginate { float: none; padding: 0; }
    .dt-page .dataTables_paginate .paginate_button { padding: 6px 12px !important; margin: 0 0 0 -1px !important; color: #52647b !important; background: #fff !important; background-image: none !important; border: 1px solid #d3dcea !important; border-radius: 0 !important; box-shadow: none !important; }
    .dt-page .dataTables_paginate .paginate_button:first-child { border-radius: 7px 0 0 7px !important; }
    .dt-page .dataTables_paginate .paginate_button:last-child { border-radius: 0 7px 7px 0 !important; }
    .dt-page .dataTables_paginate .paginate_button.current { color: #fff !important; background: #3264d8 !important; border-color: #3264d8 !important; }
    .dt-page .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) { background: #eef3fc !important; }
    .dt-page .dataTables_paginate .paginate_button.disabled { color: #a7b2c4 !important; }
    div.dt-button-background { background: transparent !important; }
    div.dt-button-collection { padding: 6px 0; border: 1px solid #dce5f1; border-radius: 8px; box-shadow: 0 8px 24px rgba(39,61,99,.15); }
    div.dt-button-collection .dt-button { display: block; width: 100%; color: #14213d !important; background: #fff !important; border: none !important; border-radius: 0 !important; text-align: left; }
    div.dt-button-collection .dt-button.active, div.dt-button-collection .dt-button.dt-button-active { color: #fff !important; background: #3264d8 !important; }

    .dt-page .status { display: inline-flex; align-items: center; justify-content: center; padding: 6px 9px; border: 1px solid transparent; border-radius: 7px; font-size: 10px; font-weight: 800; line-height: 1.5; white-space: nowrap; }
    .dt-page .status.active   { color: #087647; background: #e1f8eb; border-color: #bcebd0; }
    .dt-page .status.inactive { color: #bb2942; background: #ffedf0; border-color: #ffd0d8; }
    .dt-page .status.info     { color: #2457bd; background: #e7efff; border-color: #cbdcff; }
    .dt-page .dt-total { color: #3264d8; font-size: 13px; font-weight: 800; white-space: nowrap; }

    .dt-page .dt-actions { display: flex; align-items: center; gap: 6px; flex-wrap: nowrap; }
    .dt-page .dt-actions form { display: inline-flex; margin: 0; padding: 0; }
    .dt-page .dt-btn { display: inline-flex; align-items: center; justify-content: center; min-height: 32px; min-width: 52px; padding: 7px 12px; border: 1px solid transparent; border-radius: 7px; font-family: inherit; font-size: 10px; font-weight: 800; white-space: nowrap; text-decoration: none; cursor: pointer; transition: .2s ease; }
    .dt-page .dt-btn:hover { transform: translateY(-1px); }
    .dt-page .dt-btn-detail { color: #1854b4; background: #eaf2ff; border-color: #d2e2ff; }
    .dt-page .dt-btn-edit { color: #956000; background: #fff5dc; border-color: #ffe3a0; }
    .dt-page .dt-btn-delete { color: #bb2942; background: #ffedf0; border-color: #ffd0d8; }

    .dt-page .dt-mobile { display: none; padding: 14px; }
    .dt-page .dt-card { padding: 15px; margin-bottom: 12px; background: #fff; border: 1px solid #dce5f1; border-left: 3px solid #3264d8; border-radius: 11px; box-shadow: 0 3px 10px rgba(39,61,99,.035); }
    .dt-page .dt-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    .dt-page .dt-card-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 13px; margin-top: 14px; padding-top: 14px; border-top: 1px solid #e8edf5; }
    .dt-page .dt-card-grid .full { grid-column: 1 / -1; }
    .dt-page .dt-card-label { color: #8491a8; font-size: 11px; line-height: 1.5; }
    .dt-page .dt-card-value { margin-top: 5px; color: #263752; font-size: 12px; font-weight: 700; line-height: 1.7; overflow-wrap: anywhere; }
    .dt-page .dt-card-actions { display: flex; gap: 8px; margin-top: 14px; padding-top: 13px; border-top: 1px solid #e8edf5; }
    .dt-page .dt-card-actions > a, .dt-page .dt-card-actions > form { flex: 1; margin: 0; }
    .dt-page .dt-card-actions .dt-btn { width: 100%; min-height: 40px; font-size: 12px; }
    .dt-page .dt-card-total { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 14px; padding-top: 13px; border-top: 1px dashed #d3dcea; }
    .dt-page .dt-card-total span:first-child { color: #14213d; font-size: 12px; font-weight: 800; }
    .dt-page .dt-card-total .dt-total { font-size: 15px; }
    .dt-page .dt-m-search { width: 100%; margin-bottom: 12px; padding: 11px 13px; color: #14213d; background: #fff; border: 1px solid #d3dcea; border-radius: 9px; font-family: inherit; font-size: 16px; outline: none; }
    .dt-page .dt-m-search:focus { border-color: #3264d8; box-shadow: 0 0 0 3px rgba(50,100,216,.12); }
    .dt-page .dt-m-more { display: none; width: 100%; min-height: 44px; margin-top: 12px; color: #3264d8; background: #edf3ff; border: 1px solid #dce7ff; border-radius: 9px; font-family: inherit; font-size: 13px; font-weight: 750; cursor: pointer; }
    .dt-page .dt-m-empty { display: none; padding: 22px 10px; color: #7182a3; font-size: 13px; text-align: center; }

    @media (max-width: 800px) {
        .dt-page .table-wrapper { display: none; }
        .dt-page .dt-mobile { display: block; }
    }
    @media (max-width: 650px) {
        .dt-page .panel-header { padding: 16px; }
        .dt-page .panel-tag { display: none; }
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
        <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary">+ Tambah Layanan</a>
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
            <div class="panel-header-top">
                <div class="panel-heading">
                    <div class="panel-heading-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                            <path d="M8 7h8M8 11h8M8 15h5"/>
                        </svg>
                    </div>
                    <div>
                        <div class="panel-title">Daftar Layanan</div>
                        <div class="panel-subtitle">Total {{ $totalData }} layanan terdaftar.</div>
                    </div>
                </div>
                <span class="panel-tag">{{ $totalData }} Layanan</span>
            </div>
        </div>

        @if ($items->isEmpty())
            <div class="empty-state">Belum ada data layanan.</div>
        @else

            {{-- TABEL DESKTOP --}}
            <div class="table-wrapper">
                <table id="tabelLayanan" class="dt-table display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Harga Barang</th>
                            <th>Biaya Jasa</th>
                            <th>Total Harga</th>
                            <th>Estimasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="col-wrap" style="min-width:180px">
                                    <div class="dt-strong">{{ $service->nama_servis }}</div>
                                    <div class="dt-small">ID Layanan: #{{ $service->id }}</div>
                                </td>
                                <td class="col-wrap" style="min-width:220px">{{ $service->deskripsi ?: '-' }}</td>
                                <td data-order="{{ (float) ($service->harga_barang ?? 0) }}">{{ $rp($service->harga_barang ?? 0) }}</td>
                                <td data-order="{{ (float) ($service->biaya_jasa ?? 0) }}">{{ $rp($service->biaya_jasa ?? 0) }}</td>
                                <td data-order="{{ $totalOf($service) }}"><span class="dt-total">{{ $rp($totalOf($service)) }}</span></td>
                                <td data-order="{{ (int) $service->estimasi_waktu }}"><span class="status info">{{ $service->estimasi_waktu }} menit</span></td>
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

    // Tabel desktop: Copy, Column visibility, cari, urutkan, pagination
    function initTable(o) {
        if (!document.querySelector(o.table)) return;
        var hasAct = o.hasActions !== false;

        var copyBtn = { extend: 'copy', text: 'Copy', exportOptions: { columns: hasAct ? ':visible:not(:last-child)' : ':visible' } };
        var colBtn = { extend: 'colvis', text: 'Column visibility', background: false };
        if (hasAct) colBtn.columns = ':not(:last-child)';

        var defs = [{ targets: 0, width: '40px' }];
        if (hasAct) defs.push({ targets: -1, orderable: false, searchable: false });

        var table = jQuery(o.table).DataTable({
            dom: "<'dt-top'<'dt-btns'B><'dt-search'f>>rt<'dt-bottom'<'dt-info'i><'dt-page'p>>",
            stateSave: true,
            pageLength: 10,
            order: [],
            autoWidth: false,
            scrollX: true,
            buttons: [copyBtn, colBtn],
            columnDefs: defs,
            language: {
                search: 'Cari :',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(dari _MAX_ data)',
                zeroRecords: 'Tidak ada data yang cocok',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                buttons: { copyTitle: 'Tersalin', copySuccess: { _: '%d baris tersalin' } }
            }
        });
        jQuery(window).on('resize', function () { table.columns.adjust(); });
    }

    function start() {
        chain([
            'https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js',
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