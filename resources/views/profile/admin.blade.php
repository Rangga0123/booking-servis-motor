@extends('admin.layouts.app')

@section('title', 'Profil Akun - Bengkel Royal Motor')

@push('styles')
<style>
    .pf-page,
    .pf-page * { box-sizing: border-box; }
    .pf-page { width: 100%; max-width: 820px; color: #192740; }

    .pf-head { margin-bottom: 20px; padding: 21px 23px; background: linear-gradient(120deg, #fff, #f7faff); border: 1px solid #e3e9f2; border-left: 4px solid #3264d8; border-radius: 18px; box-shadow: 0 5px 22px rgba(31,52,88,.045); }
    .pf-head h1 { margin: 0; font-size: 24px; font-weight: 800; color: #102143; line-height: 1.35; }
    .pf-head p { margin: 6px 0 0; font-size: 12px; color: #7182a3; line-height: 1.7; }

    .pf-alert { display: flex; align-items: flex-start; gap: 8px; padding: 13px 16px; margin-bottom: 16px; border-radius: 12px; font-size: 12px; font-weight: 600; line-height: 1.7; color: #087647; background: #e1f8eb; border: 1px solid #bcebd0; }

    .pf-card { overflow: hidden; margin-bottom: 18px; background: #fff; border: 1px solid #e3e9f2; border-radius: 18px; box-shadow: 0 5px 22px rgba(31,52,88,.045); scroll-margin-top: 90px; }
    .pf-card-title { display: flex; align-items: center; gap: 14px; padding: 19px 23px; background: linear-gradient(135deg, #fff, #f8faff); border-bottom: 1px solid #edf1f7; }
    .pf-card-body { padding: 22px 23px 24px; }
    .pf-icon { width: 45px; height: 45px; border-radius: 14px; flex-shrink: 0; display: grid; place-items: center; background: linear-gradient(145deg, #527fff, #3158cb); color: #fff; }
    .pf-card-title h2 { margin: 0; font-size: 15px; font-weight: 800; color: #1a2943; }
    .pf-card-title p { margin: 5px 0 0; font-size: 12px; color: #8794a9; line-height: 1.5; }

    .pf-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 16px; }
    .pf-grid .full { grid-column: 1 / -1; }
    .pf-field { margin-bottom: 16px; min-width: 0; }
    .pf-field label { display: block; margin-bottom: 7px; font-size: 11px; font-weight: 700; color: #344765; }
    .pf-input { width: 100%; min-height: 44px; padding: 11px 13px; border: 1px solid #d3dcea; border-radius: 10px; background: #fbfcfe; color: #14213d; font-family: inherit; font-size: 13px; outline: none; transition: border-color .2s, box-shadow .2s; }
    .pf-input:focus { border-color: #3264d8; background: #fff; box-shadow: 0 0 0 3px rgba(50,100,216,.12); }
    .pf-error { margin-top: 6px; font-size: 11px; color: #bb2942; line-height: 1.5; }
    .pf-hint { font-size: 11px; color: #7182a3; line-height: 1.7; }

    .pf-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-top: 4px; }
    .pf-btn { display: inline-flex; align-items: center; justify-content: center; min-height: 44px; padding: 11px 20px; border: 0; border-radius: 10px; font-family: inherit; font-size: 12px; font-weight: 800; cursor: pointer; transition: background .2s, transform .2s; }
    .pf-btn:hover { transform: translateY(-1px); }
    .pf-btn-primary { background: #3264d8; color: #fff; box-shadow: 0 5px 14px rgba(50,100,216,.22); }
    .pf-btn-primary:hover { background: #244fb5; }
    .pf-btn-danger { background: #ffedf0; color: #bb2942; border: 1px solid #ffd0d8; }
    .pf-btn-danger:hover { background: #ffdde3; }

    .pf-photo-row { display: flex; align-items: center; gap: 18px; margin-bottom: 18px; }
    .pf-photo { width: 92px; height: 92px; border-radius: 50%; overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #d9e6ff, #9ebcff); color: #224c9c; font-size: 34px; font-weight: 800; border: 3px solid #fff; box-shadow: 0 4px 14px rgba(23,37,65,.15); }
    .pf-photo img { width: 100%; height: 100%; object-fit: cover; }
    .pf-file { width: 100%; padding: 10px; font-family: inherit; font-size: 12px; color: #52647b; background: #f7f9fd; border: 1px dashed #c4d1e6; border-radius: 10px; }
    .pf-file::file-selector-button { margin-right: 12px; padding: 9px 14px; color: #1854b4; background: #eaf2ff; border: 1px solid #d2e2ff; border-radius: 8px; font-family: inherit; font-size: 12px; font-weight: 700; cursor: pointer; }
    .pf-divider { height: 1px; margin: 18px 0 0; background: #edf1f7; border: 0; }
    .pf-delete-form { margin-top: 12px; }

    @media (max-width: 700px) {
        .pf-head { padding: 17px 16px; border-radius: 14px; }
        .pf-head h1 { font-size: 20px; }
        .pf-card { border-radius: 14px; }
        .pf-card-title { padding: 15px 16px; gap: 12px; }
        .pf-icon { width: 40px; height: 40px; border-radius: 12px; }
        .pf-card-body { padding: 17px 16px 20px; }
        .pf-grid { grid-template-columns: minmax(0, 1fr); }
        .pf-input { font-size: 16px; }          /* cegah zoom otomatis di iPhone */
        .pf-actions { flex-direction: column; align-items: stretch; }
        .pf-btn { width: 100%; }
        .pf-photo-row { flex-direction: column; text-align: center; }
        .pf-file { font-size: 13px; }
        .pf-file::file-selector-button { display: block; margin: 0 0 8px; }
    }
</style>
@endpush

@section('content')
@php $user = auth()->user(); @endphp

<div class="pf-page">
    <div class="pf-head">
        <h1>Profil Akun</h1>
        <p>Kelola informasi akun, foto profil, dan keamanan password Anda.</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="pf-alert">✓ Informasi profil berhasil disimpan.</div>
    @endif
    @if (session('status') === 'photo-updated')
        <div class="pf-alert">✓ Foto profil berhasil diperbarui.</div>
    @endif
    @if (session('status') === 'photo-deleted')
        <div class="pf-alert">✓ Foto profil berhasil dihapus.</div>
    @endif
    @if (session('status') === 'password-updated')
        <div class="pf-alert">✓ Password berhasil diganti.</div>
    @endif

    {{-- Informasi profil --}}
    <section id="profile-info" class="pf-card">
        <div class="pf-card-title">
            <div class="pf-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </div>
            <div>
                <h2>Informasi Profil</h2>
                <p>Perbarui nama dan alamat email akun Anda.</p>
            </div>
        </div>

        <div class="pf-card-body">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="pf-grid">
                    <div class="pf-field">
                        <label for="name">Nama</label>
                        <input id="name" name="name" type="text" class="pf-input"
                               value="{{ old('name', $user->name) }}" required autocomplete="name">
                        @error('name') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="pf-field">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" class="pf-input"
                               value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="pf-actions">
                    <button type="submit" class="pf-btn pf-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>

    {{-- Foto profil --}}
    <section id="profile-photo" class="pf-card">
        <div class="pf-card-title">
            <div class="pf-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <circle cx="9" cy="10" r="2"/><path d="m21 15-5-5L5 20"/>
                </svg>
            </div>
            <div>
                <h2>Foto Profil</h2>
                <p>Foto akan tampil di pojok kanan atas semua halaman admin.</p>
            </div>
        </div>

        <div class="pf-card-body">
            <div class="pf-photo-row">
                <div class="pf-photo" id="photoPreview">
                    @if($user->profile_photo_url)
                        <img src="{{ $user->profile_photo_url }}" alt="Foto profil">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="pf-hint">
                    Format JPG, PNG, atau WEBP.<br>
                    Ukuran maksimal 2 MB.
                </div>
            </div>

            <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="pf-field">
                    <input id="profile_photo" name="profile_photo" type="file" class="pf-file"
                           accept="image/png,image/jpeg,image/webp" required>
                    @if($errors->updatePhoto->has('profile_photo'))
                        <div class="pf-error">{{ $errors->updatePhoto->first('profile_photo') }}</div>
                    @endif
                </div>

                <div class="pf-actions">
                    <button type="submit" class="pf-btn pf-btn-primary">Simpan Foto</button>
                </div>
            </form>

            @if($user->profile_photo)
                <form method="POST" action="{{ route('profile.photo.destroy') }}" class="pf-delete-form">
                    @csrf
                    @method('DELETE')
                    <div class="pf-actions">
                        <button type="submit" class="pf-btn pf-btn-danger"
                                onclick="return confirm('Hapus foto profil?')">Hapus Foto</button>
                    </div>
                </form>
            @endif
        </div>
    </section>

    {{-- Ganti password --}}
    <section id="update-password" class="pf-card">
        <div class="pf-card-title">
            <div class="pf-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="4" y="10" width="16" height="11" rx="2"/>
                    <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                </svg>
            </div>
            <div>
                <h2>Ganti Password</h2>
                <p>Gunakan password yang panjang dan sulit ditebak.</p>
            </div>
        </div>

        <div class="pf-card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="pf-field">
                    <label for="current_password">Password Saat Ini</label>
                    <input id="current_password" name="current_password" type="password"
                           class="pf-input" autocomplete="current-password">
                    @if($errors->updatePassword->has('current_password'))
                        <div class="pf-error">{{ $errors->updatePassword->first('current_password') }}</div>
                    @endif
                </div>

                <div class="pf-grid">
                    <div class="pf-field">
                        <label for="password">Password Baru</label>
                        <input id="password" name="password" type="password"
                               class="pf-input" autocomplete="new-password">
                        @if($errors->updatePassword->has('password'))
                            <div class="pf-error">{{ $errors->updatePassword->first('password') }}</div>
                        @endif
                    </div>

                    <div class="pf-field">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="pf-input" autocomplete="new-password">
                    </div>
                </div>

                <div class="pf-actions">
                    <button type="submit" class="pf-btn pf-btn-primary">Simpan Password</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const fotoInput = document.getElementById('profile_photo');
    const fotoPreview = document.getElementById('photoPreview');

    if (fotoInput && fotoPreview) {
        fotoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                fotoPreview.innerHTML = '<img src="' + e.target.result + '" alt="Pratinjau">';
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush