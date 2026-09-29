<x-app-layout>
    <x-slot name="title">Laporan Checklist Pemeriksaan</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('laporan.index') }}" style="color: #64748B; text-decoration: none;">Pusat Laporan</a> / Audit Checklist
            </div>
            <h2 class="page-heading-title">Laporan Audit Checklist Pemeriksaan</h2>
            <div class="page-heading-desc">Verifikasi kepatuhan teknis dan hasil inspeksi butir checklist perangkat STO Witel Base-G</div>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('laporan.cetak', 'checklist') }}?{{ http_build_query(request()->all()) }}"
               target="_blank" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Export PDF</span>
            </a>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Filter Toolbar -->
    <form method="GET" action="{{ route('laporan.checklist') }}">
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
                <a href="{{ route('laporan.checklist') }}" class="btn btn-secondary">
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Checklist Audit Table -->
    <div class="card">
        <div class="card-header card-header-subtle">
            <div>
                <h3 class="card-title">Daftar Audit Checklist Pemeliharaan</h3>
                <div class="card-subtitle">Menampilkan {{ $maintenances->total() }} audit verifikasi teknis</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="app-table">
                <thead>
                    <tr>
                        <th style="width: 35px;">#</th>
                        <th>Tanggal</th>
                        <th>Perangkat Target</th>
                        <th>Teknisi</th>
                        <th>Kepatuhan Checklist</th>
                        <th>Rincian Item yang Diperiksa</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenances as $index => $m)
                    <tr>
                        <td style="color: #64748B;">{{ $maintenances->firstItem() + $index }}</td>
                        <td style="white-space: nowrap; font-weight: 500;">
                            {{ $m->tanggal->format('d/m/Y') }}
                            <div style="font-size: 11px; color: #64748B;">{{ $m->periode }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $m->perangkat->nama_perangkat ?? '-' }}</div>
                            <span class="code-pill">{{ $m->perangkat->kode_perangkat ?? '-' }}</span>
                        </td>
                        <td>
                            <span style="font-weight: 500;">{{ $m->user->name ?? '-' }}</span>
                        </td>
                        <td>
                            @if($m->checklist_total > 0)
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <div style="width: 60px; background-color: #E2E8F0; height: 5px; border-radius: 3px; overflow: hidden;">
                                    <div style="width: {{ ($m->checklist_selesai / $m->checklist_total) * 100 }}%; height: 100%; background-color: #16A34A;"></div>
                                </div>
                                <span style="font-size: 11.5px; font-weight: 600; color: #166534;">
                                    {{ $m->checklist_selesai }}/{{ $m->checklist_total }} ({{ round(($m->checklist_selesai / $m->checklist_total) * 100) }}%)
                                </span>
                            </div>
                            @else
                            <span style="color: #94A3B8;">-</span>
                            @endif
                        </td>
                        <td>
                            @if(is_array($m->checklist))
                            <div style="font-size: 11.5px; line-height: 1.4; max-width: 400px;">
                                @foreach(array_slice($m->checklist, 0, 3) as $cl)
                                <div style="display: flex; align-items: center; gap: 4px; color: {{ !empty($cl['checked']) ? '#166534' : '#94A3B8' }};">
                                    <span>{{ !empty($cl['checked']) ? '✓' : '✗' }}</span>
                                    <span>{{ $cl['item'] }}</span>
                                </div>
                                @endforeach
                                @if(count($m->checklist) > 3)
                                <span style="color: #64748B; font-size: 11px;">+ {{ count($m->checklist) - 3 }} item lainnya...</span>
                                @endif
                            </div>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('maintenance.show', $m) }}" class="btn btn-action-view btn-sm">
                                <span>Detail</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #64748B; padding: 36px;">
                            Tidak ada data checklist maintenance yang tercatat.
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
