<?php

namespace Database\Seeders;

use App\Models\Maintenance;
use App\Models\Perangkat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna / Petugas STO Base-G Witel Papua
        $admin = User::updateOrCreate(
            ['email' => 'admin@witelbaseg.id'],
            [
                'name'     => 'Administrator STO',
                'password' => bcrypt('password'),
                'role'     => 'admin',
                'nip'      => 'ADM-BG-001',
                'jabatan'  => 'Supervisor STO Witel Base-G',
                'no_telp'  => '081240000001',
            ]
        );

        $teknisi1 = User::updateOrCreate(
            ['email' => 'alditho@witelbaseg.id'],
            [
                'name'     => 'Alditho',
                'password' => bcrypt('password'),
                'role'     => 'teknisi',
                'nip'      => 'TKN-BG-001',
                'jabatan'  => 'Teknisi DEFA & Catu Daya',
                'no_telp'  => '081240001001',
            ]
        );

        $teknisi2 = User::updateOrCreate(
            ['email' => 'yandri@witelbaseg.id'],
            [
                'name'     => 'Yandri',
                'password' => bcrypt('password'),
                'role'     => 'teknisi',
                'nip'      => 'TKN-BG-002',
                'jabatan'  => 'Teknisi DEFA & Alpro',
                'no_telp'  => '081240001002',
            ]
        );

        // Akun teknisi pengujian alternatif
        User::updateOrCreate(
            ['email' => 'teknisi@gmail.com'],
            [
                'name'     => 'Teknisi DEFA Base-G',
                'password' => bcrypt('password'),
                'role'     => 'teknisi',
                'nip'      => 'TKN-BG-003',
                'jabatan'  => 'Teknisi Lapangan',
                'no_telp'  => '081240001003',
            ]
        );

        // Hapus data perangkat & maintenance lama untuk diganti dengan data DEFA nyata
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Maintenance::truncate();
        Perangkat::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 2. Data Perangkat Nyata Berdasarkan Laporan Harian DEFA STO Base-G Witel Papua
        $perangkatList = [
            // --- 1. PLN (Catu Daya Utama) ---
            [
                'kode_perangkat'  => 'PLN-01',
                'nama_perangkat'  => 'Trafo & Panel Distribusi PLN Utama',
                'jenis_perangkat' => 'Power PLN',
                'merk'            => 'Schneider Electric',
                'model'           => 'Cubicle TM/TR & LV-MDP',
                'no_seri'         => 'PLN-BG-TR01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'Ruang Panel PLN',
                'tanggal_install' => '2018-03-10',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Catu daya utama STO. Status: ON. Tegangan: RS 392V, ST 395V, TR 390V, RN 225V, SN 228V, TN 227V. Beban Arus: R 47.4A, S 50.6A, T 49.7A. Freq: 50.0 Hz, PF: 0.95 pf, KWH: 9892.61.',
            ],

            // --- 2. GENSET ---
            [
                'kode_perangkat'  => 'GNS-01',
                'nama_perangkat'  => 'Genset 1 Perkins 250 KVA',
                'jenis_perangkat' => 'Genset',
                'merk'            => 'PERKINS',
                'model'           => '250 KVA Diesel Generator',
                'no_seri'         => 'PK-250-BG01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'Ruang Genset',
                'tanggal_install' => '2019-06-15',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Genset #1 Kapasitas 250 KVA. Status: OFF (Standby). RPM: 1500 RPM, Freq: 50 Hz, PF: 0.95 pf. Tegangan Aki: 26.4 Vdc, BJ Aki: 1300, Level Air Aki: Penuh. Terakhir Running: 2026-04-05 21:55 - 22:16 (Beban R: 185.1A, S: 169.0A, T: 168.4A).',
            ],
            [
                'kode_perangkat'  => 'GNS-02',
                'nama_perangkat'  => 'Genset 2 Caterpillar 200 KVA',
                'jenis_perangkat' => 'Genset',
                'merk'            => 'CATERPILLAR (CAT)',
                'model'           => '200 KVA Diesel Generator',
                'no_seri'         => 'CAT-200-BG02',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'Ruang Genset',
                'tanggal_install' => '2019-08-20',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Genset #2 Kapasitas 200 KVA. Status: OFF (Standby). RPM: 1500 RPM, Freq: 50 Hz, PF: 0.95 pf. Tegangan Aki: 13.1 Vdc, BJ Aki: 1300, Level Air Aki: Penuh. Terakhir Running: 2026-04-05 21:55 - 22:16 (Beban R: 47.4A, S: 50.6A, T: 49.7A).',
            ],

            // --- 3. TANGKI BBM ---
            [
                'kode_perangkat'  => 'BBM-01',
                'nama_perangkat'  => 'Tangki BBM Solar Genset (Daily & Storage)',
                'jenis_perangkat' => 'Tangki BBM',
                'merk'            => 'Indotank',
                'model'           => 'Dual Compartment Fuel Tank',
                'no_seri'         => 'TNK-SOLAR-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'Ruang Genset',
                'tanggal_install' => '2018-05-12',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Terakhir ukur: 2026-09-04 09:05:00 WIT. Level Tangki Harian: 48 cm, Level Tangki Bulanan: 32 cm. Stok Air Aki Tersedia: 32 Botol.',
            ],

            // --- 4. RECTIFIER ---
            [
                'kode_perangkat'  => 'RCT-01',
                'nama_perangkat'  => 'Rectifier SAJAS 1 (1200A / 54VDC)',
                'jenis_perangkat' => 'Rectifier',
                'merk'            => 'SAJAS',
                'model'           => 'Modular DC Power System 1200A',
                'no_seri'         => 'SJS-1200-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Rectifier',
                'tanggal_install' => '2020-02-10',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Tegangan Output: 53.7 VDC, Arus Beban: 331 A (Kapasitas 1200 A). Beban terhubung: PFE, DWDM, PE HSI, TERRA, PATTON, PE D7 JAP, LB D7 JAP, ALLOT, PE VPN, TPND 1/2/3, WME 1/2/3, BCP. Terhubung Baterai Hoppecke 1 & 2.',
            ],
            [
                'kode_perangkat'  => 'RCT-02',
                'nama_perangkat'  => 'Rectifier SAJAS 2 (1200A / 54VDC)',
                'jenis_perangkat' => 'Rectifier',
                'merk'            => 'SAJAS',
                'model'           => 'Modular DC Power System 1200A',
                'no_seri'         => 'SJS-1200-02',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Rectifier',
                'tanggal_install' => '2020-02-10',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Tegangan Output: 53.9 VDC, Arus Beban: 325 A (Kapasitas 1200 A). Beban terhubung: PFE, DWDM, PE HSI, TERRA, PATTON, PE D7 JAP, LB D7 JAP, ALLOT, PE VPN, TPND 1/2/3, WME 1/2/3, BCP. Terhubung Baterai Hoppecke 3 & 4.',
            ],

            // --- 5. BATERAI ---
            [
                'kode_perangkat'  => 'BAT-01',
                'nama_perangkat'  => 'Battery Bank Hoppecke 1 (1000 Ah)',
                'jenis_perangkat' => 'Baterai',
                'merk'            => 'HOPPECKE',
                'model'           => '1000 Ah VRLA 54VDC',
                'no_seri'         => 'HPK-1000-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Baterai',
                'tanggal_install' => '2020-02-15',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Tegangan Float: 53.4 VDC | Kapasitas: 1000 Ah. Backup Catu Daya Rectifier SAJAS 1. Suhu ruangan baterai stabil 18.6°C.',
            ],
            [
                'kode_perangkat'  => 'BAT-02',
                'nama_perangkat'  => 'Battery Bank Hoppecke 2 (1000 Ah)',
                'jenis_perangkat' => 'Baterai',
                'merk'            => 'HOPPECKE',
                'model'           => '1000 Ah VRLA 54VDC',
                'no_seri'         => 'HPK-1000-02',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Baterai',
                'tanggal_install' => '2020-02-15',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Tegangan Float: 53.4 VDC | Kapasitas: 1000 Ah. Backup Catu Daya Rectifier SAJAS 1.',
            ],
            [
                'kode_perangkat'  => 'BAT-03',
                'nama_perangkat'  => 'Battery Bank Hoppecke 3 (1000 Ah)',
                'jenis_perangkat' => 'Baterai',
                'merk'            => 'HOPPECKE',
                'model'           => '1000 Ah VRLA 54VDC',
                'no_seri'         => 'HPK-1000-03',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Baterai',
                'tanggal_install' => '2020-02-15',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Tegangan Float: 53.4 VDC | Kapasitas: 1000 Ah. Backup Catu Daya Rectifier SAJAS 2.',
            ],
            [
                'kode_perangkat'  => 'BAT-04',
                'nama_perangkat'  => 'Battery Bank Hoppecke 4 (1000 Ah)',
                'jenis_perangkat' => 'Baterai',
                'merk'            => 'HOPPECKE',
                'model'           => '1000 Ah VRLA 54VDC',
                'no_seri'         => 'HPK-1000-04',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Baterai',
                'tanggal_install' => '2020-02-15',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Tegangan Float: 53.4 VDC | Kapasitas: 1000 Ah. Backup Catu Daya Rectifier SAJAS 2.',
            ],

            // --- 6. AIR CONDITIONER (AC) ---
            // Ruang PNG (Suhu: 19.2°C, Kelembaban: 52.7%)
            [
                'kode_perangkat'  => 'AC-PNG-01',
                'nama_perangkat'  => 'AC Daikin 1 R. PNG',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Daikin',
                'model'           => 'Inverter 2.5 PK',
                'no_seri'         => 'DK-PNG-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2021-04-10',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Suhu Ruangan PNG: 19.2°C | Kelembaban: 52.7%. Pendinginan perangkat Core IP/PNG.',
            ],
            [
                'kode_perangkat'  => 'AC-PNG-02',
                'nama_perangkat'  => 'AC Daikin 2 R. PNG',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Daikin',
                'model'           => 'Inverter 2.5 PK',
                'no_seri'         => 'DK-PNG-02',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2021-04-10',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Beroperasi tandem dengan AC Daikin 1.',
            ],
            [
                'kode_perangkat'  => 'AC-PNG-03',
                'nama_perangkat'  => 'AC Hairf 3 Precision R. PNG',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Hairf',
                'model'           => 'Precision Air Conditioner 5 PK',
                'no_seri'         => 'HRF-PNG-03',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2019-11-20',
                'kondisi'         => 'Baik',
                'status'          => 'Tidak Aktif',
                'keterangan'      => 'Status: Off Standby. Sistem pendingin presisi ruang server PNG (gilir otomatis).',
            ],
            [
                'kode_perangkat'  => 'AC-PNG-04',
                'nama_perangkat'  => 'AC Hairf 4 Precision R. PNG',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Hairf',
                'model'           => 'Precision Air Conditioner 5 PK',
                'no_seri'         => 'HRF-PNG-04',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2019-11-20',
                'kondisi'         => 'Baik',
                'status'          => 'Tidak Aktif',
                'keterangan'      => 'Status: Off Standby. Sistem pendingin presisi cadangan.',
            ],

            // Ruang NGN (Suhu: 23.9°C, Kelembaban: 41.1%)
            [
                'kode_perangkat'  => 'AC-NGN-01',
                'nama_perangkat'  => 'AC Daikin 1 R. NGN',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Daikin',
                'model'           => 'Inverter 2.5 PK',
                'no_seri'         => 'DK-NGN-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. NGN',
                'tanggal_install' => '2021-05-15',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Suhu Ruangan NGN: 23.9°C | Kelembaban: 41.1%. Pendinginan rak server NGN & Gateway.',
            ],
            [
                'kode_perangkat'  => 'AC-NGN-02',
                'nama_perangkat'  => 'AC Daikin 2 R. NGN',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Daikin',
                'model'           => 'Inverter 2.5 PK',
                'no_seri'         => 'DK-NGN-02',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. NGN',
                'tanggal_install' => '2021-05-15',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Pendinginan ruangan NGN.',
            ],
            [
                'kode_perangkat'  => 'AC-NGN-03',
                'nama_perangkat'  => 'AC Citec 3 Precision R. NGN',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Citec',
                'model'           => 'Precision Cooling System 7.5 PK',
                'no_seri'         => 'CTC-NGN-03',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. NGN',
                'tanggal_install' => '2019-10-18',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Presisi cooling unit utama ruangan NGN.',
            ],
            [
                'kode_perangkat'  => 'AC-NGN-04',
                'nama_perangkat'  => 'AC Citec 4 Precision R. NGN',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Citec',
                'model'           => 'Precision Cooling System 7.5 PK',
                'no_seri'         => 'CTC-NGN-04',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. NGN',
                'tanggal_install' => '2019-10-18',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Presisi cooling unit tandem ruangan NGN.',
            ],
            [
                'kode_perangkat'  => 'AC-NGN-05',
                'nama_perangkat'  => 'AC Hairf 5 Precision R. NGN',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Hairf',
                'model'           => 'Precision Cooling 5 PK',
                'no_seri'         => 'HRF-NGN-05',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. NGN',
                'tanggal_install' => '2020-03-25',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Unit pendingin tambahan.',
            ],

            // Ruang Rectifier (Suhu: 23.0°C, Kelembaban: 46.7%)
            [
                'kode_perangkat'  => 'AC-RCT-01',
                'nama_perangkat'  => 'AC Daikin 1 R. Rectifier',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Daikin',
                'model'           => 'Inverter 2 PK',
                'no_seri'         => 'DK-RCT-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Rectifier',
                'tanggal_install' => '2021-06-12',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Suhu Ruangan Rectifier: 23.0°C | Kelembaban: 46.7%. Menjaga suhu modul SAJAS 1 & 2.',
            ],
            [
                'kode_perangkat'  => 'AC-RCT-02',
                'nama_perangkat'  => 'AC Daikin 2 R. Rectifier',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Daikin',
                'model'           => 'Inverter 2 PK',
                'no_seri'         => 'DK-RCT-02',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Rectifier',
                'tanggal_install' => '2021-06-12',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Tandem pendingin ruang modul catu daya DC.',
            ],

            // Ruang Baterai (Suhu: 18.6°C, Kelembaban: 50.2%)
            [
                'kode_perangkat'  => 'AC-BAT-01',
                'nama_perangkat'  => 'AC Daikin 1 R. Baterai',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Daikin',
                'model'           => 'Inverter 2 PK Low Temp',
                'no_seri'         => 'DK-BAT-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Baterai',
                'tanggal_install' => '2021-07-20',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Status: On Normal. Suhu Ruangan Baterai: 18.6°C | Kelembaban: 50.2%. Menjaga suhu optimal VRLA baterai bank.',
            ],
            [
                'kode_perangkat'  => 'AC-BAT-02',
                'nama_perangkat'  => 'AC Daikin 2 R. Baterai',
                'jenis_perangkat' => 'Air Conditioner',
                'merk'            => 'Daikin',
                'model'           => 'Inverter 2 PK Low Temp',
                'no_seri'         => 'DK-BAT-02',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. Baterai',
                'tanggal_install' => '2021-07-20',
                'kondisi'         => 'Baik',
                'status'          => 'Tidak Aktif',
                'keterangan'      => 'Status: Off Normal (Standby Gilir). Unit cadangan pendingin ruang baterai.',
            ],

            // --- 7. PERANGKAT JARINGAN & TRANSMISI TERHUBUNG RECTIFIER ---
            [
                'kode_perangkat'  => 'DWD-01',
                'nama_perangkat'  => 'DWDM Optik Backbone Witel Papua',
                'jenis_perangkat' => 'Transmisi Optik',
                'merk'            => 'Huawei',
                'model'           => 'OptiX OSN 9800 U32',
                'no_seri'         => 'HW-DWD-BG01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2019-12-01',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Sistem transmisi optik DWDM utama STO Base-G menghubungkan ring backbone Papua. Catu daya dual feed SAJAS 1 & 2.',
            ],
            [
                'kode_perangkat'  => 'RTR-PE01',
                'nama_perangkat'  => 'Router PE HSI Base-G',
                'jenis_perangkat' => 'Router',
                'merk'            => 'Cisco',
                'model'           => 'ASR 9010 Aggregation Router',
                'no_seri'         => 'CS-PE-HSI-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2020-04-18',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Provider Edge Router layanan High Speed Internet (IndiHome & Corporate) STO Base-G. Catu daya terhubung SAJAS 1 & 2.',
            ],
            [
                'kode_perangkat'  => 'RTR-D701',
                'nama_perangkat'  => 'PE D7 JAP Core Datacom',
                'jenis_perangkat' => 'Router',
                'merk'            => 'Cisco',
                'model'           => 'NCS 5500 Series',
                'no_seri'         => 'CS-D7-JAP-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2020-07-22',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Router Core Datacom PE D7 Jayapura di STO Base-G. Beban catu daya DC terhubung ke Rectifier SAJAS 1 & 2.',
            ],
            [
                'kode_perangkat'  => 'LB-D701',
                'nama_perangkat'  => 'LB D7 JAP (Load Balancer Datacom)',
                'jenis_perangkat' => 'Gateway',
                'merk'            => 'F5 Networks',
                'model'           => 'BIG-IP iSeries i7800',
                'no_seri'         => 'F5-LBD7-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2020-08-14',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Load balancer datacom STO Base-G. Terkoneksi ke distribusi catu daya DC Rectifier SAJAS.',
            ],
            [
                'kode_perangkat'  => 'SEC-ALT01',
                'nama_perangkat'  => 'ALLOT Traffic Intelligence SG',
                'jenis_perangkat' => 'Security / DPI',
                'merk'            => 'Allot Communications',
                'model'           => 'Service Gateway SG-9500',
                'no_seri'         => 'ALT-SG95-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2021-01-10',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Traffic management & DPI sistem jaringan optik STO Base-G. Catu daya DC 48V/54V dari SAJAS 1 & 2.',
            ],
            [
                'kode_perangkat'  => 'RTR-VPN01',
                'nama_perangkat'  => 'Router PE VPN Base-G',
                'jenis_perangkat' => 'Router',
                'merk'            => 'Juniper Networks',
                'model'           => 'MX480 Universal Routing Platform',
                'no_seri'         => 'JN-MX480-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. PNG',
                'tanggal_install' => '2020-11-05',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Provider Edge VPN untuk layanan perbankan, instansi pemerintah & korporasi Papua. Catu daya SAJAS 1 & 2.',
            ],
            [
                'kode_perangkat'  => 'GTW-TERRA',
                'nama_perangkat'  => 'Gateway Transmisi TERRA & PATTON',
                'jenis_perangkat' => 'Gateway',
                'merk'            => 'Patton Electronics',
                'model'           => 'SmartNode VoIP & TDM Gateway',
                'no_seri'         => 'PTN-TERRA-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. NGN',
                'tanggal_install' => '2019-09-12',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Perangkat antarmuka transmisi suara TERRA & gateway PATTON. Catu daya DC terhubung ke Rectifier SAJAS.',
            ],
            [
                'kode_perangkat'  => 'SRV-WME01',
                'nama_perangkat'  => 'Server Cluster WME & TPND STO',
                'jenis_perangkat' => 'Server',
                'merk'            => 'Dell Technologies',
                'model'           => 'PowerEdge R750 Rack Server',
                'no_seri'         => 'DEL-WME-01',
                'lokasi'          => 'STO Base-G Witel',
                'ruangan'         => 'R. NGN',
                'tanggal_install' => '2021-03-20',
                'kondisi'         => 'Baik',
                'status'          => 'Aktif',
                'keterangan'      => 'Server operasional WME 1/2/3, TPND 1/2/3 & BCP. Terhubung catu daya ganda Rectifier SAJAS & PFE.',
            ],
        ];

        $createdPerangkats = [];
        foreach ($perangkatList as $pData) {
            $createdPerangkats[$pData['kode_perangkat']] = Perangkat::create($pData);
        }

        // 3. Data Riwayat Maintenance Nyata Sesuai "LAPORAN HARIAN DEFA" (Selasa, 2026-09-08 21:29 WIT)
        // Petugas: Alditho & Yandri

        // A. Maintenance PLN (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['PLN-01']->id,
            'user_id'      => $teknisi1->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi harian PLN shift malam pukul 21:29 WIT. Status: ON. Tegangan fasa: RS 392V | RN 225V | R 47.4A, ST 395V | SN 228V | S 50.6A, TR 390V | TN 227V | T 49.7A. Frekuensi: 50.0 Hz, Power Factor: 0.95 pf, KWH Meter: 9892.61. Cuaca cerah, kondisi alpro normal, STO aman.',
            'checklist'    => [
                ['item' => 'Pemeriksaan status sumber daya PLN (ON/OFF)', 'checked' => true, 'keterangan' => 'Status: ON Normal'],
                ['item' => 'Pengukuran tegangan fasa-ke-fasa (RS, ST, TR)', 'checked' => true, 'keterangan' => 'RS: 392V | ST: 395V | TR: 390V'],
                ['item' => 'Pengukuran tegangan fasa-ke-netral (RN, SN, TN)', 'checked' => true, 'keterangan' => 'RN: 225V | SN: 228V | TN: 227V'],
                ['item' => 'Pengukuran beban arus per fasa (R, S, T)', 'checked' => true, 'keterangan' => 'R: 47.4A | S: 50.6A | T: 49.7A'],
                ['item' => 'Pengecekan frekuensi sistem kelistrikan (50 Hz)', 'checked' => true, 'keterangan' => '50.0 Hz stabil'],
                ['item' => 'Pengecekan Power Factor (Cos Phi >= 0.85)', 'checked' => true, 'keterangan' => '0.95 pf (sangat baik)'],
                ['item' => 'Pencatatan akumulasi stand KWH Meter', 'checked' => true, 'keterangan' => 'Stand meter: 9892.61 KWh'],
            ],
        ]);

        // B. Maintenance Genset 1 Perkins (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['GNS-01']->id,
            'user_id'      => $teknisi2->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi kesiapan Genset 1 (Perkins 250 KVA). Status: OFF (Standby). RPM: 1500 RPM, Freq: 50 Hz, PF: 0.95. Tegangan aki 26.4 Vdc, BJ aki 1300, level air aki penuh. Running terakhir 2026-04-05 (Beban R: 185.1A, S: 169.0A, T: 168.4A). Unit siap beroperasi otomatis jika PLN padam.',
            'checklist'    => [
                ['item' => 'Pengecekan tegangan baterai aki starter (Vdc)', 'checked' => true, 'keterangan' => '26.4 Vdc normal'],
                ['item' => 'Pengukuran berat jenis (BJ) elektrolit aki', 'checked' => true, 'keterangan' => 'BJ: 1300 optimal'],
                ['item' => 'Pemeriksaan level air aki akumulator', 'checked' => true, 'keterangan' => 'Level penuh'],
                ['item' => 'Pemeriksaan level oli pelumas mesin & filter', 'checked' => true, 'keterangan' => 'Oli pada batas upper limit'],
                ['item' => 'Pemeriksaan air pendingin radiator & kebocoran', 'checked' => true, 'keterangan' => 'Radiator penuh, tidak ada bocor'],
                ['item' => 'Pengecekan posisi saklar mode kontrol (Auto)', 'checked' => true, 'keterangan' => 'Mode Auto Standby aktif'],
            ],
        ]);

        // C. Maintenance Genset 2 Caterpillar (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['GNS-02']->id,
            'user_id'      => $teknisi1->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi kesiapan Genset 2 (CAT 200 KVA). Status: OFF (Standby). RPM: 1500 RPM, Freq: 50 Hz, PF: 0.95. Tegangan aki 13.1 Vdc, BJ aki 1300, level air aki penuh. Running terakhir 2026-04-05 (Beban R: 47.4A, S: 50.6A, T: 49.7A). Sistem ATS/AMF normal.',
            'checklist'    => [
                ['item' => 'Pengecekan tegangan baterai starter genset', 'checked' => true, 'keterangan' => '13.1 Vdc normal'],
                ['item' => 'Pengukuran berat jenis (BJ) aki starter', 'checked' => true, 'keterangan' => 'BJ: 1300'],
                ['item' => 'Pengecekan level air aki', 'checked' => true, 'keterangan' => 'Penuh'],
                ['item' => 'Pemeriksaan fisik fan belt & alternator', 'checked' => true, 'keterangan' => 'Kekencangan belt normal'],
                ['item' => 'Pemeriksaan kontrol panel AMF / genset', 'checked' => true, 'keterangan' => 'Standby normal'],
            ],
        ]);

        // D. Maintenance Tangki BBM (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['BBM-01']->id,
            'user_id'      => $teknisi2->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi cadangan bahan bakar genset. Terakhir ukur: 2026-09-04 09:05:00. Level tangki harian: 48 cm, level tangki bulanan: 32 cm. Kerapian ruang genset aman, stok air aki cadangan tersedia 32 botol.',
            'checklist'    => [
                ['item' => 'Pengukuran ketinggian solar tangki harian (cm)', 'checked' => true, 'keterangan' => 'Tinggi: 48 cm'],
                ['item' => 'Pengukuran ketinggian solar tangki bulanan (cm)', 'checked' => true, 'keterangan' => 'Tinggi: 32 cm'],
                ['item' => 'Pemeriksaan katup penyalur BBM & pipa fleksibel', 'checked' => true, 'keterangan' => 'Katup terbuka normal, tidak rembes'],
                ['item' => 'Pemeriksaan strainer / separator air pada solar', 'checked' => true, 'keterangan' => 'Tidak ditemukan endapan air'],
                ['item' => 'Inventarisasi cadangan botol air aki', 'checked' => true, 'keterangan' => 'Tersedia 32 botol cadangan'],
            ],
        ]);

        // E. Maintenance Rectifier SAJAS 1 (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['RCT-01']->id,
            'user_id'      => $teknisi1->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi harian Catu Daya DC Rectifier SAJAS 1. Tegangan output 53.7 VDC, beban arus 331 A (kapasitas 1200 A). Beban aktif: PFE, DWDM, PE HSI, TERRA, PATTON, PE D7 JAP, LB D7 JAP, ALLOT, PE VPN, TPND 1-3, WME 1-3, BCP. Baterai terhubung Hoppecke 1 & 2 (53.4 VDC / 1000 Ah). Seluruh modul bekerja normal.',
            'checklist'    => [
                ['item' => 'Pengecekan tegangan DC output busbar (53.5V - 54.5V)', 'checked' => true, 'keterangan' => '53.7 VDC stabil'],
                ['item' => 'Pengukuran total arus beban DC (Ampere)', 'checked' => true, 'keterangan' => '331 A (kapasitas 1200 A)'],
                ['item' => 'Pemeriksaan modul penyearah (rectifier module)', 'checked' => true, 'keterangan' => 'Semua modul menyala normal'],
                ['item' => 'Pemeriksaan koneksi baterai Hoppecke 1 & 2', 'checked' => true, 'keterangan' => '53.4 VDC | 1000 Ah terkoneksi baik'],
                ['item' => 'Pemeriksaan alarm controller & suhu ruang rectifier', 'checked' => true, 'keterangan' => 'No Alarm, suhu ruang 23.0°C'],
            ],
        ]);

        // F. Maintenance Rectifier SAJAS 2 (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['RCT-02']->id,
            'user_id'      => $teknisi2->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi harian Catu Daya DC Rectifier SAJAS 2. Tegangan output 53.9 VDC, beban arus 325 A (kapasitas 1200 A). Baterai terhubung Hoppecke 3 & 4 (53.4 VDC / 1000 Ah). Beban terbagi seimbang dengan SAJAS 1.',
            'checklist'    => [
                ['item' => 'Pengecekan tegangan DC output busbar (53.5V - 54.5V)', 'checked' => true, 'keterangan' => '53.9 VDC stabil'],
                ['item' => 'Pengukuran total arus beban DC (Ampere)', 'checked' => true, 'keterangan' => '325 A (kapasitas 1200 A)'],
                ['item' => 'Pemeriksaan modul penyearah aktif', 'checked' => true, 'keterangan' => 'Beroperasi seimbang'],
                ['item' => 'Pemeriksaan koneksi baterai Hoppecke 3 & 4', 'checked' => true, 'keterangan' => '53.4 VDC | 1000 Ah terkoneksi baik'],
                ['item' => 'Pemeriksaan suhu modul & fan pendingin', 'checked' => true, 'keterangan' => 'Fan bekerja halus, tidak bising'],
            ],
        ]);

        // G. Maintenance Bank Baterai Hoppecke 1 (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['BAT-01']->id,
            'user_id'      => $teknisi1->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Pemeriksaan bank baterai Hoppecke 1 (1000 Ah). Tegangan float 53.4 VDC. Suhu ruang baterai 18.6°C (kelembaban 50.2%). Kondisi fisik sel baterai bersih, tidak ada korosi terminal maupun pembengkakan sel.',
            'checklist'    => [
                ['item' => 'Pengukuran tegangan float baterai (Vdc)', 'checked' => true, 'keterangan' => '53.4 VDC'],
                ['item' => 'Pengecekan temperatur fisik sel baterai', 'checked' => true, 'keterangan' => 'Suhu sel stabil 18.6°C'],
                ['item' => 'Pemeriksaan visual terminal dan kabel interkoneksi', 'checked' => true, 'keterangan' => 'Koneksi kencang, bebas jamur'],
                ['item' => 'Pemeriksaan ventilasi dan kelembaban ruang baterai', 'checked' => true, 'keterangan' => 'Kelembaban 50.2% optimal'],
            ],
        ]);

        // H. Maintenance AC Ruang PNG (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['AC-PNG-01']->id,
            'user_id'      => $teknisi2->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi sistem pendingin R. PNG. Suhu ruangan tercatat 19.2°C, kelembaban 52.7%. Status AC: Daikin 1 (On Normal), Daikin 2 (On Normal), Hairf 3 (Off Standby), Hairf 4 (Off Standby). Pembuangan air kondensasi lancar.',
            'checklist'    => [
                ['item' => 'Pengukuran suhu ruangan R. PNG (target 18°C - 22°C)', 'checked' => true, 'keterangan' => '19.2°C (Sangat Baik)'],
                ['item' => 'Pengukuran kelembaban ruangan (RH 40% - 60%)', 'checked' => true, 'keterangan' => '52.7% (Ideal)'],
                ['item' => 'Verifikasi status operasional unit AC Daikin 1 & 2', 'checked' => true, 'keterangan' => 'On Normal'],
                ['item' => 'Verifikasi status standby unit AC Hairf 3 & 4', 'checked' => true, 'keterangan' => 'Off Standby Normal'],
                ['item' => 'Pemeriksaan saluran drainase air pembuangan', 'checked' => true, 'keterangan' => 'Lancar, tidak mampet'],
            ],
        ]);

        // I. Maintenance AC Ruang NGN (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['AC-NGN-01']->id,
            'user_id'      => $teknisi1->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi pendingin R. NGN. Suhu ruangan 23.9°C, kelembaban 41.1%. Status AC: Daikin 1 (On Normal), Daikin 2 (On Normal), Citec 3 (On Normal), Citec 4 (On Normal), Hairf 5 (On Normal). Pendinginan optimal.',
            'checklist'    => [
                ['item' => 'Pengukuran suhu ruangan R. NGN', 'checked' => true, 'keterangan' => '23.9°C (Normal)'],
                ['item' => 'Pengukuran kelembaban ruangan R. NGN', 'checked' => true, 'keterangan' => '41.1% (Stabil)'],
                ['item' => 'Pengecekan unit AC Daikin 1 & 2', 'checked' => true, 'keterangan' => 'On Normal'],
                ['item' => 'Pengecekan unit AC Citec 3 & 4', 'checked' => true, 'keterangan' => 'On Normal'],
                ['item' => 'Pengecekan unit AC Hairf 5', 'checked' => true, 'keterangan' => 'On Normal'],
            ],
        ]);

        // J. Maintenance AC Ruang Rectifier (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['AC-RCT-01']->id,
            'user_id'      => $teknisi2->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi pendingin R. Rectifier. Suhu ruangan 23.0°C, kelembaban 46.7%. Status AC: Daikin 1 (On Normal), Daikin 2 (On Normal). Hawa panas modul rectifier terbuang dengan baik.',
            'checklist'    => [
                ['item' => 'Pengukuran suhu ruangan R. Rectifier', 'checked' => true, 'keterangan' => '23.0°C'],
                ['item' => 'Pengukuran kelembaban ruangan R. Rectifier', 'checked' => true, 'keterangan' => '46.7%'],
                ['item' => 'Verifikasi status operasional AC Daikin 1 & 2', 'checked' => true, 'keterangan' => 'On Normal'],
                ['item' => 'Pembersihan kisi-kisi filter udara indoor AC', 'checked' => true, 'keterangan' => 'Bersih'],
            ],
        ]);

        // K. Maintenance AC Ruang Baterai (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['AC-BAT-01']->id,
            'user_id'      => $teknisi1->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Inspeksi pendingin R. Baterai. Suhu ruangan 18.6°C, kelembaban 50.2%. Status AC: Daikin 1 (On Normal), Daikin 2 (Off Normal - Standby). Suhu dingin terjaga untuk menjaga umur pakai sel baterai VRLA.',
            'checklist'    => [
                ['item' => 'Pengukuran suhu ruangan R. Baterai (< 20°C)', 'checked' => true, 'keterangan' => '18.6°C (Sangat Optimal)'],
                ['item' => 'Pengukuran kelembaban ruangan R. Baterai', 'checked' => true, 'keterangan' => '50.2%'],
                ['item' => 'Pengecekan unit AC Daikin 1 (Duty Unit)', 'checked' => true, 'keterangan' => 'On Normal'],
                ['item' => 'Pengecekan unit AC Daikin 2 (Standby Unit)', 'checked' => true, 'keterangan' => 'Off Standby Normal'],
            ],
        ]);

        // L. Maintenance DWDM Backbone (2026-09-08)
        Maintenance::create([
            'perangkat_id' => $createdPerangkats['DWD-01']->id,
            'user_id'      => $teknisi2->id,
            'tanggal'      => Carbon::create(2026, 9, 8),
            'periode'      => 'Harian',
            'status'       => 'Selesai',
            'keterangan'   => 'Pemeriksaan alpro transmisi DWDM optik backbone STO Base-G. Status normal, tidak ada alarm loss of signal (LOS), catu daya DC ganda dari SAJAS 1 & 2 stabil.',
            'checklist'    => [
                ['item' => 'Pemeriksaan LED indikator status optik & board', 'checked' => true, 'keterangan' => 'Hijau Normal, No Alarm'],
                ['item' => 'Pengecekan level tegangan catu daya ganda (Dual Feed DC)', 'checked' => true, 'keterangan' => 'Dual feed 53.7V / 53.9V aktif'],
                ['item' => 'Pemeriksaan kerapian patch cord kabel fiber optik', 'checked' => true, 'keterangan' => 'Rapi pada ODF / tray'],
                ['item' => 'Pemeriksaan suhu rak transmisi DWDM', 'checked' => true, 'keterangan' => 'Suhu rak 21°C stabil'],
            ],
        ]);
    }
}
