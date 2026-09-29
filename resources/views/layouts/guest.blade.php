<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login — STO Witel Base-G</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-logo.png') }}?v=2">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-logo.png') }}?v=2">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #F1F5F9;
            color: #0F172A;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            -webkit-font-smoothing: antialiased;
        }

        .login-wrapper {
            width: 100%;
            max-width: 370px;
            margin: auto;
        }

        .login-box {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 34px 28px;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
        }

        .login-header {
            text-align: center;
            margin-bottom: 26px;
        }

        .login-logo {
            height: 56px;
            width: auto;
            margin: 0 auto 12px;
            display: block;
            object-fit: contain;
        }

        .login-title {
            font-size: 15px;
            font-weight: 700;
            color: #0F172A;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .login-subtitle {
            font-size: 11.5px;
            color: #64748B;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .input-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            height: 42px;
            padding: 0 12px;
            font-size: 13.5px;
            color: #0F172A;
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-input::placeholder {
            color: #94A3B8;
        }

        .form-input:focus {
            border-color: #C91F18 !important;
            box-shadow: 0 0 0 3px rgba(201, 31, 24, 0.12) !important;
            outline: none !important;
        }

        .form-input.is-error {
            border-color: #DC2626 !important;
        }

        .error-message {
            font-size: 11.5px;
            color: #DC2626;
            margin-top: 4px;
            display: block;
        }

        .btn-login {
            width: 100%;
            height: 42px;
            background-color: #C91F18;
            color: #FFFFFF;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 6px;
            transition: background-color 0.15s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-login:hover {
            background-color: #A71913;
        }

        .btn-login:active {
            background-color: #8E140F;
        }

        .login-footer {
            margin-top: 22px;
            padding-top: 16px;
            border-top: 1px solid #F1F5F9;
            text-align: center;
            font-size: 11px;
            color: #94A3B8;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        {{ $slot }}
    </div>
</body>
</html>
