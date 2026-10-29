@extends('admin.layouts.app')

@section('title', 'Jadwal Servis')

@push('styles')
<style>
    .order-page,
    .order-page * { box-sizing: border-box; }
    .order-page { color: #212529; }
    .page-heading { gap: 20px; margin-bottom: 26px; align-items: center; }

    /* ===== CARD ===== */
    .order-page .panel { overflow: hidden; background: #fff; border: 1px solid #e9ecef; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .order-page .panel-header { padding: 14px 20px; background: #fff; border-bottom: 1px solid #e9ecef; }
    .order-page .panel-header-top { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .order-page .panel-title { color: #212529; font-size: 16px; font-weight: 400; }
    .order-page .panel-subtitle { margin-top: 3px; color: #6c757d; font-size: 12px; }
    .order-page .today-badge { padding: 6px 10px; color: #004085; background: #e7f1ff; border: 1px solid #b8daff; border-radius: 4px; font-size: 12px; font-weight: 600; white-space: nowrap; }

    /* ===== KARTU JADWAL ===== */
    .order-page .schedule-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr)); gap: 16px; padding: 20px; background: #f8f9fa; }
    .order-page .schedule-card { min-width: 0; padding: 18px; background: #fff; border: 1px solid #dee2e6; border-radius: 6px; }
    .order-page .schedule-card-top { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1px solid #e9ecef; }
    .order-page .order-title { color: #212529; font-size: 14px; font-weight: 700; }
    .order-page .order-title span { display: inline-block; margin-top: 4px; color: #6c757d; font-size: 12px; font-weight: 400; }

    .order-page .status { display: inline-flex; align-items: center; padding: 5px 9px; border: 1px solid transparent; border-radius: 4px; font-size: 11px; font-weight: 700; white-space: nowrap; }
    .order-page .status.waiting { color: #856404; background: #fff3cd; border-color: #ffeeba; }
    .order-page .status.process { color: #0c5460; background: #d1ecf1; border-color: #bee5eb; }
    .order-page .status.done    { color: #155724; background: #d4edda; border-color: #c3e6cb; }

    /* ===== FORM ===== */
    .order-page .form-two { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .order-page .field { min-width: 0; margin-bottom: 14px; }
    .order-page .field label { display: block; margin-bottom: 6px; color: #212529; font-size: 13px; font-weight: 600; }
    .order-page .form-control { display: block; width: 100%; min-width: 0; max-width: 100%; min-height: 38px; padding: 7px 12px; color: #495057; background: #fff; border: 1px solid #ced4da; border-radius: 4px; font-family: inherit; font-size: 14px; outline: none; transition: border-color .15s, box-shadow .15s; }
    .order-page .form-control:focus { border-color: #80bdff; box-shadow: 0 0 0 3px rgba(0,123,255,.2); }

    .order-page .action-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; margin-top: 4px; }
    .order-page .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 38px; padding: 8px 12px; border: 1px solid transparent; border-radius: 4px; color: #fff; font-family: inherit; font-size: 14px; font-weight: 600; cursor: pointer; transition: filter .15s ease; }
    .order-page .btn:hover { filter: brightness(.92); }
    .order-page .btn-green { background: #28a745; border-color: #28a745; }
    .order-page .btn-red   { background: #dc3545; border-color: #dc3545; }
    .order-page .btn-blue  { background: #007bff; border-color: #007bff; }
    .order-page .btn-dark  { background: #6c757d; border-color: #6c757d; }
    .order-page .btn-block { width: 100%; }
    .order-page .btn-gap   { margin-top: 8px; }

    .order-page .empty-state { grid-column: 1 / -1; padding: 32px 15px; color: #6c757d; text-align: center; font-size: 13px; }
    .order-page .pagination-wrap { padding: 14px 20px; border-top: 1px solid #e9ecef; background: #f8f9fa; overflow-x: auto; }

    /* ===== MODAL ALASAN PENOLAKAN ===== */
    #rejectModal { display: none; position: fixed; inset: 0; z-index: 2000; align-items: center; justify-content: center; padding: 18px; background: rgba(0,0,0,.55); }
    #rejectModal.show { display: flex; }
    #rejectModal .reject-box { width: 100%; max-width: 460px; max-height: 92vh; overflow-y: auto; background: #fff; border-radius: 6px; padding: 20px; box-shadow: 0 10px 40px rgba(0,0,0,.25); }
    #rejectModal .reject-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
    #rejectModal .reject-head h3 { margin: 0; color: #212529; font-size: 16px; font-weight: 600; }
    #rejectModal .reject-head button { width: 32px; height: 32px; color: #495057; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer; }
    #rejectModal label { display: block; margin-bottom: 8px; color: #212529; font-size: 13px; font-weight: 600; line-height: 1.5; }
    #rejectModal textarea { display: block; width: 100%; margin-bottom: 14px; padding: 10px 12px; color: #495057; resize: vertical; border: 1px solid #ced4da; border-radius: 4px; font-family: inherit; font-size: 14px; outline: none; }
    #rejectModal textarea:focus { border-color: #80bdff; box-shadow: 0 0 0 3px rgba(0,123,255,.2); }

    @media (max-width: 650px) {
        .page-heading { align-items: stretch; }
        .order-page .panel-header { padding: 12px 14px; }
        .order-page .schedule-list { grid-template-columns: minmax(0, 1fr); gap: 12px; padding: 12px; }
        .order-page .schedule-card { padding: 14px; }
        .order-page .form-two { grid-template-columns: minmax(0, 1fr); gap: 0; }
        .order-page .form-control { font-size: 16px; min-height: 42px; }
        .order-page .btn { min-height: 42px; }
        .order-page .pagination-wrap { padding: 12px; }
        #rejectModal { padding: 10px; align-items: flex-end; }
        #rejectModal textarea { font-size: 16px; }
    }
</style>
@endpush

@section('content')
<section class="page-heading">
    <div>
        <div class="breadcrumb">Admin / Pelanggan / Jadwal Servis</div>
        <h1 class="page-title">Jadwal Servis</h1>
        <p class="page-description">Atur tanggal, jam, mekanik, dan status tiap pesanan servis.</p>
    </div>
</section>

@if(session('success'))
    <div class="notice notice-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="notice notice-error">{{ $errors->first() }}</div>
@endif

<div class="order-page">
    <section class="panel">
        <div class="panel-header">
            <div class="panel-header-top">
                <div>
                    <div class="panel-title">Pengaturan Jadwal Servis</div>
                    <div class="panel-subtitle">Setujui, tolak, ubah jadwal, atau tandai selesai.</div>
                </div>
                <span class="today-badge">{{ now()->translatedFormat('d M Y') }}</span>
            </div>
        </div>

        <div class="schedule-list">
            @forelse($bookings as $item)
                @php
                    $status = strtolower($item->status ?? '');
                    $jamBooking = $item->jam_booking ? str_replace(',', ':', trim($item->jam_booking)) : '';
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
                                    <input class="form-control" type="date" name="tanggal_booking" required
                                        value="{{ $item->tanggal_booking ? \Carbon\Carbon::parse($item->tanggal_booking)->format('Y-m-d') : '' }}">
                                </div>

                                <div class="field">
                                    <label>Jam Servis</label>
                                    <input class="form-control jam-input" type="text" name="jam_booking"
                                        value="{{ $jamBooking }}" placeholder="09:00"
                                        maxlength="5" inputmode="numeric" required>
                                </div>
                            </div>

                            <div class="field">
                                <label>Mekanik</label>
                                <select class="form-control" name="mechanic_id" required>
                                    <option value="">Pilih Mekanik</option>
                                    @foreach($mechanics as $mechanic)
                                        <option value="{{ $mechanic->id }}" {{ $item->mechanic_id == $mechanic->id ? 'selected' : '' }}>
                                            {{ $mechanic->nama_mekanik }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if(in_array($status, ['menunggu', 'pending']))
                                <div class="action-row">
                                    <button class="btn btn-green" type="submit" name="status" value="Disetujui">✓ Setujui</button>
                                    <button class="btn btn-red" type="button" onclick="openReject({{ $item->id }})">✕ Tolak</button>
                                </div>
                            @else
                                <button class="btn btn-blue btn-block" type="submit" name="status" value="Disetujui">Ubah Jadwal</button>
                            @endif
                        </form>

                        @if($status === 'disetujui')
                            <form action="{{ route('admin.booking.update', $item->id) }}" method="POST" class="btn-gap">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-dark btn-block" type="submit" name="status" value="Selesai">✓ Tandai Selesai</button>
                            </form>
                        @endif
                    @elseif($status === 'selesai')
                        <button type="button" class="btn btn-dark btn-block">✓ Servis Selesai</button>
                    @endif
                </div>
            @empty
                <div class="empty-state">Belum ada jadwal servis.</div>
            @endforelse
        </div>

        @if(method_exists($bookings, 'links') && $bookings->hasPages())
            <div class="pagination-wrap">{{ $bookings->links() }}</div>
        @endif
    </section>

    {{-- MODAL ALASAN PENOLAKAN --}}
    <div id="rejectModal" onclick="if(event.target===this) closeReject()">
        <div class="reject-box">
            <div class="reject-head">
                <h3>Alasan Penolakan</h3>
                <button type="button" onclick="closeReject()" aria-label="Tutup">✕</button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="Ditolak">
                <label for="alasan">Kenapa pesanan ini ditolak? (akan dilihat pelanggan)</label>
                <textarea id="alasan" name="alasan_penolakan" rows="4" required
                    placeholder="Contoh: Jadwal pada tanggal tersebut sudah penuh, silakan booking di tanggal lain."></textarea>
                <button type="submit" class="btn btn-red btn-block">Tolak Pesanan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Modal alasan penolakan
    const rejectUrl = "{{ route('admin.booking.update', ':id') }}";

    function openReject(id) {
        document.getElementById('rejectForm').action = rejectUrl.replace(':id', id);
        document.getElementById('rejectModal').classList.add('show');
    }

    function closeReject() {
        document.getElementById('rejectModal').classList.remove('show');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeReject();
    });

    // Format jam otomatis: ketik 0900 menjadi 09:00
    document.querySelectorAll('.jam-input').forEach(function (input) {
        input.addEventListener('input', function () {
            let value = this.value.replace(/[^0-9]/g, '').substring(0, 4);
            if (value.length >= 3) value = value.substring(0, 2) + ':' + value.substring(2);
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
</script>
@endpush