<x-app-layout>
    <x-slot name="title">Input Maintenance Baru</x-slot>

    <!-- Page Header -->
    <div class="page-header-row">
        <div>
            <div style="font-size: 11.5px; color: #64748B; margin-bottom: 2px;">
                <a href="{{ route('maintenance.index') }}" style="color: #64748B; text-decoration: none;">Maintenance</a> / Input
            </div>
            <h2 class="page-heading-title">Formulir Kegiatan Maintenance</h2>
            <div class="page-heading-desc">Pencatatan pemeriksaan berkala dan checklist teknisi di STO Witel Base-G</div>
        </div>
        <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form method="POST" action="{{ route('maintenance.store') }}" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <!-- Left Column: Informasi Pelaksanaan -->
            <div class="card" style="align-self: start; margin-bottom: 0;">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">1. Parameter Pemeliharaan</h3>
                        <div class="card-subtitle">Identitas target perangkat dan jadwal eksekusi</div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Pilih Perangkat <span style="color: #DC2626;">*</span></label>
                        <select name="perangkat_id" id="perangkatSelect"
                                class="form-control @error('perangkat_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Perangkat Target --</option>
                            @foreach($perangkatList as $p)
                            <option value="{{ $p->id }}"
                                    {{ (old('perangkat_id', request('perangkat_id')) == $p->id) ? 'selected' : '' }}>
                                [{{ $p->kode_perangkat }}] {{ $p->nama_perangkat }} — {{ $p->lokasi }}
                            </option>
                            @endforeach
                        </select>
                        @error('perangkat_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                        <div>
                            <label class="form-label">Tanggal Maintenance <span style="color: #DC2626;">*</span></label>
                            <input type="date" name="tanggal"
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="form-label">Periode Pemeliharaan <span style="color: #DC2626;">*</span></label>
                            <select name="periode" class="form-control @error('periode') is-invalid @enderror" required>
                                @foreach(['Harian','Mingguan','Bulanan','Tahunan'] as $p)
                                <option value="{{ $p }}" {{ old('periode', 'Bulanan') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                            @error('periode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Status Pekerjaan <span style="color: #DC2626;">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            @foreach(['Dijadwalkan','Dalam Proses','Selesai','Ditunda'] as $s)
                            <option value="{{ $s }}" {{ old('status', 'Selesai') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">Dokumentasi Eviden (Foto Lapangan)</label>
                        <input type="file" name="eviden" class="form-control" accept="image/*" id="evidenInput"
                               onchange="previewEviden(event)">
                        <div style="font-size: 11px; color: #64748B; margin-top: 3px;">Foto kondisi perangkat saat inspeksi (JPG/PNG, Maks. 5MB)</div>
                        <div id="evidenPreviewWrap" style="display: none; margin-top: 8px;">
                            <img id="evidenPreviewImg" src="" alt="Eviden Preview"
                                 style="max-width: 100%; height: 130px; object-fit: cover; border-radius: 4px; border: 1px solid #CBD5E1;">
                        </div>
                        @error('eviden')<div class="invalid-feedback" style="display: block;">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label">Catatan & Temuan Teknisi</label>
                        <textarea name="keterangan" class="form-control" rows="4"
                                  placeholder="Catat hasil observasi, anomali suhu/tegangan, tindakan perbaikan, atau rekomendasi...">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Checklist -->
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">2. Checklist Pemeriksaan</h3>
                        <div class="card-subtitle">Verifikasi item pemeriksaan standar teknis STO</div>
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <button type="button" onclick="toggleAllChecklist()" class="btn btn-secondary btn-sm">
                            <span id="btnCheckAllText">Pilih Semua</span>
                        </button>
                        <button type="button" onclick="addChecklistItem()" class="btn btn-secondary btn-sm">
                            + Tambah Item
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="checklistContainer">
                        @foreach($checklistTemplate as $index => $item)
                        <div class="checklist-item-row {{ old('checklist.'.$index.'.checked') ? 'is-checked' : '' }}" id="cl-row-{{ $index }}">
                            <input type="checkbox"
                                   name="checklist[{{ $index }}][checked]"
                                   value="1"
                                   class="checklist-item-checkbox"
                                   onchange="handleCheckChange(this)"
                                   {{ old('checklist.'.$index.'.checked') ? 'checked' : '' }}>
                            <div style="flex: 1;">
                                <input type="hidden" name="checklist[{{ $index }}][item]" value="{{ $item['item'] }}">
                                <div style="font-size: 13px; font-weight: 600; color: #0F172A; margin-bottom: 2px;">
                                    {{ $item['item'] }}
                                </div>
                                <input type="text"
                                       name="checklist[{{ $index }}][keterangan]"
                                       class="form-control"
                                       style="height: 28px; font-size: 11.5px; padding: 2px 8px;"
                                       placeholder="Keterangan hasil periksa (opsional)"
                                       value="{{ old('checklist.'.$index.'.keterangan') }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 11.5px; color: #64748B;">
                        Pastikan seluruh data dan eviden sudah lengkap sebelum submit.
                    </span>
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Kegiatan Maintenance</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        let checklistCounter = {{ count($checklistTemplate) }};
        let allChecked = false;

        function handleCheckChange(cb) {
            const row = cb.closest('.checklist-item-row');
            if (cb.checked) {
                row.classList.add('is-checked');
            } else {
                row.classList.remove('is-checked');
            }
        }

        function toggleAllChecklist() {
            allChecked = !allChecked;
            const checkboxes = document.querySelectorAll('.checklist-item-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = allChecked;
                handleCheckChange(cb);
            });
            document.getElementById('btnCheckAllText').textContent = allChecked ? 'Batal Semua' : 'Pilih Semua';
        }

        function addChecklistItem() {
            const container = document.getElementById('checklistContainer');
            const newIndex = checklistCounter++;
            const div = document.createElement('div');
            div.className = 'checklist-item-row';
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
                           placeholder="Keterangan / nilai ukur...">
                </div>
                <button type="button" onclick="this.closest('.checklist-item-row').remove()"
                        class="btn btn-secondary btn-sm" style="padding: 2px 6px; color: #DC2626;">&times;</button>
            `;
            container.appendChild(div);
            div.classList.add('is-checked');
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
