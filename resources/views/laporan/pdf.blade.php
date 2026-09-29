<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Maintenance — STO Witel Base-G</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #111827;
            margin: 0;
            padding: 15px;
        }

        /* Kop Surat Resmi */
        .kop-surat {
            border-bottom: 2.5px solid #C91F18;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-title {
            font-size: 14px;
            font-weight: bold;
            color: #C91F18;
            letter-spacing: 0.5px;
        }

        .kop-subtitle {
            font-size: 11px;
            font-weight: bold;
            color: #1F2937;
            margin-top: 2px;
        }

        .kop-address {
            font-size: 9px;
            color: #6B7280;
            margin-top: 3px;
        }

        /* Judul Dokumen */
        .doc-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .doc-meta {
            text-align: center;
            font-size: 10px;
            color: #4B5563;
            margin-bottom: 16px;
        }

        /* Tabel Data */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 20px;
        }

        .report-table th {
            background-color: #F3F4F6;
            color: #1F2937;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5px;
            padding: 7px 6px;
            border: 1px solid #D1D5DB;
            text-align: left;
        }

        .report-table td {
            padding: 6px;
            border: 1px solid #E5E7EB;
            vertical-align: top;
        }

        .report-table tr:nth-child(even) td {
            background-color: #F9FAFB;
        }

        .code-text {
            font-family: "Courier New", Courier, monospace;
            font-weight: bold;
        }

        /* Blok Tanda Tangan */
        .signature-section {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .sig-col {
            width: 50%;
            text-align: center;
            font-size: 10px;
        }

        .sig-space {
            height: 55px;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Kop Surat Telkom -->
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td style="width: 50px; vertical-align: middle;">
                    <div style="width: 40px; height: 40px; background-color: #C91F18; color: #FFFFFF; font-weight: bold; font-size: 20px; text-align: center; line-height: 40px; border-radius: 4px;">
                        T
                    </div>
                </td>
                <td style="vertical-align: middle; padding-left: 10px;">
                    <div class="kop-title">PT TELKOM INDONESIA (PERSERO) TBK</div>
                    <div class="kop-subtitle">STO WITEL BASE-G — DIVISI INFRASTRUKTUR TELEKOMUNIKASI</div>
                    <div class="kop-address">Sentral Telepon Otomat Base-G, Jayapura, Papua • Sistem Informasi Monitoring & Maintenance</div>
                </td>
                <td style="text-align: right; vertical-align: middle; font-size: 9px; color: #6B7280;">
                    <div>Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</div>
                    <div>Dokumen Operasional Resmi</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Judul Dokumen -->
    <div class="doc-title">
        LAPORAN REKAPITULASI PELAKSANAAN MAINTENANCE PERANGKAT
    </div>
    <div class="doc-meta">
        Periode Data: {{ $periode }} • Total Kegiatan: {{ count($maintenances) }} Kegiatan
    </div>

    <!-- Tabel Hasil -->
    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 25px; text-align: center;">No</th>
                <th style="width: 65px;">Tanggal</th>
                <th style="width: 70px;">Kode</th>
                <th>Nama Perangkat</th>
                <th>Lokasi & Ruang</th>
                <th style="width: 55px;">Periode</th>
                <th style="width: 90px;">Teknisi</th>
                <th style="width: 65px;">Status</th>
                <th>Keterangan / Temuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($maintenances as $index => $m)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $m->tanggal->format('d/m/Y') }}</td>
                <td class="code-text">{{ $m->perangkat->kode_perangkat ?? '-' }}</td>
                <td><strong>{{ $m->perangkat->nama_perangkat ?? '-' }}</strong></td>
                <td>{{ $m->perangkat->lokasi ?? '-' }} {{ $m->perangkat->ruangan ? '('.$m->perangkat->ruangan.')' : '' }}</td>
                <td>{{ $m->periode }}</td>
                <td>{{ $m->user->name ?? '-' }}</td>
                <td>{{ $m->status }}</td>
                <td>{{ $m->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; padding: 20px; color: #6B7280;">
                    Tidak ada catatan kegiatan maintenance untuk periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Resmi -->
    <table class="signature-section">
        <tr>
            <td class="sig-col">
                <div>Mengetahui,</div>
                <div><strong>Supervisor STO Witel Base-G</strong></div>
                <div class="sig-space"></div>
                <div class="sig-name">Administrator STO</div>
                <div style="font-size: 9px; color: #6B7280;">NIP: ADM-BASEG-001</div>
            </td>
            <td class="sig-col">
                <div>Jayapura, {{ now()->translatedFormat('d F Y') }}</div>
                <div><strong>Penanggung Jawab Teknisi</strong></div>
                <div class="sig-space"></div>
                <div class="sig-name">{{ auth()->user()->name ?? 'Teknisi STO' }}</div>
                <div style="font-size: 9px; color: #6B7280;">NIP: {{ auth()->user()->nip ?? 'TKN-BASEG-001' }}</div>
            </td>
        </tr>
    </table>

</body>
</html>
