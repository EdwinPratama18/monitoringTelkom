<x-app-layout>
    <x-slot name="title">Data Maintenance</x-slot>

    <div x-data="{
        showCreateModal: false,
        showEditModal: false,
        showDetailModal: false,
        editItem: null,
        detailItem: null,
        openEdit(m) {
            this.editItem = Object.assign({}, m);
            this.showEditModal = true;
        },
        openDetail(m) {
            this.detailItem = Object.assign({}, m);
            this.showDetailModal = true;
        }
    }">

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">Pemeliharaan Rutin STO Witel Base-G</div>
            <h2 class="page-heading-title">Data Maintenance Perangkat</h2>
            <div class="page-heading-desc">Log kegiatan inspeksi teknisi, pemeliharaan preventif, dan audit checklist infrastruktur</div>
        </div>
        <button type="button" @click="showCreateModal = true" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>+ Input Maintenance (Modal)</span>
        </button>
    </div>

    <!-- Filter Toolbar -->
    <form method="GET" action="{{ route('maintenance.index') }}">
        <div class="filter-toolbar">
            <div class="filter-item">
                <label class="form-label">Perangkat</label>
                <select name="perangkat_id" class="form-control">
                    <option value="">Semua Perangkat</option>
                    @foreach($perangkatList as $p)
                    <option value="{{ $p->id }}" {{ request('perangkat_id') == $p->id ? 'selected' : '' }}>
                        [{{ $p->kode_perangkat }}] {{ $p->nama_perangkat }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label class="form-label">Periode</label>
                <select name="periode" class="form-control">
                    <option value="">Semua Periode</option>
                    @foreach(['Harian','Mingguan','Bulanan','Tahunan'] as $p)
                    <option value="{{ $p }}" {{ request('periode') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    @foreach(['Dijadwalkan','Dalam Proses','Selesai','Ditunda'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
            </div>
            <div class="filter-item">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
            </div>
            <div style="display: flex; gap: 6px; align-items: flex-end;">
                <button type="submit" class="btn btn-dark">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
                <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">Daftar Kegiatan Maintenance</h3>
                <div class="card-subtitle">Total {{ $maintenances->total() }} catatan pemeliharaan</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="app-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Perangkat</th>
                        <th>Tanggal</th>
                        <th>Periode</th>
                        <th>Teknisi Pelaksana</th>
                        <th>Checklist</th>
                        <th>Eviden</th>
                        <th>Status</th>
                        <th style="text-align: right; width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenances as $index => $m)
                    @php
                        $maintJson = [
                            'id' => $m->id,
                            'perangkat_id' => $m->perangkat_id,
                            'perangkat_nama' => $m->perangkat->nama_perangkat ?? '-',
                            'perangkat_kode' => $m->perangkat->kode_perangkat ?? '-',
                            'lokasi' => ($m->perangkat->lokasi ?? '-') . ($m->perangkat->ruangan ? ' / ' . $m->perangkat->ruangan : ''),
                            'tanggal' => $m->tanggal->format('Y-m-d'),
                            'tanggal_formatted' => $m->tanggal->translatedFormat('d F Y'),
                            'periode' => $m->periode,
                            'teknisi' => $m->user->name ?? '-',
                            'status' => $m->status,
                            'badge_status' => $m->badge_status,
                            'keterangan' => $m->keterangan ?? '-',
                            'eviden_url' => $m->eviden ? Storage::url($m->eviden) : null,
                            'checklist' => $m->checklist ?? [],
                            'checklist_selesai' => $m->checklist_selesai,
                            'checklist_total' => $m->checklist_total,
                            'update_url' => route('maintenance.update', $m),
                        ];
                    @endphp
                    <tr>
                        <td style="color: #64748B;">{{ $maintenances->firstItem() + $index }}</td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $m->perangkat->nama_perangkat ?? '-' }}</div>
                            <div style="font-size: 11px; color: #64748B; margin-top: 2px; display: flex; align-items: center; gap: 4px;">
                                <span class="code-pill">{{ $m->perangkat->kode_perangkat ?? '-' }}</span>
                                <span>• {{ $m->perangkat->lokasi ?? '' }}</span>
                            </div>
                        </td>
                        <td style="white-space: nowrap;">
                            <span style="font-weight: 500; color: #1E293B;">{{ $m->tanggal->format('d/m/Y') }}</span>
                        </td>
                        <td>
                            <span style="font-size: 11.5px; background-color: #F1F5F9; border: 1px solid #E2E8F0; padding: 2px 7px; border-radius: 4px; color: #334155; font-weight: 500;">
                                {{ $m->periode }}
                            </span>
                        </td>
                        <td>
                            <span style="font-weight: 500;">{{ $m->user->name ?? '-' }}</span>
                        </td>
                        <td>
                            @if($m->checklist_total > 0)
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <div style="flex: 1; min-width: 55px; max-width: 75px; background-color: #E2E8F0; height: 5px; border-radius: 3px; overflow: hidden;">
                                    <div style="width: {{ ($m->checklist_selesai / $m->checklist_total) * 100 }}%; height: 100%; background-color: #16A34A;"></div>
                                </div>
                                <span style="font-size: 11px; color: #475569; font-weight: 500;">
                                    {{ $m->checklist_selesai }}/{{ $m->checklist_total }}
                                </span>
                            </div>
                            @else
                            <span style="color: #94A3B8; font-size: 11px;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($m->eviden)
                            <a href="{{ Storage::url($m->eviden) }}" target="_blank"
                               style="display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; color: #1E40AF; text-decoration: none;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 13px; height: 13px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Foto</span>
                            </a>
                            @else
                            <span style="color: #94A3B8; font-size: 11px;">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $m->badge_status }}">
                                <span class="badge-dot"></span>
                                {{ $m->status }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                <button type="button" @click="openDetail({{ json_encode($maintJson) }})" class="btn btn-action-view btn-sm" title="Lihat Detail">
                                    <span>Detail</span>
                                </button>
                                <button type="button" @click="openEdit({{ json_encode($maintJson) }})" class="btn btn-secondary btn-sm" title="Ubah Data">
                                    <span>Ubah</span>
                                </button>
                                <form method="POST" action="{{ route('maintenance.destroy', $m) }}"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data maintenance ini?')"
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
                        <td colspan="9" style="text-align: center; color: #64748B; padding: 36px;">
                            Tidak ditemukan data kegiatan maintenance yang sesuai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($maintenances->hasPages())
        <div class="card-footer">
            {{ $maintenances->links() }}
        </div>
        @endif
    </div>

    <!-- ===== MODAL 1: INPUT MAINTENANCE ===== -->
    <div x-cloak x-show="showCreateModal" class="app-modal-overlay" @keydown.escape.window="showCreateModal = false">
        <div class="app-modal-dialog app-modal-dialog-xl" @click.outside="showCreateModal = false">
            <div class="app-modal-header">
                <div>
                    <h3 class="app-modal-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:var(--telkom-red);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Input Kegiatan Maintenance Baru</span>
                    </h3>
                    <div class="app-modal-subtitle">Formulir pemeriksaan berkala dan audit checklist perangkat STO Witel Base-G</div>
                </div>
                <button type="button" class="app-modal-close" @click="showCreateModal = false" aria-label="Tutup">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('maintenance.store') }}" enctype="multipart/form-data" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
                @csrf
                <div class="app-modal-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <!-- Sisi Kiri: Form Identitas & Parameter -->
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #0F172A; text-transform: uppercase; margin-bottom: 12px; padding-bottom: 5px; border-bottom: 1px solid #E2E8F0;">
                                1. Target & Parameter
                            </div>

                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Pilih Perangkat Target <span style="color: #DC2626;">*</span></label>
                                <select name="perangkat_id" class="form-control" required>
                                    <option value="">-- Pilih Perangkat Target --</option>
                                    @foreach($perangkatList as $p)
                                    <option value="{{ $p->id }}" {{ request('perangkat_id') == $p->id ? 'selected' : '' }}>
                                        [{{ $p->kode_perangkat }}] {{ $p->nama_perangkat }} — {{ $p->lokasi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div>
                                    <label class="form-label">Tanggal Pelaksanaan <span style="color: #DC2626;">*</span></label>
                                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Periode <span style="color: #DC2626;">*</span></label>
                                    <select name="periode" class="form-control" required>
                                        @foreach(['Harian','Mingguan','Bulanan','Tahunan'] as $prd)
                                        <option value="{{ $prd }}" {{ $prd == 'Bulanan' ? 'selected' : '' }}>{{ $prd }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Status Pekerjaan <span style="color: #DC2626;">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="Selesai" selected>Selesai</option>
                                    <option value="Dalam Proses">Dalam Proses</option>
                                    <option value="Dijadwalkan">Dijadwalkan</option>
                                    <option value="Ditunda">Ditunda</option>
                                </select>
                            </div>

                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Dokumentasi Eviden (Foto Lapangan)</label>
                                <input type="file" name="eviden" class="form-control" accept="image/*">
                                <div style="font-size: 11px; color: #64748B; margin-top: 3px;">Format: JPG, PNG (Maks. 5MB)</div>
                            </div>

                            <div>
                                <label class="form-label">Catatan & Temuan Teknisi</label>
                                <textarea name="keterangan" class="form-control" rows="3"
                                          placeholder="Catat parameter kelistrikan, suhu ruang, observasi fisik, atau tindakan..."></textarea>
                            </div>
                        </div>

                        <!-- Sisi Kanan: Checklist Standar DEFA -->
                        <div>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; padding-bottom: 5px; border-bottom: 1px solid #E2E8F0;">
                                <div style="font-size: 11.5px; font-weight: 700; color: #0F172A; text-transform: uppercase;">
                                    2. Checklist Verifikasi Teknis
                                </div>
                                <span style="font-size: 11px; color: #64748B;">Centang item yang diperiksa</span>
                            </div>

                            <div style="max-height: 380px; overflow-y: auto; padding-right: 4px;">
                                @foreach($checklistTemplate as $idx => $item)
                                <div class="checklist-item-row" style="padding: 8px 10px; margin-bottom: 6px;">
                                    <input type="checkbox"
                                           name="checklist[{{ $idx }}][checked]"
                                           value="1"
                                           checked
                                           class="checklist-item-checkbox">
                                    <div style="flex: 1;">
                                        <input type="hidden" name="checklist[{{ $idx }}][item]" value="{{ $item['item'] }}">
                                        <div style="font-size: 12px; font-weight: 600; color: #0F172A; line-height: 1.25;">
                                            {{ $item['item'] }}
                                        </div>
                                        <input type="text"
                                               name="checklist[{{ $idx }}][catatan]"
                                               class="form-control"
                                               style="height: 26px; font-size: 11px; padding: 2px 6px; margin-top: 4px;"
                                               placeholder="Hasil ukur / kondisi normal">
                                    </div>
                                </div>
                                @endforeach
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
                        <span>Simpan Kegiatan Maintenance</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL 2: UBAH MAINTENANCE ===== -->
    <div x-cloak x-show="showEditModal" class="app-modal-overlay" @keydown.escape.window="showEditModal = false">
        <div class="app-modal-dialog app-modal-dialog-xl" @click.outside="showEditModal = false">
            <div class="app-modal-header">
                <div>
                    <h3 class="app-modal-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:#0F172A;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span>Ubah Catatan Maintenance</span>
                    </h3>
                    <div class="app-modal-subtitle" x-text="(editItem ? editItem.perangkat_nama : '') + ' • Perbarui data pelaksanaan atau status'"></div>
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
                        <!-- Parameter -->
                        <div>
                            <div style="font-size: 11.5px; font-weight: 700; color: #0F172A; text-transform: uppercase; margin-bottom: 12px; padding-bottom: 5px; border-bottom: 1px solid #E2E8F0;">
                                1. Target & Parameter
                            </div>

                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Perangkat Target <span style="color: #DC2626;">*</span></label>
                                <select name="perangkat_id" class="form-control" x-model="editItem.perangkat_id" required>
                                    @foreach($perangkatList as $p)
                                    <option value="{{ $p->id }}">
                                        [{{ $p->kode_perangkat }}] {{ $p->nama_perangkat }} — {{ $p->lokasi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                                <div>
                                    <label class="form-label">Tanggal Pelaksanaan <span style="color: #DC2626;">*</span></label>
                                    <input type="date" name="tanggal" class="form-control" x-model="editItem.tanggal" required>
                                </div>
                                <div>
                                    <label class="form-label">Periode <span style="color: #DC2626;">*</span></label>
                                    <select name="periode" class="form-control" x-model="editItem.periode" required>
                                        <option value="Harian">Harian</option>
                                        <option value="Mingguan">Mingguan</option>
                                        <option value="Bulanan">Bulanan</option>
                                        <option value="Tahunan">Tahunan</option>
                                    </select>
                                </div>
                            </div>

                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Status Pekerjaan <span style="color: #DC2626;">*</span></label>
                                <select name="status" class="form-control" x-model="editItem.status" required>
                                    <option value="Dijadwalkan">Dijadwalkan</option>
                                    <option value="Dalam Proses">Dalam Proses</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Ditunda">Ditunda</option>
                                </select>
                            </div>

                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Ganti Foto Eviden (Opsional)</label>
                                <input type="file" name="eviden" class="form-control" accept="image/*">
                            </div>

                            <div>
                                <label class="form-label">Catatan & Temuan Teknisi</label>
                                <textarea name="keterangan" class="form-control" rows="3" x-model="editItem.keterangan"></textarea>
                            </div>
                        </div>

                        <!-- Checklist Update -->
                        <div>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; padding-bottom: 5px; border-bottom: 1px solid #E2E8F0;">
                                <div style="font-size: 11.5px; font-weight: 700; color: #0F172A; text-transform: uppercase;">
                                    2. Checklist Verifikasi Teknis
                                </div>
                            </div>

                            <div style="max-height: 380px; overflow-y: auto; padding-right: 4px;">
                                <template x-for="(cl, cindex) in (editItem?.checklist || [])" :key="cindex">
                                    <div class="checklist-item-row" style="padding: 8px 10px; margin-bottom: 6px;">
                                        <input type="checkbox"
                                               :name="'checklist[' + cindex + '][checked]'"
                                               value="1"
                                               x-model="cl.checked"
                                               class="checklist-item-checkbox">
                                        <div style="flex: 1;">
                                            <input type="hidden" :name="'checklist[' + cindex + '][item]'" :value="cl.item">
                                            <div style="font-size: 12px; font-weight: 600; color: #0F172A;" x-text="cl.item"></div>
                                            <input type="text"
                                                   :name="'checklist[' + cindex + '][catatan]'"
                                                   class="form-control"
                                                   style="height: 26px; font-size: 11px; padding: 2px 6px; margin-top: 4px;"
                                                   x-model="cl.catatan"
                                                   placeholder="Hasil pemeriksaan / nilai ukur">
                                        </div>
                                    </div>
                                </template>
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

    <!-- ===== MODAL 3: DETAIL MAINTENANCE ===== -->
    <div x-cloak x-show="showDetailModal" class="app-modal-overlay" @keydown.escape.window="showDetailModal = false">
        <div class="app-modal-dialog app-modal-dialog-lg" @click.outside="showDetailModal = false">
            <div class="app-modal-header">
                <div>
                    <h3 class="app-modal-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:#0F172A;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Detail Hasil Pemeliharaan Perangkat</span>
                    </h3>
                    <div class="app-modal-subtitle" x-text="(detailItem ? detailItem.perangkat_nama : '') + ' • ' + (detailItem ? detailItem.tanggal_formatted : '')"></div>
                </div>
                <button type="button" class="app-modal-close" @click="showDetailModal = false" aria-label="Tutup">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="app-modal-body" x-show="detailItem">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                    <!-- Informasi Umum -->
                    <div>
                        <table style="width: 100%; font-size: 12.5px; border-collapse: collapse;">
                            <tbody>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B; width: 42%;">Perangkat</td>
                                    <td style="padding: 8px 0; font-weight: 600; color: #0F172A;" x-text="detailItem?.perangkat_nama"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Kode Unit</td>
                                    <td style="padding: 8px 0;">
                                        <span class="code-pill" x-text="detailItem?.perangkat_kode"></span>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Lokasi / Rack</td>
                                    <td style="padding: 8px 0; color: #334155;" x-text="detailItem?.lokasi"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Tanggal</td>
                                    <td style="padding: 8px 0; font-weight: 500;" x-text="detailItem?.tanggal_formatted"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Periode</td>
                                    <td style="padding: 8px 0;" x-text="detailItem?.periode"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Teknisi</td>
                                    <td style="padding: 8px 0; font-weight: 600;" x-text="detailItem?.teknisi"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Status</td>
                                    <td style="padding: 8px 0;">
                                        <span class="badge" :class="detailItem?.badge_status" x-text="detailItem?.status"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="margin-top: 14px; padding: 12px; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px;">
                            <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase; margin-bottom: 4px;">
                                Catatan Teknisi
                            </div>
                            <div style="font-size: 12px; color: #1E293B; line-height: 1.4;" x-text="detailItem?.keterangan"></div>
                        </div>

                        <!-- Eviden Foto -->
                        <template x-if="detailItem?.eviden_url">
                            <div style="margin-top: 14px; text-align: center;">
                                <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase; margin-bottom: 6px; text-align: left;">
                                    Dokumentasi Eviden
                                </div>
                                <a :href="detailItem.eviden_url" target="_blank">
                                    <img :src="detailItem.eviden_url" alt="Eviden" style="width: 100%; max-height: 160px; object-fit: cover; border-radius: 4px; border: 1px solid #CBD5E1;">
                                </a>
                            </div>
                        </template>
                    </div>

                    <!-- Checklist Audit -->
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <div style="font-size: 11.5px; font-weight: 700; color: #0F172A; text-transform: uppercase;">
                                Item Checklist
                            </div>
                            <span class="badge badge-success" x-text="(detailItem ? detailItem.checklist_selesai : 0) + '/' + (detailItem ? detailItem.checklist_total : 0) + ' Selesai'"></span>
                        </div>

                        <div style="max-height: 380px; overflow-y: auto; padding-right: 4px;">
                            <template x-for="(c, cidx) in (detailItem?.checklist || [])" :key="cidx">
                                <div class="checklist-item-row" :class="{ 'is-checked': c.checked }" style="padding: 8px 10px; margin-bottom: 6px;">
                                    <svg x-show="c.checked" fill="none" stroke="#16A34A" viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <svg x-show="!c.checked" fill="none" stroke="#94A3B8" viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px;">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                    </svg>
                                    <div style="flex: 1;">
                                        <div style="font-size: 12px; font-weight: 600; color: #0F172A;" x-text="c.item"></div>
                                        <div x-show="c.catatan" style="font-size: 11px; color: #64748B; margin-top: 2px;" x-text="c.catatan"></div>
                                    </div>
                                </div>
                            </template>
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
                    <span>Ubah Catatan</span>
                </button>
                <button type="button" class="btn btn-dark btn-sm" @click="showDetailModal = false">Tutup</button>
            </div>
        </div>
    </div>

    </div> <!-- End x-data -->
</x-app-layout>
