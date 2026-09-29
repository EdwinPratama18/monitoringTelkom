<x-app-layout>
    <x-slot name="title">Dashboard Monitoring</x-slot>

    <div x-data="{
        showCreateModal: false,
        showDetailModal: false,
        activeDetail: null,
        openDetail(maint) {
            this.activeDetail = maint;
            this.showDetailModal = true;
        }
    }">

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span class="badge badge-info" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Network Operations Center</span>
                <span style="font-size: 11.5px; color: #64748B;">STO WITEL BASE-G JAYAPURA</span>
            </div>
            <h2 class="page-heading-title" style="font-size: 20px;">Sistem Monitoring & Pemeliharaan Infrastruktur</h2>
            <div class="page-heading-desc">Telemetri status kelistrikan (PLN & Genset DEFA), rectifiers, baterai, perangkat transmisi DWDM, dan routing STO</div>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <a href="{{ route('perangkat.index') }}" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span>Daftar Perangkat</span>
            </a>
            <button type="button" @click="showCreateModal = true" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Input Maintenance (Modal)</span>
            </button>
        </div>
    </div>

    <!-- Operational Incident Alert (if any damaged devices exist) -->
    @if($perangkatRusakList->isNotEmpty())
    <div class="app-alert app-alert-danger" style="flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 22px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 600;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Peringatan Operasional: Ditemukan {{ $perangkatRusak }} perangkat dengan kondisi tidak optimal</span>
            </div>
            <span style="font-size: 11.5px; color: #991B1B; font-weight: 500;">Harap segera dilakukan tindakan perbaikan</span>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
            @foreach($perangkatRusakList as $p)
            <a href="{{ route('perangkat.show', $p) }}"
               style="background-color: #FFFFFF; border: 1px solid #FECACA; padding: 5px 10px; border-radius: 4px; font-size: 12px; color: #991B1B; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span class="code-pill" style="font-size: 10.5px; border-color: #FECACA;">{{ $p->kode_perangkat }}</span>
                <span style="font-weight: 600;">{{ $p->nama_perangkat }}</span>
                <span>({{ $p->lokasi }})</span>
                <span class="badge {{ $p->badge_kondisi }}" style="font-size: 10px; padding: 1px 5px;">{{ $p->kondisi }}</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- KPI Metrics Grid (5 Distinct Metrics) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 14px; margin-bottom: 22px;">
        <!-- 1. Total Perangkat -->
        <div class="metric-card metric-border-primary">
            <div class="metric-header">
                <span class="metric-label">Total Perangkat</span>
                <div class="metric-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
            </div>
            <div class="metric-value">{{ $totalPerangkat }}</div>
            <div class="metric-subtext">
                <span>Unit infrastruktur terdaftar di STO</span>
            </div>
        </div>

        <!-- 2. Kondisi Baik -->
        <div class="metric-card metric-border-success">
            <div class="metric-header">
                <span class="metric-label">Kondisi Baik</span>
                <div class="metric-icon-wrap" style="background-color: #F0FDF4; color: #16A34A;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="metric-value" style="color: #16A34A;">{{ $perangkatBaik }}</div>
            <div class="metric-subtext">
                <span class="badge badge-success" style="padding: 1px 6px;">
                    {{ $totalPerangkat > 0 ? round(($perangkatBaik / $totalPerangkat) * 100) : 0 }}%
                </span>
                <span>Beroperasi normal</span>
            </div>
        </div>

        <!-- 3. Rusak Ringan -->
        <div class="metric-card metric-border-warning">
            <div class="metric-header">
                <span class="metric-label">Rusak Ringan</span>
                <div class="metric-icon-wrap" style="background-color: #FFFBEB; color: #D97706;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="metric-value" style="color: #D97706;">{{ $kondisiData[1] ?? 0 }}</div>
            <div class="metric-subtext">
                <span>Perlu tindakan maintenance</span>
            </div>
        </div>

        <!-- 4. Rusak Berat -->
        <div class="metric-card metric-border-danger">
            <div class="metric-header">
                <span class="metric-label">Rusak Berat</span>
                <div class="metric-icon-wrap" style="background-color: #FEF2F2; color: #DC2626;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="metric-value" style="color: #DC2626;">{{ $kondisiData[2] ?? 0 }}</div>
            <div class="metric-subtext">
                <span>Prioritas penanganan teknisi</span>
            </div>
        </div>

        <!-- 5. Maintenance Selesai -->
        <div class="metric-card metric-border-telkom">
            <div class="metric-header">
                <span class="metric-label">Maintenance Selesai</span>
                <div class="metric-icon-wrap" style="background-color: #FEF2F2; color: var(--telkom-red);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
            <div class="metric-value" style="color: var(--telkom-red);">{{ $maintenanceSelesai }}</div>
            <div class="metric-subtext">
                <span>Dari total {{ $totalMaintenance }} kegiatan maintenance</span>
            </div>
        </div>
    </div>

    <!-- DEDICATED MONITORING SECTION (#monitoring) -->
    <section id="monitoring" style="margin-bottom: 22px;">
        <div class="card">
            <div class="card-header card-header-subtle">
                <div>
                    <h3 class="card-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 17px; height: 17px; color: #475569;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Monitoring Status & Kesiapan Perangkat STO</span>
                    </h3>
                    <div class="card-subtitle">Pemantauan visual status operasional dan kondisi fisik perangkat infrastruktur telekomunikasi</div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('perangkat.index') }}?kondisi=Baik" class="btn btn-action-view btn-sm">Filter Baik</a>
                    <a href="{{ route('perangkat.index') }}?kondisi=Rusak+Ringan" class="btn btn-action-view btn-sm">Filter Rusak</a>
                </div>
            </div>
            <div class="card-body">
                <!-- Status Matrix Cards -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;">
                    <!-- Panel Baik -->
                    <div style="border: 1px solid #E2E8F0; border-radius: 6px; padding: 14px; background-color: #FFFFFF;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <span class="badge badge-success">
                                <span class="badge-dot"></span>
                                Kondisi: Baik
                            </span>
                            <span style="font-size: 16px; font-weight: 700; color: #16A34A;">{{ $kondisiData[0] ?? 0 }} Unit</span>
                        </div>
                        <p style="font-size: 12px; color: #64748B; margin: 0; line-height: 1.4;">
                            Perangkat beroperasi secara optimal, tidak ditemukan anomali parameter daya, suhu ruang, maupun transmisi optik.
                        </p>
                    </div>

                    <!-- Panel Rusak Ringan -->
                    <div style="border: 1px solid #E2E8F0; border-radius: 6px; padding: 14px; background-color: #FFFFFF;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <span class="badge badge-warning">
                                <span class="badge-dot"></span>
                                Kondisi: Rusak Ringan
                            </span>
                            <span style="font-size: 16px; font-weight: 700; color: #D97706;">{{ $kondisiData[1] ?? 0 }} Unit</span>
                        </div>
                        <p style="font-size: 12px; color: #64748B; margin: 0; line-height: 1.4;">
                            Perangkat mengalami degradasi minor seperti kabel patching kendur, fan pendingin bising, atau filter debu kotor.
                        </p>
                    </div>

                    <!-- Panel Rusak Berat -->
                    <div style="border: 1px solid #E2E8F0; border-radius: 6px; padding: 14px; background-color: #FFFFFF;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <span class="badge badge-danger">
                                <span class="badge-dot"></span>
                                Kondisi: Rusak Berat
                            </span>
                            <span style="font-size: 16px; font-weight: 700; color: #DC2626;">{{ $kondisiData[2] ?? 0 }} Unit</span>
                        </div>
                        <p style="font-size: 12px; color: #64748B; margin: 0; line-height: 1.4;">
                            Perangkat padam / offline atau modul board utama mengalami kegagalan fungsi. Memerlukan pergantian unit segera.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Operational Telemetry Charts Row -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 18px; margin-bottom: 22px;">
        <!-- Chart 1: Maintenance per Bulan -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Tren Aktivitas Maintenance (12 Bulan Terakhir)</h3>
                    <div class="card-subtitle">Frekuensi kegiatan pemeliharaan perangkat per periode bulanan</div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="chartMaintenance" height="175"></canvas>
            </div>
        </div>

        <!-- Chart 2: Proporsi Kondisi Perangkat -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Distribusi Kondisi</h3>
                    <div class="card-subtitle">Rasio kelayakan unit perangkat</div>
                </div>
            </div>
            <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div style="position: relative; width: 100%; max-width: 220px;">
                    <canvas id="chartKondisi" height="190"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Operational Tables Row: Maintenance Terbaru & Distribusi Jenis -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 18px;">
        <!-- Maintenance Terbaru -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Maintenance Terbaru</h3>
                    <div class="card-subtitle">Log 5 kegiatan pemeliharaan perangkat paling mutakhir</div>
                </div>
                <a href="{{ route('maintenance.index') }}" class="btn btn-secondary btn-sm">
                    <span>Lihat Semua</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="table-responsive">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Perangkat</th>
                            <th>Teknisi</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th style="text-align: right; width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenanceTerbaru as $m)
                        <tr>
                            <td style="white-space: nowrap;">
                                <span style="font-weight: 500; color: #1E293B;">{{ $m->tanggal->format('d/m/Y') }}</span>
                                <div style="font-size: 11px; color: #64748B;">{{ $m->periode }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #0F172A;">{{ $m->perangkat->nama_perangkat ?? '-' }}</div>
                                <div style="font-size: 11px; color: #64748B; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                    <span class="code-pill">{{ $m->perangkat->kode_perangkat ?? '' }}</span>
                                    <span>• {{ $m->perangkat->lokasi ?? '' }}</span>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 500;">{{ $m->user->name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $m->badge_status }}">
                                    <span class="badge-dot"></span>
                                    {{ $m->status }}
                                </span>
                            </td>
                            <td>
                                <span style="font-size: 12px; color: #475569;">
                                    {{ Str::limit($m->keterangan ?? '-', 45) }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <button type="button"
                                        @click="openDetail({{ json_encode([
                                            'id' => $m->id,
                                            'perangkat_nama' => $m->perangkat->nama_perangkat ?? '-',
                                            'perangkat_kode' => $m->perangkat->kode_perangkat ?? '-',
                                            'lokasi' => ($m->perangkat->lokasi ?? '-') . ($m->perangkat->ruangan ? ' / ' . $m->perangkat->ruangan : ''),
                                            'tanggal' => $m->tanggal->translatedFormat('d F Y'),
                                            'periode' => $m->periode,
                                            'teknisi' => $m->user->name ?? '-',
                                            'status' => $m->status,
                                            'badge_status' => $m->badge_status,
                                            'keterangan' => $m->keterangan ?? '-',
                                            'eviden_url' => $m->eviden ? Storage::url($m->eviden) : null,
                                            'checklist' => $m->checklist ?? [],
                                            'checklist_selesai' => $m->checklist_selesai,
                                            'checklist_total' => $m->checklist_total,
                                            'edit_url' => route('maintenance.edit', $m)
                                        ]) }})"
                                        class="btn btn-action-view btn-sm">
                                    <span>Detail</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #64748B; padding: 28px;">
                                Belum ada riwayat kegiatan maintenance yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Distribusi Jenis Perangkat -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Jenis Perangkat</h3>
                    <div class="card-subtitle">Klasifikasi kategori infrastruktur</div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="chartJenis" height="230"></canvas>
            </div>
        </div>
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
                    <div class="app-modal-subtitle">Pencatatan pemeriksaan fisik, parameter kelistrikan/jaringan & checklist teknisi</div>
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
                                1. Target & Penugasan
                            </div>

                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Pilih Perangkat Target <span style="color: #DC2626;">*</span></label>
                                <select name="perangkat_id" class="form-control" required>
                                    <option value="">-- Pilih Perangkat Infrastruktur --</option>
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
                                          placeholder="Catat parameter voltase, amper, suhu, anomali, atau tindakan yang telah dilakukan..."></textarea>
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

    <!-- ===== MODAL 2: DETAIL MAINTENANCE ===== -->
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
                    <div class="app-modal-subtitle" x-text="(activeDetail ? activeDetail.perangkat_nama : '') + ' • ' + (activeDetail ? activeDetail.tanggal : '')"></div>
                </div>
                <button type="button" class="app-modal-close" @click="showDetailModal = false" aria-label="Tutup">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="app-modal-body" x-show="activeDetail">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                    <!-- Informasi Umum -->
                    <div>
                        <table style="width: 100%; font-size: 12.5px; border-collapse: collapse;">
                            <tbody>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B; width: 42%;">Perangkat</td>
                                    <td style="padding: 8px 0; font-weight: 600; color: #0F172A;" x-text="activeDetail?.perangkat_nama"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Kode Unit</td>
                                    <td style="padding: 8px 0;">
                                        <span class="code-pill" x-text="activeDetail?.perangkat_kode"></span>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Lokasi / Rack</td>
                                    <td style="padding: 8px 0; color: #334155;" x-text="activeDetail?.lokasi"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Tanggal</td>
                                    <td style="padding: 8px 0; font-weight: 500;" x-text="activeDetail?.tanggal"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Periode</td>
                                    <td style="padding: 8px 0;" x-text="activeDetail?.periode"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Teknisi</td>
                                    <td style="padding: 8px 0; font-weight: 600;" x-text="activeDetail?.teknisi"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 8px 0; color: #64748B;">Status</td>
                                    <td style="padding: 8px 0;">
                                        <span class="badge" :class="activeDetail?.badge_status" x-text="activeDetail?.status"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="margin-top: 14px; padding: 12px; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px;">
                            <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase; margin-bottom: 4px;">
                                Catatan Teknisi
                            </div>
                            <div style="font-size: 12px; color: #1E293B; line-height: 1.4;" x-text="activeDetail?.keterangan"></div>
                        </div>

                        <!-- Eviden Foto -->
                        <template x-if="activeDetail?.eviden_url">
                            <div style="margin-top: 14px; text-align: center;">
                                <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase; margin-bottom: 6px; text-align: left;">
                                    Dokumentasi Eviden
                                </div>
                                <a :href="activeDetail.eviden_url" target="_blank">
                                    <img :src="activeDetail.eviden_url" alt="Eviden" style="width: 100%; max-height: 160px; object-fit: cover; border-radius: 4px; border: 1px solid #CBD5E1;">
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
                            <span class="badge badge-success" x-text="(activeDetail ? activeDetail.checklist_selesai : 0) + '/' + (activeDetail ? activeDetail.checklist_total : 0) + ' Selesai'"></span>
                        </div>

                        <div style="max-height: 380px; overflow-y: auto; padding-right: 4px;">
                            <template x-for="(c, cidx) in (activeDetail?.checklist || [])" :key="cidx">
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
                <a :href="activeDetail?.edit_url" class="btn btn-secondary btn-sm">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span>Ubah Catatan</span>
                </a>
                <button type="button" class="btn btn-dark btn-sm" @click="showDetailModal = false">Tutup</button>
            </div>
        </div>
    </div>

    </div> <!-- End x-data -->

    <!-- Chart.js Configuration -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart 1: Maintenance Bulanan
            const ctxMaint = document.getElementById('chartMaintenance');
            if (ctxMaint) {
                new Chart(ctxMaint, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($bulanLabels) !!},
                        datasets: [{
                            label: 'Jumlah Kegiatan',
                            data: {!! json_encode($bulanData) !!},
                            backgroundColor: '#C91F18',
                            hoverBackgroundColor: '#9F1610',
                            borderRadius: 3,
                            maxBarThickness: 28
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0F172A',
                                titleFont: { size: 12, family: 'Inter' },
                                bodyFont: { size: 12, family: 'Inter' },
                                padding: 8,
                                cornerRadius: 4
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, font: { size: 11, family: 'Inter' }, color: '#64748B' },
                                grid: { color: '#F1F5F9' }
                            },
                            x: {
                                ticks: { font: { size: 11, family: 'Inter' }, color: '#64748B' },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // Chart 2: Kondisi Perangkat
            const ctxKondisi = document.getElementById('chartKondisi');
            if (ctxKondisi) {
                new Chart(ctxKondisi, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($kondisiLabels) !!},
                        datasets: [{
                            data: {!! json_encode($kondisiData) !!},
                            backgroundColor: ['#16A34A', '#D97706', '#DC2626'],
                            borderWidth: 2,
                            borderColor: '#FFFFFF'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 10,
                                    padding: 12,
                                    font: { size: 11, family: 'Inter' },
                                    color: '#475569'
                                }
                            }
                        }
                    }
                });
            }

            // Chart 3: Jenis Perangkat
            const ctxJenis = document.getElementById('chartJenis');
            if (ctxJenis) {
                const jenisLabels = {!! json_encode($jenisData->keys()) !!};
                const jenisDataVals = {!! json_encode($jenisData->values()) !!};
                new Chart(ctxJenis, {
                    type: 'bar',
                    data: {
                        labels: jenisLabels,
                        datasets: [{
                            data: jenisDataVals,
                            backgroundColor: '#334155',
                            borderRadius: 3,
                            maxBarThickness: 18
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        plugins: { legend: { display: false } },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, font: { size: 11, family: 'Inter' }, color: '#64748B' },
                                grid: { color: '#F1F5F9' }
                            },
                            y: {
                                ticks: { font: { size: 11, family: 'Inter' }, color: '#334155' },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>