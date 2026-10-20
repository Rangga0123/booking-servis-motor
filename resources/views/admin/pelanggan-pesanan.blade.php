@extends('admin.layouts.app')

@section('title', 'Pelanggan & Pesanan')

@push('styles')
<style>
    /* Semua CSS di sini hanya berlaku untuk halaman ini (diawali .order-page) */

    .clock-box {
        min-width: 240px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 13px;
        box-shadow: 0 5px 14px #273d630b;
    }
    .clock-icon {
        width: 40px; height: 40px;
        display: grid; place-items: center; flex-shrink: 0;
        border-radius: 11px; background: #e7efff; color: var(--blue);
    }
    .clock-date { font-size: 13px; color: #46618e; margin-bottom: 4px; }
    .clock-time { font-size: 18px; font-weight: 800; font-variant-numeric: tabular-nums; }

    /* Tabel di atas, jadwal servis di bawah (kartu berjajar) */
    .order-page .order-grid { display: grid; grid-template-columns: minmax(0, 1fr); gap: 20px; align-items: start; }
    .order-page .panel { margin-bottom: 0; }

    @media (min-width: 1500px) {
        .order-page .order-grid { grid-template-columns: minmax(0, 1fr) 400px; }
        .order-page .schedule-list { display: block; max-height: 760px; overflow-y: auto; }
        .order-page .schedule-card { margin-bottom: 12px; }
    }

    .order-page .panel-heading { display: flex; align-items: center; gap: 14px; }
    .order-page .panel-heading-icon {
        width: 44px; height: 44px; display: grid; place-items: center; flex-shrink: 0;
        border-radius: 12px; background: linear-gradient(135deg, #3468d5, #355eb8); color: white;
    }
    .order-page .panel-header-top { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; }

    .order-page .filter-select {
        width: 190px;
        padding: 11px 12px;
        border: 1px solid #d8e1ed;
        border-radius: 10px;
        background: #fbfcfe;
        color: #435574;
        font-size: 14px;
        outline: none;
    }
    .order-page .filter-select:focus { border-color: var(--blue); box-shadow: 0 0 0 3px #3264d81a; background: white; }

    /* Tabel pesanan */
    .order-page table { min-width: 900px; }
    .order-page .customer-name { display: block; font-size: 14px; font-weight: 800; color: #17243f; }
    .order-page .customer-detail,
    .order-page .vehicle-plate { display: block; margin-top: 4px; font-size: 12px; color: #6f86ad; }
    .order-page .complaint { max-width: 220px; line-height: 1.6; }
    .order-page .booking-date { line-height: 1.6; }

    .order-page .status.waiting { background: #fff2d7; color: #b87400; }
    .order-page .status.process { background: #e8f1ff; color: #2a5fd4; }
    .order-page .status.done { background: #d6f5e5; color: #0f7a4d; }
    .order-page .status.rejected { background: #ffe5e9; color: #c4253f; }

    .order-page .table-footer { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }

    /* Jadwal servis */
    .order-page .today-badge { padding: 7px 14px; border-radius: 20px; background: #eef4fd; color: #506a96; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .order-page .schedule-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 14px;
        padding: 18px;
    }
    .order-page .schedule-card {
        padding: 16px;
        border: 1px solid #dde5f0;
        border-radius: 13px;
        background: white;
        box-shadow: 0 3px 8px #243d6508;
    }
    .order-page .schedule-card-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; margin-bottom: 14px; }
    .order-page .order-title { font-size: 14px; font-weight: 800; color: #263b63; }
    .order-page .order-title span { display: inline-block; margin-top: 4px; font-size: 13px; font-weight: 400; color: #526585; }

    .order-page .form-two { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .order-page .field { margin-bottom: 12px; }
    .order-page .field label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 700; color: #485e85; }
    .order-page .form-control { padding: 10px 12px; font-size: 14px; }

    .order-page .action-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 4px; }
    .order-page .btn { color: white; }
    .order-page .btn-green { background: #13996e; }
    .order-page .btn-green:hover { background: #0e7d5a; }
    .order-page .btn-red { background: #e5384f; }
    .order-page .btn-red:hover { background: #c92a40; }
    .order-page .btn-blue { background: #3264d8; }
    .order-page .btn-blue:hover { background: #244fb5; }
    .order-page .btn-block { width: 100%; }
    .order-page .btn-gap { margin-top: 8px; }

    /* Tombol Detail di tabel */
    .order-page .detail-btn { white-space: nowrap; }

    /* Modal detail */
    .order-page .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 18px;
        background: #0c172b8f;
    }
    .order-page .modal.show { display: flex; animation: fadeIn .2s ease; }
    .order-page .modal-box {
        width: 100%;
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 25px 70px #0003;
    }
    .order-page .modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid #e6ebf2;
    }
    .order-page .modal-header h3 { font-size: 18px; }
    .order-page .close-modal { width: 36px; height: 36px; border: 0; border-radius: 9px; background: #f3f6fa; color: #394c6d; font-size: 14px; }
    .order-page .close-modal:hover { background: #e6ecf5; }
    .order-page .modal-content { padding: 22px; }
    .order-page .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .order-page .detail-item { padding: 13px 14px; border-radius: 10px; background: #f6f9fd; overflow-wrap: anywhere; }
    .order-page .detail-item small { display: block; margin-bottom: 6px; font-size: 12px; color: #7c8da9; }
    .order-page .detail-item strong { font-size: 14px; color: #263956; }

    @media (max-width: 650px) {
        .clock-box { width: 100%; min-width: 0; }
        .order-page .filter-select { width: 100%; }
        .order-page .schedule-list { grid-template-columns: minmax(0, 1fr); padding: 12px; }
        .order-page .detail-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
@php
    $totalBooking = $bookings->count();

    $bookingMenunggu = $bookings->filter(function ($booking) {
        return in_array(strtolower($booking->status ?? ''), ['menunggu', 'pending']);
    })->count();

    $servisSelesai = $bookings->filter(function ($booking) {
        return strtolower($booking->status ?? '') === 'selesai';
    })->count();

    $jadwalAktif = $bookings->filter(function ($booking) {
        return strtolower($booking->status ?? '') !== 'ditolak';
    });
@endphp

<section class="page-heading">
    <div>
        <div class="breadcrumb">Admin / Pelanggan &amp; Pesanan</div>
        <h1 class="page-title">Pelanggan &amp; Pesanan</h1>
        <p class="page-description">Kelola pelanggan, booking masuk, jadwal servis, dan status pesanan dalam satu tempat.</p>
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
    <section class="order-grid">

        {{-- ============ DAFTAR PESANAN ============ --}}
        <section id="pesanan" class="panel">
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

                    <select id="statusFilter" class="filter-select" aria-label="Filter status booking">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
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
                            <th style="text-align:center">Aksi Admin</th>
                        </tr>
                    </thead>

                    <tbody id="bookingRows">
                        @forelse($bookings as $index => $item)
                            @php
                                $status = strtolower($item->status ?? '');
                                $jamBooking = $item->jam_booking
                                    ? str_replace(',', ':', trim($item->jam_booking))
                                    : '';
                                $tanggalBooking = $item->tanggal_booking
                                    ? \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y')
                                    : '-';
                            @endphp

                            <tr class="booking-row" data-status="{{ $status }}">
                                <td class="col-no">{{ $index + 1 }}</td>
                                <td>
                                    <span class="customer-name">{{ $item->user->name ?? 'Pelanggan' }}</span>
                                    <span class="customer-detail">{{ $item->user->email ?? 'Email tidak tersedia' }}</span>
                                    <span class="vehicle-plate">{{ $item->plat_nomor ?? '-' }}</span>
                                </td>
                                <td>{{ $item->nama_motor ?? '-' }}</td>
                                <td><div class="complaint">{{ $item->keluhan ?? '-' }}</div></td>
                                <td>
                                    <div class="booking-date">
                                        {{ $tanggalBooking }}
                                        @if($jamBooking)
                                            <br>{{ $jamBooking }}
                                        @endif
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
                                        class="btn btn-sm btn-dark detail-btn"
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
                                    >◉ Detail</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">Belum ada pesanan servis.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span>Menampilkan {{ $bookings->count() }} data</span>
                <span>Total {{ $totalBooking }} pesanan</span>
            </div>
        </section>

        {{-- ============ PENGATURAN JADWAL SERVIS ============ --}}
        <section id="jadwal-servis" class="panel">
            <div class="panel-header">
                <div class="panel-header-top">
                    <div class="panel-heading">
                        <div class="panel-heading-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                <path d="M8 2v4M16 2v4M3 10h18"/>
                            </svg>
                        </div>
                        <div>
                            <div class="panel-title">Pengaturan Jadwal Servis</div>
                            <div class="panel-subtitle">Atur tanggal, jam, mekanik, dan status tiap pesanan.</div>
                        </div>
                    </div>
                    <span id="todayBadge" class="today-badge">Hari ini</span>
                </div>
            </div>

            <div class="schedule-list">
                @forelse($jadwalAktif as $index => $item)
                    @php
                        $status = strtolower($item->status ?? '');
                        $jamBooking = $item->jam_booking
                            ? str_replace(',', ':', trim($item->jam_booking))
                            : '';
                    @endphp

                    <div class="schedule-card">
                        <div class="schedule-card-top">
                            <div class="order-title">
                                Pesanan #{{ $item->id }}
                                <br>
                                <span>{{ $item->user->name ?? 'Pelanggan' }}</span>
                            </div>

                            @if(in_array($status, ['menunggu', 'pending']))
                                <span class="status waiting">● Menunggu</span>
                            @elseif($status === 'disetujui')
                                <span class="status process">● Disetujui</span>
                            @elseif($status === 'selesai')
                                <span class="status done">● Selesai</span>
                            @endif
                        </div>

                        @if(in_array($status, ['menunggu', 'pending', 'disetujui']))
                            <form action="{{ route('admin.booking.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-two">
                                    <div class="field">
                                        <label>Tanggal Servis</label>
                                        <input
                                            class="form-control"
                                            type="date"
                                            name="tanggal_booking"
                                            value="{{ $item->tanggal_booking ? \Carbon\Carbon::parse($item->tanggal_booking)->format('Y-m-d') : '' }}"
                                            required
                                        >
                                    </div>

                                    <div class="field">
                                        <label>Jam Servis</label>
                                        <input
                                            class="form-control jam-input"
                                            type="text"
                                            name="jam_booking"
                                            value="{{ $jamBooking }}"
                                            placeholder="09:00"
                                            maxlength="5"
                                            inputmode="numeric"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="field">
                                    <label>Mekanik</label>
                                    <select class="form-control" name="mechanic_id" required>
                                        <option value="">Pilih Mekanik</option>
                                        @foreach($mechanics as $mechanic)
                                            <option
                                                value="{{ $mechanic->id }}"
                                                {{ $item->mechanic_id == $mechanic->id ? 'selected' : '' }}
                                            >
                                                {{ $mechanic->nama_mekanik }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if(in_array($status, ['menunggu', 'pending']))
                                    <div class="action-row">
                                        <button class="btn btn-green" type="submit" name="status" value="Disetujui">
                                            ✓ Setujui
                                        </button>
                                        <button class="btn btn-red" type="submit" name="status" value="Ditolak">
                                            ✕ Tolak
                                        </button>
                                    </div>
                                @elseif($status === 'disetujui')
                                    <button class="btn btn-blue btn-block" type="submit" name="status" value="Disetujui">
                                        Ubah Jadwal
                                    </button>
                                @endif
                            </form>

                            @if($status === 'disetujui')
                                <form action="{{ route('admin.booking.update', $item->id) }}" method="POST" class="btn-gap">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-dark btn-block" type="submit" name="status" value="Selesai">
                                        ✓ Tandai Selesai
                                    </button>
                                </form>
                            @endif
                        @elseif($status === 'selesai')
                            <button type="button" class="btn btn-dark btn-block">
                                ✓ Servis Selesai
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">Belum ada jadwal servis.</div>
                @endforelse
            </div>
        </section>
    </section>

    {{-- ============ MODAL DETAIL PESANAN ============ --}}
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        const dateElement = document.getElementById('liveDate');
        const timeElement = document.getElementById('liveTime');
        const badgeElement = document.getElementById('todayBadge');

        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            });
        }

        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta'
            }) + ' WIB';
        }

        if (badgeElement) {
            badgeElement.textContent = now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            });
        }
    }

    updateClock();
    setInterval(updateClock, 1000);

    // Format jam otomatis: ketik 0900 menjadi 09:00
    document.querySelectorAll('.jam-input').forEach(function (input) {
        input.addEventListener('input', function () {
            let value = this.value.replace(/[^0-9]/g, '').substring(0, 4);

            if (value.length >= 3) {
                value = value.substring(0, 2) + ':' + value.substring(2);
            }

            this.value = value;
        });

        input.addEventListener('blur', function () {
            if (!/^\d{2}:\d{2}$/.test(this.value)) return;

            const parts = this.value.split(':');

            if (Number(parts[0]) > 23 || Number(parts[1]) > 59) {
                alert('Jam tidak valid. Gunakan format 24 jam, contoh 09:00 atau 13:45.');
                this.focus();
            }
        });
    });

    // Filter tabel berdasarkan status
    const statusFilter = document.getElementById('statusFilter');

    if (statusFilter) {
        statusFilter.addEventListener('change', function () {
            const selected = this.value.toLowerCase();

            document.querySelectorAll('.booking-row').forEach(function (row) {
                const status = (row.dataset.status || '').toLowerCase();
                const cocok = !selected ||
                    status === selected ||
                    (selected === 'menunggu' && status === 'pending');

                row.style.display = cocok ? '' : 'none';
            });
        });
    }

    // Modal detail pesanan
    function openDetail(button) {
        const data = button.dataset;

        document.getElementById('detailCustomer').textContent = data.customer || '-';
        document.getElementById('detailEmail').textContent = data.email || '-';
        document.getElementById('detailMotor').textContent = data.motor || '-';
        document.getElementById('detailPlate').textContent = data.plate || '-';
        document.getElementById('detailService').textContent = data.service || '-';
        document.getElementById('detailComplaint').textContent = data.complaint || '-';
        document.getElementById('detailDate').textContent = data.date || '-';
        document.getElementById('detailTime').textContent = data.time ? data.time + ' WIB' : '-';
        document.getElementById('detailStatus').textContent = data.status || '-';
        document.getElementById('detailMechanic').textContent = data.mechanic || '-';

        document.getElementById('detailModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDetail() {
        const modal = document.getElementById('detailModal');

        if (modal) {
            modal.classList.remove('show');
        }

        const sidebar = document.getElementById('sidebar');
        const sidebarOpen = window.innerWidth <= 1000 &&
            sidebar && sidebar.classList.contains('open');

        document.body.style.overflow = sidebarOpen ? 'hidden' : '';
    }

    function closeModalOutside(event) {
        if (event.target.id === 'detailModal') {
            closeDetail();
        }
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDetail();
        }
    });
</script>
@endpush