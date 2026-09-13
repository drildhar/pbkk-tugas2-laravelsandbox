<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Verifikasi otomatis untuk seluruh rute sandbox PBKK Pertemuan 2.
 */
class RoutingSandboxTest extends TestCase
{
    public function test_halaman_beranda_dapat_diakses(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Adriel Mahira Dharma')
            ->assertSee('5025241097')
            ->assertSee('Vivat ITS');
    }

    public function test_profil_mahasiswa_menampilkan_data_terdaftar(): void
    {
        $this->get(route('mahasiswa.profil', ['nrp' => '5025241097']))
            ->assertOk()
            ->assertSee('Adriel Mahira Dharma')
            ->assertSee('Teknik Informatika');
    }

    public function test_nrp_kurang_dari_sepuluh_digit_menghasilkan_404(): void
    {
        $this->get('/mahasiswa/50252410')->assertNotFound();
    }

    public function test_nrp_mengandung_huruf_menghasilkan_404(): void
    {
        $this->get('/mahasiswa/50252410ab')->assertNotFound();
    }

    public function test_nrp_valid_namun_tidak_terdaftar_menghasilkan_404(): void
    {
        $this->get(route('mahasiswa.profil', ['nrp' => '5025999999']))
            ->assertNotFound()
            ->assertSee('NRP Tidak Ditemukan');
    }

    public function test_agent_tanpa_parameter_memakai_nilai_fallback(): void
    {
        $this->get(route('agent.ide'))
            ->assertOk()
            ->assertSee('General Assistant Agent')
            ->assertSee('Nilai Fallback Default');
    }

    public function test_agent_dengan_slug_katalog(): void
    {
        $this->get(route('agent.ide', ['tema' => 'code-reviewer']))
            ->assertOk()
            ->assertSee('Code Reviewer Agent');
    }

    public function test_agent_dengan_tema_kustom_tetap_dirender(): void
    {
        $this->get(route('agent.ide', ['tema' => 'quantum-tutor']))
            ->assertOk()
            ->assertSee('Konsep Kustom');
    }

    public function test_agent_menyaring_payload_xss(): void
    {
        $payload = 'Adriel<img src=x onerror=alert(1)>';

        $this->get('/agent/'.rawurlencode($payload))
            ->assertOk()
            ->assertDontSee('<img', false)
            ->assertDontSee('onerror=', false)
            ->assertSee('Adriel');
    }

    public function test_kalkulator_ipk_menghitung_total_bobot_dan_predikat(): void
    {
        $this->get(route('akademik.hitung-ipk', ['ip1' => '3.75', 'ip2' => '3.60']))
            ->assertOk()
            ->assertSee('7.35')
            ->assertSee('3.68')
            ->assertSee('Cumlaude');
    }

    public function test_kalkulator_ipk_menolak_nilai_di_luar_rentang(): void
    {
        $this->get(route('akademik.hitung-ipk', ['ip1' => '4.50', 'ip2' => '3.20']))
            ->assertStatus(422)
            ->assertSee('tidak valid');
    }

    public function test_kalkulator_ipk_menolak_input_non_numerik(): void
    {
        $this->get(route('akademik.hitung-ipk', ['ip1' => 'abc', 'ip2' => '3.20']))
            ->assertStatus(422)
            ->assertSee('tidak valid');
    }

    public function test_kalkulator_ipk_menolak_input_negatif(): void
    {
        $this->get(route('akademik.hitung-ipk', ['ip1' => '-1', 'ip2' => '2.50']))
            ->assertStatus(422)
            ->assertSee('tidak valid');
    }

    public function test_dashboard_index_mengalihkan_ke_ringkasan(): void
    {
        $this->get(route('dashboard.index'))
            ->assertRedirect(route('dashboard.ringkasan'));
    }

    public function test_dashboard_ringkasan_dan_riwayat_studi_dapat_diakses(): void
    {
        $this->get(route('dashboard.ringkasan'))->assertOk()->assertSee('Ringkasan Akademik');
        $this->get(route('dashboard.riwayat-studi'))->assertOk()->assertSee('Riwayat Studi');
    }

    public function test_url_tidak_terdaftar_ditangani_fallback_route(): void
    {
        $this->get('/url-sembarang-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman Tidak Ditemukan');
    }
}
