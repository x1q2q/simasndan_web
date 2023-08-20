<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;

class materiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Materi::create([
            'kode_materi'   => 'SFNHNJH',
            'nama_materi'   => 'Kitab Safinatun Najah',
            'foto'          => 'mtr_safinatun_najah.jpg',
            'link_materi'   => 'https://www.gramedia.com/literasi/kitab-safinatun-najah/',
            'deskripsi'     => 'Safinatun Najah adalah sebuah kitab ringkas mengenai dasar-dasar ilmu fikih menurut mazhab Syafii. Kitab ini ditujukan bagi pelajar dan pemula sehingga hanya berisi kesimpulan hukum fikih saja tanpa menyertakan dalil dan dasar pengambilan dalil dalam penetapan hukum.'
        ]);

        Materi::create([
            'kode_materi'   => 'HDTSARBAIN',
            'nama_materi'   => 'Hadits Arbain Nawawi',
            'foto'          => 'mtr_hadits_arbain.jpg',
            'link_materi'   => 'https://www.nu.or.id/pustaka/mengenal-arbain-nawawiyah-kitab-40-hadits-pilihan-yang-masyhur-KKtxq',
            'deskripsi'     => 'Kitab ini dimulai dengan mukadimah (pengantar) dari Imam an-Nawawi, selanjutnya adalah hadits-hadits dari awal hingga akhir. Beliau tidak menyebut judul khusus pada hadits-hadits dalam kitab ini, hanya saja disebut hadits pertama, hadits kedua hingga seterusnya. Bagi para pembaca yang langsung merujuk ke kitab aslinya maka akan mendapati demikian, sehingga untuk mengetahui isi pembahasan suatu hadits ia harus membacanya terlebih dahulu. Beda halnya jika membaca kitab yang sudah ditahqiq atau syarah kitab ini yang tiap haditsnya sudah diberi tema oleh penerbit'
        ]);
    }
}
