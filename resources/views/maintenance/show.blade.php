<x-app-layout>
    <x-slot name="title">Laporan Maintenance — {{ $maintenance->tanggal->format('d/m/Y') }}</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('maintenance.index') }}" style="color: #64748B; text-decoration: none;">Maintenance</a> / Detail
            </div>
            <h2 class="page-heading-title">Detail Hasil Maintenance</h2>
            <div class="page-heading-desc">
                <span>{{ $maintenance->perangkat->nama_perangkat ?? '-' }}</span>
                <span>• Pelaksanaan: {{ $maintenance->tanggal->translatedFormat('d F Y') }}</span>
            </div>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('maintenance.edit', $maintenance) }}" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                <span>Edit Data</span>
            </a>
            <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
        <!-- Left: Ringkasan Informasi & Eviden -->
        <div style="display: flex; flex-direction: column; gap: 18px;">
            <!-- Informasi Pekerjaan Card -->
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Informasi Pelaksanaan</h3>
                        <div class="card-subtitle">Data teknis penugasan pemeliharaan</div>
                    </div>
                </div>
                <div class="card-body" style="padding: 0;">
                    <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <tbody>
                            <tr style="border-bottom: 1px solid #F1F5F9;">
                                <td style="padding: 10px 16px; color: #64748B; width: 40%;">Perangkat Target</td>
                                <td style="padding: 10px 16px;">
                                    <a href="{{ route('perangkat.show', $maintenance->perangkat_id) }}"
                                       style="font-weight: 600; color: #0F172A; text-decoration: none;">
                                        {{ $maintenance->perangkat->nama_perangkat ?? '-' }}
                                    </a>
                                    <div style="font-size: 11px; color: #64748B; margin-top: 1px;">
                                        <span class="code-pill">{{ $maintenance->perangkat->kode_perangkat ?? '-' }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #F1F5F9;">
                                <td style="padding: 10px 16px; color: #64748B;">Lokasi & Ruangan</td>
                                <td style="padding: 10px 16px; color: #334155;">
                                    {{ $maintenance->perangkat->lokasi ?? '-' }}
                                    @if(!empty($maintenance->perangkat->ruangan))
                                    / {{ $maintenance->perangkat->ruangan }}
                                    @endif
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #F1F5F9;">
                                <td style="padding: 10px 16px; color: #64748B;">Tanggal Selesai</td>
                                <td style="padding: 10px 16px; font-weight: 500;">
                                    {{ $maintenance->tanggal->format('d/m/Y') }}
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #F1F5F9;">
                                <td style="padding: 10px 16px; color: #64748B;">Periode Pemeriksaan</td>
                                <td style="padding: 10px 16px;">
                                    <span style="font-size: 12px; background-color: #F1F5F9; border: 1px solid #E2E8F0; padding: 2px 7px; border-radius: 4px; color: #334155; font-weight: 500;">
                                        {{ $maintenance->periode }}
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #F1F5F9;">
                                <td style="padding: 10px 16px; color: #64748B;">Teknisi Pelaksana</td>
                                <td style="padding: 10px 16px; font-weight: 500; color: #0F172A;">
                                    {{ $maintenance->user->name ?? '-' }}
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #F1F5F9;">
                                <td style="padding: 10px 16px; color: #64748B;">Status Pekerjaan</td>
                                <td style="padding: 10px 16px;">
                                    <span class="badge {{ $maintenance->badge_status }}">
                                        <span class="badge-dot"></span>
                                        {{ $maintenance->status }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if($maintenance->keterangan)
                    <div style="padding: 14px 16px; background-color: #F8FAFC; border-top: 1px solid #E2E8F0;">
                        <div style="font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase; margin-bottom: 4px;">
                            Catatan & Temuan Teknisi
                        </div>
                        <div style="font-size: 12.5px; color: #334155; line-height: 1.4;">
                            {{ $maintenance->keterangan }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Eviden Card -->
            @if($maintenance->eviden)
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Dokumentasi Eviden</h3>
                        <div class="card-subtitle">Foto bukti fisik hasil pemeriksaan</div>
                    </div>
                </div>
                <div style="padding: 14px; background-color: #F8FAFC; text-align: center;">
                    <a href="{{ Storage::url($maintenance->eviden) }}" target="_blank">
                        <img src="{{ Storage::url($maintenance->eviden) }}" alt="Eviden Maintenance"
                             style="max-width: 100%; max-height: 240px; object-fit: cover; border-radius: 4px; border: 1px solid #CBD5E1;">
                    </a>
                    <div style="margin-top: 8px;">
                        <a href="{{ Storage::url($maintenance->eviden) }}" target="_blank"
                           class="btn btn-action-view btn-sm" style="display: inline-flex;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 13px; height: 13px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span>Buka Gambar Ukuran Penuh</span>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right: Checklist Inspeksi Fisik & Fungsi -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Checklist Hasil Pemeriksaan</h3>
                    <div class="card-subtitle">Verifikasi kepatuhan parameter operasional perangkat</div>
                </div>
                @if($maintenance->checklist_total > 0)
                <span class="badge badge-success">
                    <span class="badge-dot"></span>
                    {{ $maintenance->checklist_selesai }} dari {{ $maintenance->checklist_total }} Selesai ({{ round(($maintenance->checklist_selesai / $maintenance->checklist_total) * 100) }}%)
                </span>
                @endif
            </div>
            <div class="card-body">
                @if($maintenance->checklist_total > 0)
                <!-- Completion Progress Bar -->
                <div style="margin-bottom: 18px;">
                    <div style="display: flex; justify-content: space-between; font-size: 11.5px; color: #64748B; margin-bottom: 4px;">
                        <span>Tingkat Kelengkapan Checklist</span>
                        <span style="font-weight: 600; color: #0F172A;">
                            {{ round(($maintenance->checklist_selesai / $maintenance->checklist_total) * 100) }}%
                        </span>
                    </div>
                    <div style="width: 100%; height: 6px; background-color: #E2E8F0; border-radius: 3px; overflow: hidden;">
                        <div style="width: {{ ($maintenance->checklist_selesai / $maintenance->checklist_total) * 100 }}%; height: 100%; background-color: #16A34A; border-radius: 3px;"></div>
                    </div>
                </div>

                <!-- Checklist Items -->
                <div>
                    @foreach($maintenance->checklist as $index => $item)
                    @php $isChecked = !empty($item['checked']); @endphp
                    <div style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1px solid {{ $isChecked ? '#BBF7D0' : '#E2E8F0' }}; background-color: {{ $isChecked ? '#F0FDF4' : '#FFFFFF' }}; border-radius: 5px; margin-bottom: 8px;">
                        <div style="width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background-color: {{ $isChecked ? '#16A34A' : '#F1F5F9' }}; color: #FFFFFF; font-size: 11px; margin-top: 1px;">
                            @if($isChecked)
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                            @else
                            <span style="color: #94A3B8;">&minus;</span>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 13px; font-weight: 600; color: #0F172A;">
                                {{ $item['item'] ?? '-' }}
                            </div>
                            @if(!empty($item['keterangan']))
                            <div style="font-size: 11.5px; color: #475569; margin-top: 2px;">
                                Catatan teknisi: <em>{{ $item['keterangan'] }}</em>
                            </div>
                            @endif
                        </div>
                        <span style="font-size: 11px; font-weight: 500; color: {{ $isChecked ? '#166534' : '#94A3B8' }};">
                            {{ $isChecked ? 'Lulus / OK' : 'Belum Dicek' }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div style="text-align: center; color: #64748B; padding: 24px;">
                    Tidak ada butir checklist yang tersimpan untuk kegiatan ini.
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
