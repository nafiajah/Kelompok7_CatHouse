<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Variant;
use App\Models\Session;
use App\Models\DataKucing;
use App\Models\Feedback;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'role' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama_pelanggan' => 'Administrator Capyca',
            'email' => 'admin@cathouse.com',
            'no_telp' => '081234567890',
        ]);

        $user = User::create([
            'role' => 'user',
            'username' => 'user',
            'password' => Hash::make('user123'),
            'nama_pelanggan' => 'Nabila Putri',
            'email' => 'nabila@gmail.com',
            'no_telp' => '089876543210',
        ]);

        // 2. Seed Variants
        $variants = [
            'Persia',
            'British Shorthair',
            'Scottish Fold',
            'Ragdoll',
            'Maine Coon',
            'Bengal',
            'Munchkin',
        ];

        $variantModels = [];
        foreach ($variants as $jenis) {
            $variantModels[$jenis] = Variant::create(['jenis' => $jenis]);
        }

        // 3. Seed Sessions
        $sessionsData = [
            ['jam_sesi' => '10:00 - 11:30', 'token_sesi' => 15],
            ['jam_sesi' => '12:00 - 13:30', 'token_sesi' => 15],
            ['jam_sesi' => '14:00 - 15:30', 'token_sesi' => 15],
            ['jam_sesi' => '16:00 - 17:30', 'token_sesi' => 15],
            ['jam_sesi' => '18:00 - 19:30', 'token_sesi' => 15],
        ];

        $sessionModels = [];
        foreach ($sessionsData as $s) {
            $sessionModels[] = Session::create($s);
        }

        // 4. Seed Cats (Data Kucing)
        $cats = [
            [
                'id_variant' => $variantModels['British Shorthair']->id,
                'nama_kucing' => 'Mochi',
                'deskripsi' => 'Kucing berbulu abu-abu lebat yang sangat tenang dan gemar tidur siang di pangkuan pengunjung.',
                'foto' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'id_variant' => $variantModels['Persia']->id,
                'nama_kucing' => 'Milo',
                'deskripsi' => 'Memiliki bulu putih halus seperti kapas, sangat manja dan suka diajak bermain bulu ayam.',
                'foto' => 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'id_variant' => $variantModels['Scottish Fold']->id,
                'nama_kucing' => 'Luna',
                'deskripsi' => 'Kucing dengan telinga terlipat yang imut dan mata bulat besar. Suka duduk santai mengamati sekitar.',
                'foto' => 'https://images.unsplash.com/photo-1543852786-1cf6624b9987?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'id_variant' => $variantModels['Ragdoll']->id,
                'nama_kucing' => 'Bella',
                'deskripsi' => 'Berbulu halus dengan mata biru mempesona. Sangat ramah, jinak, dan suka digendong.',
                'foto' => 'https://images.unsplash.com/photo-1513360309081-38f076278f1d?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'id_variant' => $variantModels['Maine Coon']->id,
                'nama_kucing' => 'Simba',
                'deskripsi' => 'Kucing bertubuh gagah seperti singa mini namun berhati lembut. Sangat aktif dan senang dielus.',
                'foto' => 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'id_variant' => $variantModels['Bengal']->id,
                'nama_kucing' => 'Leo',
                'deskripsi' => 'Corak tutul eksotis seperti macan tutul, sangat lincah dan gemar memanjat cat condo.',
                'foto' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'id_variant' => $variantModels['Munchkin']->id,
                'nama_kucing' => 'Choco',
                'deskripsi' => 'Kucing berkaki pendek yang lincah dan sangat menggemaskan saat berlarian menyapa pengunjung.',
                'foto' => 'https://images.unsplash.com/photo-1561948955-570b270e7c36?w=600&auto=format&fit=crop&q=80',
            ],
        ];

        foreach ($cats as $cat) {
            DataKucing::create($cat);
        }

        // 5. Seed Payments & Reservations
        $payment = Payment::create([
            'id_user' => $user->id,
            'jumlah_tamu' => 2,
            'total_harga' => 70000.00,
            'metode_pembayaran' => 'qris',
            'tanggal_pembayaran' => now(),
        ]);

        Reservation::create([
            'id_payments' => $payment->id,
            'id_users' => $user->id,
            'id_sesi' => $sessionModels[0]->id,
            'tanggal_reservasi' => now()->addDays(2)->format('Y-m-d'),
            'waktu_reservasi' => '10:00:00',
        ]);

        // 6. Seed Feedbacks
        Feedback::create([
            'id_user' => $user->id,
            'tanggal_saran' => now()->subDay(),
            'teks_saran' => 'Tempatnya bersih banget, wangi, dan kucing-kucingnya terawat serta gemuk-gemuk! Mochi manja banget diajak selfie. Pasti bakal balik lagi.',
            'bintang' => 5,
            'status_tampil' => 'tampil',
        ]);

        Feedback::create([
            'id_user' => $user->id,
            'tanggal_saran' => now()->subHours(5),
            'teks_saran' => 'Pelayanan ramah, kopi dan kuenya enak. Anak-anak sangat senang bermain dengan Bella dan Simba!',
            'bintang' => 5,
            'status_tampil' => 'tampil',
        ]);
    }
}
