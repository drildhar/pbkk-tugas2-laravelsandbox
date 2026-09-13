@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    {{-- HERO: sambutan hangat khas ITS + identitas ringkas mahasiswa. --}}
    <section class="overflow-hidden rounded-3xl brand-gradient text-white shadow-xl">
        <div class="grid gap-8 p-8 sm:p-10 lg:grid-cols-[1.6fr_1fr] lg:items-center">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-white ring-1 ring-inset ring-white/25">
                    PBKK Pertemuan 2
                </span>

                <h1 class="mt-5 text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl lg:text-5xl">
                    Selamat Datang, <span class="text-gradient">{{ $student['nama'] }}</span>
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-relaxed text-blue-100 sm:text-base">
                    <strong class="font-bold text-white">Vivat ITS! Vivat Informatika!</strong>
                    Ini adalah <em>local sandbox</em> Laravel yang mendemonstrasikan routing dasar:
                    rute statis, parameter wajib, parameter opsional dengan nilai default, validasi regex,
                    <em>route group</em>, hingga <em>fallback route</em> 404. Seluruh navigasi dibangun
                    memakai helper <code class="font-mono text-[#ffd166]">route()</code> tanpa satu pun URL
                    yang di-<em>hardcode</em>.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('mahasiswa.profil', ['nrp' => $student['nrp']]) }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-[#0a2c5e] shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-50">
                        Lihat Profil Lengkap
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </a>
                    <a href="{{ route('agent.ide') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-5 py-2.5 text-sm font-semibold text-white ring-1 ring-inset ring-white/30 transition hover:bg-white/20">
                        Eksplorasi Ide Agentic AI
                    </a>
                    <a href="{{ route('akademik.hitung-ipk', ['ip1' => '3.75', 'ip2' => '3.60']) }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-[#f2a900] px-5 py-2.5 text-sm font-bold text-[#3a2600] shadow-lg transition hover:-translate-y-0.5 hover:bg-[#ffc23d]">
                        Hitung IPK Sekarang
                    </a>
                </div>
            </div>

            <div class="rounded-2xl bg-white/10 p-6 ring-1 ring-inset ring-white/20 backdrop-blur">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-100">Kartu Identitas</p>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-blue-200">Nama</dt>
                        <dd class="font-bold text-white">{{ $student['nama'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-blue-200">NRP</dt>
                        <dd class="font-mono font-bold text-[#ffd166]">{{ $student['nrp'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-blue-200">Departemen</dt>
                        <dd class="font-semibold text-white">{{ $student['departemen'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-blue-200">Fakultas</dt>
                        <dd class="font-semibold text-white">{{ $student['fakultas'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-blue-200">Status</dt>
                        <dd>
                            <span class="inline-flex items-center rounded-full bg-emerald-400/20 px-2.5 py-0.5 text-xs font-bold text-emerald-100 ring-1 ring-inset ring-emerald-300/40">
                                {{ $student['status'] }} — Semester {{ $student['semester'] }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    {{-- PETA RUTE: navigasi interaktif ke seluruh rute memakai route(). --}}
    <section class="mt-10">
        <header class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Peta Rute Sandbox</h2>
                <p class="mt-1 text-sm text-slate-500">Setiap kartu memakai helper <code class="font-mono text-xs">route()</code>, bukan URL manual.</p>
            </div>
            <a href="{{ route('dashboard.ringkasan') }}" class="text-sm font-semibold text-[#14539a] hover:underline">
                Buka dashboard analitik
            </a>
        </header>

        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

            <a href="{{ route('home') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#14539a]/40 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <span class="rounded-lg bg-slate-100 px-2 py-1 font-mono text-xs font-bold text-slate-600">GET /</span>
                    <span class="font-mono text-[11px] font-semibold text-[#14539a]">home</span>
                </div>
                <h3 class="mt-4 font-bold text-slate-900">Halaman Beranda</h3>
                <p class="mt-1 text-sm text-slate-500">Rute statis tanpa parameter sebagai titik masuk aplikasi.</p>
            </a>

            <a href="{{ route('mahasiswa.profil', ['nrp' => $student['nrp']]) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#14539a]/40 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <span class="rounded-lg bg-slate-100 px-2 py-1 font-mono text-xs font-bold text-slate-600">GET /mahasiswa/{nrp}</span>
                    <span class="font-mono text-[11px] font-semibold text-[#14539a]">mahasiswa.profil</span>
                </div>
                <h3 class="mt-4 font-bold text-slate-900">Profil Mahasiswa</h3>
                <p class="mt-1 text-sm text-slate-500">Parameter wajib dengan pengaman regex <code class="font-mono text-xs">^[0-9]{10}$</code>.</p>
            </a>

            <a href="{{ route('agent.ide') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#14539a]/40 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <span class="rounded-lg bg-slate-100 px-2 py-1 font-mono text-xs font-bold text-slate-600">GET /agent/{tema?}</span>
                    <span class="font-mono text-[11px] font-semibold text-[#14539a]">agent.ide</span>
                </div>
                <h3 class="mt-4 font-bold text-slate-900">Ide Platform Agentic AI</h3>
                <p class="mt-1 text-sm text-slate-500">Parameter opsional dengan fallback <em>General Assistant Agent</em>.</p>
            </a>

            <a href="{{ route('akademik.hitung-ipk', ['ip1' => '3.75', 'ip2' => '3.60']) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#14539a]/40 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <span class="rounded-lg bg-slate-100 px-2 py-1 font-mono text-xs font-bold text-slate-600">GET /hitung-ipk/{ip1}/{ip2}</span>
                    <span class="font-mono text-[11px] font-semibold text-[#14539a]">akademik.hitung-ipk</span>
                </div>
                <h3 class="mt-4 font-bold text-slate-900">Kalkulator IPK</h3>
                <p class="mt-1 text-sm text-slate-500">Validasi rentang 0.00 - 4.00 beserta predikat otomatis.</p>
            </a>

            <a href="{{ route('dashboard.ringkasan') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#14539a]/40 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <span class="rounded-lg bg-slate-100 px-2 py-1 font-mono text-xs font-bold text-slate-600">GET /dashboard/ringkasan</span>
                    <span class="font-mono text-[11px] font-semibold text-[#14539a]">dashboard.ringkasan</span>
                </div>
                <h3 class="mt-4 font-bold text-slate-900">Ringkasan Akademik</h3>
                <p class="mt-1 text-sm text-slate-500">Anggota <em>route group</em> ber-prefix <code class="font-mono text-xs">/dashboard</code>.</p>
            </a>

            <a href="{{ route('dashboard.riwayat-studi') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#14539a]/40 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <span class="rounded-lg bg-slate-100 px-2 py-1 font-mono text-xs font-bold text-slate-600">GET /dashboard/riwayat-studi</span>
                    <span class="font-mono text-[11px] font-semibold text-[#14539a]">dashboard.riwayat-studi</span>
                </div>
                <h3 class="mt-4 font-bold text-slate-900">Riwayat Studi</h3>
                <p class="mt-1 text-sm text-slate-500">Tabel IP per semester dengan perhitungan IPK kumulatif.</p>
            </a>
        </div>
    </section>

    {{-- CUPLIKAN METRIK: membuktikan data terpusat dipakai lintas halaman. --}}
    <section class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">IPK Kumulatif</p>
            <p class="mt-2 text-3xl font-extrabold tracking-tight text-[#0a2c5e]">{{ number_format($summary['ipk'], 2) }}</p>
            <p class="mt-1 text-xs text-slate-500">Skala 4.00</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Total SKS</p>
            <p class="mt-2 text-3xl font-extrabold tracking-tight text-[#0a2c5e]">{{ $summary['totalSks'] }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ count($summary['riwayat']) }} semester terlewati</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Predikat</p>
            <p class="mt-2 text-2xl font-extrabold tracking-tight text-emerald-600">{{ $summary['predikat']['label'] }}</p>
            <p class="mt-1 text-xs text-slate-500">Berdasarkan ambang IPK</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Ide Terkatalog</p>
            <p class="mt-2 text-3xl font-extrabold tracking-tight text-[#0a2c5e]">{{ count($agentIdeas) }}</p>
            <a href="{{ route('agent.ide') }}" class="mt-1 inline-block text-xs font-semibold text-[#14539a] hover:underline">Jelajahi katalog</a>
        </div>
    </section>

    {{-- PRATINJAU IDE AGENTIC AI. --}}
    <section class="mt-10">
        <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Pratinjau Ide Platform Agentic AI</h2>
        <p class="mt-1 text-sm text-slate-500">Tiga dari {{ count($agentIdeas) }} konsep yang siap dikembangkan menjadi proyek akhir semester.</p>

        <div class="mt-5 grid gap-4 md:grid-cols-3">
            @foreach (array_slice($agentIdeas, 1, 3) as $idea)
                <a href="{{ route('agent.ide', ['tema' => $idea['slug']]) }}"
                   class="flex flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#f2a900]/60 hover:shadow-lg">
                    <span class="inline-flex w-fit items-center rounded-full bg-[#0a2c5e]/5 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider text-[#0a2c5e]">
                        {{ $idea['kesulitan'] }}
                    </span>
                    <h3 class="mt-4 font-bold text-slate-900">{{ $idea['nama'] }}</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-500">{{ $idea['tagline'] }}</p>
                    <span class="mt-4 text-xs font-bold text-[#14539a]">Buka konsep &rarr;</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- CATATAN HIGIENITAS GIT. --}}
    <section class="mt-10 rounded-2xl border border-amber-200 bg-amber-50 p-6">
        <h2 class="text-sm font-extrabold uppercase tracking-widest text-amber-800">Catatan Higienitas Repositori</h2>
        <p class="mt-2 text-sm leading-relaxed text-amber-900">
            Berkas <code class="font-mono text-xs font-bold">.env</code> (berisi <code class="font-mono text-xs">APP_KEY</code> dan kredensial basis data)
            serta direktori <code class="font-mono text-xs font-bold">vendor/</code> <strong>tidak boleh</strong> ikut di-commit ke repositori GitHub personal.
            Pastikan keduanya sudah tercantum pada <code class="font-mono text-xs">.gitignore</code>, dan cukup bagikan
            <code class="font-mono text-xs">.env.example</code> sebagai templat konfigurasi.
        </p>
    </section>

@endsection
