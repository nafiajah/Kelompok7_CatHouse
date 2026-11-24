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
                'name' => 'Bentley',
                'breed' => 'Maine Coon',
                'description' => 'Kucing Maine Coon jantan bertubuh gagah dengan bulu lebat, berkarakter tenang dan sangat ramah.',
                'photo' => 'bentley.jpg',
            ],
            [
                'name' => 'Camala',
                'breed' => 'Maine Coon',
                'description' => 'Kucing Maine Coon betina yang cantik, anggun, dan gemar bermain bersama pengunjung.',
                'photo' => 'camala.jpg',
            ],
            [
                'name' => 'Delon',
                'breed' => 'Scottish Fold',
                'description' => 'Kucing berwajah bulat menggemaskan dengan telinga terlipat yang sangat tenang dan penyayang.',
                'photo' => 'delon.png',
            ],
            [
                'name' => 'Ichigo',
                'breed' => 'British Shorthair',
                'description' => 'Kucing British Shorthair betina berpipi gembul yang manis dan sangat jinak.',
                'photo' => 'ichigo.jpeg',
            ],
            [
                'name' => 'Kunyit',
                'breed' => 'Bengal',
                'description' => 'Kucing lincah berwarna oranye keemasan eksotis yang sangat aktif dan senang berinteraksi.',
                'photo' => 'kunyit.png',
            ],
            [
                'name' => 'Luna',
                'breed' => 'Maine Coon',
                'description' => 'Kucing Maine Coon mix Persia betina dengan bulu sutra halus dan mata bulat indah.',
                'photo' => 'luna.png',
            ],
            [
                'name' => 'Mochi',
                'breed' => 'British Shorthair',
                'description' => 'Kucing berbulu abu-abu lebat yang sangat tenang dan gemar tidur siang di pangkuan pengunjung.',
                'photo' => 'mochi.jpeg',
            ],
            [
                'name' => 'Nara',
                'breed' => 'Maine Coon',
                'description' => 'Kucing Maine Coon betina dengan telinga berumbai khas dan sifat manja yang menyenangkan.',
                'photo' => 'nara.jpeg',
            ],
            [
                'name' => 'Pablo',
                'breed' => 'Ragdoll',
                'description' => 'Kucing berbulu halus dengan tatapan mata teduh yang selalu jinak dan senang digendong.',
                'photo' => 'pablo.png',
            ],
            [
                'name' => 'Pandan',
                'breed' => 'Munchkin',
                'description' => 'Kucing berkaki mungil yang gesit, selalu penasaran, dan sangat menggemaskan saat berlarian.',
                'photo' => 'pandan.png',
            ],
            [
                'name' => 'Sky',
                'breed' => 'Persia',
                'description' => 'Kucing Persia jantan berbulu lebat seperti awan yang ramah dan senang dielus.',
                'photo' => 'sky.png',
            ],
        ];

        foreach ($cats as $cat) {
            $variant = Variant::firstOrCreate(['jenis' => $cat['breed']]);

            DataKucing::updateOrCreate(
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
