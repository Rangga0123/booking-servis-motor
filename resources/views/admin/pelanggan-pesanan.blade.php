@extends('admin.layouts.app')

@section('title', 'Pelanggan & Pesanan')

@push('styles')
<style>
    .order-page { color: #192740; }
    .page-heading { gap: 20px; margin-bottom: 26px; align-items: center; }

    .order-page .panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e3e9f2;
        border-radius: 18px;
        box-shadow: 0 5px 22px rgba(31, 52, 88, .045);
    }
    .order-page .panel-header {
        padding: 21px 23px;
        background: linear-gradient(135deg, #fff, #f8faff);
        border-bottom: 1px solid #edf1f7;
    }
    .order-page .panel-header-top {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 16px;
    }
    .order-page .panel-heading { display: flex; align-items: center; gap: 14px; }
    .order-page .panel-heading-icon {
        width: 45px; height: 45px; display: grid; place-items: center; flex-shrink: 0;
        border-radius: 14px; background: linear-gradient(145deg, #527fff, #3158cb); color: #fff;
    }
    .order-page .panel-title { color: #1a2943; font-size: 15px; font-weight: 800; }
    .order-page .panel-subtitle { margin-top: 5px; color: #8794a9; font-size: 12px; }

    .order-page .filter-select {
        width: 200px; max-width: 100%; padding: 11px 36px 11px 13px;
        border: 1px solid #dfe6f1; border-radius: 11px; background: #fff;
        color: #40516e; font-size: 12px; font-weight: 700; outline: none;
    }

    /* TABEL */
    .order-page .table-wrapper { width: 100%; overflow-x: auto; padding: 20px 21px 6px; }
    .order-page table {
        width: 100%; min-width: 900px; table-layout: fixed;
        border-collapse: collapse; border: 1px solid #dee2e6;
    }
    .order-page th:nth-child(1) { width: 50px; }
    .order-page th:nth-child(2) { width: 22%; }
    .order-page th:nth-child(3) { width: 14%; }
    .order-page th:nth-child(4) { width: 20%; }
    .order-page th:nth-child(5) { width: 14%; }
    .order-page th:nth-child(6) { width: 12%; }
    .order-page th:nth-child(7) { width: 100px; }

    .order-page table thead th {
        padding: 13px 14px; background: #fff; color: #212529;
        border: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6;
        font-size: 13px; font-weight: 800; text-align: left; vertical-align: middle;
    }
    .order-page table tbody td {
        padding: 12px 14px; color: #3c4858; border: 1px solid #dee2e6;
        font-size: 13px; line-height: 1.6; vertical-align: middle; overflow-wrap: anywhere;
    }
    .order-page table tbody tr:hover { background: #f2f4f7; }
    .order-page .col-no { color: #3c4858; text-align: center !important; }

    .order-page .customer-name { display: block; color: #263650; font-weight: 800; }
    .order-page .customer-detail { display: block; margin-top: 4px; color: #8b9ab1; font-size: 10px; }
    .order-page .vehicle-plate {
        display: inline-block; margin-top: 4px; padding: 2px 7px;
        background: #f0f3f8; border: 1px solid #e6ebf3; border-radius: 5px;
        color: #52627b; font-size: 10px; font-weight: 700;
    }
    .order-page .booking-date { color: #52627b; font-size: 11px; font-weight: 600; line-height: 1.8; }

    /* STATUS */
    .order-page .status {
        display: inline-flex; align-items: center; padding: 7px 10px;
        border-radius: 8px; font-size: 10px; font-weight: 800; white-space: nowrap;
    }
    .order-page .status.waiting  { background: #fff3dc; color: #b9790b; }
    .order-page .status.process  { background: #eaf0ff; color: #3864d2; }
    .order-page .status.done     { background: #e0f7eb; color: #138453; }
    .order-page .status.rejected { background: #ffe8eb; color: #c5344c; }

    .order-page .detail-btn {
        padding: 9px 12px; border: 0; border-radius: 9px; background: #263650;
        color: #fff; font-size: 11px; font-weight: 800; cursor: pointer; transition: .2s ease;
    }
    .order-page .detail-btn:hover { background: #4775ef; }

    .order-page .table-footer {
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 12px; padding: 14px 21px 22px;
        color: #3c4858; font-size: 13px;
    }
    .order-page .pager { display: flex; }
    .order-page .pager a,
    .order-page .pager span {
        padding: 7px 13px; margin-left: -1px; background: #fff;
        border: 1px solid #dee2e6; color: #3264d8; font-size: 13px; text-decoration: none;
    }
    .order-page .pager a:hover { background: #eef2fb; }
    .order-page .pager .disabled { color: #8a94a3; }
    .order-page .pager .active { background: #3264d8; border-color: #3264d8; color: #fff; }
    .order-page .pager > :first-child { margin-left: 0; border-radius: 5px 0 0 5px; }
    .order-page .pager > :last-child { border-radius: 0 5px 5px 0; }
    .order-page .empty-state { padding: 32px 15px; color: #8a97ab; text-align: center; font-size: 12px; }

    /* MODAL DETAIL */
    .order-page .modal {
        display: none; position: fixed; inset: 0; z-index: 2000;
        align-items: center; justify-content: center; padding: 18px;
        background: rgba(12, 23, 43, .68); backdrop-filter: blur(5px);
    }
    .order-page .modal.show { display: flex; }
    .order-page .modal-box {
        width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto;
        background: #fff; border-radius: 19px; box-shadow: 0 25px 80px #0003;
    }
    .order-page .modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 23px; border-bottom: 1px solid #e8edf5;
    }
    .order-page .modal-header h3 { color: #1d2c45; font-size: 16px; font-weight: 800; }
    .order-page .close-modal {
        width: 36px; height: 36px; border: 1px solid #e7ebf3; border-radius: 10px;
        background: #f5f7fb; color: #53637c; cursor: pointer;
    }
    .order-page .modal-content { padding: 23px; }
    .order-page .detail-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .order-page .detail-item {
        padding: 15px; overflow-wrap: anywhere; background: #f7f9fd;
        border: 1px solid #e9edf5; border-radius: 12px;
    }
    .order-page .detail-item small {
        display: block; margin-bottom: 7px; color: #8996aa; font-size: 10px;
        font-weight: 700; text-transform: uppercase;
    }
    .order-page .detail-item strong { color: #263650; font-size: 12px; line-height: 1.7; }

    /* JAM */
    .clock-box {
        min-width: 240px; display: flex; align-items: center; gap: 12px; padding: 13px 16px;
        background: #fff; border: 1px solid #e2e8f1; border-radius: 15px;
    }
    .clock-icon {
        width: 42px; height: 42px; display: grid; place-items: center; flex-shrink: 0;
        border-radius: 13px; background: #eaf0ff; color: #426fe7;
    }
    .clock-date { margin-bottom: 4px; color: #7c8ba4; font-size: 11px; font-weight: 600; }
    .clock-time { color: #1b2941; font-size: 17px; font-weight: 800; white-space: nowrap; }

    @media (max-width: 650px) {
        .page-heading { align-items: stretch; }
        .clock-box { width: 100%; min-width: 0; }
        .order-page .panel-header { padding: 16px; }
        .order-page .filter-select { width: 100%; }
        .order-page .detail-grid { grid-template-columns: minmax(0, 1fr); }
    }
</style>
@endpush

@section('content')
<section class="page-heading">
    <div>
        <div class="breadcrumb">Admin / Pelanggan / Daftar Pesanan</div>
        <h1 class="page-title">Daftar Pesanan</h1>
        <p class="page-description">Lihat pelanggan, booking masuk, dan status pesanan servis.</p>
    </div>

    <div class="clock-box">
        <div class="clock-icon">
            <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="17" rx="2"/>
                <path d="M8 2v4M16 2v4M3 10h18"/>
            </svg>
        </div>
        <div>
            <div id="liveDate" class="clock-date">Memuat tanggal...</div>
            <div id="liveTime" class="clock-time">--:--:-- WIB</div>
        </div>
    </div>
</section>

<div class="order-page">
    <section class="panel">
        <div class="panel-header">
            <div class="panel-header-top">
                <div class="panel-heading">
                    <div class="panel-heading-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                            <path d="M8 7h8M8 11h8M8 15h5"/>
                        </svg>
                    </div>
                    <div>
                        <div class="panel-title">Daftar Pesanan Servis Masuk</div>
                        <div class="panel-subtitle">Lihat detail pesanan, tanggal booking, dan status pelanggan.</div>
                    </div>
                </div>

                {{-- Filter status (diproses di server, jadi cocok dengan pagination) --}}
                <form method="GET">
                    <select name="status" class="filter-select" onchange="this.form.submit()" aria-label="Filter status booking">
                        <option value="">Semua Status</option>
                        @foreach(['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $val => $label)
                            <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Nama Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Keluhan</th>
                        <th>Tanggal Booking</th>
                        <th>Status</th>
                        <th style="text-align:center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bookings as $index => $item)
                        @php
                            $status = strtolower($item->status ?? '');
                            $jamBooking = $item->jam_booking ? str_replace(',', ':', trim($item->jam_booking)) : '';
                            $tanggalBooking = $item->tanggal_booking
                                ? \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y')
                                : '-';
                        @endphp

                        <tr>
                            <td class="col-no">{{ $bookings->firstItem() + $index }}</td>

                            <td>
                                <span class="customer-name">{{ $item->user->name ?? 'Pelanggan' }}</span>
                                <span class="customer-detail">{{ $item->user->email ?? 'Email tidak tersedia' }}</span>
                                <span class="vehicle-plate">{{ $item->plat_nomor ?? '-' }}</span>
                            </td>

                            <td>{{ $item->nama_motor ?? '-' }}</td>
                            <td>{{ $item->keluhan ?? '-' }}</td>

                            <td>
                                <div class="booking-date">
                                    {{ $tanggalBooking }}
                                    @if($jamBooking)<br>{{ $jamBooking }}@endif
                                </div>
                            </td>

                            <td>
                                @if(in_array($status, ['menunggu', 'pending']))
                                    <span class="status waiting">● Menunggu</span>
                                @elseif($status === 'disetujui')
                                    <span class="status process">● Disetujui</span>
                                @elseif($status === 'selesai')
                                    <span class="status done">● Selesai</span>
                                @elseif($status === 'ditolak')
                                    <span class="status rejected">● Ditolak</span>
                                @else
                                    <span class="status process">{{ ucfirst($item->status ?? '-') }}</span>
                                @endif
                            </td>

                            <td style="text-align:center">
                                <button
                                    type="button"
                                    class="detail-btn"
                                    onclick="openDetail(this)"
                                    data-customer="{{ $item->user->name ?? 'Pelanggan' }}"
                                    data-email="{{ $item->user->email ?? '-' }}"
                                    data-motor="{{ $item->nama_motor ?? '-' }}"
                                    data-plate="{{ $item->plat_nomor ?? '-' }}"
                                    data-service="{{ $item->jenis_servis ?? '-' }}"
                                    data-complaint="{{ $item->keluhan ?? '-' }}"
                                    data-date="{{ $tanggalBooking }}"
                                    data-time="{{ $jamBooking }}"
                                    data-status="{{ $item->status ?? '-' }}"
                                    data-mechanic="{{ $item->mechanic->nama_mekanik ?? 'Belum dipilih' }}"
                                    data-reason="{{ $item->alasan_penolakan ?? '' }}"
                                >◉ Detail</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7"><div class="empty-state">Belum ada pesanan servis.</div></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span>Menampilkan {{ $bookings->firstItem() ?? 0 }} sampai {{ $bookings->lastItem() ?? 0 }} dari {{ $bookings->total() }} data</span>

            @if($bookings->hasPages())
                <nav class="pager" aria-label="Halaman">
                    @if($bookings->onFirstPage())
                        <span class="disabled">Sebelumnya</span>
                    @else
                        <a href="{{ $bookings->previousPageUrl() }}">Sebelumnya</a>
                    @endif

                    @foreach($bookings->getUrlRange(max(1, $bookings->currentPage() - 2), min($bookings->lastPage(), $bookings->currentPage() + 2)) as $page => $url)
                        @if($page == $bookings->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($bookings->hasMorePages())
                        <a href="{{ $bookings->nextPageUrl() }}">Berikutnya</a>
                    @else
                        <span class="disabled">Berikutnya</span>
                    @endif
                </nav>
            @endif
        </div>
    </section>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="modal" onclick="closeModalOutside(event)">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Detail Pesanan Servis</h3>
                <button type="button" class="close-modal" onclick="closeDetail()" aria-label="Tutup">✕</button>
            </div>

            <div class="modal-content">
                <div class="detail-grid">
                    <div class="detail-item"><small>Pelanggan</small><strong id="detailCustomer">-</strong></div>
                    <div class="detail-item"><small>Email</small><strong id="detailEmail">-</strong></div>
                    <div class="detail-item"><small>Kendaraan</small><strong id="detailMotor">-</strong></div>
                    <div class="detail-item"><small>Plat Nomor</small><strong id="detailPlate">-</strong></div>
                    <div class="detail-item"><small>Jenis Servis</small><strong id="detailService">-</strong></div>
                    <div class="detail-item"><small>Tanggal</small><strong id="detailDate">-</strong></div>
                    <div class="detail-item"><small>Jam</small><strong id="detailTime">-</strong></div>
                    <div class="detail-item"><small>Mekanik</small><strong id="detailMechanic">-</strong></div>
                    <div class="detail-item"><small>Status</small><strong id="detailStatus">-</strong></div>
                    <div class="detail-item"><small>Keluhan</small><strong id="detailComplaint">-</strong></div>
                    <div class="detail-item" id="reasonBox" style="display:none">
                        <small>Alasan Penolakan</small><strong id="detailReason">-</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Jam & tanggal live
    function updateClock() {
        const now = new Date();
        const dateEl = document.getElementById('liveDate');
        const timeEl = document.getElementById('liveTime');

        if (dateEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
                timeZone: 'Asia/Jakarta'
            });
        }
        if (timeEl) {
            timeEl.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                hour12: false, timeZone: 'Asia/Jakarta'
            }) + ' WIB';
        }
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Modal detail
    function openDetail(button) {
        const d = button.dataset;
        const set = (id, val) => document.getElementById(id).textContent = val || '-';

        set('detailCustomer', d.customer);
        set('detailEmail', d.email);
        set('detailMotor', d.motor);
        set('detailPlate', d.plate);
        set('detailService', d.service);
        set('detailComplaint', d.complaint);
        set('detailDate', d.date);
        set('detailTime', d.time ? d.time + ' WIB' : '-');
        set('detailStatus', d.status);
        set('detailMechanic', d.mechanic);

        document.getElementById('reasonBox').style.display = d.reason ? '' : 'none';
        set('detailReason', d.reason);

        document.getElementById('detailModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.remove('show');
        const sidebar = document.getElementById('sidebar');
        const sidebarOpen = window.innerWidth <= 1000 && sidebar && sidebar.classList.contains('open');
        document.body.style.overflow = sidebarOpen ? 'hidden' : '';
    }

    function closeModalOutside(event) {
        if (event.target.id === 'detailModal') closeDetail();
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeDetail();
    });
</script>
@endpush