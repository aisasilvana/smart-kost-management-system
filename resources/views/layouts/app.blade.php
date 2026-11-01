
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="theme-color" content="#F7F2EB">
    <meta name="description" content="Smartkost - Platform manajemen kost yang praktis, nyaman, dan terintegrasi.">

    <title>
        @hasSection('title')
            @yield('title') | smartkost.
        @else
            {{ config('app.name', 'Smartkost') }}
        @endif
    </title>

    {{-- FONT CONNECTION --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- APPLICATION FONTS --}}
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    {{-- LARAVEL VITE --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    {{-- PAGE-SPECIFIC STYLES --}}
    @stack('styles')

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

        html {
            min-height: 100%;
            scroll-behavior: smooth;
            scroll-padding-top: 90px;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--cream);
            color: var(--text);
            font-family: 'Manrope', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        button,
        input,
        select,
        textarea {
            font-family: 'Manrope', sans-serif;
        }

        button {
            cursor: pointer;
        }

        a {
            -webkit-tap-highlight-color: transparent;
        }

        [x-cloak] {
            display: none !important;
        }

        .sk-app-shell {
            min-height: 100vh;
            background: var(--cream);
        }

        .sk-main {
            min-height: 100vh;
            background: var(--cream);
        }

        .sk-topbar {
            position: relative;
            z-index: 10;
            display: flex;
            min-height: 72px;
            align-items: center;
            padding: 0 32px;
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(12px);
        }

        ::selection {
            background: var(--beige);
            color: var(--brown-dark);
        }

        :focus-visible {
            outline: 2px solid var(--brown-light);
            outline-offset: 3px;
        }

        @media (max-width: 768px) {
            .sk-topbar {
                min-height: 60px;
                padding: 0 18px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
    <div class="sk-app-shell">

        {{-- MAIN NAVIGATION --}}
        @include('layouts.navigation')

        {{-- MAIN CONTENT --}}
        <main class="sk-main">
            @isset($header)
                <header class="sk-topbar">
                    {{ $header }}
                </header>
            @endisset

            {{-- SUPPORT BLADE COMPONENT SLOT --}}
            {{ $slot ?? '' }}

            {{-- SUPPORT @extends AND @section --}}
            @yield('content')
        </main>

    </div>

    {{-- PAGE-SPECIFIC SCRIPTS --}}
    @stack('scripts')
</body>
</html>
