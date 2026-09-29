<x-app-layout>
    <x-slot name="title">Edit Maintenance</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('maintenance.index') }}" style="color: #64748B; text-decoration: none;">Maintenance</a> / Edit
            </div>
            <h2 class="page-heading-title">Edit Catatan Maintenance</h2>
            <div class="page-heading-desc">
                <span>{{ $maintenance->perangkat->nama_perangkat ?? 'Perangkat' }}</span>
                <span>• {{ $maintenance->tanggal->format('d F Y') }}</span>
            </div>
        </div>
        <a href="{{ route('maintenance.show', $maintenance) }}" class="btn btn-secondary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Batal & Kembali</span>
        </a>
    </div>

    <form method="POST" action="{{ route('maintenance.update', $maintenance) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <!-- Left Column: Informasi Pelaksanaan -->
            <div class="card" style="align-self: start; margin-bottom: 0;">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">1. Parameter Pemeliharaan</h3>
                        <div class="card-subtitle">Perbarui data pelaksanaan dan status pekerjaan</div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Perangkat Target <span style="color: #DC2626;">*</span></label>
                        <select name="perangkat_id" class="form-control" required>
                            @foreach($perangkatList as $p)
                            <option value="{{ $p->id }}" {{ old('perangkat_id', $maintenance->perangkat_id) == $p->id ? 'selected' : '' }}>
                                [{{ $p->kode_perangkat }}] {{ $p->nama_perangkat }} — {{ $p->lokasi }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                        <div>
                            <label class="form-label">Tanggal Pelaksanaan <span style="color: #DC2626;">*</span></label>
                            <input type="date" name="tanggal" class="form-control"
                                   value="{{ old('tanggal', $maintenance->tanggal->format('Y-m-d')) }}" required>
                        </div>
                        <div>
                            <label class="form-label">Periode Pemeliharaan</label>
                            <select name="periode" class="form-control">
                                @foreach(['Harian','Mingguan','Bulanan','Tahunan'] as $p)
                                <option value="{{ $p }}" {{ old('periode', $maintenance->periode) == $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Status Pekerjaan <span style="color: #DC2626;">*</span></label>
                        <select name="status" class="form-control" required>
                            @foreach(['Dijadwalkan','Dalam Proses','Selesai','Ditunda'] as $s)
                            <option value="{{ $s }}" {{ old('status', $maintenance->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Eviden Lapangan (Foto)</label>
                        @if($maintenance->eviden)
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                            <img src="{{ Storage::url($maintenance->eviden) }}" alt="Eviden"
                                 style="width: 70px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #CBD5E1;">
                            <span style="font-size: 11.5px; color: #64748B;">Foto saat ini terpasang. Pilih berkas baru di bawah jika ingin mengganti.</span>
                        </div>
                        @endif
                        <input type="file" name="eviden" class="form-control" accept="image/*" id="evidenInput"
                               onchange="previewEviden(event)">
                        <div id="evidenPreviewWrap" style="display: none; margin-top: 8px;">
                            <img id="evidenPreviewImg" src="" alt="Eviden Preview"
                                 style="max-width: 100%; height: 130px; object-fit: cover; border-radius: 4px; border: 1px solid #CBD5E1;">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Catatan & Temuan Teknisi</label>
                        <textarea name="keterangan" class="form-control" rows="4"
                                  placeholder="Catat hasil observasi, tindakan yang dilakukan...">{{ old('keterangan', $maintenance->keterangan) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Checklist -->
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">2. Checklist Pemeriksaan</h3>
                        <div class="card-subtitle">Item verifikasi teknis pemeliharaan</div>
                    </div>
                    <button type="button" onclick="addChecklistItem()" class="btn btn-secondary btn-sm">
                        + Tambah Item
                    </button>
                </div>
                <div class="card-body">
                    <div id="checklistContainer">
                        @if(is_array($maintenance->checklist))
                            @foreach($maintenance->checklist as $index => $item)
                            <div class="checklist-item-row {{ (!empty($item['checked'])) ? 'is-checked' : '' }}" id="cl-row-{{ $index }}">
                                <input type="checkbox"
                                       name="checklist[{{ $index }}][checked]"
                                       value="1"
                                       class="checklist-item-checkbox"
                                       onchange="handleCheckChange(this)"
                                       {{ !empty($item['checked']) ? 'checked' : '' }}>
                                <div style="flex: 1;">
                                    <input type="hidden" name="checklist[{{ $index }}][item]" value="{{ $item['item'] }}">
                                    <div style="font-size: 13px; font-weight: 600; color: #0F172A; margin-bottom: 2px;">
                                        {{ $item['item'] }}
                                    </div>
                                    <input type="text"
                                           name="checklist[{{ $index }}][keterangan]"
                                           class="form-control"
                                           style="height: 28px; font-size: 11.5px; padding: 2px 8px;"
                                           placeholder="Keterangan hasil periksa"
                                           value="{{ $item['keterangan'] ?? '' }}">
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div style="color: #64748B; font-size: 12.5px; padding: 10px 0;">
                                Tidak ada data checklist tersimpan.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer" style="display: flex; justify-content: flex-end; gap: 8px;">
                    <a href="{{ route('maintenance.show', $maintenance) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        let checklistCounter = 100;

        function handleCheckChange(cb) {
            const row = cb.closest('.checklist-item-row');
            if (cb.checked) {
                row.classList.add('is-checked');
            } else {
                row.classList.remove('is-checked');
            }
        }

        function addChecklistItem() {
            const container = document.getElementById('checklistContainer');
            const newIndex = checklistCounter++;
            const div = document.createElement('div');
            div.className = 'checklist-item-row is-checked';
            div.id = 'cl-row-' + newIndex;
            div.innerHTML = `
                <input type="checkbox" name="checklist[${newIndex}][checked]" value="1"
                       class="checklist-item-checkbox" onchange="handleCheckChange(this)" checked>
                <div style="flex: 1;">
                    <input type="text" name="checklist[${newIndex}][item]" class="form-control"
                           style="height: 28px; font-size: 12px; font-weight: 600; margin-bottom: 4px;"
                           placeholder="Nama item pemeriksaan baru..." required>
                    <input type="text" name="checklist[${newIndex}][keterangan]" class="form-control"
                           style="height: 28px; font-size: 11.5px; padding: 2px 8px;"
                           placeholder="Keterangan hasil periksa...">
                </div>
                <button type="button" onclick="this.closest('.checklist-item-row').remove()"
                        class="btn btn-secondary btn-sm" style="padding: 2px 6px; color: #DC2626;">&times;</button>
            `;
            container.appendChild(div);
        }

        function previewEviden(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('evidenPreviewImg').src = e.target.result;
                    document.getElementById('evidenPreviewWrap').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
