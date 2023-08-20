<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Media;

class mediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Media::create([
            'type_media'    => 'gambar',
            'nama'          => 'news_window.jpg',
            'berita_id'     => 1,
        ]);

        Media::create([
            'type_media'    => 'gambar',
            'nama'          => 'news_earth.jpg',
            'berita_id'     => 2,
        ]);

        Media::create([
            'type_media'    => 'gambar',
            'nama'          => 'news_duck.jpg',
            'berita_id'     => 3,
        ]);
    }
}
