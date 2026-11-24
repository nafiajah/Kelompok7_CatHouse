<?php

namespace Tests\Feature;

use App\Models\DataKucing;
use App\Models\Reservation;
use App\Models\Session;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QAFixesTest extends TestCase
{
    use RefreshDatabase;

    public function test_cat_search_and_variant_filter_grouping(): void
    {
        $v1 = Variant::create(['jenis' => 'Persia']);
        $v2 = Variant::create(['jenis' => 'Bengal']);

        DataKucing::create([
            'id_variant' => $v1->id,
            'nama_kucing' => 'Milo Persia',
            'deskripsi' => 'Kucing lucu',
            'foto' => 'milo.png',
        ]);

        DataKucing::create([
            'id_variant' => $v2->id,
            'nama_kucing' => 'Milo Bengal',
            'deskripsi' => 'Kucing aktif',
            'foto' => 'milo_bengal.png',
        ]);

        $response = $this->get('/kucing?search=Milo&variant=' . $v1->id);
        $response->assertStatus(200);
        $response->assertSee('Milo Persia');
        $response->assertDontSee('Milo Bengal');
    }

    public function test_reservation_stores_guest_contact_details(): void
    {
        $user = User::create([
            'role' => 'user',
            'username' => 'testuser',
            'password' => bcrypt('password'),
            'email' => 'user@test.com',
            'no_telp' => '0812345678',
            'nama_lengkap' => 'Akun Pemilik',
        ]);

        $session = Session::firstOrCreate(
            ['jam_sesi' => '14:00 - 14:30'],
            ['token_sesi' => 10]
        );

        $futureDate = now()->addDays(5)->format('Y-m-d');

        $response = $this->actingAs($user)->post('/reservasi', [
            'tanggal_reservasi' => $futureDate,
            'id_sesi' => $session->id,
            'nama_lengkap' => 'Nama Tamu Khusus',
            'email' => 'tamu@khusus.com',
            'no_telp' => '0899999999',
            'jumlah_tamu' => 2,
            'setuju_syarat' => '1',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('reservations', [
            'id_users' => $user->id,
            'id_sesi' => $session->id,
            'nama_pemesan' => 'Nama Tamu Khusus',
            'email_pemesan' => 'tamu@khusus.com',
            'no_telp_pemesan' => '0899999999',
            'jumlah_tamu' => 2,
            'status_konfirmasi' => 'belum',
        ]);
    }

    public function test_admin_can_access_user_management_routes(): void
    {
        $admin = User::create([
            'role' => 'admin',
            'username' => 'adminuser',
            'password' => bcrypt('password'),
            'email' => 'admin@test.com',
            'no_telp' => '0812345678',
            'nama_lengkap' => 'Admin Test',
        ]);

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
        $response->assertSee('adminuser');
    }

    public function test_admin_search_reservation_by_name_and_id(): void
    {
        $admin = User::create([
            'role' => 'admin',
            'username' => 'admin2',
            'password' => bcrypt('password'),
            'email' => 'admin2@test.com',
            'no_telp' => '0812345679',
            'nama_lengkap' => 'Admin Dua',
        ]);

        $user = User::create([
            'role' => 'user',
            'username' => 'budi123',
            'password' => bcrypt('password'),
            'email' => 'budi@test.com',
            'no_telp' => '0812000000',
            'nama_lengkap' => 'Budi Susanto 2',
        ]);

        $session = Session::firstOrCreate(
            ['jam_sesi' => '15:00 - 15:30'],
            ['token_sesi' => 10]
        );

        $res = Reservation::create([
            'id_users' => $user->id,
            'id_sesi' => $session->id,
            'nama_pemesan' => 'Budi Susanto 2',
            'email_pemesan' => 'budi@test.com',
            'no_telp_pemesan' => '0812000000',
            'jumlah_tamu' => 1,
            'total_harga' => 25000,
            'tanggal_reservasi' => now()->addDays(3)->format('Y-m-d'),
            'waktu_reservasi' => '15:00:00',
            'status_konfirmasi' => 'belum',
        ]);

        $response = $this->actingAs($admin)->get('/admin/reservations?search=Budi');
        $response->assertStatus(200);
        $response->assertSee('Budi Susanto 2');

        $response2 = $this->actingAs($admin)->get('/admin/reservations?search=' . $res->id);
        $response2->assertStatus(200);
        $response2->assertSee('Budi Susanto 2');
    }

    public function test_guest_can_submit_feedback_without_login(): void
    {
        $response = $this->get('/feedback');
        $response->assertStatus(200);
        $response->assertDontSee('Silahkan login terlebih dahulu');

        $postResponse = $this->post('/feedback', [
            'nama_lengkap' => 'Pengunjung Tamu',
            'bintang' => 5,
            'teks_saran' => 'Tempatnya sangat bersih dan kucingnya lucu!',
        ]);

        $postResponse->assertRedirect(route('home'));
        $this->assertDatabaseHas('feedbacks', [
            'nama_pengirim' => 'Pengunjung Tamu',
            'bintang' => 5,
            'id_user' => null,
        ]);
    }

    public function test_admin_can_search_sessions(): void
    {
        $admin = User::create([
            'role' => 'admin',
            'username' => 'admin_session_test',
            'password' => bcrypt('password'),
            'email' => 'admin_session@test.com',
            'no_telp' => '08123456789',
        ]);

        Session::firstOrCreate(['jam_sesi' => '08:00 - 08:30'], ['token_sesi' => 10]);
        Session::firstOrCreate(['jam_sesi' => '16:00 - 16:30'], ['token_sesi' => 10]);

        $response = $this->actingAs($admin)->get('/admin/sessions?search=16:00');
        $response->assertStatus(200);
        $sessions = $response->viewData('sessions');
        $this->assertTrue($sessions->contains('jam_sesi', '16:00 - 16:30'));
        $this->assertFalse($sessions->contains('jam_sesi', '08:00 - 08:30'));
    }

    public function test_admin_can_search_variants(): void
    {
        $admin = User::create([
            'role' => 'admin',
            'username' => 'admin_variant_test',
            'password' => bcrypt('password'),
            'email' => 'admin_variant@test.com',
            'no_telp' => '08123456789',
        ]);

        Variant::firstOrCreate(['jenis' => 'Maine Coon']);
        Variant::firstOrCreate(['jenis' => 'Munchkin']);

        $response = $this->actingAs($admin)->get('/admin/variants?search=Munchkin');
        $response->assertStatus(200);
        $response->assertSee('Munchkin');
        $response->assertDontSee('Maine Coon');
    }
}
