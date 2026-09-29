<x-app-layout>
    <x-slot name="title">Galeri Eviden Maintenance</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('laporan.index') }}" style="color: #64748B; text-decoration: none;">Pusat Laporan</a> / Galeri Eviden
            </div>
            <h2 class="page-heading-title">Galeri Dokumentasi Eviden Lapangan</h2>
            <div class="page-heading-desc">Arsip bukti visual pelaksanaan pemeliharaan infrastruktur STO Witel Base-G</div>
        </div>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Laporan</span>
        </a>
    </div>

    <!-- Filter Toolbar -->
    <form method="GET" action="{{ route('laporan.eviden') }}">
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
                <a href="{{ route('laporan.eviden') }}" class="btn btn-secondary">
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Gallery Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; margin-bottom: 24px;">
        @forelse($maintenances as $m)
        <div class="card" style="margin-bottom: 0; overflow: hidden; display: flex; flex-direction: column;">
            <a href="{{ Storage::url($m->eviden) }}" target="_blank"
               style="display: block; height: 160px; background-color: #F1F5F9; border-bottom: 1px solid #E2E8F0; overflow: hidden; position: relative;">
                <img src="{{ Storage::url($m->eviden) }}" alt="Eviden"
                     style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.2s;"
                     onmouseover="this.style.transform='scale(1.03)'"
                     onmouseout="this.style.transform='scale(1)'">
                <span class="badge {{ $m->badge_status }}"
                      style="position: absolute; top: 8px; right: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                    {{ $m->status }}
                </span>
            </a>
            <div style="padding: 12px 14px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="font-weight: 600; font-size: 13px; color: #0F172A; margin-bottom: 2px;">
                        {{ $m->perangkat->nama_perangkat ?? '-' }}
                    </div>
                    <div style="font-size: 11px; color: #64748B; margin-bottom: 8px;">
                        <span class="code-pill">{{ $m->perangkat->kode_perangkat ?? '-' }}</span>
                        <span>• {{ $m->tanggal->format('d/m/Y') }}</span>
                    </div>
                    <div style="font-size: 11.5px; color: #475569; line-height: 1.3;">
                        Teknisi: <strong>{{ $m->user->name ?? '-' }}</strong>
                    </div>
                </div>
                <div style="margin-top: 12px; padding-top: 8px; border-top: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 11px; color: #64748B;">{{ $m->periode }}</span>
                    <a href="{{ route('maintenance.show', $m) }}" class="btn btn-action-view btn-sm">
                        <span>Lihat Detail</span>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="card" style="grid-column: 1 / -1; padding: 48px; text-align: center; color: #64748B;">
            Belum ada dokumentasi foto eviden yang tersimpan.
        </div>
        @endforelse
    </div>

    @if($maintenances->hasPages())
    <div class="card">
        <div class="card-body" style="padding: 12px 18px;">
            {{ $maintenances->links() }}
        </div>
    </div>
    @endif
</x-app-layout>
