@extends('layouts.app')

@section('title', $student === null ? 'NRP Tidak Ditemukan' : 'Profil '.$student['nama'])

@section('content')

    @if ($student === null)

        {{-- Kondisi NRP valid secara format, namun tidak ada di katalog data. --}}
        <section class="mx-auto max-w-2xl rounded-3xl border border-rose-200 bg-white p-8 text-center shadow-sm sm:p-10">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-2xl font-extrabold text-rose-500">!</span>
            <h1 class="mt-5 text-2xl font-extrabold tracking-tight text-slate-900">NRP Tidak Ditemukan</h1>
            <p class="mt-3 text-sm leading-relaxed text-slate-500">
                NRP <span class="font-mono font-bold text-slate-700">{{ $nrp }}</span> lolos validasi format
                10 digit, tetapi belum terdaftar pada katalog sandbox ini. Status respons yang dikirim adalah
                <span class="font-mono font-semibold text-rose-600">HTTP 404</span>.
            </p>

            <div class="mt-6 rounded-xl bg-slate-50 p-4 text-left">
                <p class="text-xs font-bold uppercase tracking-widest text-slate-400">NRP contoh yang tersedia</p>
                <a href="{{ route('mahasiswa.profil', ['nrp' => '5025241097']) }}"
                   class="mt-2 inline-block font-mono text-sm font-bold text-[#14539a] hover:underline">
                    5025241097
                </a>
            </div>

            <div class="mt-7 flex flex-wrap justify-center gap-3">
                <a href="{{ route('mahasiswa.profil', ['nrp' => '5025241097']) }}"
                   class="rounded-xl bg-[#0a2c5e] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#14539a]">
                    Buka Profil Tersedia
                </a>
                <a href="{{ route('home') }}"
                   class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Kembali ke Beranda
                </a>
            </div>
        </section>

    @else

        {{-- Header profil. --}}
        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="brand-gradient px-8 py-10 text-white sm:px-10">
                <div class="flex flex-wrap items-center gap-5">
                    <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 text-xl font-extrabold tracking-tight text-white ring-1 ring-inset ring-white/30">
                        {{ strtoupper(mb_substr($student['nama'], 0, 2)) }}
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-blue-100">Profil Mahasiswa</p>
                        <h1 class="mt-1 text-2xl font-extrabold tracking-tight sm:text-3xl">{{ $student['nama'] }}</h1>
                        <p class="mt-1 font-mono text-sm text-[#ffd166]">NRP {{ $student['nrp'] }}</p>
                    </div>
                </div>
                <p class="mt-6 max-w-3xl text-sm italic leading-relaxed text-blue-100">"{{ $student['motto'] }}"</p>
            </div>

            <dl class="grid gap-px bg-slate-200 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    'Departemen' => $student['departemen'],
                    'Fakultas' => $student['fakultas'],
                    'Institusi' => $student['institut'],
                    'Angkatan' => (string) $student['angkatan'],
                    'Semester Aktif' => (string) $student['semester'],
                    'Jalur Masuk' => $student['jalurMasuk'],
                    'Kelas' => $student['kelas'],
                    'Dosen Wali' => $student['dosenWali'],
                    'Surel Kampus' => $student['email'],
                ] as $label => $nilai)
                    <div class="bg-white px-6 py-5">
                        <dt class="text-xs font-bold uppercase tracking-widest text-slate-400">{{ $label }}</dt>
                        <dd class="mt-1.5 text-sm font-semibold text-slate-800">{{ $nilai }}</dd>
                    </div>
                @endforeach
            </dl>
        </section>

        {{-- Minat akademik. --}}
        <section class="mt-6 grid gap-4 lg:grid-cols-[1.4fr_1fr]">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400">Minat &amp; Fokus Studi</h2>
                <ul class="mt-4 space-y-3">
                    @foreach ($student['minat'] as $minat)
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#f2a900]"></span>
                            <span>{{ $minat }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400">Parameter Rute</h2>
                <p class="mt-3 text-sm leading-relaxed text-slate-500">
                    Halaman ini dirender oleh rute <code class="font-mono text-xs font-bold text-[#14539a]">mahasiswa.profil</code>
                    dengan parameter wajib <code class="font-mono text-xs font-bold text-[#14539a]">{nrp}</code>
                    yang dikunci regex <code class="font-mono text-xs font-bold text-[#14539a]">^[0-9]{{ '{10}' }}$</code>.
                </p>
                <a href="{{ route('agent.ide') }}"
                   class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-[#14539a] hover:underline">
                    Lanjut ke ide Agentic AI
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                </a>
            </div>
        </section>

        {{-- Navigasi silang antar rute. --}}
        <section class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('home') }}"
               class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
                &larr; Beranda
            </a>
            <a href="{{ route('dashboard.ringkasan') }}"
               class="rounded-xl bg-[#0a2c5e] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#14539a]">
                Ringkasan Akademik
            </a>
            <a href="{{ route('akademik.hitung-ipk', ['ipk1' => '3.75', 'ipk2' => '3.60']) }}"
               class="rounded-xl bg-[#f2a900] px-5 py-2.5 text-sm font-bold text-[#3a2600] shadow-sm transition hover:bg-[#ffc23d]">
                Kalkulator IPK
            </a>
        </section>

    @endif

@endsection
