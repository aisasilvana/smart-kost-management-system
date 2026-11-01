<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#F7F2EB">
    <meta name="description" content="Smart Kost membantu pemilik kost mengelola properti, kamar, penghuni, tagihan, dan pembayaran dalam satu platform.">
    <title>{{ config('app.name', 'Smart Kost') }} — Smart management for better living</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --brown-dark: #493126;
            --brown: #684936;
            --brown-medium: #8B654D;
            --brown-light: #B58B6B;
            --beige: #E7D3BE;
            --cream: #F7F2EB;
            --cream-dark: #EFE5D9;
            --white: #FFFFFF;
            --text: #493A30;
            --muted: #99877A;
            --border: #E9DED3;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: #FFFEFC;
            color: var(--text);
            font-family: 'Manrope', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        button { font: inherit; }
        .site-shell { overflow: hidden; }
        .container { width: min(1160px, calc(100% - 48px)); margin: 0 auto; }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255,254,252,.92);
            border-bottom: 1px solid rgba(233,222,211,.8);
            backdrop-filter: blur(16px);
        }
        .nav-inner {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
        }
        .brand {
            color: var(--brown-dark);
            font-family: 'DM Sans', sans-serif;
            font-size: 29px;
            font-weight: 800;
            letter-spacing: -2px;
            line-height: 1;
        }
        .brand span { color: var(--brown-light); }
        .nav-links { display: flex; align-items: center; gap: 34px; }
        .nav-links a {
            color: #806F61;
            font-size: 12px;
            font-weight: 700;
            transition: color .2s ease;
        }
        .nav-links a:hover { color: var(--brown-dark); }
        .nav-actions { display: flex; align-items: center; gap: 12px; }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 45px;
            padding: 0 21px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 800;
            transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
            cursor: pointer;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-outline { color: var(--brown); border-color: var(--border); background: #fff; }
        .btn-outline:hover { background: var(--cream); }
        .btn-primary {
            color: #fff;
            background: var(--brown);
            box-shadow: 0 7px 16px rgba(73,49,38,.12);
        }
        .btn-primary:hover { background: var(--brown-dark); box-shadow: 0 10px 20px rgba(73,49,38,.17); }
        .btn svg { width: 15px; height: 15px; }

        .hero {
            position: relative;
            padding: 82px 0 90px;
            background:
                radial-gradient(ellipse at 82% 22%, rgba(231,211,190,.45), transparent 34%),
                linear-gradient(180deg, #FBF8F3 0%, #FFFEFC 100%);
        }
        .hero-grid {
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            align-items: center;
            gap: 58px;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 8px 13px;
            border: 1px solid #E9DED3;
            border-radius: 99px;
            background: rgba(255,255,255,.75);
            color: var(--brown-medium);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.1px;
            text-transform: uppercase;
        }
        .eyebrow-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #9B765B;
            box-shadow: 0 0 0 4px rgba(181,139,107,.15);
        }
        .hero h1 {
            max-width: 620px;
            margin: 22px 0 18px;
            color: var(--brown-dark);
            font-size: clamp(39px, 5.2vw, 61px);
            font-weight: 800;
            letter-spacing: -3.4px;
            line-height: 1.13;
        }
        .hero h1 em { color: var(--brown-light); font-style: normal; }
        .hero-copy {
            max-width: 490px;
            color: #89796D;
            font-size: 14px;
            line-height: 1.95;
        }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 29px; }
        .hero-note {
            display: flex; align-items: center; gap: 10px;
            margin-top: 28px; color: #9A8B7F; font-size: 10px; font-weight: 600;
        }
        .hero-note svg { width: 16px; height: 16px; color: #8B654D; }

        .visual-wrap { position: relative; min-height: 430px; display: flex; align-items: center; justify-content: center; }
        .visual-orbit {
            position: absolute; width: 390px; height: 390px; border-radius: 50%;
            background: #F1E4D6; opacity: .75;
        }
        .visual-orbit:before, .visual-orbit:after {
            content: ''; position: absolute; border: 1px solid rgba(139,101,77,.16); border-radius: 50%;
        }
        .visual-orbit:before { inset: 24px; }
        .visual-orbit:after { inset: 52px; }
        .dashboard-card {
            position: relative; z-index: 2; width: min(440px, 100%);
            padding: 23px; border: 1px solid rgba(233,222,211,.95); border-radius: 18px;
            background: rgba(255,255,255,.96); box-shadow: 0 25px 65px rgba(73,49,38,.13);
            transform: rotate(-2deg);
        }
        .dash-top { display: flex; justify-content: space-between; align-items: center; gap: 12px; }
        .dash-title { color: var(--brown-dark); font-size: 13px; font-weight: 800; }
        .dash-subtitle { margin-top: 4px; color: #A39488; font-size: 9px; }
        .dash-pill { padding: 7px 10px; border-radius: 7px; background: #F5EEE6; color: var(--brown-medium); font-size: 9px; font-weight: 800; }
        .dash-stats { display: grid; grid-template-columns: repeat(2,1fr); gap: 11px; margin-top: 22px; }
        .dash-stat { padding: 15px; border: 1px solid #F0E8E0; border-radius: 11px; background: #FFFEFC; }
        .dash-stat-label { color: #A39488; font-size: 9px; font-weight: 700; }
        .dash-stat-value { margin-top: 8px; color: var(--brown-dark); font-size: 25px; font-weight: 800; letter-spacing: -1px; }
        .dash-stat-foot { margin-top: 4px; color: #8B9A7D; font-size: 8px; font-weight: 700; }
        .dash-chart { margin-top: 13px; padding: 15px; border: 1px solid #F0E8E0; border-radius: 11px; }
        .chart-head { display: flex; justify-content: space-between; align-items: center; color: var(--brown); font-size: 10px; font-weight: 800; }
        .chart-head span:last-child { color: #A39488; font-size: 8px; font-weight: 600; }
        .chart-bars { height: 76px; display: flex; align-items: end; gap: 10px; padding: 10px 7px 0; }
        .chart-bars i { flex: 1; border-radius: 4px 4px 1px 1px; background: #D9C2AA; }
        .chart-bars i:nth-child(2n) { background: #8B654D; }
        .chart-bars i:nth-child(1) { height: 34%; }
        .chart-bars i:nth-child(2) { height: 56%; }
        .chart-bars i:nth-child(3) { height: 45%; }
        .chart-bars i:nth-child(4) { height: 76%; }
        .chart-bars i:nth-child(5) { height: 60%; }
        .chart-bars i:nth-child(6) { height: 88%; }
        .chart-bars i:nth-child(7) { height: 70%; }
        .chart-days { display: flex; justify-content: space-between; padding: 6px 5px 0; color: #B1A398; font-size: 8px; }
        .float-note {
            position: absolute; z-index: 3; display: flex; align-items: center; gap: 10px;
            padding: 13px 16px; border: 1px solid #E9DED3; border-radius: 12px;
            background: #fff; box-shadow: 0 12px 30px rgba(73,49,38,.10);
        }
        .float-note.one { top: 48px; right: -4px; }
        .float-note.two { bottom: 35px; left: -15px; }
        .float-icon { display: grid; place-items: center; width: 33px; height: 33px; border-radius: 9px; background: #F4EAE0; color: var(--brown); }
        .float-icon svg { width: 17px; height: 17px; }
        .float-text strong { display: block; color: var(--brown-dark); font-size: 10px; }
        .float-text span { display: block; margin-top: 3px; color: #A39488; font-size: 8px; }

        .trust-strip { padding: 22px 0; border-top: 1px solid #F0E8E0; border-bottom: 1px solid #F0E8E0; background: #fff; }
        .trust-inner { display: flex; align-items: center; justify-content: center; gap: 48px; flex-wrap: wrap; }
        .trust-item { display: flex; align-items: center; gap: 9px; color: #8E7D70; font-size: 10px; font-weight: 800; }
        .trust-item svg { width: 17px; height: 17px; color: var(--brown-light); }

        .section { padding: 88px 0; }
        .section-heading { max-width: 610px; margin: 0 auto 43px; text-align: center; }
        .section-kicker { color: var(--brown-light); font-size: 10px; font-weight: 800; letter-spacing: 1.8px; text-transform: uppercase; }
        .section-heading h2 { margin: 13px 0 12px; color: var(--brown-dark); font-size: clamp(28px,3.4vw,39px); font-weight: 800; letter-spacing: -1.8px; line-height: 1.2; }
        .section-heading p { color: #948477; font-size: 12px; line-height: 1.9; }
        .features { background: #FFFEFC; }
        .feature-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 17px; }
        .feature-card {
            padding: 27px 25px; border: 1px solid var(--border); border-radius: 14px;
            background: #fff; transition: transform .25s ease, box-shadow .25s ease;
        }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(73,49,38,.07); }
        .feature-icon { display: grid; place-items: center; width: 47px; height: 47px; border-radius: 12px; background: #F5EEE6; color: var(--brown); }
        .feature-icon svg { width: 22px; height: 22px; }
        .feature-card h3 { margin: 20px 0 9px; color: var(--brown-dark); font-size: 14px; font-weight: 800; }
        .feature-card p { margin: 0; color: #948477; font-size: 11px; line-height: 1.9; }

        .workflow { background: var(--cream); }
        .workflow-grid { display: grid; grid-template-columns: .9fr 1.1fr; align-items: center; gap: 70px; }
        .workflow-copy .section-kicker { display: block; }
        .workflow-copy h2 { margin: 14px 0; color: var(--brown-dark); font-size: clamp(29px,3.5vw,41px); font-weight: 800; letter-spacing: -1.8px; line-height: 1.2; }
        .workflow-copy p { color: #8E7D70; font-size: 12px; line-height: 1.95; }
        .workflow-list { display: grid; gap: 18px; margin-top: 27px; }
        .workflow-item { display: flex; gap: 13px; align-items: flex-start; }
        .step-number { display: grid; place-items: center; flex: 0 0 29px; height: 29px; border-radius: 9px; background: var(--brown); color: #fff; font-size: 10px; font-weight: 800; }
        .workflow-item strong { display: block; color: var(--brown-dark); font-size: 11px; font-weight: 800; }
        .workflow-item span { display: block; margin-top: 4px; color: #978679; font-size: 10px; line-height: 1.7; }
        .workflow-panel { padding: 26px; border: 1px solid #E5D8CA; border-radius: 17px; background: rgba(255,255,255,.75); }
        .workflow-panel-head { display: flex; align-items: center; justify-content: space-between; padding-bottom: 18px; border-bottom: 1px solid #EFE5D9; }
        .workflow-panel-head strong { color: var(--brown-dark); font-size: 12px; }
        .workflow-panel-head span { color: #A39488; font-size: 9px; }
        .workflow-row { display: flex; align-items: center; gap: 13px; padding: 16px 0; border-bottom: 1px solid #F0E8E0; }
        .workflow-row:last-child { border-bottom: 0; padding-bottom: 0; }
        .workflow-row-icon { display: grid; place-items: center; width: 38px; height: 38px; flex: 0 0 38px; border-radius: 10px; background: #F5EEE6; color: var(--brown); }
        .workflow-row-icon svg { width: 18px; height: 18px; }
        .workflow-row-copy { flex: 1; }
        .workflow-row-copy strong { display: block; color: var(--brown-dark); font-size: 10px; }
        .workflow-row-copy span { display: block; margin-top: 4px; color: #A39488; font-size: 8px; }
        .workflow-status { padding: 6px 8px; border-radius: 6px; background: #EDF2E9; color: #718568; font-size: 8px; font-weight: 800; }

        .closing { padding: 75px 0; background: #fff; }
        .closing-card {
            position: relative; overflow: hidden; padding: 54px 30px; border-radius: 19px;
            background: var(--brown-dark); text-align: center;
        }
        .closing-card:before, .closing-card:after {
            content: ''; position: absolute; width: 240px; height: 240px; border: 1px solid rgba(231,211,190,.15); border-radius: 50%;
        }
        .closing-card:before { top: -130px; left: -60px; }
        .closing-card:after { right: -65px; bottom: -150px; }
        .closing-card h2 { position: relative; z-index: 1; margin: 0 auto 12px; max-width: 590px; color: #fff; font-size: clamp(27px,3.5vw,38px); font-weight: 800; letter-spacing: -1.5px; }
        .closing-card p { position: relative; z-index: 1; margin: 0 auto 24px; max-width: 500px; color: #D6C4B4; font-size: 11px; line-height: 1.9; }
        .closing-card .btn { position: relative; z-index: 1; background: #E7D3BE; color: var(--brown-dark); }
        .closing-card .btn:hover { background: #F4E8DC; }

        .footer { padding: 27px 0; border-top: 1px solid #F0E8E0; background: #FFFEFC; }
        .footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .footer .brand { font-size: 23px; }
        .footer-copy { color: #A39488; font-size: 9px; }
        .footer-links { display: flex; gap: 20px; }
        .footer-links a { color: #8E7D70; font-size: 9px; font-weight: 700; }
        .footer-links a:hover { color: var(--brown-dark); }

        @media (max-width: 900px) {
            .hero { padding: 65px 0 70px; }
            .hero-grid { grid-template-columns: 1fr; gap: 25px; }
            .hero-content { text-align: center; }
            .hero-copy { margin: 0 auto; }
            .hero-actions, .hero-note { justify-content: center; }
            .visual-wrap { min-height: 405px; }
            .workflow-grid { grid-template-columns: 1fr; gap: 35px; }
            .workflow-copy { max-width: 620px; }
        }
        @media (max-width: 700px) {
            .container { width: min(100% - 34px, 560px); }
            .nav-inner { min-height: 68px; }
            .nav-links { display: none; }
            .brand { font-size: 26px; }
            .nav-actions { gap: 8px; }
            .nav-actions .btn { min-height: 39px; padding: 0 13px; font-size: 10px; }
            .hero { padding: 55px 0 52px; }
            .hero h1 { font-size: clamp(37px, 10vw, 49px); letter-spacing: -2.5px; }
            .hero-copy { font-size: 12px; }
            .visual-wrap { min-height: 340px; }
            .visual-orbit { width: 300px; height: 300px; }
            .dashboard-card { padding: 17px; width: min(390px, 94%); }
            .dash-stat-value { font-size: 21px; }
            .float-note.one { top: 10px; right: -2px; }
            .float-note.two { bottom: 5px; left: -2px; }
            .float-note { padding: 10px 12px; }
            .trust-inner { gap: 17px 25px; }
            .trust-item { font-size: 9px; }
            .section { padding: 65px 0; }
            .feature-grid { grid-template-columns: 1fr; }
            .feature-card { padding: 23px; }
            .workflow-panel { padding: 18px; }
            .closing { padding: 55px 0; }
            .closing-card { padding: 43px 22px; }
            .footer-inner { flex-direction: column; text-align: center; }
        }
        @media (max-width: 390px) {
            .nav-actions .btn-outline { display: none; }
            .hero-actions .btn { width: 100%; }
            .visual-wrap { min-height: 315px; }
            .float-note { transform: scale(.88); }
        }
    </style>
</head>
<body>
<div class="site-shell">
    <header class="navbar">
        <div class="container nav-inner">
            <a href="{{ url('/') }}" class="brand">smartkost<span>.</span></a>

            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="#beranda">Beranda</a>
                <a href="#fitur">Fitur</a>
                <a href="#cara-kerja">Cara Kerja</a>
            </nav>

            <div class="nav-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                        Dashboard
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section class="hero" id="beranda">
            <div class="container hero-grid">
                <div class="hero-content">
                    <div class="eyebrow"><span class="eyebrow-dot"></span> PLATFORM MANAJEMEN KOST</div>
                    <h1>Kelola Kost Lebih <em>Mudah</em>, Hidup Lebih Teratur.</h1>
                    <p class="hero-copy">
                        Satu platform untuk membantu pemilik kost mengelola properti, kamar,
                        penghuni, tagihan, dan pembayaran dengan lebih praktis dan terorganisir.
                    </p>
                    <div class="hero-actions">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                                Buka Dashboard
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                Mulai Sekarang
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </a>
                            <a href="#fitur" class="btn btn-outline">Jelajahi Fitur</a>
                        @endauth
                    </div>
                    <div class="hero-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/><path d="m9 12 2 2 4-4"/></svg>
                        Pengelolaan kost dalam satu sistem yang terintegrasi
                    </div>
                </div>

                <div class="visual-wrap" aria-label="Ilustrasi dashboard Smart Kost">
                    <div class="visual-orbit"></div>

                    <div class="dashboard-card">
                        <div class="dash-top">
                            <div>
                                <div class="dash-title">Ringkasan Properti</div>
                                <div class="dash-subtitle">Gambaran pengelolaan kost Anda</div>
                            </div>
                            <div class="dash-pill">OVERVIEW</div>
                        </div>
                        <div class="dash-stats">
                            <div class="dash-stat">
                                <div class="dash-stat-label">Total Kamar</div>
                                <div class="dash-stat-value">24</div>
                                <div class="dash-stat-foot">Data kamar terkelola</div>
                            </div>
                            <div class="dash-stat">
                                <div class="dash-stat-label">Kamar Terisi</div>
                                <div class="dash-stat-value">18</div>
                                <div class="dash-stat-foot">Informasi penghuni</div>
                            </div>
                        </div>
                        <div class="dash-chart">
                            <div class="chart-head"><span>Ringkasan Pemasukan</span><span>Ilustrasi tampilan</span></div>
                            <div class="chart-bars"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
                            <div class="chart-days"><span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span><span>Jul</span></div>
                        </div>
                    </div>

                    <div class="float-note one">
                        <div class="float-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 7 10 17l-5-5"/><path d="M21 12a9 9 0 1 1-5.3-8.2"/></svg></div>
                        <div class="float-text"><strong>Data lebih teratur</strong><span>Semua dalam satu platform</span></div>
                    </div>
                    <div class="float-note two">
                        <div class="float-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M7 15h3"/></svg></div>
                        <div class="float-text"><strong>Kelola pembayaran</strong><span>Tagihan dan transaksi tercatat</span></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="trust-strip" aria-label="Manfaat Smart Kost">
            <div class="container trust-inner">
                <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 8h8M8 12h8M8 16h5"/></svg> Data Terpusat</div>
                <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 10h.01M15 10h.01M9 14h.01M15 14h.01"/></svg> Manajemen Properti</div>
                <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg> Pencatatan Pembayaran</div>
                <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19V5M4 19h17M8 15l4-4 3 2 5-6"/></svg> Rekap Pemasukan</div>
            </div>
        </section>

        <section class="section features" id="fitur">
            <div class="container">
                <div class="section-heading">
                    <div class="section-kicker">Fitur Smart Kost</div>
                    <h2>Semua kebutuhan pengelolaan kost, lebih praktis.</h2>
                    <p>Kelola aktivitas operasional kost melalui fitur yang saling terhubung, mulai dari data properti hingga pencatatan pembayaran.</p>
                </div>

                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/><path d="M8 9h.01M8 13h.01M8 17h.01M16 13h.01M16 17h.01"/></svg></div>
                        <h3>Manajemen Properti & Kamar</h3>
                        <p>Catat informasi kost, kelola daftar kamar, harga sewa, dan pantau ketersediaan kamar dengan lebih mudah.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="8" r="4"/><path d="M2 21a7 7 0 0 1 14 0M17 11a4 4 0 0 0 0-7M22 21a7 7 0 0 0-5-6.7"/></svg></div>
                        <h3>Manajemen Penghuni</h3>
                        <p>Simpan informasi penghuni dan data kontak agar administrasi penghuni lebih rapi dan mudah ditelusuri.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 10h18M9 15h6"/></svg></div>
                        <h3>Penempatan Kamar</h3>
                        <p>Hubungkan penghuni dengan kamar yang ditempati dan pantau riwayat penempatan secara terorganisir.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M6 2h9l5 5v15H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"/><path d="M14 2v6h6M8 13h8M8 17h8"/></svg></div>
                        <h3>Manajemen Tagihan</h3>
                        <p>Buat tagihan sewa berdasarkan periode, nominal, dan tanggal jatuh tempo dengan pencatatan yang jelas.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h4"/></svg></div>
                        <h3>Verifikasi Pembayaran</h3>
                        <p>Pantau pembayaran penghuni dan kelola proses verifikasi transaksi melalui satu halaman.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 3v18h18M7 14l4-4 4 3 6-7M15 6h6v6"/></svg></div>
                        <h3>Rekap Pemasukan</h3>
                        <p>Lihat ringkasan pemasukan dari pembayaran yang telah diverifikasi dan unduh laporan sesuai periode.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section workflow" id="cara-kerja">
            <div class="container workflow-grid">
                <div class="workflow-copy">
                    <span class="section-kicker">Cara Kerja</span>
                    <h2>Alur pengelolaan yang lebih tertata.</h2>
                    <p>Smart Kost menghubungkan proses administrasi kost dalam satu alur. Pemilik dapat mengelola data dan memantau pembayaran, sementara penghuni dapat melihat tagihan serta mengirim pembayaran.</p>

                    <div class="workflow-list">
                        <div class="workflow-item">
                            <div class="step-number">01</div>
                            <div><strong>Kelola data kost dan kamar</strong><span>Masukkan informasi properti, kamar, serta harga sewa.</span></div>
                        </div>
                        <div class="workflow-item">
                            <div class="step-number">02</div>
                            <div><strong>Catat penghuni dan penempatan</strong><span>Hubungkan penghuni dengan kamar yang ditempati.</span></div>
                        </div>
                        <div class="workflow-item">
                            <div class="step-number">03</div>
                            <div><strong>Kelola tagihan dan pembayaran</strong><span>Buat tagihan, periksa pembayaran, dan verifikasi transaksi.</span></div>
                        </div>
                        <div class="workflow-item">
                            <div class="step-number">04</div>
                            <div><strong>Pantau rekap pemasukan</strong><span>Lihat ringkasan pembayaran yang telah diverifikasi.</span></div>
                        </div>
                    </div>
                </div>

                <div class="workflow-panel">
                    <div class="workflow-panel-head">
                        <strong>Aktivitas Pengelolaan</strong>
                        <span>Gambaran alur sistem</span>
                    </div>
                    <div class="workflow-row">
                        <div class="workflow-row-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 21h18M5 21V7l7-4 7 4v14"/></svg></div>
                        <div class="workflow-row-copy"><strong>Data properti dan kamar</strong><span>Informasi kost dan ketersediaan kamar</span></div>
                        <div class="workflow-status">TERKELOLA</div>
                    </div>
                    <div class="workflow-row">
                        <div class="workflow-row-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="8" r="4"/><path d="M2 21a7 7 0 0 1 14 0"/></svg></div>
                        <div class="workflow-row-copy"><strong>Data penghuni</strong><span>Informasi penghuni dan penempatan kamar</span></div>
                        <div class="workflow-status">TERCATAT</div>
                    </div>
                    <div class="workflow-row">
                        <div class="workflow-row-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg></div>
                        <div class="workflow-row-copy"><strong>Tagihan sewa</strong><span>Periode tagihan dan tanggal jatuh tempo</span></div>
                        <div class="workflow-status">TERJADWAL</div>
                    </div>
                    <div class="workflow-row">
                        <div class="workflow-row-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg></div>
                        <div class="workflow-row-copy"><strong>Pembayaran penghuni</strong><span>Riwayat dan status verifikasi transaksi</span></div>
                        <div class="workflow-status">TERPANTAU</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="closing">
            <div class="container">
                <div class="closing-card">
                    <h2>Mulai kelola kost dengan cara yang lebih terorganisir.</h2>
                    <p>Gunakan Smart Kost untuk membantu menyederhanakan pengelolaan properti dan administrasi kost Anda.</p>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn">Kembali ke Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn">Buat Akun Smart Kost</a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <a href="{{ url('/') }}" class="brand">smartkost<span>.</span></a>
            <div class="footer-copy">© {{ date('Y') }} Smart Kost. Smart management for better living.</div>
            <div class="footer-links">
                <a href="#beranda">Beranda</a>
                <a href="#fitur">Fitur</a>
                <a href="#cara-kerja">Cara Kerja</a>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
