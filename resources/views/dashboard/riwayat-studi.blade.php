@extends('layouts.app')

@section('title', 'Dashboard — Riwayat Studi')

@section('content')

    @php
        $totalSks = array_sum(array_column($riwayat, 'sks'));
        $totalMutu = array_sum(array_map(static fn (array $baris): float => $baris['ip'] * $baris['sks'], $riwayat));
        $ipkKumulatif = $totalSks > 0 ? round($totalMutu / $totalSks, 2) : 0.0;
    @endphp

    <section class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-[#14539a]">Route Group /dashboard</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Riwayat Studi</h1>
            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-500">
                Rekapitulasi capaian per semester untuk {{ $student['nama'] }}
                (<span class="font-mono text-xs">{{ $student['nrp'] }}</span>) beserta IPK kumulatif yang
                dihitung dari total mutu dibagi total SKS.
            </p>
        </div>
        <a href="{{ route('dashboard.ringkasan') }}"
           class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
            &larr; Ringkasan
        </a>
    </section>

    <section class="mt-7 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[36rem] text-left text-sm">
                <caption class="sr-only">Riwayat studi per semester</caption>
                <thead class="bg-slate-50 text-xs uppercase tracking-widest text-slate-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Semester</th>
                        <th scope="col" class="px-6 py-4 font-bold">SKS</th>
                        <th scope="col" class="px-6 py-4 font-bold">Indeks Prestasi</th>
                        <th scope="col" class="px-6 py-4 font-bold">Mutu (IP x SKS)</th>
                        <th scope="col" class="px-6 py-4 font-bold">Predikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($riwayat as $baris)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-800">Semester {{ $baris['semester'] }}</td>
                            <td class="px-6 py-4 font-mono text-slate-600">{{ $baris['sks'] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="font-mono font-bold text-[#0a2c5e]">{{ number_format($baris['ip'], 2) }}</span>
                                    <span class="h-1.5 w-24 overflow-hidden rounded-full bg-slate-100">
                                        <span class="block h-full rounded-full bg-gradient-to-r from-[#0a2c5e] to-[#f2a900]"
                                              style="width: {{ round($baris['ip'] / 4 * 100) }}%"></span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600">{{ number_format($baris['ip'] * $baris['sks'], 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $baris['predikat'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-50 text-sm">
                    <tr>
                        <td class="px-6 py-4 font-extrabold text-slate-700">Total</td>
                        <td class="px-6 py-4 font-mono font-extrabold text-slate-700">{{ $totalSks }}</td>
                        <td class="px-6 py-4 font-mono font-extrabold text-[#0a2c5e]">{{ number_format($ipkKumulatif, 2) }}</td>
                        <td class="px-6 py-4 font-mono font-extrabold text-slate-700">{{ number_format($totalMutu, 2) }}</td>
                        <td class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-500">IPK Kumulatif</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section class="mt-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">IPK Kumulatif</p>
            <p class="mt-2 font-mono text-2xl font-extrabold text-[#0a2c5e]">{{ number_format($ipkKumulatif, 2) }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Total SKS</p>
            <p class="mt-2 font-mono text-2xl font-extrabold text-[#0a2c5e]">{{ $totalSks }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Total Mutu</p>
            <p class="mt-2 font-mono text-2xl font-extrabold text-[#0a2c5e]">{{ number_format($totalMutu, 2) }}</p>
        </div>
    </section>

    <section class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('home') }}"
           class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
            &larr; Beranda
        </a>
        <a href="{{ route('akademik.hitung-ipk', ['ipk1' => '3.75', 'ipk2' => '3.60']) }}"
           class="rounded-xl bg-[#f2a900] px-5 py-2.5 text-sm font-bold text-[#3a2600] shadow-sm transition hover:bg-[#ffc23d]">
            Kalkulator IPK
        </a>
    </section>

@endsection
