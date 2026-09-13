<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Str;

/**
 * AcademicSandbox
 * -----------------------------------------------------------------------------
 * Sumber data tunggal (single source of truth) untuk seluruh sandbox akademik
 * PBKK Pertemuan 2.
 *
 * Kelas ini sengaja dipisahkan dari `routes/web.php` agar rute tetap ringkas,
 * mudah dibaca, dan bebas dari data yang panjang (prinsip Clean Code: Separation
 * of Concerns). Semua nilai yang ditampilkan ke pengguna di-escape oleh Blade
 * `{{ }}` sehingga aman dari XSS.
 *
 * @package App\Support
 */
final class AcademicSandbox
{
    /**
     * Nilai fallback resmi untuk parameter opsional `{tema?}` pada rute agent.ide.
     */
    public const DEFAULT_AGENT_THEME = 'General Assistant Agent';

    /**
     * Rentang IP yang valid menurut aturan akademik (skala 0.00 - 4.00).
     */
    public const IP_MIN = 0.00;

    public const IP_MAX = 4.00;

    /**
     * Katalog profil mahasiswa, di-key berdasarkan NRP (10 digit numerik).
     *
     * @var array<string, array<string, mixed>>
     */
    private const STUDENTS = [
        '5025241097' => [
            'nrp' => '5025241097',
            'nama' => 'Adriel Mahira Dharma',
            'departemen' => 'Teknik Informatika',
            'fakultas' => 'Fakultas Teknologi Elektro dan Informatika Cerdas (FTEIC)',
            'institut' => 'Institut Teknologi Sepuluh Nopember (ITS) Surabaya',
            'angkatan' => 2024,
            'semester' => 4,
            'jalurMasuk' => 'Seleksi Nasional Berdasarkan Tes (SNBT)',
            'status' => 'Aktif',
            'kelas' => 'PBKK — Kelas A',
            'dosenWali' => 'Tim Dosen Teknik Informatika ITS',
            'email' => '5025241097@student.its.ac.id',
            'motto' => 'Membangun agentic AI yang bermanfaat, bukan sekadar pintar.',
            'minat' => [
                'Agentic AI & Large Language Model',
                'Web Engineering (Laravel)',
                'Cloud & DevOps',
                'Human-Centered Design',
            ],
        ],
    ];

    /**
     * Katalog ide proyek akhir semester platform Agentic AI.
     *
     * @var array<string, array<string, mixed>>
     */
    private const AGENT_IDEAS = [
        'general-assistant' => [
            'slug' => 'general-assistant',
            'nama' => 'General Assistant Agent',
            'tagline' => 'Asisten serba bisa untuk produktivitas harian mahasiswa.',
            'deskripsi' => 'Agent ini berperan sebagai satu pintu masuk (single entry point) '
                .'yang mampu memahami intent pengguna, lalu memilih tool yang tepat untuk '
                .'menjawab pertanyaan umum, menyusun ringkasan, dan mengelola agenda akademik.',
            'kapabilitas' => [
                'Memahami dan memecah instruksi kompleks menjadi langkah-langkah kecil.',
                'Memanggil tool pencarian, kalkulator, dan manajemen berkas secara mandiri.',
                'Menjaga konteks percakapan panjang dengan memori jangka pendek dan panjang.',
            ],
            'stack' => ['Laravel 13', 'HTTP Client Tool Calling', 'Vector Store', 'Redis Queue'],
            'dampak' => 'Menjadi fondasi arsitektur bagi agent-agent yang lebih spesifik.',
            'kesulitan' => 'Menengah',
        ],
        'code-reviewer' => [
            'slug' => 'code-reviewer',
            'nama' => 'Code Reviewer Agent',
            'tagline' => 'Reviewer otomatis yang menjaga kualitas dan keamanan kode.',
            'deskripsi' => 'Agent ini membaca diff pada sebuah pull request, menilai kepatuhan '
                .'terhadap standar PSR-12, mendeteksi celah keamanan umum, dan menuliskan '
                .'komentar perbaikan langsung pada baris kode yang bermasalah.',
            'kapabilitas' => [
                'Analisis statis ringan terhadap diff tanpa menjalankan kode.',
                'Deteksi pola rentan: XSS, SQL Injection, mass assignment, dan secret ter-hardcode.',
                'Menyusun komentar review terstruktur beserta contoh perbaikan.',
            ],
            'stack' => ['Laravel 13', 'GitHub Webhook', 'Static Analysis', 'Queue Worker'],
            'dampak' => 'Memangkas waktu review manual dan menekan bug yang lolos ke produksi.',
            'kesulitan' => 'Menengah - Tinggi',
        ],
        'research-copilot' => [
            'slug' => 'research-copilot',
            'nama' => 'Research Copilot Agent',
            'tagline' => 'Navigator literatur ilmiah dari pertanyaan menjadi sitasi.',
            'deskripsi' => 'Agent ini membantu mahasiswa menelusuri literatur, merangkum paper, '
                .'membangun peta konsep, serta menyusun daftar pustaka yang konsisten dengan '
                .'gaya sitasi yang dipilih.',
            'kapabilitas' => [
                'Pencarian semantik lintas repositori paper dan repositori kampus.',
                'Perangkuman bertingkat: abstrak, temuan utama, lalu implikasi.',
                'Generasi sitasi otomatis beserta manajemen metadata.',
            ],
            'stack' => ['Laravel 13', 'Retrieval Augmented Generation', 'Embedding Model', 'PDF Parser'],
            'dampak' => 'Mempercepat fase studi literatur pada pengerjaan tugas akhir.',
            'kesulitan' => 'Tinggi',
        ],
        'campus-service' => [
            'slug' => 'campus-service',
            'nama' => 'Campus Service Agent',
            'tagline' => 'Layanan administrasi kampus yang menjawab kapan pun.',
            'deskripsi' => 'Agent ini menjawab pertanyaan seputar kalender akademik, prosedur '
                .'cuti, pengajuan transkrip, dan beasiswa dengan merujuk pada dokumen resmi '
                .'sehingga jawaban dapat dipertanggungjawabkan.',
            'kapabilitas' => [
                'Pencarian dokumen resmi dengan sitasi halaman sumber.',
                'Alur tanya-jawab bertahap untuk melengkapi berkas persyaratan.',
                'Eskalasi otomatis ke petugas ketika pertanyaan di luar cakupan dokumen.',
            ],
            'stack' => ['Laravel 13', 'Document Ingestion', 'Vector Database', 'Role Based Access'],
            'dampak' => 'Mengurangi beban antrean layanan administrasi di tingkat departemen.',
            'kesulitan' => 'Menengah',
        ],
        'data-analyst' => [
            'slug' => 'data-analyst',
            'nama' => 'Data Analyst Agent',
            'tagline' => 'Dari pertanyaan bahasa alami menjadi insight dan grafik.',
            'deskripsi' => 'Agent ini menerjemahkan pertanyaan analitis menjadi kueri data, '
                .'menjalankannya pada dataset akademik, lalu menyajikan temuan dalam bentuk '
                .'narasi singkat dan visualisasi.',
            'kapabilitas' => [
                'Text-to-SQL dengan validasi skema sebelum eksekusi.',
                'Deteksi anomali sederhana pada tren nilai dan kehadiran.',
                'Penyusunan laporan ringkas beserta grafik pendukung.',
            ],
            'stack' => ['Laravel 13', 'Text-to-SQL', 'Chart Renderer', 'Audit Log'],
            'dampak' => 'Membantu pengambilan keputusan berbasis data di tingkat program studi.',
            'kesulitan' => 'Tinggi',
        ],
        'thesis-mentor' => [
            'slug' => 'thesis-mentor',
            'nama' => 'Thesis Mentor Agent',
            'tagline' => 'Pendamping penulisan tugas akhir yang disiplin dan terstruktur.',
            'deskripsi' => 'Agent ini memecah pengerjaan tugas akhir menjadi milestone, '
                .'memberi umpan balik atas draf tulisan, dan mengingatkan tenggat secara '
                .'bertahap agar mahasiswa tetap berada di jalur.',
            'kapabilitas' => [
                'Penyusunan rencana kerja bertahap beserta tenggat realistis.',
                'Umpan balik struktur, kohesi paragraf, dan konsistensi istilah.',
                'Pelacakan progres bab dan pengingat otomatis.',
            ],
            'stack' => ['Laravel 13', 'Scheduler', 'Notification Channel', 'Rubrik Penilaian'],
            'dampak' => 'Menurunkan risiko keterlambatan studi dengan pemantauan progres.',
            'kesulitan' => 'Menengah',
        ],
    ];

    /**
     * Riwayat studi contoh untuk halaman /dashboard/riwayat-studi.
     *
     * @var array<int, array<string, mixed>>
     */
    private const STUDY_HISTORY = [
        ['semester' => 1, 'sks' => 20, 'ip' => 3.72, 'predikat' => 'Sangat Memuaskan'],
        ['semester' => 2, 'sks' => 21, 'ip' => 3.68, 'predikat' => 'Sangat Memuaskan'],
        ['semester' => 3, 'sks' => 22, 'ip' => 3.81, 'predikat' => 'Cumlaude'],
    ];

    /**
     * Ambil seluruh katalog mahasiswa.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function students(): array
    {
        return self::STUDENTS;
    }

    /**
     * Ambil mahasiswa utama (pemilik sandbox) untuk ditampilkan di beranda.
     *
     * @return array<string, mixed>
     */
    public static function primaryStudent(): array
    {
        return self::STUDENTS[array_key_first(self::STUDENTS)] ?? [];
    }

    /**
     * Cari profil mahasiswa berdasarkan NRP.
     *
     * @return array<string, mixed>|null Null apabila NRP tidak terdaftar.
     */
    public static function student(string $nrp): ?array
    {
        return self::STUDENTS[$nrp] ?? null;
    }

    /**
     * Ambil seluruh katalog ide platform Agentic AI.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function agentIdeas(): array
    {
        return self::AGENT_IDEAS;
    }

    /**
     * Resolusi tema menjadi struktur ide yang siap ditampilkan.
     *
     * Urutan resolusi: slug katalog -> nama katalog (case-insensitive) ->
     * konsep kustom generik. Dengan demikian rute selalu mengembalikan data
     * yang aman ditampilkan, tanpa pernah melempar error ke pengguna.
     *
     * @return array<string, mixed>
     */
    public static function agentIdea(?string $tema): array
    {
        $tema = self::sanitizeTheme($tema);
        $slug = Str::slug($tema);

        if ($slug !== '' && isset(self::AGENT_IDEAS[$slug])) {
            return self::AGENT_IDEAS[$slug];
        }

        foreach (self::AGENT_IDEAS as $idea) {
            if (strcasecmp((string) $idea['nama'], $tema) === 0) {
                return $idea;
            }
        }

        return self::customAgentIdea($tema);
    }

    /**
     * Nilai fallback apabila parameter opsional `{tema?}` tidak diisi.
     *
     * @return array<string, mixed>
     */
    public static function defaultAgentIdea(): array
    {
        return self::AGENT_IDEAS['general-assistant'];
    }

    /**
     * Bersihkan input tema dari pengguna (anti-XSS & anti-payload berlebih).
     *
     * Nilai kosong dikembalikan sebagai fallback default sesuai spesifikasi tugas.
     */
    public static function sanitizeTheme(?string $tema): string
    {
        $tema = strip_tags((string) $tema);
        $tema = trim(preg_replace('/\s+/u', ' ', $tema) ?? '');
        $tema = Str::limit($tema, 60, '');

        return $tema === '' ? self::DEFAULT_AGENT_THEME : $tema;
    }

    /**
     * Validasi satu nilai IP dari URL.
     *
     * Menerima bilangan bulat maupun desimal. Mengembalikan null apabila nilai
     * bukan numerik, bernilai negatif, atau berada di luar rentang 0.00 - 4.00.
     */
    public static function parseIp(string $value): ?float
    {
        $value = trim($value);

        if ($value === '' || ! is_numeric($value)) {
            return null;
        }

        $ip = (float) $value;

        if (! is_finite($ip) || $ip < self::IP_MIN || $ip > self::IP_MAX) {
            return null;
        }

        return round($ip, 2);
    }

    /**
     * Tentukan predikat akademik berdasarkan nilai IPK.
     *
     * @return array{label: string, tone: string, keterangan: string}
     */
    public static function predicate(float $ipk): array
    {
        return match (true) {
            $ipk >= 3.51 => [
                'label' => 'Cumlaude',
                'tone' => 'emerald',
                'keterangan' => 'Pujian tertinggi, di atas ambang 3.50.',
            ],
            $ipk >= 3.01 => [
                'label' => 'Sangat Memuaskan',
                'tone' => 'sky',
                'keterangan' => 'Prestasi baik dengan rentang IPK 3.01 - 3.50.',
            ],
            $ipk >= 2.76 => [
                'label' => 'Memuaskan',
                'tone' => 'amber',
                'keterangan' => 'Prestasi cukup dengan rentang IPK 2.76 - 3.00.',
            ],
            $ipk >= 2.00 => [
                'label' => 'Baik',
                'tone' => 'orange',
                'keterangan' => 'Di atas batas minimum kelulusan, masih dapat ditingkatkan.',
            ],
            default => [
                'label' => 'Perlu Perbaikan',
                'tone' => 'rose',
                'keterangan' => 'Di bawah 2.00, perlu pendampingan akademik.',
            ],
        };
    }

    /**
     * Ringkasan metrik akademik untuk halaman /dashboard/ringkasan.
     *
     * @return array<string, mixed>
     */
    public static function dashboardSummary(): array
    {
        $history = self::STUDY_HISTORY;

        $totalSks = array_sum(array_column($history, 'sks'));
        $totalMutu = array_sum(array_map(
            static fn (array $row): float => $row['ip'] * $row['sks'],
            $history,
        ));
        $ipk = round($totalMutu / $totalSks, 2);

        return [
            'ipk' => $ipk,
            'totalSks' => $totalSks,
            'totalMutu' => round($totalMutu, 2),
            'semesterAktif' => count($history) + 1,
            'predikat' => self::predicate($ipk),
            'riwayat' => $history,
        ];
    }

    /**
     * Riwayat studi per semester untuk halaman /dashboard/riwayat-studi.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function studyHistory(): array
    {
        return self::STUDY_HISTORY;
    }

    /**
     * Bangun konsep kustom generik untuk tema yang belum ada di katalog.
     *
     * @return array<string, mixed>
     */
    private static function customAgentIdea(string $tema): array
    {
        return [
            'slug' => Str::slug($tema) ?: 'general-assistant',
            'nama' => Str::title($tema),
            'tagline' => 'Konsep kustom hasil eksplorasi mandiri.',
            'deskripsi' => 'Tema "'.$tema.'" belum terdaftar pada katalog sandbox. '
                .'Kerangka berikut disusun otomatis sebagai titik awal perancangan platform '
                .'Agentic AI, sehingga eksplorasi tetap berjalan tanpa menghentikan demo.',
            'kapabilitas' => [
                'Perumusan tujuan agent dan batas tanggung jawabnya.',
                'Pemilihan tool yang relevan beserta skema pemanggilannya.',
                'Perancangan mekanisme evaluasi dan pengawasan keluaran agent.',
            ],
            'stack' => ['Laravel 13', 'Tool Calling', 'Vector Store', 'Observability'],
            'dampak' => 'Menjadi cetak biru awal sebelum tema dipromosikan ke katalog resmi.',
            'kesulitan' => 'Perlu Kajian',
            'isCustom' => true,
        ];
    }
}
