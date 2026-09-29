<x-app-layout>
    <x-slot name="title">Tambah Perangkat Baru</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('perangkat.index') }}" style="color: #64748B; text-decoration: none;">Data Perangkat</a> / Tambah
            </div>
            <h2 class="page-heading-title">Tambah Perangkat Infrastruktur</h2>
            <div class="page-heading-desc">Form registrasi data teknis perangkat baru pada fasilitas STO Witel Base-G</div>
        </div>
        <a href="{{ route('perangkat.index') }}" class="btn btn-secondary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form method="POST" action="{{ route('perangkat.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Formulir Data Perangkat</h3>
                    <div class="card-subtitle">Lengkapi atribut perangkat sesuai data lapangan teknisi</div>
                </div>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
                    <!-- Sisi Kiri: Identitas Perangkat -->
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px; padding-bottom: 6px; border-bottom: 1px solid #E2E8F0;">
                            1. Identitas & Tipe Perangkat
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Kode Perangkat <span style="color: #DC2626;">*</span></label>
                            <input type="text" name="kode_perangkat"
                                   class="form-control @error('kode_perangkat') is-invalid @enderror"
                                   value="{{ old('kode_perangkat') }}" placeholder="Contoh: SRV-001, OLT-002, RTR-001" required>
                            <div style="font-size: 11px; color: #64748B; margin-top: 3px;">Kode identifikasi unik perangkat di STO</div>
                            @error('kode_perangkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Nama Perangkat <span style="color: #DC2626;">*</span></label>
                            <input type="text" name="nama_perangkat"
                                   class="form-control @error('nama_perangkat') is-invalid @enderror"
                                   value="{{ old('nama_perangkat') }}" placeholder="Contoh: Core Router STO Base-G" required>
                            @error('nama_perangkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Jenis Perangkat <span style="color: #DC2626;">*</span></label>
                            <input type="text" name="jenis_perangkat"
                                   class="form-control @error('jenis_perangkat') is-invalid @enderror"
                                   value="{{ old('jenis_perangkat') }}" placeholder="Server / Router / Switch / OLT / UPS / Rectifier" required>
                            @error('jenis_perangkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                            <div>
                                <label class="form-label">Merk / Brand</label>
                                <input type="text" name="merk" class="form-control"
                                       value="{{ old('merk') }}" placeholder="Cisco / Huawei / Dell">
                            </div>
                            <div>
                                <label class="form-label">Model / Tipe</label>
                                <input type="text" name="model" class="form-control"
                                       value="{{ old('model') }}" placeholder="Contoh: ASR 9000">
                            </div>
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Nomor Seri (Serial Number)</label>
                            <input type="text" name="no_seri" class="form-control"
                                   value="{{ old('no_seri') }}" placeholder="SN dari pabrikan">
                        </div>
                    </div>

                    <!-- Sisi Kanan: Lokasi, Status & Foto -->
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px; padding-bottom: 6px; border-bottom: 1px solid #E2E8F0;">
                            2. Penempatan & Status Operasional
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                            <div>
                                <label class="form-label">Lokasi Fasilitas <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="lokasi"
                                       class="form-control @error('lokasi') is-invalid @enderror"
                                       value="{{ old('lokasi', 'STO Witel Base-G') }}" required>
                                @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="form-label">Ruangan / Rack</label>
                                <input type="text" name="ruangan" class="form-control"
                                       value="{{ old('ruangan') }}" placeholder="Contoh: R. Server Lt. 2 / Rack 04">
                            </div>
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Tanggal Instalasi / Commissioning</label>
                            <input type="date" name="tanggal_install" class="form-control"
                                   value="{{ old('tanggal_install') }}">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                            <div>
                                <label class="form-label">Kondisi Teknis <span style="color: #DC2626;">*</span></label>
                                <select name="kondisi" class="form-control @error('kondisi') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kondisi --</option>
                                    <option value="Baik" {{ old('kondisi', 'Baik') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="form-label">Status Operasional <span style="color: #DC2626;">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="Dalam Perbaikan" {{ old('status') == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Foto Fisik Perangkat</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" id="fotoInput"
                                   onchange="previewPhoto(event)">
                            <div style="font-size: 11px; color: #64748B; margin-top: 3px;">Format berkas: JPG, PNG (Maks. 2MB)</div>
                            <div id="photoPreviewBox" style="display: none; margin-top: 8px;">
                                <img id="photoPreviewImg" src="" alt="Preview"
                                     style="max-width: 140px; height: 90px; object-fit: cover; border-radius: 4px; border: 1px solid #CBD5E1;">
                            </div>
                            @error('foto')<div class="invalid-feedback" style="display: block;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Full Width: Keterangan -->
                <div style="margin-top: 10px; padding-top: 16px; border-top: 1px solid #E2E8F0;">
                    <label class="form-label">Catatan Tambahan & Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"
                              placeholder="Keterangan fungsi khusus, jalur perkabelan, catatan konfigurasi...">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="card-footer" style="display: flex; justify-content: flex-end; gap: 8px;">
                <a href="{{ route('perangkat.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Perangkat</span>
                </button>
            </div>
        </div>
    </form>

    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreviewImg').src = e.target.result;
                    document.getElementById('photoPreviewBox').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
