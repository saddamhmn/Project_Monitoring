<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes scanline {
            0%   { transform: translateY(-100%); }
            100% { transform: translateY(500%); }
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            overflow: hidden;
            font-family: 'Figtree', sans-serif;
        }

        .login-shell {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .panel-left {
            width: 60%;
            position: relative;
            overflow: hidden;
        }
        .panel-left-bg {
            position: absolute;
            inset: 0;
            background-image: url('{{ asset("images/bgbg.png") }}');
            background-size: cover;
            background-position: center;
        }
        .panel-left-overlay {
            position: absolute;
            inset: 0;
            background: rgba(7,20,34,0.28);
        }
        .panel-left-border {
            position: absolute;
            top: 0; right: 0; bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom,
                transparent 0%,
                rgba(34,211,238,0.8) 20%,
                rgba(34,211,238,1.0) 50%,
                rgba(34,211,238,0.8) 80%,
                transparent 100%
            );
            box-shadow: 0 0 12px rgba(34,211,238,0.5), 0 0 30px rgba(34,211,238,0.15);
        }

        .panel-right {
            width: 40%;
            flex-shrink: 0;
            background: #071422;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            position: relative;
            overflow: hidden;
            animation: fadeUp 0.6s ease forwards;
            transition: background 0.3s ease;
        }
        .scanline {
            position: absolute;
            left: 0; right: 0;
            height: 20%;
            background: linear-gradient(to bottom, transparent, rgba(34,211,238,0.012), transparent);
            pointer-events: none;
            animation: scanline 5s ease-in-out infinite;
        }

        .form-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 360px;
        }

        .logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 28px;
        }
        .logo-inner {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid rgba(34,211,238,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 28px rgba(34,211,238,0.18), inset 0 0 18px rgba(34,211,238,0.04);
            margin: 0 auto 14px auto;
            padding: 0;
            overflow: hidden;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .logo-inner svg,
        .logo-inner img {
            display: block;
            margin: 0 auto;
            flex-shrink: 0;
        }
        .logo-title {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: #ffffff;
            margin-bottom: 3px;
            transition: color 0.3s ease;
        }
        .logo-sub {
            font-size: 0.6rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: rgba(34,211,238,0.7);
            margin-bottom: 2px;
        }
        .logo-sub2 {
            font-size: 0.55rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(156,163,175,0.4);
            transition: color 0.3s ease;
        }

        .form-card {
            background: rgba(10,22,40,0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(34,211,238,0.15);
            border-radius: 14px;
            padding: 28px 26px 22px;
            box-shadow: 0 0 50px rgba(0,0,0,0.4), inset 0 1px 0 rgba(34,211,238,0.08);
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-card::before {
            content: '';
            position: absolute;
            top: 0; left: 50%; transform: translateX(-50%);
            width: 100px; height: 1px;
            background: linear-gradient(to right, transparent, rgba(34,211,238,0.6), transparent);
        }
        .form-footer {
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1px solid rgba(34,211,238,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: border-color 0.3s ease;
        }
        .form-footer span {
            font-size: 10px;
            letter-spacing: 0.12em;
            color: rgba(156,163,175,0.35);
            transition: color 0.3s ease;
        }

        @media (prefers-color-scheme: light) {
            .panel-right {
                background: #e8edf2;
                background-image: linear-gradient(135deg, #e8edf2 0%, #dde4ec 100%);
            }
            .logo-inner {
                background: #ffffff;
                border-color: rgba(6,148,162,0.5);
                box-shadow: 0 0 20px rgba(6,148,162,0.12);
            }
            .logo-title {
                color: #0f172a;
            }
            .logo-sub {
                color: rgba(6,148,162,0.85);
            }
            .logo-sub2 {
                color: rgba(71,85,105,0.6);
            }
            .form-card {
                background: #ffffff;
                border-color: rgba(6,148,162,0.2);
                box-shadow: 0 4px 40px rgba(0,0,0,0.08), 0 1px 0 rgba(6,148,162,0.1);
            }
            .form-footer {
                border-top-color: rgba(6,148,162,0.12);
            }
            .form-footer span {
                color: rgba(100,116,139,0.5);
            }
            .scanline {
                display: none;
            }
        }

        .panel-bottom-footer {
            position: absolute;
            bottom: 16px;
            left: 32px;
            right: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 2;
        }
        .footer-left {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(34,211,238,0.5);
        }
        .footer-right {
            font-size: 10px;
            letter-spacing: 0.1em;
            color: rgba(156,163,175,0.35);
        }
        @media (prefers-color-scheme: light) {
            .footer-left  { color: rgba(6,148,162,0.6); }
            .footer-right { color: rgba(100,116,139,0.5); }
        }


@media (max-width: 767px) {
    .login-shell { flex-direction: column; }
    .panel-left  { display: none; }

    .panel-right {
        width: 100%;
        min-height: 100vh;
        padding: 40px 24px;
    }
    .form-container,
    .panel-bottom-footer,
    .scanline { z-index: 1; }
}


@media (max-width: 767px) and (prefers-color-scheme: dark) {
    .panel-right {
        background-image: url('{{ asset("images/bgbg.png") }}');
        background-size: cover;
        background-position: center;
        background-color: transparent;
    }
    .panel-right::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(7, 20, 34, 0.72);
        z-index: 0;
    }
    .logo-title { color: #ffffff !important; }
    .logo-sub   { color: rgba(34,211,238,0.8) !important; }
    .logo-sub2  { color: rgba(156,163,175,0.5) !important; }
    .logo-inner {
        background: rgba(7,20,34,0.6) !important;
        border-color: rgba(34,211,238,0.5) !important;
    }
    .logo-icon-color { color: #22d3ee !important; }
    .form-card {
        background: rgba(10,22,40,0.85) !important;
        border-color: rgba(34,211,238,0.15) !important;
    }
    .footer-left  { color: rgba(34,211,238,0.5) !important; }
    .footer-right { color: rgba(156,163,175,0.35) !important; }
}


@media (max-width: 767px) and (prefers-color-scheme: light) {
    .panel-right {
        background-image: url('{{ asset("images/bgbg.png") }}') !important;
        background-size: cover !important;
        background-position: center !important;
        background-color: transparent !important;
    }
    .panel-right::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(232, 237, 242, 0.75);
        z-index: 0;
        display: block !important;
    }
    .logo-icon-color { color: #0891b2 !important; }
    .form-card {
        background: #ffffff !important;
        border-color: rgba(6,148,162,0.2) !important;
        box-shadow: 0 4px 40px rgba(0,0,0,0.08), 0 1px 0 rgba(6,148,162,0.1) !important;
    }
    .footer-left  { color: rgba(6,148,162,0.6) !important; }
    .footer-right { color: rgba(100,116,139,0.5) !important; }
}
    </style>
</head>
<body>

<div class="login-shell">

    <div class="panel-left">
        <div class="panel-left-bg"></div>
        <div class="panel-left-overlay"></div>
        <div class="panel-left-border"></div>
    </div>


    <div class="panel-right">
        <div class="scanline"></div>

        <div class="form-container">

            <div class="logo-wrap">
                <div class="logo-inner">
                    <x-application-logo class="w-11 h-11 fill-current logo-icon-color block mx-auto" style="display:block;margin:0 auto;" />
                </div>
                <p class="logo-title">DHOHO</p>
                <p class="logo-sub">Monitoring CCTV</p>
            </div>


            <div class="form-card">
                {{ $slot }}
                <div class="form-footer">
                    <span>v1.0.0</span>
                </div>
            </div>
        </div>

        <div class="panel-bottom-footer">
            <span class="footer-left">SI UNESA 2026</span>
            <span class="footer-right">© 2026 Bandara Internasional Dhoho Kediri</span>
        </div>
    </div>

</div>

</body>
</html>