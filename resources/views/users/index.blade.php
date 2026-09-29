<x-app-layout>
    <x-slot name="title">Manajemen User & Teknisi</x-slot>

    <div x-data="{
        showCreateModal: false,
        showEditModal: false,
        editUser: null,
        openEdit(u) {
            this.editUser = Object.assign({}, u);
            this.showEditModal = true;
        }
    }">

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">Administrasi Akun STO Witel Base-G</div>
            <h2 class="page-heading-title">Manajemen Pengguna & Teknisi</h2>
            <div class="page-heading-desc">Kelola hak akses sistem, profil teknisi lapangan, dan akun administrator</div>
        </div>
        <button type="button" @click="showCreateModal = true" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>+ Tambah User (Modal)</span>
        </button>
    </div>

    <!-- Filter Toolbar -->
    <form method="GET" action="{{ route('users.index') }}">
        <div class="filter-toolbar">
            <div class="filter-item filter-item-search">
                <label class="form-label">Pencarian</label>
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama atau email pengguna..." value="{{ request('search') }}">
            </div>
            <div class="filter-item">
                <label class="form-label">Peran (Role)</label>
                <select name="role" class="form-control">
                    <option value="">Semua Peran</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="teknisi" {{ request('role') == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                </select>
            </div>
            <div style="display: flex; gap: 6px; align-items: flex-end;">
                <button type="submit" class="btn btn-dark">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">Daftar Akun Pengguna</h3>
                <div class="card-subtitle">Total {{ $users->total() }} akun terdaftar dalam sistem</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="app-table">
                <thead>
                    <tr>
                        <th style="width: 35px;">#</th>
                        <th>Nama & NIP</th>
                        <th>Email</th>
                        <th>Peran (Role)</th>
                        <th>Jabatan</th>
                        <th>No. Telepon</th>
                        <th style="text-align: right; width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                    @php
                        $userJson = [
                            'id' => $u->id,
                            'name' => $u->name,
                            'nip' => $u->nip ?? '',
                            'email' => $u->email,
                            'role' => $u->role,
                            'jabatan' => $u->jabatan ?? '',
                            'no_telp' => $u->no_telp ?? '',
                            'update_url' => route('users.update', $u)
                        ];
                    @endphp
                    <tr>
                        <td style="color: #64748B;">{{ $users->firstItem() + $index }}</td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $u->name }}</div>
                            @if($u->nip)
                            <div style="font-size: 11px; color: #64748B;">NIP: {{ $u->nip }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="color: #334155;">{{ $u->email }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $u->role === 'admin' ? 'badge-danger' : 'badge-info' }}">
                                <span class="badge-dot"></span>
                                {{ $u->role === 'admin' ? 'Administrator' : 'Teknisi' }}
                            </span>
                        </td>
                        <td>{{ $u->jabatan ?? '-' }}</td>
                        <td>{{ $u->no_telp ?? '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                <button type="button" @click="openEdit({{ json_encode($userJson) }})" class="btn btn-secondary btn-sm" title="Ubah User">
                                    <span>Edit</span>
                                </button>
                                @if(auth()->id() !== $u->id)
                                <form method="POST" action="{{ route('users.destroy', $u) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                      style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <span>Hapus</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #64748B; padding: 36px;">
                            Tidak ditemukan akun pengguna.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="card-footer">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- ===== MODAL 1: TAMBAH USER ===== -->
    <div x-cloak x-show="showCreateModal" class="app-modal-overlay" @keydown.escape.window="showCreateModal = false">
        <div class="app-modal-dialog" @click.outside="showCreateModal = false">
            <div class="app-modal-header">
                <div>
                    <h3 class="app-modal-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:var(--telkom-red);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Akun Pengguna Baru</span>
                    </h3>
                    <div class="app-modal-subtitle">Registrasi akun teknisi lapangan atau administrator sistem</div>
                </div>
                <button type="button" class="app-modal-close" @click="showCreateModal = false" aria-label="Tutup">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('users.store') }}" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
                @csrf
                <div class="app-modal-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div style="grid-column: span 2;">
                            <label class="form-label">Nama Lengkap <span style="color: #DC2626;">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Nama lengkap teknisi / petugas" required>
                        </div>
                        <div>
                            <label class="form-label">NIP / ID Pegawai</label>
                            <input type="text" name="nip" class="form-control" placeholder="NIP Telkom (opsional)">
                        </div>
                        <div>
                            <label class="form-label">Alamat Email <span style="color: #DC2626;">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="email@witelbaseg.id" required>
                        </div>
                        <div>
                            <label class="form-label">Password <span style="color: #DC2626;">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                        </div>
                        <div>
                            <label class="form-label">Konfirmasi Password <span style="color: #DC2626;">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                        </div>
                        <div>
                            <label class="form-label">Peran (Role) <span style="color: #DC2626;">*</span></label>
                            <select name="role" class="form-control" required>
                                <option value="teknisi" selected>Teknisi</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Teknisi Alpro / Spv Operasional">
                        </div>
                        <div style="grid-column: span 2;">
                            <label class="form-label">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                <div class="app-modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showCreateModal = false">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Akun Pengguna</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL 2: UBAH USER ===== -->
    <div x-cloak x-show="showEditModal" class="app-modal-overlay" @keydown.escape.window="showEditModal = false">
        <div class="app-modal-dialog" @click.outside="showEditModal = false">
            <div class="app-modal-header">
                <div>
                    <h3 class="app-modal-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:#0F172A;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span>Ubah Data Akun: <span x-text="editUser?.name"></span></span>
                    </h3>
                    <div class="app-modal-subtitle" x-text="editUser?.email"></div>
                </div>
                <button type="button" class="app-modal-close" @click="showEditModal = false" aria-label="Tutup">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form :action="editUser?.update_url" method="POST" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
                @csrf
                @method('PUT')
                <div class="app-modal-body" x-show="editUser">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div style="grid-column: span 2;">
                            <label class="form-label">Nama Lengkap <span style="color: #DC2626;">*</span></label>
                            <input type="text" name="name" class="form-control" x-model="editUser.name" required>
                        </div>
                        <div>
                            <label class="form-label">NIP / ID Pegawai</label>
                            <input type="text" name="nip" class="form-control" x-model="editUser.nip">
                        </div>
                        <div>
                            <label class="form-label">Alamat Email <span style="color: #DC2626;">*</span></label>
                            <input type="email" name="email" class="form-control" x-model="editUser.email" required>
                        </div>
                        <div>
                            <label class="form-label">Ganti Password (Opsional)</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                        </div>
                        <div>
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        </div>
                        <div>
                            <label class="form-label">Peran (Role) <span style="color: #DC2626;">*</span></label>
                            <select name="role" class="form-control" x-model="editUser.role" required>
                                <option value="teknisi">Teknisi</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" x-model="editUser.jabatan">
                        </div>
                        <div style="grid-column: span 2;">
                            <label class="form-label">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="no_telp" class="form-control" x-model="editUser.no_telp">
                        </div>
                    </div>
                </div>

                <div class="app-modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showEditModal = false">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    </div> <!-- End x-data -->
</x-app-layout>
