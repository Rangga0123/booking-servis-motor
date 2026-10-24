@extends('layouts.customer')

@section('title', 'Edit Booking - Bengkel Royal Motor')

@section('content')
@php
    $kategoriBayar = [
        'tunai' => [
            'label' => 'Tunai',
            'badge' => 'Rp',
            'warna' => '#19a875',
            'pilihan' => [],
        ],
        'ewallet' => [
            'label' => 'E-Wallet',
            'badge' => 'EW',
            'warna' => '#4c2a86',
            'pilihan' => ['OVO', 'GoPay', 'DANA', 'ShopeePay', 'LinkAja'],
        ],
        'qris' => [
            'label' => 'QRIS',
            'badge' => 'QR',
            'warna' => '#64748b',
            'pilihan' => [],
        ],
        'bank' => [
            'label' => 'Transfer Bank',
            'badge' => 'TF',
            'warna' => '#3975ad',
            'pilihan' => ['BCA', 'BRI', 'Mandiri', 'BNI'],
        ],
    ];

    $metodeLama = old(
        'metode_pembayaran',
        $booking->metode_pembayaran ?: 'Tunai / Bayar di Kasir'
    );

    if ($metodeLama === 'QRIS') {
        $kategoriAktif = 'qris';
    } elseif (str_starts_with($metodeLama, 'Transfer ')) {
        $kategoriAktif = 'bank';
    } elseif (in_array($metodeLama, $kategoriBayar['ewallet']['pilihan'], true)) {
        $kategoriAktif = 'ewallet';
    } else {
        $kategoriAktif = 'tunai';
    }

    $mekanikTerpilih = old('mechanic_id', $booking->mechanic_id);

    $saranServis = [
        'Servis rutin',
        'Ganti oli',
        'Ganti aki',
        'Ganti ban',
        'Rem',
        'Kelistrikan',
        'Tune up',
        'Cek kerusakan',
    ];

    $tanggalLama = old(
        'tanggal_booking',
        $booking->tanggal_booking
            ? \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('Y-m-d')
            : ''
    );

    $jamLama = old(
        'jam_booking',
        $booking->jam_booking
            ? substr((string) $booking->jam_booking, 0, 5)
            : ''
    );
@endphp

<div class="bk-page">
    <header class="bk-head">
        <div>
            <span class="bk-eyebrow">ROYAL MOTOR</span>
            <h1>Edit Booking Servis</h1>
            <p>Periksa dan perbarui data booking sebelum menyimpan perubahan.</p>
        </div>

        <a href="{{ route('booking.index') }}" class="bk-btn bk-btn-ghost">
            <span aria-hidden="true">←</span> Riwayat Booking
        </a>
    </header>

    @if ($errors->any())
        <div class="bk-alert" role="alert">
            <strong>Ada data yang perlu diperbaiki.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('booking.update', $booking->id) }}"
        method="POST"
        id="bookingForm"
        class="bk-layout"
    >
        @csrf
        @method('PUT')

        <div class="bk-main">

            {{-- 1. DATA PELANGGAN --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">1</span>
                    <div>
                        <h2>Data Pelanggan</h2>
                        <p>Perbarui informasi orang yang membawa motor.</p>
                    </div>
                </div>

                <div class="bk-grid">
                    <div class="bk-field">
                        <label for="nama_pelanggan">Nama Pemesan <i>*</i></label>
                        <input
                            class="bk-input"
                            type="text"
                            id="nama_pelanggan"
                            name="nama_pelanggan"
                            value="{{ old('nama_pelanggan', $booking->nama_pelanggan) }}"
                            maxlength="255"
                            required
                            placeholder="Nama lengkap"
                        >
                        @error('nama_pelanggan')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="no_hp">No. HP / WhatsApp <i>*</i></label>
                        <input
                            class="bk-input"
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            value="{{ old('no_hp', $booking->no_hp) }}"
                            inputmode="tel"
                            maxlength="20"
                            required
                            placeholder="Contoh: 081234567890"
                        >
                        @error('no_hp')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field bk-span">
                        <label for="email_pelanggan">Email</label>
                        <input
                            class="bk-input"
                            type="email"
                            id="email_pelanggan"
                            name="email_pelanggan"
                            value="{{ old('email_pelanggan', $booking->email_pelanggan) }}"
                            maxlength="255"
                            placeholder="nama@email.com"
                        >
                        @error('email_pelanggan')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- 2. DATA KENDARAAN --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">2</span>
                    <div>
                        <h2>Data Kendaraan</h2>
                        <p>Perbarui merek motor dan nomor polisi kendaraan.</p>
                    </div>
                </div>

                <div class="bk-grid">
                    <div class="bk-field">
                        <label for="nama_motor">Merek / Tipe Motor <i>*</i></label>
                        <input
                            class="bk-input"
                            type="text"
                            id="nama_motor"
                            name="nama_motor"
                            value="{{ old('nama_motor', $booking->nama_motor) }}"
                            maxlength="255"
                            required
                            placeholder="Contoh: Honda Vario 160"
                        >
                        @error('nama_motor')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="plat_nomor">Nomor Polisi <i>*</i></label>
                        <input
                            class="bk-input bk-upper"
                            type="text"
                            id="plat_nomor"
                            name="plat_nomor"
                            value="{{ old('plat_nomor', $booking->plat_nomor) }}"
                            maxlength="20"
                            required
                            placeholder="Contoh: B 1234 ABC"
                        >
                        @error('plat_nomor')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- 3. LAYANAN DAN JADWAL --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">3</span>
                    <div>
                        <h2>Layanan dan Jadwal</h2>
                        <p>Sesuaikan kebutuhan servis serta waktu kedatangan.</p>
                    </div>
                </div>

                <div class="bk-grid">
                    <div class="bk-field bk-span">
                        <label for="jenis_servis">Servis yang Diinginkan <i>*</i></label>
                        <input
                            class="bk-input"
                            type="text"
                            id="jenis_servis"
                            name="jenis_servis"
                            value="{{ old('jenis_servis', $booking->jenis_servis) }}"
                            maxlength="255"
                            required
                            placeholder="Contoh: Ganti oli dan cek rem depan"
                        >

                        <div class="bk-chips" aria-label="Saran cepat">
                            @foreach ($saranServis as $saran)
                                <button
                                    type="button"
                                    class="bk-chip"
                                    data-saran="{{ $saran }}"
                                >
                                    + {{ $saran }}
                                </button>
                            @endforeach
                        </div>

                        <small class="bk-hint">
                            Ketik kebutuhan servis atau klik salah satu saran.
                        </small>

                        @error('jenis_servis')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="tanggal_booking">Tanggal Servis <i>*</i></label>
                        <input
                            class="bk-input"
                            type="date"
                            id="tanggal_booking"
                            name="tanggal_booking"
                            value="{{ $tanggalLama }}"
                            required
                        >
                        @error('tanggal_booking')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="jam_booking">Jam Servis <i>*</i></label>
                        <input
                            class="bk-input"
                            type="time"
                            id="jam_booking"
                            name="jam_booking"
                            value="{{ $jamLama }}"
                            required
                        >
                        <small class="bk-hint" id="ket_waktu"></small>
                        @error('jam_booking')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field bk-span">
                        <label for="keluhan">Keluhan / Catatan <i>*</i></label>
                        <textarea
                            class="bk-input"
                            id="keluhan"
                            name="keluhan"
                            rows="4"
                            required
                            placeholder="Ceritakan kendala motor Anda..."
                        >{{ old('keluhan', $booking->keluhan) }}</textarea>
                        @error('keluhan')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- 4. PILIH MEKANIK --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">4</span>
                    <div>
                        <h2>Pilih Mekanik</h2>
                        <p>Pilih mekanik atau biarkan admin yang menentukan.</p>
                    </div>
                </div>

                <div class="bk-mek-grid">
                    <label class="bk-mek">
                        <input
                            type="radio"
                            name="mechanic_id"
                            value=""
                            data-label="Ditentukan admin"
                            @checked($mekanikTerpilih === null || $mekanikTerpilih === '')
                        >

                        <span class="bk-mek-box">
                            <span class="bk-mek-avatar bk-mek-any">?</span>
                            <span class="bk-mek-info">
                                <strong>Bebas</strong>
                                <small>Ditentukan oleh admin</small>
                            </span>
                            <span class="bk-tick" aria-hidden="true">✓</span>
                        </span>
                    </label>

                    @foreach (($mechanics ?? collect()) as $mekanik)
                        <label class="bk-mek">
                            <input
                                type="radio"
                                name="mechanic_id"
                                value="{{ $mekanik->id }}"
                                data-label="{{ $mekanik->nama_mekanik }}"
                                @checked((string) $mekanikTerpilih === (string) $mekanik->id)
                            >

                            <span class="bk-mek-box">
                                <span class="bk-mek-avatar">
                                    {{ strtoupper(substr($mekanik->nama_mekanik ?? 'M', 0, 1)) }}
                                </span>

                                <span class="bk-mek-info">
                                    <strong>{{ $mekanik->nama_mekanik }}</strong>
                                    <small>{{ $mekanik->spesialisasi ?: 'Mekanik Royal Motor' }}</small>
                                </span>

                                <span class="bk-tick" aria-hidden="true">✓</span>
                            </span>
                        </label>
                    @endforeach
                </div>

                @if (($mechanics ?? collect())->count() === 0)
                    <small class="bk-hint">
                        Belum ada mekanik aktif yang bisa dipilih. Mekanik akan ditentukan oleh admin.
                    </small>
                @endif

                @error('mechanic_id')
                    <small class="bk-error">{{ $message }}</small>
                @enderror
            </section>

            {{-- 5. METODE PEMBAYARAN --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">5</span>
                    <div>
                        <h2>Metode Pembayaran</h2>
                        <p>Perbarui metode pembayaran yang akan digunakan.</p>
                    </div>
                </div>

                <input
                    type="hidden"
                    name="metode_pembayaran"
                    id="metode_pembayaran"
                    value="{{ $metodeLama }}"
                >

                <div class="bk-cat-grid">
                    @foreach ($kategoriBayar as $kode => $kat)
                        @php
                            $nilaiLangsung = $kode === 'tunai'
                                ? 'Tunai / Bayar di Kasir'
                                : ($kode === 'qris' ? 'QRIS' : '');

                            $labelLangsung = $kode === 'tunai'
                                ? 'Tunai (bayar di kasir)'
                                : ($kode === 'qris' ? 'QRIS' : '');
                        @endphp

                        <button
                            type="button"
                            class="bk-cat {{ $kode === $kategoriAktif ? 'is-active' : '' }}"
                            data-kat="{{ $kode }}"
                            data-nilai="{{ $nilaiLangsung }}"
                            data-label="{{ $labelLangsung }}"
                        >
                            <span
                                class="bk-badge"
                                style="background:{{ $kat['warna'] }};color:#fff"
                            >
                                {{ $kat['badge'] }}
                            </span>
                            <span class="bk-cat-label">{{ $kat['label'] }}</span>
                        </button>
                    @endforeach
                </div>

                @foreach (['ewallet', 'bank'] as $kode)
                    <div
                        class="bk-sub {{ $kode === $kategoriAktif ? '' : 'is-hidden' }}"
                        data-sub="{{ $kode }}"
                    >
                        <span class="bk-sub-title">
                            Pilih {{ $kode === 'ewallet' ? 'e-wallet' : 'bank' }}
                        </span>

                        <div class="bk-sub-chips">
                            @foreach ($kategoriBayar[$kode]['pilihan'] as $pilihan)
                                @php
                                    $nilai = $kode === 'bank'
                                        ? 'Transfer ' . $pilihan
                                        : $pilihan;
                                @endphp

                                <button
                                    type="button"
                                    class="bk-opt {{ $metodeLama === $nilai ? 'is-active' : '' }}"
                                    data-nilai="{{ $nilai }}"
                                    data-label="{{ $nilai }}"
                                >
                                    {{ $pilihan }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <small class="bk-error is-hidden" id="errBayar">
                    Pilih e-wallet atau bank terlebih dahulu.
                </small>

                @error('metode_pembayaran')
                    <small class="bk-error">{{ $message }}</small>
                @enderror
            </section>

            <div class="bk-actions">
                <a href="{{ route('booking.index') }}" class="bk-btn bk-btn-ghost">
                    Batal
                </a>

                <button type="submit" class="bk-btn bk-btn-primary" id="btnKirim">
                    Simpan Perubahan →
                </button>
            </div>
        </div>

        {{-- RINGKASAN BOOKING --}}
        <aside class="bk-side">
            <div class="bk-summary">
                <h3>Ringkasan Booking</h3>
                <p class="bk-sum-sub">Ringkasan diperbarui sesuai data yang Anda isi.</p>

                <dl>
                    <div><dt>Pemesan</dt><dd id="sumNama">-</dd></div>
                    <div><dt>No. HP</dt><dd id="sumHp">-</dd></div>
                    <div><dt>Motor</dt><dd id="sumMotor">-</dd></div>
                    <div><dt>Nomor polisi</dt><dd id="sumPlat">-</dd></div>
                    <div><dt>Servis</dt><dd id="sumServis">-</dd></div>
                    <div><dt>Jadwal</dt><dd id="sumJadwal">-</dd></div>
                    <div><dt>Mekanik</dt><dd id="sumMekanik">Ditentukan admin</dd></div>
                    <div><dt>Pembayaran</dt><dd id="sumBayar">-</dd></div>
                </dl>

                <div class="bk-note">
                    Periksa kembali perubahan sebelum menyimpannya. Booking akan diperbarui
                    setelah data berhasil diproses.
                </div>
            </div>
        </aside>
    </form>

    <p class="bk-foot">Royal Motor · Booking Servis Motor</p>
</div>
@endsection

@push('styles')
<style>
    .bk-page {
        --bk-blue: #3975ad;
        --bk-blue-dark: #2f6597;
        --bk-text: #343a40;
        --bk-muted: #737d87;
        --bk-line: #dfe3e8;
        --bk-soft: #f7f8fa;

        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
        color: var(--bk-text);
    }

    .bk-page * {
        box-sizing: border-box;
    }

    .bk-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .bk-eyebrow {
        display: inline-block;
        margin-bottom: 7px;
        color: #6485a5;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    .bk-head h1 {
        margin: 0;
        color: #343a40;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.3;
    }

    .bk-head p {
        margin: 7px 0 0;
        color: #737d87;
        font-size: 13px;
        line-height: 1.7;
    }

    .bk-alert {
        margin-bottom: 18px;
        padding: 15px 17px;
        border: 1px solid #efc9cd;
        border-radius: 12px;
        background: #fff6f6;
        color: #a63843;
        font-size: 13px;
    }

    .bk-alert ul {
        margin: 8px 0 0;
        padding-left: 20px;
        line-height: 1.8;
    }

    .bk-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 22px;
        align-items: start;
    }

    .bk-main {
        display: flex;
        min-width: 0;
        flex-direction: column;
        gap: 18px;
    }

    .bk-card,
    .bk-summary {
        min-width: 0;
        border: 1px solid #dfe3e8;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 3px 12px rgba(40, 52, 65, .035);
    }

    .bk-card {
        padding: 22px;
        animation: bkUp .35s ease both;
    }

    .bk-card-head {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        margin-bottom: 19px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e7eaee;
    }

    .bk-step {
        display: grid;
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        place-items: center;
        border: 1px solid #d5e0eb;
        border-radius: 9px;
        background: #edf3f8;
        color: #3975ad;
        font-size: 13px;
        font-weight: 800;
    }

    .bk-card-head h2 {
        margin: 0;
        color: #343a40;
        font-size: 16px;
        font-weight: 800;
    }

    .bk-card-head p {
        margin: 5px 0 0;
        color: #7a838d;
        font-size: 12px;
        line-height: 1.6;
    }

    .bk-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .bk-span {
        grid-column: 1 / -1;
    }

    .bk-field {
        min-width: 0;
    }

    .bk-field label {
        display: block;
        margin-bottom: 8px;
        color: #4b5560;
        font-size: 12px;
        font-weight: 700;
    }

    .bk-field label i {
        color: #d64b58;
        font-style: normal;
    }

    .bk-input {
        display: block;
        width: 100%;
        min-width: 0;
        padding: 12px 13px;
        border: 1px solid #d4d9df;
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: #343a40;
        font: inherit;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }

    .bk-input:hover {
        border-color: #b9c4cf;
    }

    .bk-input:focus {
        border-color: #7198bc;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(57, 117, 173, .11);
    }

    .bk-input::placeholder {
        color: #a0a8b0;
    }

    textarea.bk-input {
        min-height: 110px;
        resize: vertical;
        line-height: 1.7;
    }

    .bk-upper {
        text-transform: uppercase;
    }

    .bk-upper::placeholder {
        text-transform: none;
    }

    .bk-hint {
        display: block;
        margin-top: 7px;
        color: #7a838d;
        font-size: 11px;
        line-height: 1.6;
    }

    .bk-error {
        display: block;
        margin-top: 7px;
        color: #c13e4c;
        font-size: 12px;
        line-height: 1.5;
    }

    .bk-chips,
    .bk-sub-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .bk-chip {
        padding: 7px 11px;
        border: 1px solid #d8dfe6;
        border-radius: 7px;
        background: #f7f8fa;
        color: #596775;
        font: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background .18s, border-color .18s;
    }

    .bk-chip:hover {
        border-color: #b8c9d9;
        background: #edf3f8;
    }

    .bk-badge {
        display: grid;
        min-width: 40px;
        height: 30px;
        padding: 0 7px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 800;
    }

    .bk-mek-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(205px, 1fr));
        gap: 10px;
    }

    .bk-mek {
        position: relative;
        display: block;
        cursor: pointer;
    }

    .bk-mek input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .bk-mek-box {
        display: flex;
        min-height: 66px;
        align-items: center;
        gap: 11px;
        padding: 12px;
        border: 1px solid #d9dee4;
        border-radius: 10px;
        background: #fff;
        transition: border-color .18s, background .18s;
    }

    .bk-mek:hover .bk-mek-box {
        border-color: #b8c9d9;
        background: #fafbfd;
    }

    .bk-mek input:focus-visible + .bk-mek-box {
        outline: 3px solid rgba(57, 117, 173, .15);
    }

    .bk-mek input:checked + .bk-mek-box {
        border-color: #7198bc;
        background: #f0f5f9;
    }

    .bk-mek-avatar {
        display: grid;
        width: 39px;
        height: 39px;
        flex-shrink: 0;
        place-items: center;
        border: 1px solid #d6e0e9;
        border-radius: 50%;
        background: #edf3f8;
        color: #3975ad;
        font-size: 15px;
        font-weight: 800;
    }

    .bk-mek-any {
        background: #f0f1f3;
        color: #78818a;
    }

    .bk-mek-info {
        flex: 1;
        min-width: 0;
    }

    .bk-mek-info strong {
        display: block;
        color: #414a53;
        font-size: 13px;
        overflow-wrap: anywhere;
    }

    .bk-mek-info small {
        display: block;
        margin-top: 4px;
        color: #7b858f;
        font-size: 11px;
        line-height: 1.5;
    }

    .bk-tick {
        display: grid;
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        place-items: center;
        border: 1px solid #d5dbe1;
        border-radius: 50%;
        background: #fff;
        color: #fff;
        font-size: 11px;
        opacity: .45;
        transition: background .18s, opacity .18s;
    }

    .bk-mek input:checked + .bk-mek-box .bk-tick {
        border-color: #3975ad;
        background: #3975ad;
        opacity: 1;
    }

    .bk-cat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
    }

    .bk-cat {
        display: flex;
        min-width: 0;
        align-items: center;
        gap: 9px;
        padding: 11px 10px;
        border: 1px solid #d9dee4;
        border-radius: 10px;
        background: #fff;
        color: #454e57;
        font: inherit;
        text-align: left;
        cursor: pointer;
        transition: border-color .18s, background .18s;
    }

    .bk-cat:hover {
        border-color: #b8c9d9;
        background: #fafbfd;
    }

    .bk-cat.is-active {
        border-color: #7198bc;
        background: #f0f5f9;
    }

    .bk-cat-label {
        font-size: 12px;
        font-weight: 700;
        line-height: 1.4;
    }

    .bk-sub {
        margin-top: 14px;
        padding: 14px;
        border: 1px solid #dfe3e8;
        border-radius: 10px;
        background: #f8f9fa;
    }

    .bk-sub-title {
        display: block;
        margin-bottom: 10px;
        color: #737d87;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .bk-opt {
        padding: 9px 14px;
        border: 1px solid #d5dbe1;
        border-radius: 7px;
        background: #fff;
        color: #4b5560;
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: border-color .18s, background .18s, color .18s;
    }

    .bk-opt:hover {
        border-color: #aebfce;
        background: #f4f7f9;
    }

    .bk-opt.is-active {
        border-color: #7198bc;
        background: #eaf1f7;
        color: #315f88;
    }

    .is-hidden {
        display: none !important;
    }

    .bk-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 10px;
    }

    .bk-btn {
        display: inline-flex;
        min-height: 43px;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 12px 20px;
        border: 1px solid transparent;
        border-radius: 9px;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: background .18s, border-color .18s, transform .18s;
    }

    .bk-btn:active {
        transform: scale(.98);
    }

    .bk-btn-primary {
        border-color: #3975ad;
        background: #3975ad;
        color: #fff;
    }

    .bk-btn-primary:hover {
        border-color: #2f6597;
        background: #2f6597;
    }

    .bk-btn-ghost {
        border-color: #d5dbe1;
        background: #fff;
        color: #59636d;
    }

    .bk-btn-ghost:hover {
        background: #f3f5f7;
        border-color: #c3cbd3;
    }

    .bk-btn:disabled {
        cursor: wait;
    }

    .bk-side {
        position: sticky;
        top: 92px;
        min-width: 0;
    }

    .bk-summary {
        padding: 20px;
    }

    .bk-summary h3 {
        margin: 0;
        color: #343a40;
        font-size: 15px;
        font-weight: 800;
    }

    .bk-sum-sub {
        margin: 6px 0 15px;
        color: #7a838d;
        font-size: 11px;
        line-height: 1.6;
    }

    .bk-summary dl {
        display: flex;
        flex-direction: column;
        gap: 0;
        margin: 0;
    }

    .bk-summary dl > div {
        display: grid;
        grid-template-columns: minmax(75px, .8fr) minmax(0, 1.2fr);
        gap: 12px;
        padding: 11px 0;
        border-bottom: 1px solid #e7eaee;
        font-size: 12px;
    }

    .bk-summary dt {
        color: #7a838d;
    }

    .bk-summary dd {
        margin: 0;
        color: #414a53;
        font-weight: 700;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .bk-note {
        margin-top: 15px;
        padding: 12px;
        border: 1px solid #dce5ed;
        border-radius: 9px;
        background: #f4f7fa;
        color: #65788a;
        font-size: 11px;
        line-height: 1.7;
    }

    .bk-foot {
        margin: 22px 0 0;
        color: #9aa2aa;
        font-size: 11px;
        text-align: center;
    }

    @keyframes bkUp {
        from {
            opacity: 0;
            transform: translateY(6px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 1080px) {
        .bk-layout {
            grid-template-columns: minmax(0, 1fr);
        }

        .bk-side {
            position: static;
            order: -1;
        }
    }

    @media (max-width: 700px) {
        .bk-head {
            align-items: stretch;
        }

        .bk-head h1 {
            font-size: 23px;
        }

        .bk-head > a {
            width: 100%;
        }

        .bk-card {
            padding: 16px 14px;
            border-radius: 12px;
        }

        .bk-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 15px;
        }

        .bk-span {
            grid-column: auto;
        }

        .bk-cat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .bk-mek-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .bk-actions {
            flex-direction: column-reverse;
        }

        .bk-actions .bk-btn {
            width: 100%;
        }

        .bk-summary {
            padding: 16px;
        }
    }

    @media (max-width: 380px) {
        .bk-cat {
            gap: 7px;
            padding: 9px 7px;
        }

        .bk-cat-label {
            font-size: 11px;
        }

        .bk-summary dl > div {
            grid-template-columns: minmax(65px, .8fr) minmax(0, 1.2fr);
            gap: 8px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .bk-card {
            animation: none;
        }

        .bk-page * {
            transition-duration: .01ms !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const $ = (id) => document.getElementById(id);

    const nama = $('nama_pelanggan');
    const hp = $('no_hp');
    const motor = $('nama_motor');
    const plat = $('plat_nomor');
    const servis = $('jenis_servis');
    const tgl = $('tanggal_booking');
    const jam = $('jam_booking');
    const ket = $('ket_waktu');

    const bayarInput = $('metode_pembayaran');
    const errBayar = $('errBayar');
    const form = $('bookingForm');

    if (!form || !bayarInput) {
        return;
    }

    function teks(el, nilai) {
        if (!el) return;
        el.textContent = nilai && String(nilai).trim()
            ? String(nilai).trim()
            : '-';
    }

    function labelWaktu() {
        if (!jam || !ket || !jam.value) {
            if (ket) ket.textContent = '';
            return '';
        }

        const j = Number(jam.value.split(':')[0]);
        const waktu = j < 11
            ? 'Pagi'
            : j < 15
                ? 'Siang'
                : j < 18
                    ? 'Sore'
                    : 'Malam';

        ket.textContent = waktu;
        return waktu;
    }

    function ringkasan() {
        teks($('sumNama'), nama?.value);
        teks($('sumHp'), hp?.value);
        teks($('sumMotor'), motor?.value);
        teks($('sumPlat'), plat?.value.toUpperCase());
        teks($('sumServis'), servis?.value);

        let jadwal = '-';

        if (tgl?.value) {
            const tanggal = new Date(tgl.value + 'T00:00:00');

            jadwal = tanggal.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });

            if (jam?.value) {
                jadwal += ', ' + jam.value;
            }
        } else if (jam?.value) {
            jadwal = jam.value;
        }

        teks($('sumJadwal'), jadwal);
        teks($('sumBayar'), bayarInput.dataset.label || '-');

        const mekanik = document.querySelector(
            'input[name="mechanic_id"]:checked'
        );

        teks(
            $('sumMekanik'),
            mekanik?.dataset.label || 'Ditentukan admin'
        );
    }

    if (hp) {
        hp.addEventListener('input', function () {
            hp.value = hp.value.replace(/[^0-9+\-\s]/g, '');
            ringkasan();
        });
    }

    if (plat) {
        plat.addEventListener('input', function () {
            const posisi = plat.selectionStart;
            plat.value = plat.value.toUpperCase();

            if (posisi !== null) {
                plat.setSelectionRange(posisi, posisi);
            }

            ringkasan();
        });
    }

    document.querySelectorAll('.bk-chip').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            const saran = tombol.dataset.saran;
            const sekarang = servis.value.trim();

            if (sekarang.toLowerCase().includes(saran.toLowerCase())) {
                return;
            }

            servis.value = sekarang
                ? sekarang + ', ' + saran.toLowerCase()
                : saran;

            servis.dispatchEvent(new Event('input', { bubbles: true }));
            servis.focus();
            ringkasan();
        });
    });

    [nama, hp, motor, plat, servis, tgl, jam]
        .filter(Boolean)
        .forEach(function (elemen) {
            elemen.addEventListener('input', function () {
                labelWaktu();
                ringkasan();
            });

            elemen.addEventListener('change', function () {
                labelWaktu();
                ringkasan();
            });
        });

    function setBayar(nilai, label) {
        bayarInput.value = nilai;
        bayarInput.dataset.label = label;

        if (errBayar) {
            errBayar.classList.add('is-hidden');
        }

        ringkasan();
    }

    document.querySelectorAll('.bk-cat').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            document.querySelectorAll('.bk-cat').forEach(function (item) {
                item.classList.toggle('is-active', item === tombol);
            });

            document.querySelectorAll('.bk-sub').forEach(function (panel) {
                panel.classList.toggle(
                    'is-hidden',
                    panel.dataset.sub !== tombol.dataset.kat
                );
            });

            if (tombol.dataset.nilai) {
                document.querySelectorAll('.bk-opt').forEach(function (opsi) {
                    opsi.classList.remove('is-active');
                });

                setBayar(
                    tombol.dataset.nilai,
                    tombol.dataset.label
                );
            } else {
                const opsiAktif = document.querySelector(
                    '.bk-sub[data-sub="' + tombol.dataset.kat + '"] .bk-opt.is-active'
                );

                if (opsiAktif) {
                    setBayar(
                        opsiAktif.dataset.nilai,
                        opsiAktif.dataset.label
                    );
                } else {
                    bayarInput.value = '';
                    bayarInput.dataset.label = '';
                    ringkasan();
                }
            }
        });
    });

    document.querySelectorAll('.bk-opt').forEach(function (opsi) {
        opsi.addEventListener('click', function () {
            const panel = opsi.closest('.bk-sub');

            panel.querySelectorAll('.bk-opt').forEach(function (item) {
                item.classList.toggle('is-active', item === opsi);
            });

            setBayar(opsi.dataset.nilai, opsi.dataset.label);
        });
    });

    document.querySelectorAll('input[name="mechanic_id"]').forEach(function (radio) {
        radio.addEventListener('change', ringkasan);
    });

    // Menampilkan metode pembayaran yang sudah tersimpan.
    (function () {
        const nilai = bayarInput.value;
        const kategori = document.querySelector('.bk-cat.is-active');

        let label = '';

        if (nilai.startsWith('Transfer ')) {
            label = nilai;
        } else if (nilai === 'QRIS') {
            label = 'QRIS';
        } else if (
            ['OVO', 'GoPay', 'DANA', 'ShopeePay', 'LinkAja'].includes(nilai)
        ) {
            label = nilai;
        } else if (nilai) {
            label = 'Tunai (bayar di kasir)';
        }

        bayarInput.dataset.label = label;

        if (!nilai && kategori && kategori.dataset.nilai) {
            bayarInput.dataset.label = kategori.dataset.label;
        }
    })();

    form.addEventListener('submit', function (event) {
        if (!bayarInput.value) {
            event.preventDefault();

            if (errBayar) {
                errBayar.classList.remove('is-hidden');
                errBayar.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            return;
        }

        const tombol = $('btnKirim');

        if (tombol) {
            tombol.disabled = true;
            tombol.style.opacity = '.75';
            tombol.textContent = 'Menyimpan...';
        }
    });

    labelWaktu();
    ringkasan();
})();
</script>
@endpush