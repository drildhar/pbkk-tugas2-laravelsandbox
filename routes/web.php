<?php

declare(strict_types=1);

use App\Support\AcademicSandbox;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Web — PBKK Pertemuan 2: Laravel Local Sandbox & Routing Dasar
|--------------------------------------------------------------------------
|
| Berkas ini adalah satu-satunya pintu masuk (front controller) seluruh
| permintaan HTTP pada aplikasi sandbox akademik.
|
| Aturan yang dipegang pada berkas ini:
|  1. Anti hardcoded URL. Seluruh tautan, tombol, dan redirect memakai helper
|     `route('nama.rute', [...])`, tidak pernah menulis string URL manual.
|  2. Parameter opsional `{param?}` selalu diletakkan pada segmen paling akhir
|     dan memiliki nilai default eksplisit.
|  3. Penamaan rute mengikuti pola `kategori.aksi` (contoh: `dashboard.ringkasan`).
|  4. Input dari pengguna divalidasi di sisi server sebelum dipakai.
|
*/

/*
|--------------------------------------------------------------------------
| A. RUTE UTAMA (WAJIB)
|--------------------------------------------------------------------------
*/

/**
 * Rute 1 — Halaman Beranda (Home).
 *
 * GET /  →  route('home')
 *
 * Menampilkan sambutan hangat khas ITS beserta ringkasan identitas mahasiswa
 * dan navigasi ke seluruh rute lain melalui helper `route()`.
 */
Route::get('/', function () {
    return view('home', [
        'student' => AcademicSandbox::primaryStudent(),
        'agentIdeas' => AcademicSandbox::agentIdeas(),
        'summary' => AcademicSandbox::dashboardSummary(),
    ]);
})->name('home');

/**
 * Rute 2 — Detail Profil Mahasiswa.
 *
 * GET /mahasiswa/{nrp}  →  route('mahasiswa.profil', ['nrp' => $nrp])
 *
 * Tantangan 1: parameter {nrp} dikunci dengan regex `[0-9]{10}` sehingga
 * hanya menerima tepat 10 digit angka (format NRP ITS). Permintaan yang tidak
 * sesuai pola otomatis dijawab HTTP 404 oleh router sebelum closure dijalankan.
 *
 * Apabila format valid namun NRP tidak ada di katalog, halaman tetap dirender
 * dengan pesan yang ramah dan status HTTP 404.
 */
Route::get('/mahasiswa/{nrp}', function (string $nrp) {
    $student = AcademicSandbox::student($nrp);

    return response()->view('profil', [
        'nrp' => $nrp,
        'student' => $student,
    ], $student === null ? 404 : 200);
})->where('nrp', '[0-9]{10}')->name('mahasiswa.profil');

/**
 * Rute 3 — Eksplorasi Ide Platform Agentic AI.
 *
 * GET /agent/{tema?}  →  route('agent.ide', ['tema' => $tema])
 *
 * Parameter opsional wajib berada di akhir segmen. Nilai default eksplisit
 * adalah 'General Assistant Agent'. Tema dari pengguna dibersihkan terlebih
 * dahulu sebelum dipakai (anti-XSS) dan dicocokkan ke katalog ide.
 */
Route::get('/agent/{tema?}', function (?string $tema = AcademicSandbox::DEFAULT_AGENT_THEME) {
    $tema = AcademicSandbox::sanitizeTheme($tema);

    return view('agent', [
        'tema' => $tema,
        'idea' => AcademicSandbox::agentIdea($tema),
        'katalog' => AcademicSandbox::agentIdeas(),
        'isFallback' => $tema === AcademicSandbox::DEFAULT_AGENT_THEME,
    ]);
})->name('agent.ide');

/*
|--------------------------------------------------------------------------
| B. TANTANGAN 2 — KALKULATOR PORTOFOLIO AKADEMIS (IPK SEMESTER)
|--------------------------------------------------------------------------
*/

/**
 * GET /hitung-ipk/{ipk1}/{ipk2}  →  route('akademik.hitung-ipk', [...])
 *
 * Menerima dua parameter IP semester (bilangan bulat maupun desimal).
 *
 * Keamanan input:
 *  - Parameter tidak di-type-hint sebagai `float` agar input non-numerik tidak
 *    memicu TypeError (HTTP 500), melainkan ditangkap dan divalidasi manual.
 *  - Nilai harus berada pada rentang 0.00 - 4.00.
 *  - Apabila tidak valid, halaman dirender ulang dengan status HTTP 422 beserta
 *    pesan kesalahan yang spesifik per kolom.
 */
Route::get('/hitung-ipk/{ipk1}/{ipk2}', function (string $ipk1, string $ipk2) {
    $input = ['ipk1' => $ipk1, 'ipk2' => $ipk2];
    $nilai = [];
    $errors = [];

    foreach ($input as $kolom => $mentah) {
        $parsed = AcademicSandbox::parseIp($mentah);

        if ($parsed === null) {
            $errors[$kolom] = sprintf(
                'Nilai "%s" tidak valid. Masukkan angka pada rentang %.2f - %.2f.',
                $mentah,
                AcademicSandbox::IP_MIN,
                AcademicSandbox::IP_MAX,
            );

            continue;
        }

        $nilai[$kolom] = $parsed;
    }

    if ($errors !== []) {
        return response()->view('kalkulator', [
            'input' => $input,
            'errors' => $errors,
            'hasil' => null,
        ], 422);
    }

    $totalBobot = round($nilai['ipk1'] + $nilai['ipk2'], 2);
    $ipk = round($totalBobot / 2, 2);

    return view('kalkulator', [
        'input' => $input,
        'errors' => [],
        'hasil' => [
            'ipk1' => $nilai['ipk1'],
            'ipk2' => $nilai['ipk2'],
            'totalBobot' => $totalBobot,
            'ipk' => $ipk,
            'predikat' => AcademicSandbox::predicate($ipk),
        ],
    ]);
})->name('akademik.hitung-ipk');

/*
|--------------------------------------------------------------------------
| C. TANTANGAN 3 — ROUTE GROUP PREFIX /dashboard
|--------------------------------------------------------------------------
|
| Seluruh rute analitik dikelompokkan dengan `prefix('dashboard')` dan
| `name('dashboard.')` sehingga nama rutenya menjadi:
|   - dashboard.index
|   - dashboard.ringkasan
|   - dashboard.riwayat-studi
|
*/
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    /**
     * Halaman index dashboard: mengalihkan pengunjung ke ringkasan.
     *
     * Redirect dibangun dengan helper `route()`, bukan string URL manual.
     */
    Route::get('/', function () {
        return redirect()->route('dashboard.ringkasan');
    })->name('index');

    /**
     * GET /dashboard/ringkasan → route('dashboard.ringkasan')
     *
     * Menampilkan kartu metrik akademik: IPK kumulatif, total SKS, dan predikat.
     */
    Route::get('/ringkasan', function () {
        return view('dashboard.ringkasan', [
            'summary' => AcademicSandbox::dashboardSummary(),
            'student' => AcademicSandbox::primaryStudent(),
        ]);
    })->name('ringkasan');

    /**
     * GET /dashboard/riwayat-studi → route('dashboard.riwayat-studi')
     *
     * Menampilkan tabel riwayat studi per semester.
     */
    Route::get('/riwayat-studi', function () {
        return view('dashboard.riwayat-studi', [
            'riwayat' => AcademicSandbox::studyHistory(),
            'student' => AcademicSandbox::primaryStudent(),
        ]);
    })->name('riwayat-studi');
});

/*
|--------------------------------------------------------------------------
| D. TANTANGAN 3 — ROUTE FALLBACK (HANDLER 404 KUSTOM)
|--------------------------------------------------------------------------
|
| `Route::fallback()` menangkap seluruh URL yang tidak terdaftar pada berkas
| ini. Handler selalu diletakkan paling bawah agar tidak menutupi rute lain,
| dan mengembalikan status HTTP 404 yang benar (bukan 200).
|
| Halaman error untuk permintaan yang gagal pada level router (misalnya NRP
| tidak lolos regex) dirender oleh `resources/views/errors/404.blade.php`.
|
*/
Route::fallback(function () {
    return response()->view('errors.404', [
        'path' => request()->path(),
    ], 404);
});
