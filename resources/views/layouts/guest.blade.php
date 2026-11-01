
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Smart Kost') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: #F7F2EB;
            color: #493A30;
            -webkit-font-smoothing: antialiased;
        }

        .guest-page {
            position: relative;
            display: flex;
            min-height: 100vh;
            min-height: 100dvh;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 45px 20px;
            background:
                radial-gradient(
                    circle at 12% 15%,
                    rgba(231, 211, 190, 0.55),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 85%,
                    rgba(181, 139, 107, 0.13),
                    transparent 30%
                ),
                #F7F2EB;
        }

        .guest-decoration {
            position: fixed;
            width: 360px;
            height: 360px;
            border: 1px solid rgba(139, 101, 77, 0.10);
            border-radius: 50%;
            pointer-events: none;
        }

        .guest-decoration::before {
            position: absolute;
            content: '';
            inset: 28px;
            border: 1px solid rgba(139, 101, 77, 0.08);
            border-radius: 50%;
        }

        .guest-decoration-top {
            top: -210px;
            right: -100px;
        }

        .guest-decoration-bottom {
            bottom: -230px;
            left: -130px;
        }

        .guest-content {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (max-width: 480px) {
            .guest-page {
                padding: 25px 12px;
            }
        }
    </style>
</head>

<body>
    <main class="guest-page">
        <div class="guest-decoration guest-decoration-top"></div>
        <div class="guest-decoration guest-decoration-bottom"></div>

        <div class="guest-content">
            {{ $slot }}
        </div>
    </main>
</body>
</html>
