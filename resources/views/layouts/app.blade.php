<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Royal Motor') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
            scrollbar-gutter: stable;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        .page-content {
            min-height: calc(100vh - 64px);
            animation: none;
            transform: none;
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-slate-50">

        @include('layouts.navigation')

        @if (isset($header))
            <header class="border-b border-slate-200 bg-white shadow-sm">
                <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="page-content">
            {{ $slot }}
        </main>

    </div>
</body>
</html>