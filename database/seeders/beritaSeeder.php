<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;

class beritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Berita::create([
            'judul_berita'     => 'Doa Sholat Dhuha',
            'kategori_berita'  => 'artikel',
            'isi_berita'       => 'Shalat Dhuha dikerjakan sampai gelincir matahari atau waktu Zuhur. Shalat Dhuha minimal dua rakaat dan maksimal delapan rakaat. Setelah itu, kita dianjurkan untuk membaca doa sebagai berikut sebagaimana ditemukan di kitab-kitab fiqih Mazhab Syafi’i yaitu I’anatut Thalibin, Tuhfatul Muhtaj, Hasyiyatul Jamal.',
            'penulis'          => 'pengurus',
            'created_at'       => now()
        ]);

        Berita::create([
            'judul_berita'     => 'Jadwal Piket Bersih Minggu pertama',
            'kategori_berita'  => 'jadwal',
            'isi_berita'       =>  '05.30 – 06.00, Kegiatan pagi (olahraga, piket kelas, piket asrama, dan lain-lain), Lingkungan Pesantren. 4. 06.00 – 07.15, Mandi, sarapan, persiapan masuk',
            'penulis'          => 'admin',
            'created_at'       => now()
        ]);

        Berita::create([
            'judul_berita'     => 'Pengumuman Pengajian Ahad Wage',
            'kategori_berita'  => 'pengumuman',
            'isi_berita'       => 'Berikut adalah surat edaran untu pengajian besar ahad wage rutinan hari minggu',
            'penulis'          => 'pengasuh',
            'created_at'       => now()
        ]);
    }
}
