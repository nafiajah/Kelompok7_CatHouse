<?php

namespace Tests\Unit;

use App\Models\DataKucing;
use Tests\TestCase;

class DataKucingTest extends TestCase
{
    public function test_it_uses_the_matching_cat_photo_if_the_uploaded_photo_is_missing(): void
    {
        $cat = new DataKucing(['nama_kucing' => 'Sky', 'foto' => 'sky.png']);

        $this->assertStringEndsWith('/images/cats/sky.png', $cat->foto_url);
    }

    public function test_it_supports_jpeg_cat_photos(): void
    {
        $cat = new DataKucing(['nama_kucing' => 'Ichigo', 'foto' => 'ichigo.jpeg']);

        $this->assertStringEndsWith('/images/cats/ichigo.jpeg', $cat->foto_url);
    }

    public function test_it_uses_the_default_photo_if_no_photo_file_exists(): void
    {
        $cat = new DataKucing(['foto' => 'missing-cat-photo.png']);

        $this->assertStringEndsWith('/images/cat-photo.png', $cat->foto_url);
    }
}
