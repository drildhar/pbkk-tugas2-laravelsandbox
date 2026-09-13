# Laravel Local Sandbox & Routing Dasar

Tugas Mandiri & Tantangan Mingguan **PBKK Pertemuan 2** — Departemen Teknik Informatika,
Fakultas Teknologi Elektro dan Informatika Cerdas (FTEIC), Institut Teknologi Sepuluh Nopember.

| Item | Keterangan |
| --- | --- |
| Nama | Adriel Mahira Dharma |
| NRP | 5025241097 |
| Stack | Laravel 13.31.0, PHP 8.5, Blade, Tailwind CSS (Play CDN) |

---

## 1. Cara Menjalankan

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Buka `http://127.0.0.1:8000`. Basis data tidak diperlukan untuk sandbox ini
(seluruh data akademik berasal dari `app/Support/AcademicSandbox.php`).

---

## 2. Daftar Rute

| # | Method | URL | Nama Rute | Parameter |
| --- | --- | --- | --- | --- |
| 1 | GET | `/` | `home` | — |
| 2 | GET | `/mahasiswa/{nrp}` | `mahasiswa.profil` | Wajib, regex `^[0-9]{10}$` |
| 3 | GET | `/agent/{tema?}` | `agent.ide` | Opsional, default `General Assistant Agent` |
| 4 | GET | `/hitung-ipk/{ipk1}/{ipk2}` | `akademik.hitung-ipk` | Wajib, rentang `0.00 - 4.00` |
| 5 | GET | `/dashboard` | `dashboard.index` | Redirect ke `dashboard.ringkasan` |
| 6 | GET | `/dashboard/ringkasan` | `dashboard.ringkasan` | Route group prefix |
| 7 | GET | `/dashboard/riwayat-studi` | `dashboard.riwayat-studi` | Route group prefix |
| 8 | ANY | `{fallbackPlaceholder}` | — | `Route::fallback()` → 404 kustom |

---

## 3. Struktur Berkas

```
routes/web.php                              Semua deklarasi rute + komentar arsitektur
app/Support/AcademicSandbox.php             Sumber data akademik & logika predikat
resources/views/layouts/app.blade.php       Layout induk (navbar, footer, Tailwind CDN)
resources/views/home.blade.php              Rute 1 — beranda
resources/views/profil.blade.php            Rute 2 — profil / NRP tidak ditemukan
resources/views/agent.blade.php             Rute 3 — ide platform Agentic AI
resources/views/kalkulator.blade.php        Tantangan 2 — kalkulator IPK
resources/views/dashboard/ringkasan.blade.php       Tantangan 3 — route group
resources/views/dashboard/riwayat-studi.blade.php   Tantangan 3 — route group
resources/views/errors/404.blade.php        Tantangan 3 — halaman 404 kustom
tests/Feature/RoutingSandboxTest.php        Verifikasi otomatis seluruh rute
```

---

## 4. Matriks Pengujian

| No | URL Uji Coba | Jenis Parameter | Hasil yang Diharapkan | Penanganan Error |
| --- | --- | --- | --- | --- |
| 1 | `/` | Tanpa parameter | HTTP 200, hero "Vivat ITS!" dan kartu identitas | — |
| 2 | `/mahasiswa/5025241097` | Wajib, 10 digit valid | HTTP 200, profil Adriel Mahira Dharma | — |
| 3 | `/mahasiswa/123` | Regex gagal (3 digit) | HTTP 404 halaman 404 kustom | Router menolak sebelum closure |
| 4 | `/mahasiswa/50252410ab` | Regex gagal (mengandung huruf) | HTTP 404 halaman 404 kustom | Router menolak sebelum closure |
| 5 | `/mahasiswa/5025999999` | Format valid, data tidak ada | HTTP 404 "NRP Tidak Ditemukan" | Ditangani di dalam closure |
| 6 | `/agent` | Opsional tidak diisi | HTTP 200, fallback *General Assistant Agent* | Nilai default eksplisit |
| 7 | `/agent/code-reviewer` | Opsional, slug katalog | HTTP 200, detail *Code Reviewer Agent* | — |
| 8 | `/agent/quantum-tutor` | Opsional, tema kustom | HTTP 200, konsep kustom generik | Resolusi katalog gagal → konsep kustom |
| 9 | `/agent/<img src=x onerror=alert(1)>` | Payload XSS | HTTP 200, tag dibersihkan | `strip_tags()` + escape Blade `{{ }}` |
| 10 | `/hitung-ipk/3.75/3.60` | Desimal valid | HTTP 200, total 7.35, IPK 3.68, Cumlaude | — |
| 11 | `/hitung-ipk/3.20/2.90` | Desimal valid | HTTP 200, IPK 3.05, Sangat Memuaskan | — |
| 12 | `/hitung-ipk/4.50/3.20` | Di luar rentang | HTTP 422 + pesan kesalahan | Validasi rentang `0.00 - 4.00` |
| 13 | `/hitung-ipk/abc/3.20` | Non-numerik | HTTP 422 + pesan kesalahan | `is_numeric()` guard, tanpa `TypeError` |
| 14 | `/hitung-ipk/-1/2.50` | Negatif | HTTP 422 + pesan kesalahan | Validasi batas bawah |
| 15 | `/dashboard` | — | HTTP 302 ke `/dashboard/ringkasan` | `redirect()->route()` |
| 16 | `/dashboard/ringkasan` | Route group | HTTP 200, kartu IPK/SKS/predikat | — |
| 17 | `/dashboard/riwayat-studi` | Route group | HTTP 200, tabel riwayat + total | — |
| 18 | `/halaman-ngawur` | URL tidak terdaftar | HTTP 404 halaman 404 kustom | `Route::fallback()` |

---

## 5. Verifikasi Terminal Artisan

```bash
# Seluruh rute aplikasi (tanpa rute bawaan vendor)
php artisan route:list --except-vendor

# Hanya rute ber-prefix dashboard
php artisan route:list --path=dashboard

# Filter berdasarkan nama rute
php artisan route:list --name=mahasiswa
php artisan route:list --name=akademik

# Detail middleware & action satu rute
php artisan route:list --name=agent.ide -v

# Menjalankan server lokal
php artisan serve
php artisan serve --host=127.0.0.1 --port=8123

# Menjalankan pengujian otomatis
php artisan test
php artisan test --filter=RoutingSandboxTest

# Membersihkan cache rute & view setelah mengubah routes/web.php
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

---

## 6. Cheatsheet Live Demo 5 Menit

**Menit 0-1 — Pembuka**
- Sebutkan identitas: Adriel Mahira Dharma, NRP 5025241097, Teknik Informatika FTEIC ITS.
- Tunjukkan `php artisan route:list --except-vendor`: 8 rute, semua bernama, terurut rapi.

**Menit 1-2 — Rute Dasar**
- Buka `/` → tunjukkan `route('home')`, navigasi antar halaman lewat tombol.
- Buka `/mahasiswa/5025241097` → tegaskan parameter **wajib** `{nrp}`.
- Uji `/mahasiswa/123` → **404 otomatis dari regex** `^[0-9]{10}$` (bukan `if` manual).

**Menit 2-3 — Parameter Opsional**
- Buka `/agent` → tampil *General Assistant Agent* dari **nilai default eksplisit**.
- Buka `/agent/code-reviewer` → katalog ter-resolve; lalu `/agent/quantum-tutor` → konsep kustom.
- Sebut: parameter opsional selalu di **segmen paling akhir** rute.

**Menit 3-4 — Tantangan A+**
- Buka `/hitung-ipk/3.75/3.60` → total bobot 7.35, IPK 3.68, predikat *Cumlaude*.
- Buka `/hitung-ipk/abc/3.20` → **HTTP 422**, bukan HTTP 500 (bukti validasi mencegah `TypeError`).
- Buka `/dashboard` → **302** ke `dashboard.ringkasan`; tunjukkan *route group* prefix + name prefix.
- Buka `/halaman-ngawur` → **`Route::fallback()`** mengembalikan 404 kustom yang tetap bernavigasi.

**Menit 4-5 — Kualitas & Penutup**
- Tekankan **anti hardcoded URL**: seluruh `<a href>` memakai `route()`.
- Tunjukkan `php artisan test` → 17 tes lulus.
- Tutup dengan higienitas Git: `.env` dan `vendor/` ada di `.gitignore`.

### Pertanyaan yang Sering Muncul

| Pertanyaan | Jawaban Singkat |
| --- | --- |
| Kenapa parameter tidak di-type-hint `float`? | Input non-numerik akan memicu `TypeError` → HTTP 500. Validasi manual memungkinkan respons 422 yang ramah. |
| Di mana data profil disimpan? | `app/Support/AcademicSandbox.php` sebagai *single source of truth*, agar `routes/web.php` tetap ringkas. |
| Bagaimana XSS dicegah? | `strip_tags()` + pembatasan panjang di `sanitizeTheme()`, lalu output di-escape oleh Blade `{{ }}`. |
| Apa bedanya `Route::fallback()` dengan `errors/404.blade.php`? | `fallback()` menangani URL yang tidak cocok dengan rute mana pun; `errors/404.blade.php` merender 404 yang dilempar framework (misalnya gagal regex). |
| Kenapa memakai `route()` semua? | Perubahan URL cukup di `routes/web.php`; tautan lain ikut menyesuaikan otomatis dan aplikasi bebas *broken link*. |

---

## 7. Higienitas Git

- `.env` dan `/vendor` **tidak boleh** di-commit; keduanya sudah tercantum pada `.gitignore`.
- Commit hanya `composer.json` dan `composer.lock` agar dependensi dapat direproduksi.
- Cek dengan: `git check-ignore -v .env vendor`.

```bash
git status --short
git check-ignore -v .env vendor
```
