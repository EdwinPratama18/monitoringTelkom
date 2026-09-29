<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring Maintenance STO Witel Base-G | Telkom Indonesia</title>
    <meta name="description" content="Sistem Informasi Monitoring dan Pelaporan Maintenance Perangkat Infrastruktur Telekomunikasi STO Witel Base-G Jayapura">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-logo.png') }}?v=2">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-logo.png') }}?v=2">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --telkom-red: #E11D24;
            --telkom-red-dark: #B91C1C;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
            background: radial-gradient(circle at 50% 0%, #1E293B 0%, #0F172A 50%, #0B1120 100%);
            color: #F8FAFC;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        .portal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            background: rgba(11, 17, 32, 0.8);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .header-content {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-box {
            background-color: #FFFFFF;
            padding: 6px 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .btn-enter {
            background: linear-gradient(135deg, var(--telkom-red) 0%, var(--telkom-red-dark) 100%);
            color: #FFFFFF;
            font-weight: 600;
            font-size: 13.5px;
            padding: 9px 20px;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(225, 29, 36, 0.35);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-enter:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(225, 29, 36, 0.45);
            color: #FFFFFF;
        }

        .hero-section {
            padding: 70px 0 50px;
            text-align: center;
            flex: 1;
        }

        .chip-noc {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(225, 29, 36, 0.1);
            border: 1px solid rgba(225, 29, 36, 0.3);
            border-radius: 9999px;
            font-size: 12px;
            color: #FCA5A5;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 24px;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background-color: #10B981;
            border-radius: 50%;
            box-shadow: 0 0 8px #10B981;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.03em;
            margin: 0 auto 18px;
            max-width: 820px;
            color: #FFFFFF;
        }

        .hero-title span {
            background: linear-gradient(135deg, #FFFFFF 0%, #94A3B8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 16px;
            color: #94A3B8;
            max-width: 680px;
            margin: 0 auto 36px;
            line-height: 1.6;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 48px;
            text-align: left;
        }

        .feature-card {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 24px;
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
        }

        .feature-card:hover {
            border-color: rgba(225, 29, 36, 0.4);
            transform: translateY(-3px);
            background: rgba(30, 41, 59, 0.7);
        }

        .feature-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(225, 29, 36, 0.12);
            color: var(--telkom-red);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .portal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 20px 0;
            font-size: 12.5px;
            color: #64748B;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="portal-header">
        <div class="container-custom">
            <div class="header-content">
                <a href="{{ url('/') }}" class="brand-badge">
                    <div class="logo-box">
                        <img src="{{ asset('images/telkom-logo.png') }}" alt="Telkom Indonesia" style="height: 24px; width: auto; object-fit: contain;">
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 800; color: #FFFFFF; letter-spacing: 0.5px;">STO WITEL BASE-G</div>
                        <div style="font-size: 11px; color: #94A3B8;">Papua • Jayapura</div>
                    </div>
                </a>

                <div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-enter">
                            <span>Buka Dashboard</span>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-enter">
                            <span>Login Petugas / Teknisi</span>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Content -->
    <main class="hero-section">
        <div class="container-custom">
            <div class="chip-noc">
                <span class="live-dot"></span>
                <span>NETWORK OPERATIONS CENTER STO BASE-G</span>
            </div>

            <h1 class="hero-title">
                Sistem Monitoring & Pemeliharaan <span>Infrastruktur Telekomunikasi</span>
            </h1>

            <p class="hero-desc">
                Portal operasional terpadu STO Witel Base-G Jayapura untuk pengawasan real-time kelistrikan DEFA, rectifiers, baterai cadangan, perangkat transmisi DWDM, routing, dan audit checklist teknisi.
            </p>

            <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-enter" style="padding: 12px 28px; font-size: 15px;">
                        <span>Masuk ke Dashboard Sistem</span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-enter" style="padding: 12px 28px; font-size: 15px;">
                        <span>Masuk ke Sistem Monitoring</span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- Features Cards -->
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon-wrap">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #FFFFFF; margin: 0 0 8px;">Telemetri Daya & Kelistrikan</h3>
                    <p style="font-size: 13px; color: #94A3B8; line-height: 1.5; margin: 0;">
                        Pemantauan kontinyu status PLN, Genset DEFA otomatis, level tegangan rectifier DC 48V, dan kapasitas bank baterai.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrap">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #FFFFFF; margin: 0 0 8px;">Audit Checklist Lapangan</h3>
                    <p style="font-size: 13px; color: #94A3B8; line-height: 1.5; margin: 0;">
                        Verifikasi terstandarisasi untuk pemeliharaan preventif berkala, dokumentasi foto eviden fisik, dan validasi kondisi rak.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrap">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #FFFFFF; margin: 0 0 8px;">Pelaporan Resmi & Ekspor PDF</h3>
                    <p style="font-size: 13px; color: #94A3B8; line-height: 1.5; margin: 0;">
                        Penerbitan rekapitulasi performa perangkat dan riwayat kegiatan maintenance dalam format laporan resmi siap cetak.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container-custom">
            &copy; {{ date('Y') }} PT Telkom Indonesia (Persero) Tbk — STO Witel Base-G Jayapura. Divisi Infrastruktur & Jaringan.
        </div>
    </footer>

</body>
</html>
