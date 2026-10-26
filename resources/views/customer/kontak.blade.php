@extends('layouts.customer')

@section('title', 'Kontak - Bengkel Royal Motor')

@push('styles')
<style>
    .ct-page,
    .ct-page * {
        box-sizing: border-box;
    }

    .ct-page {
        width: 100%;
        max-width: 1450px;
        margin: 0 auto;
        padding: 0 0 30px;
        color: #192740;
    }

    .ct-head {
        margin-bottom: 20px;
        padding: 23px 25px;
        background: linear-gradient(120deg, #fff, #f7faff);
        border: 1px solid #e3e9f2;
        border-left: 4px solid #3264d8;
        border-radius: 18px;
        box-shadow: 0 5px 22px rgba(31,52,88,.045);
    }

    .ct-crumb {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
        color: #7182a3;
        font-size: 12px;
    }

    .ct-crumb span:last-child {
        color: #3264d8;
        font-weight: 700;
    }

    .ct-title {
        margin: 0;
        color: #14213d;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.35;
    }

    .ct-desc {
        max-width: 650px;
        margin: 8px 0 0;
        color: #7182a3;
        font-size: 13px;
        line-height: 1.8;
    }

    .ct-info {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 20px;
        padding: 14px 16px;
        color: #2457bd;
        background: #e7efff;
        border: 1px solid #cbdcff;
        border-radius: 12px;
        font-size: 13px;
        line-height: 1.7;
    }

    .ct-info svg {
        flex-shrink: 0;
        margin-top: 3px;
    }

    .ct-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .ct-card {
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: 24px 22px 22px;
        background: #fff;
        border: 1px solid #e3e9f2;
        border-top: 3px solid var(--ct, #3264d8);
        border-radius: 18px;
        box-shadow: 0 5px 22px rgba(31,52,88,.045);
        transition: transform .2s, box-shadow .2s;
    }

    .ct-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(31,52,88,.09);
    }

    .ct-avatar {
        display: grid;
        place-items: center;
        width: 84px;
        height: 84px;
        margin: 0 auto 14px;
        color: #fff;
        background: var(--ct, #3264d8);
        border: 4px solid #e3e9f2;
        border-radius: 50%;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .ct-name {
        margin: 0;
        text-align: center;
        color: #14213d;
        font-size: 17px;
        font-weight: 800;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .ct-role {
        margin: 5px 0 16px;
        text-align: center;
        color: #7182a3;
        font-size: 12px;
        line-height: 1.7;
    }

    .ct-rows {
        margin-bottom: 18px;
        border-top: 1px solid #e8edf5;
    }

    .ct-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #e8edf5;
        font-size: 12px;
    }

    .ct-row span:first-child {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #14213d;
        font-weight: 800;
        white-space: nowrap;
    }

    .ct-row span:first-child svg {
        color: var(--ct, #3264d8);
        flex-shrink: 0;
    }

    .ct-row span:last-child {
        color: #52647b;
        font-weight: 600;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .ct-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        margin-top: auto;
        padding: 11px 12px;
        color: #fff;
        background: #22a45d;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 800;
        text-align: center;
        text-decoration: none;
        transition: background .2s, transform .2s;
    }

    .ct-btn:hover {
        color: #fff;
        background: #1b8a4d;
        transform: translateY(-1px);
    }

    .ct-btn.disabled {
        background: #cbd5e1;
        pointer-events: none;
    }

    .ct-foot {
        margin-top: 20px;
        color: #94a0b2;
        font-size: 11px;
        line-height: 1.7;
        text-align: center;
    }

    @media (max-width: 1000px) {
        .ct-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 700px) {
        .ct-head {
            padding: 19px 17px;
            border-radius: 14px;
        }

        .ct-title {
            font-size: 22px;
        }

        .ct-desc {
            font-size: 12px;
        }

        .ct-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 14px;
        }

        .ct-card {
            padding: 20px 16px 18px;
            border-radius: 14px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .ct-card,
        .ct-btn {
            transition: none;
        }
    }
</style>
@endpush

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATA KONTAK BENGKEL ROYAL MOTOR
    |--------------------------------------------------------------------------
    | Nomor ditampilkan tetap dalam format 08xxxx.
    | Link WhatsApp otomatis menggunakan format 62.
    */

    $kontak = [
        [
            'inisial' => 'KA',
            'warna' => '#3264d8',
            'nama' => 'Kevin Andreas',
            'peran' => 'Admin Bengkel',
            'keterangan' => 'Booking, Jadwal & Status Servis',
            'wa' => '083873414100',
            'sembunyikan' => true,
            'jam' => '13.00 - 22.00',
            'hari' => 'Senin - Minggu',
            'tombol' => 'Hubungi Admin Bengkel',
            'pesan' => 'Halo Kevin Andreas, saya ingin bertanya tentang booking dan layanan Bengkel Royal Motor.',
        ],
        [
            'inisial' => 'MD',
            'warna' => '#22a45d',
            'nama' => 'Ardi / Mr. Dadone',
            'peran' => 'Pemilik Bengkel',
            'keterangan' => 'Informasi Bengkel Royal Motor',
            'wa' => '081779559642',
            'sembunyikan' => true,
            'jam' => '13.00 - 22.00',
            'hari' => 'Senin - Minggu',
            'tombol' => 'Hubungi Pemilik Bengkel',
            'pesan' => 'Halo Pak Ardi / Mr. Dadone, saya ingin bertanya tentang Bengkel Royal Motor.',
        ],
        [
            'inisial' => 'RG',
            'warna' => '#343a40',
            'nama' => 'Rangga',
            'peran' => 'Admin Website',
            'keterangan' => 'Pembuat Website & Kendala Aplikasi',
            'wa' => '087741844414',
            'sembunyikan' => true,
            'jam' => 'Sesuai ketersediaan',
            'hari' => 'Senin - Minggu',
            'tombol' => 'Hubungi Admin Website',
            'pesan' => 'Halo Rangga, saya ingin bertanya tentang website Booking Servis Bengkel Royal Motor.',
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNGSI LINK WHATSAPP
    |--------------------------------------------------------------------------
    */

    $waLink = function ($nomor, $pesan) {
        $digit = preg_replace('/\D/', '', (string) $nomor);

        if (strlen($digit) < 9) {
            return null;
        }

        if (str_starts_with($digit, '0')) {
            $digit = '62' . substr($digit, 1);
        }

        return 'https://wa.me/' . $digit . '?text=' . rawurlencode($pesan);
    };
@endphp

<div class="ct-page">

    <section class="ct-head">
        <div class="ct-crumb">
            <span>Pelanggan</span>
            <span aria-hidden="true">/</span>
            <span>Kontak</span>
        </div>

        <h1 class="ct-title">Hubungi Kami</h1>

        <p class="ct-desc">
            Hubungi kontak yang sesuai dengan kebutuhan kamu.
            Mulai dari urusan booking servis, informasi bengkel,
            sampai kendala pada website Bengkel Royal Motor.
        </p>
    </section>

    <div class="ct-info">
        <svg width="16" height="16" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2"
             aria-hidden="true">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 16v-4M12 8h.01"/>
        </svg>

        <div>
            Silakan pilih kontak sesuai keperluan kamu.
            Klik tombol WhatsApp untuk membuka percakapan
            dengan orang yang dituju.
        </div>
    </div>

    <section class="ct-grid">

        @foreach ($kontak as $k)

            @php
                $link = $waLink($k['wa'], $k['pesan']);

                $digit = preg_replace('/\D/', '', (string) $k['wa']);

                $tampil = ($k['sembunyikan'] ?? true)
                    ? substr($digit, 0, 2)
                        . str_repeat('x', max(strlen($digit) - 2, 0))
                    : $k['wa'];
            @endphp

            <article class="ct-card" style="--ct: {{ $k['warna'] }}">

                <div class="ct-avatar">
                    {{ $k['inisial'] }}
                </div>

                <h2 class="ct-name">
                    {{ $k['nama'] }}
                </h2>

                <p class="ct-role">
                    {{ $k['peran'] }}<br>
                    {{ $k['keterangan'] }}
                </p>

                <div class="ct-rows">

                    <div class="ct-row">
                        <span>
                            <svg width="15" height="15"
                                 viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2"
                                 aria-hidden="true">
                                <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>
                            </svg>
                            WhatsApp
                        </span>

                        <span>{{ $tampil }}</span>
                    </div>

                    <div class="ct-row">
                        <span>
                            <svg width="15" height="15"
                                 viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2"
                                 aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            </svg>
                            Jam Layanan
                        </span>

                        <span>{{ $k['jam'] }}</span>
                    </div>

                    <div class="ct-row">
                        <span>
                            <svg width="15" height="15"
                                 viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2"
                                 aria-hidden="true">
                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                <path d="M8 2v4M16 2v4M3 10h18"/>
                            </svg>
                            Hari
                        </span>

                        <span>{{ $k['hari'] }}</span>
                    </div>

                </div>

                <a href="{{ $link ?? '#' }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="ct-btn {{ $link ? '' : 'disabled' }}"
                   @if (!$link) aria-disabled="true" @endif>

                    <svg width="17" height="17"
                         viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         aria-hidden="true">
                        <path d="M21 11.5a8.4 8.4 0 0 1-12.4 7.4L3 21l2-5.4A8.5 8.5 0 1 1 21 11.5z"/>
                    </svg>

                    {{ $k['tombol'] }}

                </a>

            </article>

        @endforeach

    </section>

    <div class="ct-foot">
        Bengkel Royal Motor · Kontak Resmi
    </div>

</div>

@endsection