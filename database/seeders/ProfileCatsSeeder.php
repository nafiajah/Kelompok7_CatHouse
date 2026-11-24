<?php

namespace Database\Seeders;

use App\Models\DataKucing;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class ProfileCatsSeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            [
                'name' => 'Sky',
                'breed' => 'Persia',
                'description' => 'Kucing Persia jantan.',
                'photo' => 'sky.png',
            ],
            [
                'name' => 'Nara',
                'breed' => 'Maine Coon',
                'description' => 'Kucing Maine Coon betina.',
                'photo' => 'nara.jpeg',
            ],
            [
                'name' => 'Ichigo',
                'breed' => 'British Shorthair',
                'description' => 'Kucing British Shorthair betina.',
                'photo' => 'ichigo.jpeg',
            ],
            [
                'name' => 'Mochi',
                'breed' => 'British Shorthair',
                'description' => 'Kucing British Shorthair betina.',
                'photo' => 'mochi.jpeg',
            ],
        ];

        foreach ($cats as $cat) {
            $variant = Variant::where('jenis', $cat['breed'])->firstOrFail();

            DataKucing::firstOrCreate(
                ['nama_kucing' => $cat['name']],
                [
                    'id_variant' => $variant->id,
                    'deskripsi' => $cat['description'],
                    'foto' => $cat['photo'],
                ]
            );
        }
    }
}
