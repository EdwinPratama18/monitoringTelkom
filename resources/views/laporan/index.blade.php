<x-app-layout>
    <x-slot name="title">Pusat Laporan Operasional</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 12px; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">Pusat Dokumentasi & Audit STO</div>
            <h2 class="page-heading-title" style="font-size: 22px;">Pusat Laporan & Pelaporan Operasional</h2>
            <div class="page-heading-desc">Rekapitulasi berkala kegiatan pemeliharaan dan audit kelayakan infrastruktur telekomunikasi STO Witel Base-G</div>
        </div>
    </div>

    <!-- Corporate Report Modules Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(310px, 1fr)); gap: 20px;">
        <!-- 1. Laporan Maintenance -->
        <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; margin-bottom: 0;">
            <div>
                <div class="card-header card-header-subtle">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div class="metric-icon-wrap" style="background-color: #FEF2F2; color: var(--telkom-red);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Laporan Rekap Maintenance</h3>
                    </div>
                    <span class="badge badge-secondary">Dokumen Resmi</span>
                </div>
                <div class="card-body">
                    <p style="font-size: 13px; color: #475569; line-height: 1.5; margin: 0 0 14px;">
                        Rekapitulasi riwayat pekerjaan maintenance preventif dan kuratif. Dilengkapi filter periode bulanan, perangkat target, status, serta fasilitas ekspor berkas cetak dokumen PDF standar Telkom.
                    </p>
                    <div style="font-size: 11.5px; color: #64748B; background-color: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 12px; border-radius: 4px;">
                        <strong>Format Ekspor:</strong> Tabel Operasional Web & Cetak PDF Landscape
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('laporan.maintenance') }}" class="btn btn-primary" style="width: 100%;">
                    <span>Buka Laporan Maintenance</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- 2. Laporan Checklist -->
        <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; margin-bottom: 0;">
            <div>
                <div class="card-header card-header-subtle">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div class="metric-icon-wrap" style="background-color: #F0FDF4; color: #16A34A;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="card-title">Audit Checklist Pemeriksaan</h3>
                    </div>
                    <span class="badge badge-secondary">Audit Standar</span>
                </div>
                <div class="card-body">
                    <p style="font-size: 13px; color: #475569; line-height: 1.5; margin: 0 0 14px;">
                        Daftar rincian item checklist kepatuhan teknis yang telah diperiksa oleh teknisi. Memantau kelengkapan verifikasi suhu, suplai daya, grounding, dan kabel optik.
                    </p>
                    <div style="font-size: 11.5px; color: #64748B; background-color: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 12px; border-radius: 4px;">
                        <strong>Format Ekspor:</strong> Tabel Rincian Checklist & Persentase Kelulusan
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('laporan.checklist') }}" class="btn btn-secondary" style="width: 100%;">
                    <span>Buka Laporan Checklist</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- 3. Galeri Eviden -->
        <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; margin-bottom: 0;">
            <div>
                <div class="card-header card-header-subtle">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div class="metric-icon-wrap" style="background-color: #FFFBEB; color: #D97706;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Galeri Dokumentasi Eviden</h3>
                    </div>
                    <span class="badge badge-secondary">Arsip Foto</span>
                </div>
                <div class="card-body">
                    <p style="font-size: 13px; color: #475569; line-height: 1.5; margin: 0 0 14px;">
                        Arsip foto dokumentasi fisik lapangan hasil kegiatan maintenance. Memudahkan verifikasi kondisi fisik perangkat, kerapian rak kabel, dan bukti pelaksanaan tugas teknisi.
                    </p>
                    <div style="font-size: 11.5px; color: #64748B; background-color: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 12px; border-radius: 4px;">
                        <strong>Format Ekspor:</strong> Grid Galeri Visual dengan Metadata Perangkat
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('laporan.eviden') }}" class="btn btn-secondary" style="width: 100%;">
                    <span>Buka Galeri Eviden</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
