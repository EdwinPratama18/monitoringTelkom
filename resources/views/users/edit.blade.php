<x-app-layout>
    <x-slot name="title">Edit User — {{ $user->name }}</x-slot>

    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('users.index') }}" style="color: #64748B; text-decoration: none;">Manajemen User</a> / Edit
            </div>
            <h2 class="page-heading-title">Edit Profil Pengguna</h2>
            <div class="page-heading-desc">{{ $user->name }} ({{ $user->email }})</div>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Perbarui Informasi Akun</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Nama Lengkap <span style="color: #DC2626;">*</span></label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Alamat Email <span style="color: #DC2626;">*</span></label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Ganti Password (Opsional)</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Kosongkan jika tidak ingin mengubah password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Ulangi password baru">
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Peran (Role) <span style="color: #DC2626;">*</span></label>
                        <select name="role" class="form-control" required>
                            <option value="teknisi" {{ old('role', $user->role) == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip" class="form-control"
                               value="{{ old('nip', $user->nip) }}">
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control"
                               value="{{ old('jabatan', $user->jabatan) }}">
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="no_telp" class="form-control"
                               value="{{ old('no_telp', $user->no_telp) }}">
                    </div>
                </div>
            </div>
            <div class="card-footer" style="display: flex; justify-content: flex-end; gap: 8px;">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
