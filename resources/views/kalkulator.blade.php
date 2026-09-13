@extends('layouts.app')

@section('title', 'Kalkulator IPK Semester')

@section('content')

    @php
        /*
         | Templat URL dibangun dari helper route() agar formulir tetap bebas
         | hardcoded URL. Placeholder diganti di sisi klien sebelum submit.
         */
        $urlTemplate = route('akademik.hitung-ipk', ['ip1' => '__IP1__', 'ip2' => '__IP2__']);

        $toneStyle = [
            'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
            'sky' => 'border-sky-200 bg-sky-50 text-sky-800',
            'amber' => 'border-amber-200 bg-amber-50 text-amber-900',
            'orange' => 'border-orange-200 bg-orange-50 text-orange-900',
            'rose' => 'border-rose-200 bg-rose-50 text-rose-900',
        ];
    @endphp

    {{-- HEADER. --}}
    <section class="overflow-hidden rounded-3xl brand-gradient p-8 text-white shadow-xl sm:p-10">
        <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-widest ring-1 ring-inset ring-white/25">
            Tantangan 2
        </span>
        <h1 class="mt-5 text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">Kalkulator Portofolio Akademis</h1>
        <p class="mt-3 max-w-3xl text-sm leading-relaxed text-blue-100 sm:text-base">
            Hitung <em>Indeks Prestasi Kumulatif</em> sementara dari dua nilai IP semester, lengkap dengan
            validasi rentang <span class="font-mono font-bold text-[#ffd166]">0.00 - 4.00</span> serta
            penentuan predikat akademik secara otomatis.
        </p>

        <div class="mt-6 grid gap-3 sm:grid-cols-3">
            <div class="rounded-xl bg-white/10 p-4 ring-1 ring-inset ring-white/20">
                <p class="text-[11px] font-bold uppercase tracking-widest text-blue-200">Pola Rute</p>
                <p class="mt-1 font-mono text-xs font-bold text-white">/hitung-ipk/{ip1}/{ip2}</p>
            </div>
            <div class="rounded-xl bg-white/10 p-4 ring-1 ring-inset ring-white/20">
                <p class="text-[11px] font-bold uppercase tracking-widest text-blue-200">Nama Rute</p>
                <p class="mt-1 font-mono text-xs font-bold text-white">akademik.hitung-ipk</p>
            </div>
            <div class="rounded-xl bg-white/10 p-4 ring-1 ring-inset ring-white/20">
                <p class="text-[11px] font-bold uppercase tracking-widest text-blue-200">Rumus</p>
                <p class="mt-1 font-mono text-xs font-bold text-white">IPK = (IP1 + IP2) / 2</p>
            </div>
        </div>
    </section>

    {{-- PESAN KESALAHAN VALIDASI (HTTP 422). --}}
    @if ($errors !== [])
        <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-6">
            <h2 class="flex items-center gap-2 text-sm font-extrabold uppercase tracking-widest text-rose-700">
                Input Tidak Valid — HTTP 422
            </h2>
            <ul class="mt-3 space-y-2">
                @foreach ($errors as $pesan)
                    <li class="flex items-start gap-3 text-sm text-rose-900">
                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-rose-500"></span>
                        <span>{{ $pesan }}</span>
                    </li>
                @endforeach
            </ul>
            <p class="mt-4 text-xs leading-relaxed text-rose-700">
                Validasi dijalankan di sisi server sebelum perhitungan, sehingga tidak ada
                <span class="font-mono font-semibold">TypeError</span> maupun
                <span class="font-mono font-semibold">HTTP 500</span> yang bocor ke pengguna.
            </p>
        </div>
    @endif

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_1.2fr]">

        {{-- FORMULIR. --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400">Masukkan Nilai IP</h2>

            <form id="formIpk" method="GET" action="{{ $urlTemplate }}" class="mt-5 space-y-4">
                <div>
                    <label for="ip1" class="block text-sm font-semibold text-slate-700">IP Semester 1</label>
                    <input id="ip1" name="ip1" type="text" inputmode="decimal" autocomplete="off"
                           value="{{ old('ip1', $input['ip1'] ?? '') }}"
                           placeholder="contoh: 3.75"
                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 font-mono text-sm text-slate-800 shadow-sm outline-none transition focus:border-[#14539a] focus:ring-2 focus:ring-[#14539a]/20">
                </div>

                <div>
                    <label for="ip2" class="block text-sm font-semibold text-slate-700">IP Semester 2</label>
                    <input id="ip2" name="ip2" type="text" inputmode="decimal" autocomplete="off"
                           value="{{ old('ip2', $input['ip2'] ?? '') }}"
                           placeholder="contoh: 3.60"
                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-2.5 font-mono text-sm text-slate-800 shadow-sm outline-none transition focus:border-[#14539a] focus:ring-2 focus:ring-[#14539a]/20">
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-[#0a2c5e] px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#14539a]">
                    Hitung IPK &amp; Predikat
                </button>

                <p class="text-xs leading-relaxed text-slate-500">
                    Formulir menyusun URL tujuan dari
                    <code class="font-mono text-[11px]">route('akademik.hitung-ipk', [...])</code>,
                    bukan dari string manual.
                </p>
            </form>
        </section>

        {{-- HASIL. --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400">Hasil Perhitungan</h2>

            @if ($hasil === null)
                <div class="mt-5 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                    <p class="text-sm font-semibold text-slate-500">Belum ada hasil perhitungan.</p>
                    <p class="mt-1 text-xs text-slate-400">
                        Isi kedua kolom di samping, atau gunakan salah satu contoh di bawah.
                    </p>
                </div>
            @else
                <div class="mt-5 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Total Bobot IP</p>
                        <p class="mt-2 font-mono text-2xl font-extrabold text-[#0a2c5e]">{{ number_format($hasil['totalBobot'], 2) }}</p>
                        <p class="mt-1 font-mono text-[11px] text-slate-500">{{ number_format($hasil['ip1'], 2) }} + {{ number_format($hasil['ip2'], 2) }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Nilai Rata-rata (IPK)</p>
                        <p class="mt-2 font-mono text-2xl font-extrabold text-[#0a2c5e]">{{ number_format($hasil['ipk'], 2) }}</p>
                        <p class="mt-1 text-[11px] text-slate-500">Dibulatkan 2 desimal</p>
                    </div>
                    <div class="rounded-xl border p-4 {{ $toneStyle[$hasil['predikat']['tone']] ?? $toneStyle['sky'] }}">
                        <p class="text-[11px] font-bold uppercase tracking-widest opacity-70">Predikat</p>
                        <p class="mt-2 text-lg font-extrabold">{{ $hasil['predikat']['label'] }}</p>
                        <p class="mt-1 text-[11px] opacity-80">{{ $hasil['predikat']['keterangan'] }}</p>
                    </div>
                </div>

                <div class="mt-5 overflow-hidden rounded-xl border border-slate-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-widest text-slate-400">
                            <tr>
                                <th class="px-4 py-3 font-bold">Komponen</th>
                                <th class="px-4 py-3 font-bold">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr><td class="px-4 py-3 text-slate-600">IP Semester 1</td><td class="px-4 py-3 font-mono font-semibold">{{ number_format($hasil['ip1'], 2) }}</td></tr>
                            <tr><td class="px-4 py-3 text-slate-600">IP Semester 2</td><td class="px-4 py-3 font-mono font-semibold">{{ number_format($hasil['ip2'], 2) }}</td></tr>
                            <tr><td class="px-4 py-3 text-slate-600">Total Bobot IP</td><td class="px-4 py-3 font-mono font-semibold">{{ number_format($hasil['totalBobot'], 2) }}</td></tr>
                            <tr class="bg-slate-50"><td class="px-4 py-3 font-bold text-slate-700">IPK Sementara</td><td class="px-4 py-3 font-mono font-extrabold text-[#0a2c5e]">{{ number_format($hasil['ipk'], 2) }}</td></tr>
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- CONTOH UJI CEPAT: seluruh tautan memakai route(). --}}
            <div class="mt-6 border-t border-slate-100 pt-5">
                <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Contoh Uji Cepat</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <a href="{{ route('akademik.hitung-ipk', ['ip1' => '3.75', 'ip2' => '3.60']) }}"
                       class="rounded-lg bg-emerald-50 px-3 py-1.5 font-mono text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200 transition hover:bg-emerald-100">
                        3.75 / 3.60
                    </a>
                    <a href="{{ route('akademik.hitung-ipk', ['ip1' => '3.20', 'ip2' => '2.90']) }}"
                       class="rounded-lg bg-sky-50 px-3 py-1.5 font-mono text-xs font-semibold text-sky-700 ring-1 ring-inset ring-sky-200 transition hover:bg-sky-100">
                        3.20 / 2.90
                    </a>
                    <a href="{{ route('akademik.hitung-ipk', ['ip1' => '2.50', 'ip2' => '2.40']) }}"
                       class="rounded-lg bg-amber-50 px-3 py-1.5 font-mono text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200 transition hover:bg-amber-100">
                        2.50 / 2.40
                    </a>
                    <a href="{{ route('akademik.hitung-ipk', ['ip1' => '4.50', 'ip2' => '3.20']) }}"
                       class="rounded-lg bg-rose-50 px-3 py-1.5 font-mono text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200 transition hover:bg-rose-100">
                        4.50 / 3.20 (di luar rentang)
                    </a>
                    <a href="{{ route('akademik.hitung-ipk', ['ip1' => 'abc', 'ip2' => '3.20']) }}"
                       class="rounded-lg bg-rose-50 px-3 py-1.5 font-mono text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200 transition hover:bg-rose-100">
                        abc / 3.20 (non-numerik)
                    </a>
                    <a href="{{ route('akademik.hitung-ipk', ['ip1' => '-1', 'ip2' => '2.50']) }}"
                       class="rounded-lg bg-rose-50 px-3 py-1.5 font-mono text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200 transition hover:bg-rose-100">
                        -1 / 2.50 (negatif)
                    </a>
                </div>
            </div>
        </section>
    </div>

    <section class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('home') }}"
           class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
            &larr; Beranda
        </a>
        <a href="{{ route('dashboard.ringkasan') }}"
           class="rounded-xl bg-[#0a2c5e] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#14539a]">
            Lihat Ringkasan Akademik
        </a>
    </section>

@endsection

@push('scripts')
<script>
    (function () {
        var form = document.getElementById('formIpk');
        var templat = @json($urlTemplate);

        if (!form) {
            return;
        }

        form.addEventListener('submit', function (event) {
            var ip1 = encodeURIComponent(document.getElementById('ip1').value.trim());
            var ip2 = encodeURIComponent(document.getElementById('ip2').value.trim());

            event.preventDefault();
            window.location.href = templat.replace('__IP1__', ip1).replace('__IP2__', ip2);
        });
    })();
</script>
@endpush
