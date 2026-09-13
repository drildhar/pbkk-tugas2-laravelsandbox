@extends('layouts.app')

@section('title', 'Ide Agentic AI — '.$idea['nama'])

@section('content')

    {{-- HEADER: menegaskan sumber tema (parameter URL atau nilai fallback). --}}
    <section class="overflow-hidden rounded-3xl brand-gradient p-8 text-white shadow-xl sm:p-10">
        <div class="flex flex-wrap items-center gap-3">
            <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-widest ring-1 ring-inset ring-white/25">
                Platform Agentic AI
            </span>
            @if ($isFallback)
                <span class="rounded-full bg-[#f2a900] px-3 py-1 text-xs font-bold uppercase tracking-widest text-[#3a2600]">
                    Nilai Fallback Default
                </span>
            @elseif (! empty($idea['isCustom']))
                <span class="rounded-full bg-sky-400/20 px-3 py-1 text-xs font-bold uppercase tracking-widest text-sky-100 ring-1 ring-inset ring-sky-300/40">
                    Konsep Kustom
                </span>
            @endif
        </div>

        <h1 class="mt-5 text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">{{ $idea['nama'] }}</h1>
        <p class="mt-3 max-w-3xl text-sm leading-relaxed text-blue-100 sm:text-base">{{ $idea['tagline'] }}</p>

        <div class="mt-6 grid gap-3 sm:grid-cols-3">
            <div class="rounded-xl bg-white/10 p-4 ring-1 ring-inset ring-white/20">
                <p class="text-[11px] font-bold uppercase tracking-widest text-blue-200">Parameter Diterima</p>
                <p class="mt-1 font-mono text-sm font-bold text-[#ffd166]">{tema} = {{ $tema }}</p>
            </div>
            <div class="rounded-xl bg-white/10 p-4 ring-1 ring-inset ring-white/20">
                <p class="text-[11px] font-bold uppercase tracking-widest text-blue-200">Tingkat Kesulitan</p>
                <p class="mt-1 text-sm font-bold text-white">{{ $idea['kesulitan'] }}</p>
            </div>
            <div class="rounded-xl bg-white/10 p-4 ring-1 ring-inset ring-white/20">
                <p class="text-[11px] font-bold uppercase tracking-widest text-blue-200">Nama Rute</p>
                <p class="mt-1 font-mono text-sm font-bold text-white">agent.ide</p>
            </div>
        </div>
    </section>

    @if ($isFallback)
        <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm leading-relaxed text-amber-900">
            URL diakses <strong>tanpa parameter</strong> (<code class="font-mono text-xs font-bold">/agent</code>),
            sehingga closure memakai nilai default eksplisit
            <code class="font-mono text-xs font-bold">{{ "'".\App\Support\AcademicSandbox::DEFAULT_AGENT_THEME."'" }}</code>.
            Coba juga variasi bertema, misalnya
            <a href="{{ route('agent.ide', ['tema' => 'code-reviewer']) }}" class="font-bold underline">/agent/code-reviewer</a>.
        </div>
    @endif

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.5fr_1fr]">

        {{-- Kolom kiri: deskripsi & kapabilitas. --}}
        <div class="space-y-6">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400">Deskripsi Konsep</h2>
                <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $idea['deskripsi'] }}</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400">Kapabilitas Inti</h2>
                <ol class="mt-4 space-y-4">
                    @foreach ($idea['kapabilitas'] as $index => $kapabilitas)
                        <li class="flex gap-4">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#0a2c5e]/5 font-mono text-xs font-extrabold text-[#0a2c5e]">
                                {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="text-sm leading-relaxed text-slate-700">{{ $kapabilitas }}</span>
                        </li>
                    @endforeach
                </ol>
            </section>
        </div>

        {{-- Kolom kanan: metadata teknis. --}}
        <div class="space-y-6">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400">Usulan Tech Stack</h2>
                <ul class="mt-4 flex flex-wrap gap-2">
                    @foreach ($idea['stack'] as $teknologi)
                        <li class="rounded-lg bg-slate-100 px-3 py-1.5 font-mono text-xs font-semibold text-slate-700">{{ $teknologi }}</li>
                    @endforeach
                </ul>
            </section>

            <section class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-emerald-700">Dampak yang Diharapkan</h2>
                <p class="mt-3 text-sm leading-relaxed text-emerald-900">{{ $idea['dampak'] }}</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400">Uji Rute Terkait</h2>
                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('agent.ide') }}"
                       class="rounded-lg bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        /agent <span class="text-xs font-normal text-slate-400">(tanpa parameter)</span>
                    </a>
                    <a href="{{ route('agent.ide', ['tema' => $idea['slug']]) }}"
                       class="rounded-lg bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        /agent/{{ $idea['slug'] }} <span class="text-xs font-normal text-slate-400">(slug katalog)</span>
                    </a>
                    <a href="{{ route('agent.ide', ['tema' => 'quantum-tutor']) }}"
                       class="rounded-lg bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        /agent/quantum-tutor <span class="text-xs font-normal text-slate-400">(tema kustom)</span>
                    </a>
                </div>
            </section>
        </div>
    </div>

    {{-- KATALOG: seluruh tautan dibangun dengan route(). --}}
    <section class="mt-10">
        <header class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Katalog Ide Tersedia</h2>
                <p class="mt-1 text-sm text-slate-500">Setiap kartu menuju <code class="font-mono text-xs">route('agent.ide', ['tema' =&gt; slug])</code>.</p>
            </div>
        </header>

        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($katalog as $item)
                @php($aktif = $item['slug'] === $idea['slug'])
                <a href="{{ route('agent.ide', ['tema' => $item['slug']]) }}"
                   class="flex flex-col rounded-2xl border bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg {{ $aktif ? 'border-[#f2a900] ring-2 ring-[#f2a900]/30' : 'border-slate-200 hover:border-[#14539a]/40' }}">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="font-bold text-slate-900">{{ $item['nama'] }}</h3>
                        @if ($aktif)
                            <span class="shrink-0 rounded-full bg-[#f2a900] px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-[#3a2600]">
                                Aktif
                            </span>
                        @endif
                    </div>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-500">{{ $item['tagline'] }}</p>
                    <span class="mt-4 font-mono text-[11px] font-semibold text-[#14539a]">/agent/{{ $item['slug'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('home') }}"
           class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
            &larr; Beranda
        </a>
        <a href="{{ route('akademik.hitung-ipk', ['ipk1' => '3.75', 'ipk2' => '3.60']) }}"
           class="rounded-xl bg-[#0a2c5e] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#14539a]">
            Lanjut ke Kalkulator IPK
        </a>
    </section>

@endsection
