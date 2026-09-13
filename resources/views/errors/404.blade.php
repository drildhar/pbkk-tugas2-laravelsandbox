@extends('layouts.app')

@section('title', '404 — Halaman Tidak Ditemukan')

@section('content')

    @php
        /*
         | Variabel $path diisi oleh Route::fallback(). Apabila halaman ini
         | dirender oleh exception handler (misalnya NRP gagal regex), nilai
         | tersebut diambil dari request yang sedang berjalan.
         */
        $pathTidakDitemukan = $path ?? request()->path();
    @endphp

    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="brand-gradient px-8 py-12 text-center text-white sm:px-10">
            <p class="font-mono text-6xl font-extrabold tracking-tighter text-[#ffd166] sm:text-7xl">404</p>
            <h1 class="mt-4 text-2xl font-extrabold tracking-tight sm:text-3xl">Halaman Tidak Ditemukan</h1>
            <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-blue-100">
                Rute yang Anda tuju tidak terdaftar pada <code class="font-mono text-xs text-[#ffd166]">routes/web.php</code>.
                Handler ini disediakan oleh <code class="font-mono text-xs text-[#ffd166]">Route::fallback()</code>
                dan tetap mengembalikan status <span class="font-mono font-bold">HTTP 404</span>.
            </p>
        </div>

        <div class="px-8 py-8 sm:px-10">
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Path yang diminta</p>
                <p class="mt-1.5 break-all font-mono text-sm font-semibold text-rose-600">/{{ ltrim($pathTidakDitemukan, '/') }}</p>
            </div>

            <h2 class="mt-8 text-sm font-extrabold uppercase tracking-widest text-slate-400">Rute yang Tersedia</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('home') }}"
                   class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#14539a]/40 hover:bg-slate-50">
                    <span>Beranda</span>
                    <span class="font-mono text-[11px] text-slate-400">home</span>
                </a>
                <a href="{{ route('mahasiswa.profil', ['nrp' => '5025241097']) }}"
                   class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#14539a]/40 hover:bg-slate-50">
                    <span>Profil Mahasiswa</span>
                    <span class="font-mono text-[11px] text-slate-400">mahasiswa.profil</span>
                </a>
                <a href="{{ route('agent.ide') }}"
                   class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#14539a]/40 hover:bg-slate-50">
                    <span>Ide Agentic AI</span>
                    <span class="font-mono text-[11px] text-slate-400">agent.ide</span>
                </a>
                <a href="{{ route('akademik.hitung-ipk', ['ip1' => '3.75', 'ip2' => '3.60']) }}"
                   class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#14539a]/40 hover:bg-slate-50">
                    <span>Kalkulator IPK</span>
                    <span class="font-mono text-[11px] text-slate-400">akademik.hitung-ipk</span>
                </a>
                <a href="{{ route('dashboard.ringkasan') }}"
                   class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#14539a]/40 hover:bg-slate-50">
                    <span>Ringkasan Akademik</span>
                    <span class="font-mono text-[11px] text-slate-400">dashboard.ringkasan</span>
                </a>
                <a href="{{ route('dashboard.riwayat-studi') }}"
                   class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#14539a]/40 hover:bg-slate-50">
                    <span>Riwayat Studi</span>
                    <span class="font-mono text-[11px] text-slate-400">dashboard.riwayat-studi</span>
                </a>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('home') }}"
                   class="rounded-xl bg-[#0a2c5e] px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#14539a]">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('dashboard.ringkasan') }}"
                   class="rounded-xl border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Buka Dashboard
                </a>
            </div>
        </div>
    </section>

@endsection
