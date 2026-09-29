<x-app-layout>
    <x-slot name="title">Pengaturan Profil Pengguna</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 12px; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">Akun & Keamanan</div>
            <h2 class="page-heading-title" style="font-size: 22px;">Pengaturan Profil & Kredensial</h2>
            <div class="page-heading-desc">Perbarui informasi profil pengguna dan kata sandi akun sistem</div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 24px; max-width: 900px;">
        <!-- Profil Information -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Informasi Pengguna</h3>
                    <div class="card-subtitle">Perbarui data nama dan alamat email akun Anda</div>
                </div>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Perbarui Password</h3>
                    <div class="card-subtitle">Pastikan akun Anda menggunakan kata sandi acak yang aman</div>
                </div>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header" style="border-bottom-color: #FEE2E2; background-color: #FEF2F2;">
                <div>
                    <h3 class="card-title" style="color: #991B1B;">Hapus Akun Pengguna</h3>
                    <div class="card-subtitle" style="color: #B91C1C;">Tindakan permanen penghapusan seluruh data akun Anda</div>
                </div>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
