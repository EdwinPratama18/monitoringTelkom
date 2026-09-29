<x-app-layout>
    <x-slot name="title">Detail Perangkat — {{ $perangkat->kode_perangkat }}</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('perangkat.index') }}" style="color: #64748B; text-decoration: none;">Data Perangkat</a> / Detail
            </div>
            <h2 class="page-heading-title">{{ $perangkat->nama_perangkat }}</h2>
            <div class="page-heading-desc">
                <span class="code-pill">{{ $perangkat->kode_perangkat }}</span>
                <span>• {{ $perangkat->jenis_perangkat }} • {{ $perangkat->lokasi }}</span>
            </div>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('maintenance.create') }}?perangkat_id={{ $perangkat->id }}" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Input Maintenance</span>
            </a>
            <a href="{{ route('perangkat.edit', $perangkat) }}" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                <span>Edit</span>
            </a>
            <a href="{{ route('perangkat.index') }}" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 18px;">
        <!-- Left: Device Specification Dossier -->
        <div class="card" style="align-self: start;">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Spesifikasi Teknis</h3>
                    <div class="card-subtitle">Data inventaris perangkat</div>
                </div>
            </div>

            <!-- Device Photo or Fallback -->
            @if($perangkat->foto)
            <div style="border-bottom: 1px solid #E2E8F0; background-color: #F8FAFC; text-align: center;">
                <img src="{{ Storage::url($perangkat->foto) }}" alt="{{ $perangkat->nama_perangkat }}"
                     style="width: 100%; max-height: 220px; object-fit: cover; display: block;">
            </div>
            @else
            <div style="padding: 24px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94A3B8;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 38px; height: 38px; margin-bottom: 6px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                </svg>
                <span style="font-size: 11.5px;">Foto fisik perangkat belum diunggah</span>
            </div>
            @endif

            <div class="card-body" style="padding: 0;">
                <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                    <tbody>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B; width: 40%;">Kode Perangkat</td>
                            <td style="padding: 10px 16px;">
                                <span class="code-pill">{{ $perangkat->kode_perangkat }}</span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B;">Jenis Perangkat</td>
                            <td style="padding: 10px 16px; font-weight: 500;">{{ $perangkat->jenis_perangkat }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B;">Merk / Brand</td>
                            <td style="padding: 10px 16px;">{{ $perangkat->merk ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B;">Model / Seri</td>
                            <td style="padding: 10px 16px;">{{ $perangkat->model ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B;">Serial Number</td>
                            <td style="padding: 10px 16px; font-family: monospace; font-size: 12px;">{{ $perangkat->no_seri ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B;">Lokasi Penempatan</td>
                            <td style="padding: 10px 16px;">{{ $perangkat->lokasi }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B;">Ruangan</td>
                            <td style="padding: 10px 16px;">{{ $perangkat->ruangan ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B;">Tanggal Pasang</td>
                            <td style="padding: 10px 16px;">{{ $perangkat->tanggal_install?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B;">Kondisi Teknis</td>
                            <td style="padding: 10px 16px;">
                                <span class="badge {{ $perangkat->badge_kondisi }}">
                                    <span class="badge-dot"></span>
                                    {{ $perangkat->kondisi }}
                                </span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 10px 16px; color: #64748B;">Status Operasi</td>
                            <td style="padding: 10px 16px;">
                                <span class="badge {{ $perangkat->badge_status }}">
                                    <span class="badge-dot"></span>
                                    {{ $perangkat->status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if($perangkat->keterangan)
                <div style="padding: 14px 16px; background-color: #F8FAFC; border-top: 1px solid #E2E8F0;">
                    <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase; margin-bottom: 4px;">
                        Keterangan & Catatan Operasional
                    </div>
                    <div style="font-size: 12.5px; color: #334155; line-height: 1.4;">
                        {{ $perangkat->keterangan }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Maintenance History Ledger -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Riwayat Maintenance Perangkat</h3>
                    <div class="card-subtitle">Catatan pekerjaan pemeliharaan yang telah dilakukan pada perangkat ini</div>
                </div>
                <a href="{{ route('maintenance.create') }}?perangkat_id={{ $perangkat->id }}" class="btn btn-primary btn-sm">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Input Maintenance</span>
                </a>
            </div>

            <div class="table-responsive">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Periode</th>
                            <th>Teknisi</th>
                            <th>Checklist</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $m)
                        <tr>
                            <td>
                                <span style="font-weight: 600; color: #0F172A;">{{ $m->tanggal->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <span style="font-size: 12px; color: #475569;">{{ $m->periode }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 500;">{{ $m->user->name ?? '-' }}</span>
                            </td>
                            <td>
                                @if($m->checklist_total > 0)
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="flex: 1; min-width: 60px; max-width: 90px; background-color: #E2E8F0; height: 5px; border-radius: 3px; overflow: hidden;">
                                        <div style="width: {{ ($m->checklist_selesai / $m->checklist_total) * 100 }}%; height: 100%; background-color: #16A34A;"></div>
                                    </div>
                                    <span style="font-size: 11.5px; color: #64748B;">{{ $m->checklist_selesai }}/{{ $m->checklist_total }}</span>
                                </div>
                                @else
                                <span style="color: #94A3B8; font-size: 12px;">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $m->badge_status }}">
                                    <span class="badge-dot"></span>
                                    {{ $m->status }}
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
                            <td colspan="6" style="text-align: center; color: #64748B; padding: 36px;">
                                Belum ada riwayat kegiatan maintenance untuk perangkat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($riwayat->hasPages())
            <div class="card-footer">
                {{ $riwayat->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
