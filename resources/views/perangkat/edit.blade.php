<x-app-layout>
    <x-slot name="title">Edit Perangkat — {{ $perangkat->kode_perangkat }}</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('perangkat.index') }}" style="color: #64748B; text-decoration: none;">Data Perangkat</a> / Edit
            </div>
            <h2 class="page-heading-title">Edit Perangkat Infrastruktur</h2>
            <div class="page-heading-desc">
                <span class="code-pill">{{ $perangkat->kode_perangkat }}</span>
                <span>• {{ $perangkat->nama_perangkat }}</span>
            </div>
        </div>
        <a href="{{ route('perangkat.show', $perangkat) }}" class="btn btn-secondary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Batal & Kembali</span>
        </a>
    </div>

    <form method="POST" action="{{ route('perangkat.update', $perangkat) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Perbarui Informasi Perangkat</h3>
                    <div class="card-subtitle">Ubah data teknis, kondisi atau status operasional perangkat</div>
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
                                   value="{{ old('kode_perangkat', $perangkat->kode_perangkat) }}" required>
                            @error('kode_perangkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Nama Perangkat <span style="color: #DC2626;">*</span></label>
                            <input type="text" name="nama_perangkat"
                                   class="form-control @error('nama_perangkat') is-invalid @enderror"
                                   value="{{ old('nama_perangkat', $perangkat->nama_perangkat) }}" required>
                            @error('nama_perangkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Jenis Perangkat <span style="color: #DC2626;">*</span></label>
                            <input type="text" name="jenis_perangkat"
                                   class="form-control @error('jenis_perangkat') is-invalid @enderror"
                                   value="{{ old('jenis_perangkat', $perangkat->jenis_perangkat) }}" required>
                            @error('jenis_perangkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                            <div>
                                <label class="form-label">Merk / Brand</label>
                                <input type="text" name="merk" class="form-control"
                                       value="{{ old('merk', $perangkat->merk) }}">
                            </div>
                            <div>
                                <label class="form-label">Model / Tipe</label>
                                <input type="text" name="model" class="form-control"
                                       value="{{ old('model', $perangkat->model) }}">
                            </div>
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Nomor Seri (Serial Number)</label>
                            <input type="text" name="no_seri" class="form-control"
                                   value="{{ old('no_seri', $perangkat->no_seri) }}">
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
                                       value="{{ old('lokasi', $perangkat->lokasi) }}" required>
                                @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="form-label">Ruangan / Rack</label>
                                <input type="text" name="ruangan" class="form-control"
                                       value="{{ old('ruangan', $perangkat->ruangan) }}">
                            </div>
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Tanggal Instalasi / Commissioning</label>
                            <input type="date" name="tanggal_install" class="form-control"
                                   value="{{ old('tanggal_install', $perangkat->tanggal_install?->format('Y-m-d')) }}">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                            <div>
                                <label class="form-label">Kondisi Teknis <span style="color: #DC2626;">*</span></label>
                                <select name="kondisi" class="form-control" required>
                                    <option value="Baik" {{ old('kondisi', $perangkat->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi', $perangkat->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi', $perangkat->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Status Operasional <span style="color: #DC2626;">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="Aktif" {{ old('status', $perangkat->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status', $perangkat->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="Dalam Perbaikan" {{ old('status', $perangkat->status) == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="form-label">Foto Fisik Perangkat</label>
                            @if($perangkat->foto)
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                <img src="{{ Storage::url($perangkat->foto) }}" alt="Foto saat ini"
                                     style="width: 70px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #CBD5E1;">
                                <span style="font-size: 11.5px; color: #64748B;">Foto saat ini terpasang. Pilih berkas baru di bawah jika ingin mengganti.</span>
                            </div>
                            @endif
                            <input type="file" name="foto" class="form-control" accept="image/*" id="fotoInput"
                                   onchange="previewPhoto(event)">
                            <div style="font-size: 11px; color: #64748B; margin-top: 3px;">Format berkas: JPG, PNG (Maks. 2MB)</div>
                            <div id="photoPreviewBox" style="display: none; margin-top: 8px;">
                                <img id="photoPreviewImg" src="" alt="Preview baru"
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
                              placeholder="Keterangan fungsi khusus, jalur perkabelan, catatan konfigurasi...">{{ old('keterangan', $perangkat->keterangan) }}</textarea>
                </div>
            </div>

            <div class="card-footer" style="display: flex; justify-content: flex-end; gap: 8px;">
                <a href="{{ route('perangkat.show', $perangkat) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Perubahan</span>
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
