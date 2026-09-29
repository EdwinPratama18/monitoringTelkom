<x-app-layout>
    <x-slot name="title">Data Perangkat</x-slot>

    <div x-data="{
        showCreateModal: false,
        showEditModal: false,
        showDetailModal: false,
        editItem: null,
        detailItem: null,
        openEdit(p) {
            this.editItem = Object.assign({}, p);
            this.showEditModal = true;
        },
        openDetail(p) {
            this.detailItem = Object.assign({}, p);
            this.showDetailModal = true;
        }
    }">

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">Inventaris Operasional STO Witel Base-G</div>
            <h2 class="page-heading-title">Data Perangkat Infrastruktur</h2>
            <div class="page-heading-desc">Inventaris dan status teknis perangkat telekomunikasi (PLN, Genset, Rectifier, DWDM, Router)</div>
        </div>
        <button type="button" @click="showCreateModal = true" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>+ Tambah Perangkat (Modal)</span>
        </button>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('perangkat.index') }}">
        <div class="filter-toolbar">
            <div class="filter-item filter-item-search">
                <label class="form-label">Pencarian</label>
                <input type="text" name="search" class="form-control"
                       placeholder="Cari kode, nama, atau lokasi..." value="{{ request('search') }}">
            </div>
            <div class="filter-item">
                <label class="form-label">Kondisi</label>
                <select name="kondisi" class="form-control">
                    <option value="">Semua Kondisi</option>
                    <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>
            <div class="filter-item">
                <label class="form-label">Status Operasional</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="Dalam Perbaikan" {{ request('status') == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                </select>
            </div>
            <div class="filter-item">
                <label class="form-label">Jenis Perangkat</label>
                <select name="jenis" class="form-control">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisPerangkat as $jenis)
                    <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
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
                <a href="{{ route('perangkat.index') }}" class="btn btn-secondary" title="Reset filter">
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">Daftar Perangkat</h3>
                <div class="card-subtitle">Menampilkan {{ $perangkat->total() }} total unit infrastruktur</div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="app-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Kode Perangkat</th>
                        <th>Nama Perangkat</th>
                        <th>Jenis</th>
                        <th>Lokasi & Ruangan</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th style="text-align: right; width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perangkat as $index => $p)
                    @php
                        $itemJson = [
                            'id' => $p->id,
                            'kode_perangkat' => $p->kode_perangkat,
                            'nama_perangkat' => $p->nama_perangkat,
                            'jenis_perangkat' => $p->jenis_perangkat,
                            'merk' => $p->merk ?? '-',
                            'model' => $p->model ?? '-',
                            'no_seri' => $p->no_seri ?? '-',
                            'lokasi' => $p->lokasi,
                            'ruangan' => $p->ruangan ?? '-',
                            'tanggal_install' => $p->tanggal_install ? $p->tanggal_install->format('Y-m-d') : '',
                            'tanggal_install_formatted' => $p->tanggal_install ? $p->tanggal_install->format('d/m/Y') : '-',
                            'kondisi' => $p->kondisi,
                            'badge_kondisi' => $p->badge_kondisi,
                            'status' => $p->status,
                            'badge_status' => $p->badge_status,
                            'keterangan' => $p->keterangan ?? '-',
                            'foto_url' => $p->foto ? Storage::url($p->foto) : null,
                            'update_url' => route('perangkat.update', $p),
                            'maintenance_count' => $p->maintenances()->count(),
                        ];
                    @endphp
                    <tr>
                        <td style="color: #64748B;">{{ $perangkat->firstItem() + $index }}</td>
                        <td>
                            <span class="code-pill">{{ $p->kode_perangkat }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $p->nama_perangkat }}</div>
                            @if($p->merk || $p->model)
                            <div style="font-size: 11.5px; color: #64748B; margin-top: 1px;">
                                {{ $p->merk }} {{ $p->model }} {{ $p->no_seri ? '• SN: ' . $p->no_seri : '' }}
                            </div>
                            @endif
                        </td>
                        <td>
                            <span style="color: #334155; font-weight: 500;">{{ $p->jenis_perangkat }}</span>
                        </td>
                        <td>
                            <div style="color: #1E293B;">{{ $p->lokasi }}</div>
                            @if($p->ruangan)
                            <div style="font-size: 11px; color: #64748B;">Ruangan: {{ $p->ruangan }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $p->badge_kondisi }}">
                                <span class="badge-dot"></span>
                                {{ $p->kondisi }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $p->badge_status }}">
                                <span class="badge-dot"></span>
                                {{ $p->status }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                <button type="button" @click="openDetail({{ json_encode($itemJson) }})" class="btn btn-action-view btn-sm" title="Lihat Detail">
                                    <span>Detail</span>
                                </button>
                                <button type="button" @click="openEdit({{ json_encode($itemJson) }})" class="btn btn-secondary btn-sm" title="Ubah Data">
                                    <span>Ubah</span>
                                </button>
                                <form method="POST" action="{{ route('perangkat.destroy', $p) }}"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat ini? Data riwayat maintenance terkait juga akan terpengaruh.')"
                                      style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #64748B; padding: 36px;">
                            Tidak ditemukan data perangkat sesuai kriteria filter pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($perangkat->hasPages())
        <div class="card-footer">
            {{ $perangkat->links() }}
        </div>
        @endif
    </div>

    <!-- ===== MODAL 1: TAMBAH PERANGKAT ===== -->
    <div x-cloak x-show="showCreateModal" class="app-modal-overlay" @keydown.escape.window="showCreateModal = false">
        <div class="app-modal-dialog app-modal-dialog-xl" @click.outside="showCreateModal = false">
            <div class="app-modal-header">
                <div>
                    <h3 class="app-modal-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:var(--telkom-red);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Registrasi Perangkat Infrastruktur Baru</span>
                    </h3>
                    <div class="app-modal-subtitle">Tambahkan unit infrastruktur ke database operasional STO Witel Base-G</div>
                </div>
                <button type="button" class="app-modal-close" @click="showCreateModal = false" aria-label="Tutup">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('perangkat.store') }}" enctype="multipart/form-data" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
                @csrf
                <div class="app-modal-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <!-- Sisi Kiri: Identitas -->
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #0F172A; text-transform: uppercase; margin-bottom: 12px; padding-bottom: 5px; border-bottom: 1px solid #E2E8F0;">
                                1. Identifikasi Perangkat
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Kode Perangkat <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="kode_perangkat" class="form-control" placeholder="Contoh: SRV-001, OLT-002, RTR-001" required>
                                <div style="font-size: 11px; color: #64748B; margin-top: 3px;">Kode identifikasi unik perangkat di STO</div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Nama Perangkat <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="nama_perangkat" class="form-control" placeholder="Contoh: Core Router STO Base-G" required>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Jenis Perangkat <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="jenis_perangkat" class="form-control" placeholder="Server / Router / OLT / Rectifier / Baterai / Genset" required>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div>
                                    <label class="form-label">Merk / Brand</label>
                                    <input type="text" name="merk" class="form-control" placeholder="Cisco / Huawei / Perkins">
                                </div>
                                <div>
                                    <label class="form-label">Model / Tipe</label>
                                    <input type="text" name="model" class="form-control" placeholder="Contoh: ASR 9000">
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Nomor Seri (Serial Number)</label>
                                <input type="text" name="no_seri" class="form-control" placeholder="SN dari pabrikan">
                            </div>
                        </div>

                        <!-- Sisi Kanan: Lokasi & Status -->
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #0F172A; text-transform: uppercase; margin-bottom: 12px; padding-bottom: 5px; border-bottom: 1px solid #E2E8F0;">
                                2. Penempatan & Status
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div>
                                    <label class="form-label">Lokasi <span style="color: #DC2626;">*</span></label>
                                    <input type="text" name="lokasi" class="form-control" value="STO Witel Base-G" required>
                                </div>
                                <div>
                                    <label class="form-label">Ruangan / Rak</label>
                                    <input type="text" name="ruangan" class="form-control" placeholder="R. Server Lt. 2 / Rack 04">
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Tanggal Pasang / Commissioning</label>
                                <input type="date" name="tanggal_install" class="form-control">
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div>
                                    <label class="form-label">Kondisi Teknis <span style="color: #DC2626;">*</span></label>
                                    <select name="kondisi" class="form-control" required>
                                        <option value="Baik" selected>Baik</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Status Operasional <span style="color: #DC2626;">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="Aktif" selected>Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                    </select>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Foto Fisik Perangkat</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>
                            <div>
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan fungsi atau perkabelan..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="app-modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showCreateModal = false">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Perangkat</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL 2: UBAH/EDIT PERANGKAT ===== -->
    <div x-cloak x-show="showEditModal" class="app-modal-overlay" @keydown.escape.window="showEditModal = false">
        <div class="app-modal-dialog app-modal-dialog-xl" @click.outside="showEditModal = false">
            <div class="app-modal-header">
                <div>
                    <h3 class="app-modal-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:#0F172A;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span>Ubah Data Perangkat: <span x-text="editItem?.nama_perangkat"></span></span>
                    </h3>
                    <div class="app-modal-subtitle" x-text="'Kode: ' + (editItem?.kode_perangkat || '') + ' • Perbarui data spesifikasi atau kondisi teknis'"></div>
                </div>
                <button type="button" class="app-modal-close" @click="showEditModal = false" aria-label="Tutup">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form :action="editItem?.update_url" method="POST" enctype="multipart/form-data" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
                @csrf
                @method('PUT')
                <div class="app-modal-body" x-show="editItem">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <!-- Sisi Kiri: Identitas -->
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #0F172A; text-transform: uppercase; margin-bottom: 12px; padding-bottom: 5px; border-bottom: 1px solid #E2E8F0;">
                                1. Identifikasi Perangkat
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Kode Perangkat <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="kode_perangkat" class="form-control" x-model="editItem.kode_perangkat" required>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Nama Perangkat <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="nama_perangkat" class="form-control" x-model="editItem.nama_perangkat" required>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Jenis Perangkat <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="jenis_perangkat" class="form-control" x-model="editItem.jenis_perangkat" required>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div>
                                    <label class="form-label">Merk / Brand</label>
                                    <input type="text" name="merk" class="form-control" x-model="editItem.merk">
                                </div>
                                <div>
                                    <label class="form-label">Model / Tipe</label>
                                    <input type="text" name="model" class="form-control" x-model="editItem.model">
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Nomor Seri (Serial Number)</label>
                                <input type="text" name="no_seri" class="form-control" x-model="editItem.no_seri">
                            </div>
                        </div>

                        <!-- Sisi Kanan: Lokasi & Status -->
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #0F172A; text-transform: uppercase; margin-bottom: 12px; padding-bottom: 5px; border-bottom: 1px solid #E2E8F0;">
                                2. Penempatan & Status
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div>
                                    <label class="form-label">Lokasi <span style="color: #DC2626;">*</span></label>
                                    <input type="text" name="lokasi" class="form-control" x-model="editItem.lokasi" required>
                                </div>
                                <div>
                                    <label class="form-label">Ruangan / Rak</label>
                                    <input type="text" name="ruangan" class="form-control" x-model="editItem.ruangan">
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Tanggal Pasang / Commissioning</label>
                                <input type="date" name="tanggal_install" class="form-control" x-model="editItem.tanggal_install">
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div>
                                    <label class="form-label">Kondisi Teknis <span style="color: #DC2626;">*</span></label>
                                    <select name="kondisi" class="form-control" x-model="editItem.kondisi" required>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Status Operasional <span style="color: #DC2626;">*</span></label>
                                    <select name="status" class="form-control" x-model="editItem.status" required>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                    </select>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Ganti Foto Fisik (Opsional)</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>
                            <div>
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea name="keterangan" class="form-control" rows="2" x-model="editItem.keterangan"></textarea>
                            </div>
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

    <!-- ===== MODAL 3: DETAIL PERANGKAT ===== -->
    <div x-cloak x-show="showDetailModal" class="app-modal-overlay" @keydown.escape.window="showDetailModal = false">
        <div class="app-modal-dialog app-modal-dialog-lg" @click.outside="showDetailModal = false">
            <div class="app-modal-header">
                <div>
                    <h3 class="app-modal-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:#0F172A;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                        <span>Detail Spesifikasi Perangkat</span>
                    </h3>
                    <div class="app-modal-subtitle" x-text="(detailItem ? detailItem.nama_perangkat : '') + ' • STO Witel Base-G'"></div>
                </div>
                <button type="button" class="app-modal-close" @click="showDetailModal = false" aria-label="Tutup">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="app-modal-body" x-show="detailItem">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <!-- Informasi Teknis -->
                    <div>
                        <table style="width: 100%; font-size: 12.5px; border-collapse: collapse;">
                            <tbody>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B; width: 42%;">Kode Perangkat</td>
                                    <td style="padding: 8px 0;">
                                        <span class="code-pill" x-text="detailItem?.kode_perangkat"></span>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Nama Unit</td>
                                    <td style="padding: 8px 0; font-weight: 600; color: #0F172A;" x-text="detailItem?.nama_perangkat"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Jenis Perangkat</td>
                                    <td style="padding: 8px 0; font-weight: 500;" x-text="detailItem?.jenis_perangkat"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Merk / Seri</td>
                                    <td style="padding: 8px 0;" x-text="(detailItem?.merk || '-') + ' ' + (detailItem?.model || '')"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Serial Number</td>
                                    <td style="padding: 8px 0; font-family: monospace; font-size: 11.5px;" x-text="detailItem?.no_seri"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Lokasi Fasilitas</td>
                                    <td style="padding: 8px 0;" x-text="detailItem?.lokasi"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Ruangan / Rack</td>
                                    <td style="padding: 8px 0;" x-text="detailItem?.ruangan"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Tanggal Pasang</td>
                                    <td style="padding: 8px 0;" x-text="detailItem?.tanggal_install_formatted"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Kondisi Teknis</td>
                                    <td style="padding: 8px 0;">
                                        <span class="badge" :class="detailItem?.badge_kondisi" x-text="detailItem?.kondisi"></span>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Status Operasi</td>
                                    <td style="padding: 8px 0;">
                                        <span class="badge" :class="detailItem?.badge_status" x-text="detailItem?.status"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="margin-top: 14px; padding: 12px; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px;">
                            <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase; margin-bottom: 4px;">
                                Catatan Tambahan
                            </div>
                            <div style="font-size: 12px; color: #1E293B; line-height: 1.4;" x-text="detailItem?.keterangan"></div>
                        </div>
                    </div>

                    <!-- Foto & Rekap Maintenance -->
                    <div>
                        <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase; margin-bottom: 6px;">
                            Dokumentasi Fisik Unit
                        </div>
                        <template x-if="detailItem?.foto_url">
                            <div style="border: 1px solid #E2E8F0; border-radius: 6px; overflow: hidden; background-color: #F8FAFC; text-align: center; margin-bottom: 14px;">
                                <a :href="detailItem.foto_url" target="_blank">
                                    <img :src="detailItem.foto_url" alt="Foto Perangkat" style="width: 100%; max-height: 200px; object-fit: cover;">
                                </a>
                            </div>
                        </template>
                        <template x-if="!detailItem?.foto_url">
                            <div style="padding: 28px 16px; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px; text-align: center; color: #94A3B8; margin-bottom: 14px;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 32px; height: 32px; margin: 0 auto 6px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span style="font-size: 12px;">Foto fisik belum diunggah</span>
                            </div>
                        </template>

                        <div style="border: 1px solid #E2E8F0; border-radius: 6px; padding: 14px; background-color: #FFFFFF;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <div style="font-size: 11px; color: #64748B; text-transform: uppercase;">Total Maintenance</div>
                                    <div style="font-size: 20px; font-weight: 700; color: #0F172A;" x-text="(detailItem?.maintenance_count || 0) + ' Log Kegiatan'"></div>
                                </div>
                                <a :href="'{{ route('maintenance.index') }}?perangkat_id=' + (detailItem ? detailItem.id : '')" class="btn btn-secondary btn-sm">
                                    <span>Lihat Riwayat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-modal-footer">
                <button type="button" @click="showDetailModal = false; openEdit(detailItem)" class="btn btn-secondary btn-sm">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span>Ubah Perangkat</span>
                </button>
                <button type="button" class="btn btn-dark btn-sm" @click="showDetailModal = false">Tutup</button>
            </div>
        </div>
    </div>

    </div> <!-- End x-data -->
</x-app-layout>
