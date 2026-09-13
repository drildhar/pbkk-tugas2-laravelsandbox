<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Laravel Local Sandbox & Routing Dasar — Tugas PBKK Pertemuan 2, Departemen Teknik Informatika FTEIC ITS.">

    <title>@yield('title', 'Beranda') — Sandbox PBKK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Tailwind CSS Play CDN: cukup untuk sandbox lokal tanpa proses build. --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        :root {
            --its-navy: #0a2c5e;
            --its-blue: #14539a;
            --its-gold: #f2a900;
        }

        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif;
        }

        .font-mono {
            font-family: 'JetBrains Mono', ui-monospace, 'Cascadia Code', Consolas, monospace;
        }

        .brand-gradient {
            background-image: linear-gradient(120deg, var(--its-navy) 0%, var(--its-blue) 55%, #1f7ac4 100%);
        }

        .text-gradient {
            background-image: linear-gradient(120deg, var(--its-gold) 0%, #ffd166 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    {{-- Penanda warna identitas ITS. --}}
    <div class="h-1.5 w-full bg-gradient-to-r from-[#0a2c5e] via-[#14539a] to-[#f2a900]"></div>

    <a href="#konten"
       class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-[#0a2c5e] focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white">
        Lewati ke konten utama
    </a>

    @php
        /*
         | Helper tampilan murni untuk menandai menu aktif.
         | Semua tautan tetap memakai helper route() sehingga bebas hardcoded URL.
         */
        $navItem = static fn (bool $active): string => $active
            ? 'rounded-lg bg-[#0a2c5e] px-3 py-2 text-sm font-semibold text-white shadow-sm'
            : 'rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-[#0a2c5e]';
    @endphp

    <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/85 backdrop-blur">
        <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6">

            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl brand-gradient text-sm font-extrabold tracking-tight text-white shadow-md">
                    ITS
                </span>
                <span class="leading-tight">
                    <span class="block text-sm font-extrabold tracking-tight text-[#0a2c5e]">Sandbox PBKK</span>
                    <span class="block text-[11px] font-medium text-slate-500">Routing Dasar Laravel</span>
                </span>
            </a>

            <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
                <a href="{{ route('home') }}" class="{{ $navItem(request()->routeIs('home')) }}">Beranda</a>
                <a href="{{ route('mahasiswa.profil', ['nrp' => $student['nrp'] ?? '5025241097']) }}"
                   class="{{ $navItem(request()->routeIs('mahasiswa.profil')) }}">Profil</a>
                <a href="{{ route('agent.ide') }}" class="{{ $navItem(request()->routeIs('agent.ide')) }}">Agentic AI</a>
                <a href="{{ route('akademik.hitung-ipk', ['ip1' => '3.75', 'ip2' => '3.60']) }}"
                   class="{{ $navItem(request()->routeIs('akademik.hitung-ipk')) }}">Kalkulator IPK</a>
                <a href="{{ route('dashboard.ringkasan') }}" class="{{ $navItem(request()->routeIs('dashboard.*')) }}">Dashboard</a>
            </nav>

            <button type="button" id="tombolMenu"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:bg-slate-100 lg:hidden"
                    aria-controls="menuMobile" aria-expanded="false" aria-label="Buka navigasi">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <nav id="menuMobile" class="hidden border-t border-slate-200 bg-white px-4 py-3 lg:hidden" aria-label="Navigasi seluler">
            <div class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="{{ $navItem(request()->routeIs('home')) }}">Beranda</a>
                <a href="{{ route('mahasiswa.profil', ['nrp' => $student['nrp'] ?? '5025241097']) }}"
                   class="{{ $navItem(request()->routeIs('mahasiswa.profil')) }}">Profil Mahasiswa</a>
                <a href="{{ route('agent.ide') }}" class="{{ $navItem(request()->routeIs('agent.ide')) }}">Ide Agentic AI</a>
                <a href="{{ route('akademik.hitung-ipk', ['ip1' => '3.75', 'ip2' => '3.60']) }}"
                   class="{{ $navItem(request()->routeIs('akademik.hitung-ipk')) }}">Kalkulator IPK</a>
                <a href="{{ route('dashboard.ringkasan') }}" class="{{ $navItem(request()->routeIs('dashboard.*')) }}">Dashboard</a>
            </div>
        </nav>
    </header>

    <main id="konten" class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:py-12">
        @yield('content')
    </main>

    <footer class="mt-8 border-t border-slate-200 bg-white">
        <div class="mx-auto flex w-full max-w-6xl flex-col gap-4 px-4 py-8 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-extrabold tracking-tight text-[#0a2c5e]">Vivat ITS! Vivat Informatika!</p>
                <p class="mt-1 text-xs text-slate-500">
                    Tugas Mandiri PBKK Pertemuan 2 — Laravel Local Sandbox &amp; Routing Dasar.
                </p>
            </div>
            <div class="text-xs text-slate-500 lg:text-right">
                <p class="font-semibold text-slate-700">{{ $student['nama'] ?? 'Adriel Mahira Dharma' }}</p>
                <p>NRP <span class="font-mono">{{ $student['nrp'] ?? '5025241097' }}</span> — {{ $student['departemen'] ?? 'Teknik Informatika' }} FTEIC ITS</p>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            var tombol = document.getElementById('tombolMenu');
            var menu = document.getElementById('menuMobile');

            if (!tombol || !menu) {
                return;
            }

            tombol.addEventListener('click', function () {
                var terbuka = menu.classList.toggle('hidden');
                tombol.setAttribute('aria-expanded', terbuka ? 'false' : 'true');
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
