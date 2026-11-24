<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Variant;
use App\Models\Session;
use App\Models\DataKucing;
use App\Models\Feedback;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'nama_lengkap' => 'Administrator Capyca',
                'email' => 'admin@cathouse.com',
                'alamat' => 'Jl. Boulevard Raya No. 1, Jakarta',
                'no_telp' => '081234567890',
            ]
        );

        $user = User::firstOrCreate(
            ['username' => 'user'],
            [
                'role' => 'user',
                'password' => Hash::make('user123'),
                'nama_lengkap' => 'Nabila Putri',
                'email' => 'nabila@gmail.com',
                'alamat' => 'Jl. Kambing Guling No. 10, Jakarta',
                'no_telp' => '089876543210',
            ]
        );

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
            $variantModels[$jenis] = Variant::firstOrCreate(['jenis' => $jenis]);
        }

        $sessionsData = [
            ['jam_sesi' => '08:00 - 08:30', 'token_sesi' => 10],
            ['jam_sesi' => '08:30 - 09:00', 'token_sesi' => 10],
            ['jam_sesi' => '09:00 - 09:30', 'token_sesi' => 10],
            ['jam_sesi' => '09:30 - 10:00', 'token_sesi' => 10],
            ['jam_sesi' => '10:00 - 10:30', 'token_sesi' => 10],
            ['jam_sesi' => '10:30 - 11:00', 'token_sesi' => 10],
            ['jam_sesi' => '11:00 - 11:30', 'token_sesi' => 10],
            ['jam_sesi' => '11:30 - 12:00', 'token_sesi' => 10],
            ['jam_sesi' => '12:00 - 12:30', 'token_sesi' => 10],
            ['jam_sesi' => '12:30 - 13:00', 'token_sesi' => 10],
            ['jam_sesi' => '13:00 - 13:30', 'token_sesi' => 10],
            ['jam_sesi' => '13:30 - 14:00', 'token_sesi' => 10],
            ['jam_sesi' => '14:00 - 14:30', 'token_sesi' => 10],
            ['jam_sesi' => '14:30 - 15:00', 'token_sesi' => 10],
            ['jam_sesi' => '15:00 - 15:30', 'token_sesi' => 10],
            ['jam_sesi' => '15:30 - 16:00', 'token_sesi' => 10],
            ['jam_sesi' => '16:00 - 16:30', 'token_sesi' => 10],
            ['jam_sesi' => '16:30 - 17:00', 'token_sesi' => 10],
        ];

        $sessionModels = [];
        foreach ($sessionsData as $s) {
            $sessionModels[] = Session::firstOrCreate(['jam_sesi' => $s['jam_sesi']], $s);
        }

        $this->call(ProfileCatsSeeder::class);

        Reservation::create([
            'id_users' => $user->id,
            'id_sesi' => $sessionModels[0]->id,
            'jumlah_tamu' => 2,
            'total_harga' => 70000.00,
            'tanggal_reservasi' => now()->addDays(2)->format('Y-m-d'),
            'waktu_reservasi' => '10:00:00',
        ]);

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
            'teks_saran' => 'Pelayanan ramah, kopi dan kuenya enak. Anak-anak sangat senang bermain dengan Luna dan Bentley!',
            'bintang' => 5,
            'status_tampil' => 'tampil',
        ]);
    }
}
