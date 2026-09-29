<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}Monitoring Maintenance STO Witel Base-G</title>
    <meta name="description" content="Sistem Informasi Monitoring dan Pelaporan Maintenance Perangkat Infrastruktur Telekomunikasi STO Witel Base-G">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-logo.png') }}?v=2">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-logo.png') }}?v=2">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <!-- Vite Assets (Tailwind & Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --telkom-red: #C91F18;
            --telkom-red-dark: #9F1610;
            --telkom-red-subtle: #FEF2F2;
            --telkom-red-border: #FCA5A5;
            --sidebar-width: 252px;
            --topbar-height: 60px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        code, pre, .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* ===== SIDEBAR ===== */
        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background-color: #0F172A;
            border-right: 1px solid #1E293B;
            z-index: 50;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease-in-out;
        }

        .sidebar-brand {
            height: var(--topbar-height);
            padding: 0 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #1E293B;
            background-color: #0B1120;
        }

        .brand-emblem {
            width: 34px;
            height: 34px;
            background-color: var(--telkom-red);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: -0.5px;
            flex-shrink: 0;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
        }

        .brand-meta {
            overflow: hidden;
            line-height: 1.25;
        }

        .brand-meta .title {
            font-size: 13px;
            font-weight: 700;
            color: #F8FAFC;
            letter-spacing: 0.2px;
            white-space: nowrap;
        }

        .brand-meta .subtitle {
            font-size: 11px;
            color: #94A3B8;
            letter-spacing: 0.1px;
            white-space: nowrap;
        }

        .sidebar-nav-container {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
        }

        .nav-section-title {
            font-size: 10.5px;
            font-weight: 600;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 8px 10px 4px;
            margin-bottom: 2px;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8.5px 12px;
            margin-bottom: 2px;
            border-radius: 6px;
            color: #94A3B8;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s ease;
            position: relative;
        }

        .nav-link-item:hover {
            color: #F8FAFC;
            background-color: #1E293B;
            text-decoration: none;
        }

        .nav-link-item.active {
            color: #FFFFFF;
            background-color: var(--telkom-red);
            font-weight: 600;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .nav-link-item.active svg {
            color: #FFFFFF;
        }

        .nav-link-item svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            color: #64748B;
            transition: color 0.15s ease;
        }

        .nav-link-item:hover svg {
            color: #CBD5E1;
        }

        .sidebar-footer {
            padding: 14px 14px;
            border-top: 1px solid #1E293B;
            background-color: #0B1120;
        }

        .user-profile-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background-color: #334155;
            color: #E2E8F0;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            flex-shrink: 0;
            border: 1px solid #475569;
        }

        .user-text-info {
            line-height: 1.25;
            overflow: hidden;
            flex: 1;
        }

        .user-name-label {
            font-size: 12.5px;
            font-weight: 600;
            color: #F8FAFC;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role-badge {
            font-size: 11px;
            color: #94A3B8;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .role-indicator-dot {
            width: 6px;
            height: 6px;
            background-color: #10B981;
            border-radius: 50%;
            display: inline-block;
        }

        .btn-sidebar-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 6px;
            border: 1px solid #334155;
            background-color: transparent;
            color: #94A3B8;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-sidebar-logout:hover {
            background-color: #1E293B;
            color: #F8FAFC;
            border-color: #475569;
        }

        /* ===== TOPBAR ===== */
        .app-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background-color: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 40;
            transition: left 0.25s ease-in-out;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-mobile-toggle {
            display: none;
            padding: 6px;
            border-radius: 6px;
            border: 1px solid #CBD5E1;
            background: #FFFFFF;
            color: #475569;
            cursor: pointer;
        }

        .topbar-header-info {
            display: flex;
            flex-direction: column;
            line-height: 1.25;
        }

        .topbar-page-title {
            font-size: 15px;
            font-weight: 600;
            color: #0F172A;
            margin: 0;
        }

        .topbar-facility-tag {
            font-size: 11.5px;
            color: #64748B;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .operational-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background-color: #F1F5F9;
            border: 1px solid #E2E8F0;
            border-radius: 4px;
            font-size: 11.5px;
            color: #475569;
            font-weight: 500;
        }

        .live-indicator {
            width: 7px;
            height: 7px;
            background-color: #16A34A;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.2);
        }

        /* ===== MAIN CONTENT WRAPPER ===== */
        .app-main {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            background-color: #F8FAFC;
        }

        .app-content-container {
            padding: 24px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ===== ENTERPRISE CARDS ===== */
        .card {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-header {
            padding: 14px 18px;
            background-color: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .card-header-subtle {
            background-color: #F8FAFC;
        }

        .card-title {
            font-size: 13.5px;
            font-weight: 600;
            color: #0F172A;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-subtitle {
            font-size: 12px;
            color: #64748B;
            margin-top: 2px;
        }

        .card-body {
            padding: 18px;
        }

        .card-footer {
            padding: 12px 18px;
            background-color: #F8FAFC;
            border-top: 1px solid #E2E8F0;
        }

        /* ===== KPI & STATS METRICS ===== */
        .metric-card {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            padding: 16px 18px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
            position: relative;
        }

        .metric-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .metric-label {
            font-size: 12px;
            font-weight: 500;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .metric-icon-wrap {
            width: 28px;
            height: 28px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            background-color: #F1F5F9;
        }

        .metric-icon-wrap svg {
            width: 16px;
            height: 16px;
        }

        .metric-value {
            font-size: 24px;
            font-weight: 700;
            color: #0F172A;
            line-height: 1.1;
            letter-spacing: -0.5px;
        }

        .metric-subtext {
            font-size: 11.5px;
            color: #64748B;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Metric Accent borders */
        .metric-border-primary { border-left: 3.5px solid #0F172A; }
        .metric-border-success { border-left: 3.5px solid #16A34A; }
        .metric-border-warning { border-left: 3.5px solid #D97706; }
        .metric-border-danger  { border-left: 3.5px solid #DC2626; }
        .metric-border-telkom  { border-left: 3.5px solid var(--telkom-red); }

        /* ===== TABLES ===== */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .app-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
            text-align: left;
        }

        .app-table thead th {
            background-color: #F8FAFC;
            color: #475569;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 14px;
            border-bottom: 1px solid #E2E8F0;
            white-space: nowrap;
        }

        .app-table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid #F1F5F9;
            color: #1E293B;
            vertical-align: middle;
        }

        .app-table tbody tr:hover td {
            background-color: #F8FAFC;
        }

        .app-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 7px 12px;
            font-size: 12.5px;
            font-weight: 500;
            border-radius: 5px;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            line-height: 1.3;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .btn:hover { text-decoration: none; }

        .btn svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        .btn-sm {
            padding: 4px 9px;
            font-size: 11.5px;
            border-radius: 4px;
        }

        .btn-sm svg {
            width: 12px;
            height: 12px;
        }

        .btn-primary {
            background-color: var(--telkom-red);
            border-color: var(--telkom-red);
            color: #FFFFFF;
        }

        .btn-primary:hover {
            background-color: var(--telkom-red-dark);
            border-color: var(--telkom-red-dark);
            color: #FFFFFF;
        }

        .btn-secondary {
            background-color: #FFFFFF;
            border-color: #CBD5E1;
            color: #334155;
        }

        .btn-secondary:hover {
            background-color: #F8FAFC;
            border-color: #94A3B8;
            color: #0F172A;
        }

        .btn-dark {
            background-color: #0F172A;
            border-color: #0F172A;
            color: #FFFFFF;
        }

        .btn-dark:hover {
            background-color: #1E293B;
            border-color: #1E293B;
            color: #FFFFFF;
        }

        .btn-danger {
            background-color: #DC2626;
            border-color: #DC2626;
            color: #FFFFFF;
        }

        .btn-danger:hover {
            background-color: #B91C1C;
            border-color: #B91C1C;
            color: #FFFFFF;
        }

        .btn-warning {
            background-color: #FFFBEB;
            border-color: #FDE68A;
            color: #B45309;
        }

        .btn-warning:hover {
            background-color: #FEF3C7;
            border-color: #FCD34D;
            color: #92400E;
        }

        .btn-info {
            background-color: #F0FDF4;
            border-color: #BBF7D0;
            color: #166534;
        }

        .btn-info:hover {
            background-color: #DCFCE7;
            border-color: #86EFAC;
            color: #14532D;
        }

        .btn-action-view {
            background-color: #F8FAFC;
            border-color: #E2E8F0;
            color: #475569;
        }

        .btn-action-view:hover {
            background-color: #F1F5F9;
            border-color: #CBD5E1;
            color: #0F172A;
        }

        /* ===== BADGES ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 2.5px 8px;
            font-size: 11px;
            font-weight: 500;
            border-radius: 4px;
            line-height: 1.3;
            white-space: nowrap;
        }

        .badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
        }

        .badge-success {
            background-color: #F0FDF4;
            color: #166534;
            border: 1px solid #BBF7D0;
        }
        .badge-success .badge-dot { background-color: #16A34A; }

        .badge-warning {
            background-color: #FFFBEB;
            color: #92400E;
            border: 1px solid #FDE68A;
        }
        .badge-warning .badge-dot { background-color: #D97706; }

        .badge-danger {
            background-color: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }
        .badge-danger .badge-dot { background-color: #DC2626; }

        .badge-info {
            background-color: #EFF6FF;
            color: #1E40AF;
            border: 1px solid #BFDBFE;
        }
        .badge-info .badge-dot { background-color: #2563EB; }

        .badge-secondary {
            background-color: #F1F5F9;
            color: #475569;
            border: 1px solid #CBD5E1;
        }
        .badge-secondary .badge-dot { background-color: #64748B; }

        /* Monospace Code Pill */
        .code-pill {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            background-color: #F1F5F9;
            color: #334155;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid #E2E8F0;
            font-weight: 500;
            display: inline-block;
        }

        /* ===== FORMS & FILTERS ===== */
        .filter-toolbar {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            padding: 14px 18px;
            margin-bottom: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
        }

        .filter-item {
            flex: 1;
            min-width: 140px;
        }

        .filter-item-search {
            min-width: 220px;
        }

        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            height: 35px;
            padding: 6px 10px;
            font-size: 13px;
            color: #1E293B;
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-radius: 5px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        textarea.form-control {
            height: auto;
            min-height: 80px;
            padding: 8px 10px;
        }

        .form-control:focus {
            border-color: #0F172A;
            box-shadow: 0 0 0 1px #0F172A;
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #DC2626;
        }

        .invalid-feedback {
            font-size: 11.5px;
            color: #DC2626;
            margin-top: 4px;
        }

        /* ===== ALERTS ===== */
        .app-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            line-height: 1.4;
            margin-bottom: 18px;
            border: 1px solid transparent;
        }

        .app-alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .app-alert-success {
            background-color: #F0FDF4;
            border-color: #BBF7D0;
            color: #166534;
        }

        .app-alert-danger {
            background-color: #FEF2F2;
            border-color: #FECACA;
            color: #991B1B;
        }

        .app-alert-warning {
            background-color: #FFFBEB;
            border-color: #FDE68A;
            color: #92400E;
        }

        .app-alert-info {
            background-color: #EFF6FF;
            border-color: #BFDBFE;
            color: #1E40AF;
        }

        /* ===== PAGE HEADER ===== */
        .page-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .page-heading-title {
            font-size: 18px;
            font-weight: 700;
            color: #0F172A;
            letter-spacing: -0.3px;
            margin: 0;
        }

        .page-heading-desc {
            font-size: 12.5px;
            color: #64748B;
            margin-top: 2px;
        }

        /* ===== OPERATIONAL CHECKLIST ===== */
        .checklist-item-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 14px;
            border: 1px solid #E2E8F0;
            border-radius: 5px;
            margin-bottom: 8px;
            background-color: #FFFFFF;
            transition: border-color 0.15s ease, background-color 0.15s ease;
        }

        .checklist-item-row:hover {
            border-color: #CBD5E1;
        }

        .checklist-item-row.is-checked {
            background-color: #F0FDF4;
            border-color: #BBF7D0;
        }

        .checklist-item-checkbox {
            width: 17px;
            height: 17px;
            margin-top: 2px;
            accent-color: var(--telkom-red);
            cursor: pointer;
        }

        /* ===== MODAL CSS SYSTEM ===== */
        [x-cloak] { display: none !important; }

        .app-modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(2px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-y: auto;
        }

        .app-modal-dialog {
            background-color: #FFFFFF;
            border-radius: 8px;
            border: 1px solid #CBD5E1;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 680px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            animation: modalFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .app-modal-dialog-lg {
            max-width: 860px;
        }

        .app-modal-dialog-xl {
            max-width: 1020px;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.97) translateY(-8px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .app-modal-header {
            padding: 14px 20px;
            background-color: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-shrink: 0;
        }

        .app-modal-title {
            font-size: 14.5px;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .app-modal-subtitle {
            font-size: 11.5px;
            color: #64748B;
            margin-top: 2px;
        }

        .app-modal-close {
            background: transparent;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
        }

        .app-modal-close:hover {
            background-color: #E2E8F0;
            color: #0F172A;
        }

        .app-modal-body {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .app-modal-footer {
            padding: 12px 20px;
            background-color: #F8FAFC;
            border-top: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-shrink: 0;
        }

        /* ===== MOBILE RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .app-sidebar {
                transform: translateX(-100%);
            }

            .app-sidebar.sidebar-open {
                transform: translateX(0);
            }

            .app-topbar {
                left: 0;
            }

            .app-main {
                margin-left: 0;
            }

            .btn-mobile-toggle {
                display: flex;
            }

            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                background-color: rgba(15, 23, 42, 0.6);
                z-index: 45;
            }
        }
    </style>
</head>
<body x-data="{ sidebarOpen: false }">

    <!-- MOBILE BACKDROP -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="sidebar-backdrop"
         style="display: none;"></div>

    <!-- MAIN SIDEBAR -->
    <aside class="app-sidebar" :class="{ 'sidebar-open': sidebarOpen }">
        <!-- Brand Header -->
        <div class="sidebar-brand">
            <div style="background-color: #FFFFFF; padding: 4px 6px; border-radius: 6px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(0,0,0,0.2); flex-shrink: 0;">
                <img src="{{ asset('images/telkom-logo.png') }}" alt="Telkom Indonesia" style="height: 24px; width: auto; object-fit: contain; display: block;">
            </div>
            <div class="brand-meta">
                <div class="title">STO WITEL BASE-G</div>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="sidebar-nav-container">
            <div class="nav-section-title">Menu Utama</div>

            <!-- 1. Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="nav-link-item {{ request()->routeIs('dashboard') && !request()->has('view') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- 2. Data Perangkat -->
            <a href="{{ route('perangkat.index') }}"
               class="nav-link-item {{ request()->routeIs('perangkat.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                </svg>
                <span>Data Perangkat</span>
            </a>

            <!-- 3. Maintenance -->
            <a href="{{ route('maintenance.index') }}"
               class="nav-link-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Maintenance</span>
            </a>

            <!-- 4. Monitoring (Dedicated Section on Dashboard) -->
            <a href="{{ route('dashboard') }}#monitoring"
               class="nav-link-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Monitoring</span>
            </a>

            <!-- 5. Laporan -->
            <a href="{{ route('laporan.index') }}"
               class="nav-link-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Laporan</span>
            </a>

            @if(auth()->check() && auth()->user()->isAdmin())
            <div class="nav-section-title" style="margin-top: 14px;">Administrasi</div>
            <a href="{{ route('users.index') }}"
               class="nav-link-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Manajemen User</span>
            </a>
            @endif
        </div>

        <!-- Sidebar Footer / Technician Account Info -->
        <div class="sidebar-footer">
            <div class="user-profile-badge">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-text-info">
                    <div class="user-name-label">{{ auth()->user()->name }}</div>
                    <div class="user-role-badge">
                        <span class="role-indicator-dot"></span>
                        <span>{{ auth()->user()->isAdmin() ? 'Administrator' : 'Teknisi Operasional' }}</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn-sidebar-logout" title="Keluar dari sistem">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- TOPBAR -->
    <header class="app-topbar">
        <div class="topbar-left">
            <button type="button" class="btn-mobile-toggle" @click="sidebarOpen = !sidebarOpen" aria-label="Toggle Navigation">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="topbar-header-info">
                <h1 class="topbar-page-title">{{ $title ?? 'Sistem Monitoring' }}</h1>
                <span class="topbar-facility-tag">STO Witel Base-G • Divisi Infrastruktur & Jaringan</span>
            </div>
        </div>

        <div class="topbar-right">
            <div class="operational-status-chip">
                <span class="live-indicator"></span>
                <span>Sistem Normal</span>
            </div>
            <div style="font-size: 12px; color: #64748B; font-weight: 500;" class="hidden sm:block">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="app-main">
        <div class="app-content-container">
            @if(session('success'))
            <div class="app-alert app-alert-success">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div style="flex:1;">
                    <strong>Berhasil:</strong> {{ session('success') }}
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="app-alert app-alert-danger">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div style="flex:1;">
                    <strong>Perhatian:</strong> {{ session('error') }}
                </div>
            </div>
            @endif

            {{ $slot }}
        </div>
    </main>

</body>
</html>
