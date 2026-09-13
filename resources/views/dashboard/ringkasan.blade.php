@extends('layouts.app')

@section('title', 'Dashboard — Ringkasan Akademik')

@section('content')

    @php
        $toneStyle = [
            'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
            'sky' => 'border-sky-200 bg-sky-50 text-sky-800',
            'amber' => 'border-amber-200 bg-amber-50 text-amber-900',
            'orange' => 'border-orange-200 bg-orange-50 text-orange-900',
            'rose' => 'border-rose-200 bg-rose-50 text-rose-900',
        ];
    @endphp

    <section class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-[#14539a]">Route Group /dashboard</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Ringkasan Akademik</h1>
            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-500">
                Halaman ini berada di dalam grup ber-prefix <code class="font-mono text-xs">/dashboard</code>
                dengan <em>name prefix</em> <code class="font-mono text-xs">dashboard.</code>, sehingga rutenya
                bernama <code class="font-mono text-xs">dashboard.ringkasan</code>.
            </p>
        </div>
        <a href="{{ route('dashboard.riwayat-studi') }}"
           class="rounded-xl bg-[#0a2c5e] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#14539a]">
            Buka Riwayat Studi
        </a>
    </section>

    {{-- KARTU METRIK UTAMA. --}}
    <section class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">IPK Kumulatif</p>
            <p class="mt-2 font-mono text-3xl font-extrabold text-[#0a2c5e]">{{ number_format($summary['ipk'], 2) }}</p>
            <p class="mt-1 text-xs text-slate-500">Total mutu / total SKS</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Total SKS</p>
            <p class="mt-2 font-mono text-3xl font-extrabold text-[#0a2c5e]">{{ $summary['totalSks'] }}</p>
            <p class="mt-1 text-xs text-slate-500">Terhitung {{ count($summary['riwayat']) }} semester</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Total Mutu</p>
            <p class="mt-2 font-mono text-3xl font-extrabold text-[#0a2c5e]">{{ number_format($summary['totalMutu'], 2) }}</p>
            <p class="mt-1 text-xs text-slate-500">Sigma (IP x SKS)</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Semester Aktif</p>
            <p class="mt-2 font-mono text-3xl font-extrabold text-[#0a2c5e]">{{ $summary['semesterAktif'] }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ $student['kelas'] }}</p>
        </div>
    </section>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_1.3fr]">

        {{-- PREDIKAT. --}}
        <section class="rounded-2xl border p-6 {{ $toneStyle[$summary['predikat']['tone']] ?? $toneStyle['sky'] }}">
            <p class="text-xs font-bold uppercase tracking-widest opacity-70">Predikat Sementara</p>
            <p class="mt-2 text-3xl font-extrabold">{{ $summary['predikat']['label'] }}</p>
            <p class="mt-2 text-sm opacity-90">{{ $summary['predikat']['keterangan'] }}</p>
            <p class="mt-4 border-t border-current/20 pt-4 text-xs opacity-80">
                Predikat dihitung otomatis oleh <code class="font-mono">AcademicSandbox::predicate()</code>
                dari IPK kumulatif {{ number_format($summary['ipk'], 2) }}.
            </p>
        </section>

        {{-- RINGKASAN PER SEMESTER. --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400">Tren IP per Semester</h2>
            <div class="mt-5 space-y-4">
                @foreach ($summary['riwayat'] as $baris)
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold text-slate-700">Semester {{ $baris['semester'] }}</span>
                            <span class="font-mono font-bold text-[#0a2c5e]">{{ number_format($baris['ip'], 2) }}</span>
                        </div>
                        <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-gradient-to-r from-[#0a2c5e] to-[#f2a900]"
                                 style="width: {{ round($baris['ip'] / 4 * 100) }}%"></div>
                        </div>
                        <p class="mt-1 text-xs text-slate-400">{{ $baris['sks'] }} SKS — {{ $baris['predikat'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <section class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('home') }}"
           class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
            &larr; Beranda
        </a>
        <a href="{{ route('dashboard.index') }}"
           class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
            /dashboard <span class="text-xs font-normal text-slate-400">(redirect ke sini)</span>
        </a>
        <a href="{{ route('mahasiswa.profil', ['nrp' => $student['nrp']]) }}"
           class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
            Profil Mahasiswa
        </a>
    </section>

@endsection
