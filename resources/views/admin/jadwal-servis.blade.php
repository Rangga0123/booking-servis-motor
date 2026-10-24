@extends('admin.layouts.app')

@section('title', 'Jadwal Servis')

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
    .order-page .today-badge {
        padding: 8px 13px; border: 1px solid #e0e9ff; border-radius: 10px;
        background: #edf3ff; color: #456cce; font-size: 11px; font-weight: 800;
    }

    /* KARTU JADWAL */
    .order-page .schedule-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 16px; padding: 20px; background: #fafbfe;
    }
    .order-page .schedule-card {
        min-width: 0; padding: 19px; background: #fff;
        border: 1px solid #e4eaf3; border-radius: 15px;
    }
    .order-page .schedule-card-top {
        display: flex; justify-content: space-between; align-items: flex-start;
        flex-wrap: wrap; gap: 10px; margin-bottom: 18px; padding-bottom: 15px;
        border-bottom: 1px solid #edf1f7;
    }
    .order-page .order-title { color: #24334e; font-size: 13px; font-weight: 800; }
    .order-page .order-title span { display: inline-block; margin-top: 6px; color: #8190a7; font-size: 12px; font-weight: 500; }

    .order-page .status {
        display: inline-flex; align-items: center; padding: 7px 10px;
        border-radius: 8px; font-size: 10px; font-weight: 800; white-space: nowrap;
    }
    .order-page .status.waiting { background: #fff3dc; color: #b9790b; }
    .order-page .status.process { background: #eaf0ff; color: #3864d2; }
    .order-page .status.done    { background: #e0f7eb; color: #138453; }

    /* FORM */
    .order-page .form-two { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .order-page .field { min-width: 0; margin-bottom: 14px; }
    .order-page .field label { display: block; margin-bottom: 7px; color: #64748d; font-size: 11px; font-weight: 800; }
    .order-page .form-control {
        width: 100%; min-width: 0; padding: 11px 12px;
        border: 1px solid #dfe6f0; border-radius: 10px; background: #fbfcff;
        color: #34445e; font-size: 12px; outline: none;
    }
    .order-page .form-control:focus { border-color: #6487f2; background: #fff; box-shadow: 0 0 0 4px #4775ef12; }

    .order-page .action-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 9px; margin-top: 5px; }
    .order-page .btn {
        display: inline-flex; align-items: center; justify-content: center;
        min-height: 39px; padding: 10px 13px; border: 0; border-radius: 9px;
        color: #fff; font-size: 11px; font-weight: 800; cursor: pointer; transition: .2s ease;
    }
    .order-page .btn:hover { filter: brightness(.94); }
    .order-page .btn-green { background: #15986d; }
    .order-page .btn-red   { background: #e34e60; }
    .order-page .btn-blue  { background: #4775ef; }
    .order-page .btn-dark  { background: #263650; }
    .order-page .btn-block { width: 100%; }
    .order-page .btn-gap   { margin-top: 9px; }

    .order-page .empty-state {
        grid-column: 1 / -1; padding: 32px 15px;
        color: #8a97ab; text-align: center; font-size: 12px;
    }
    .order-page .pagination-wrap { padding: 15px 21px; border-top: 1px solid #edf1f6; background: #fafbfe; }

    @media (max-width: 650px) {
        .page-heading { align-items: stretch; }
        .order-page .panel-header { padding: 16px; }
        .order-page .schedule-list { grid-template-columns: minmax(0, 1fr); padding: 12px; }
        .order-page .form-two { grid-template-columns: minmax(0, 1fr); }
    }

    /* MODAL ALASAN PENOLAKAN */
    #rejectModal {
        display: none; position: fixed; inset: 0; z-index: 2000;
        align-items: center; justify-content: center; padding: 18px;
        background: rgba(12, 23, 43, .68);
    }
    #rejectModal.show { display: flex; }
    #rejectModal .reject-box { width: 100%; max-width: 460px; background: #fff; border-radius: 16px; padding: 22px; }
    #rejectModal .reject-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    #rejectModal .reject-head h3 { font-size: 16px; font-weight: 800; color: #1d2c45; }
    #rejectModal .reject-head button {
        width: 34px; height: 34px; border: 1px solid #e7ebf3; border-radius: 9px; background: #f5f7fb; cursor: pointer;
    }
    #rejectModal label { display: block; margin-bottom: 8px; font-size: 12px; font-weight: 700; color: #64748d; }
    #rejectModal textarea {
        width: 100%; margin-bottom: 14px; padding: 12px; resize: vertical;
        border: 1px solid #dfe6f0; border-radius: 10px; font-size: 13px; outline: none;
    }
    #rejectModal textarea:focus { border-color: #6487f2; }
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
                <div class="panel-heading">
                    <div class="panel-heading-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                            <path d="M8 2v4M16 2v4M3 10h18"/>
                        </svg>
                    </div>
                    <div>
                        <div class="panel-title">Pengaturan Jadwal Servis</div>
                        <div class="panel-subtitle">Setujui, tolak, ubah jadwal, atau tandai selesai.</div>
                    </div>
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