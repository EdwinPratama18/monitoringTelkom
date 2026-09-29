<x-app-layout>
    <x-slot name="title">Laporan Maintenance Perangkat</x-slot>

    <!-- Document Header Row -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('laporan.index') }}" style="color: #64748B; text-decoration: none;">Pusat Laporan</a> / Rekap Maintenance
            </div>
            <h2 class="page-heading-title">Laporan Rekapitulasi Maintenance Perangkat</h2>
            <div class="page-heading-desc">Dokumen rekap operasional kegiatan pemeliharaan infrastruktur STO Witel Base-G</div>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('laporan.cetak', 'maintenance') }}?{{ http_build_query(request()->all()) }}"
               target="_blank" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Export Dokumen PDF</span>
            </a>
            <button type="button" onclick="window.print()" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Print</span>
            </button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Summary Metrics Strip -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 18px;">
        <div class="metric-card metric-border-primary">
            <div class="metric-label">Total Kegiatan Terfilter</div>
            <div class="metric-value">{{ $maintenances->total() }}</div>
            <div class="metric-subtext">Catatan pemeliharaan terverifikasi</div>
        </div>
        <div class="metric-card metric-border-success">
            <div class="metric-label">Status Selesai</div>
            <div class="metric-value" style="color: #16A34A;">{{ $totalSelesai }}</div>
            <div class="metric-subtext">Pekerjaan berhasil diselesaikan</div>
        </div>
        <div class="metric-card metric-border-warning">
            <div class="metric-label">Dalam Proses / Dijadwalkan</div>
            <div class="metric-value" style="color: #D97706;">{{ max(0, $maintenances->total() - $totalSelesai) }}</div>
            <div class="metric-subtext">Kegiatan dalam antrean teknisi</div>
        </div>
    </div>

    <!-- Filter Toolbar -->
    <form method="GET" action="{{ route('laporan.maintenance') }}">
        <div class="filter-toolbar">
            <div class="filter-item">
                <label class="form-label">Periode Bulan</label>
                <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
            </div>
            <div class="filter-item">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
            </div>
            <div class="filter-item">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
            </div>
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
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    @foreach(['Dijadwalkan','Dalam Proses','Selesai','Ditunda'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; gap: 6px; align-items: flex-end;">
                <button type="submit" class="btn btn-dark">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter Data</span>
                </button>
                <a href="{{ route('laporan.maintenance') }}" class="btn btn-secondary">
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Formal Operational Report Table -->
    <div class="card">
        <div class="card-header card-header-subtle">
            <div>
                <h3 class="card-title">Tabel Rekapitulasi Pelaksanaan Maintenance</h3>
                <div class="card-subtitle">Data resmi terdaftar pada database sistem STO Witel Base-G</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="app-table">
                <thead>
                    <tr>
                        <th style="width: 35px;">#</th>
                        <th>Tanggal</th>
                        <th>Perangkat Target</th>
                        <th>Lokasi</th>
                        <th>Periode</th>
                        <th>Teknisi Pelaksana</th>
                        <th>Checklist</th>
                        <th>Status</th>
                        <th>Keterangan / Temuan</th>
                        <th style="text-align: right; width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenances as $index => $m)
                    <tr>
                        <td style="color: #64748B;">{{ $maintenances->firstItem() + $index }}</td>
                        <td style="white-space: nowrap; font-weight: 500;">
                            {{ $m->tanggal->format('d/m/Y') }}
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $m->perangkat->nama_perangkat ?? '-' }}</div>
                            <div style="font-size: 11px; color: #64748B; margin-top: 1px;">
                                <span class="code-pill">{{ $m->perangkat->kode_perangkat ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 12px; color: #334155;">{{ $m->perangkat->lokasi ?? '-' }}</span>
                        </td>
                        <td>
                            <span style="font-size: 11.5px; background-color: #F1F5F9; border: 1px solid #E2E8F0; padding: 2px 6px; border-radius: 4px; color: #334155;">
                                {{ $m->periode }}
                            </span>
                        </td>
                        <td>
                            <span style="font-weight: 500;">{{ $m->user->name ?? '-' }}</span>
                        </td>
                        <td>
                            @if($m->checklist_total > 0)
                            <span style="font-size: 11.5px; font-weight: 600; color: {{ $m->checklist_selesai == $m->checklist_total ? '#16A34A' : '#D97706' }};">
                                {{ $m->checklist_selesai }}/{{ $m->checklist_total }}
                            </span>
                            @else
                            <span style="color: #94A3B8;">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $m->badge_status }}">
                                <span class="badge-dot"></span>
                                {{ $m->status }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 12px; color: #475569;">
                                {{ Str::limit($m->keterangan ?? '-', 50) }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('maintenance.show', $m) }}" class="btn btn-action-view btn-sm">
                                <span>Detail</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="text-align: center; color: #64748B; padding: 36px;">
                            Tidak ada data kegiatan maintenance yang memenuhi kriteria filter.
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
</x-app-layout>
