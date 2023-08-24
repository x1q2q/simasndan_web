<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;
use Illuminate\Support\Facades\Hash;

class santriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Santri::create([
            'username'      => 'pengurus12345',
            'password'      => Hash::make('12345'),
            'nama_santri'   => 'Pengurus kedua',
            'email'         => '-',
            'nomor_hp'      => '0857121878490',
            'tingkatan'     => 'ulya',
            'tempat_lahir'  => 'Surakrata',
            'tgl_lahir'     => '2000-10-10',
            'alamat'        => 'Guci, Tegal',
            'foto'          => '-',
            'is_pengurus'   => 1,
            'jenis_kelamin' => 'laki-laki',
            'status_santri' => 'aktif',
            'universitas'   => 'Pend. TIK UNS',
            'created_at'    => now()
        ]);

        Santri::create([
            'username'      => 'pengurus67890',
            'password'      => Hash::make('67890'),
            'nama_santri'   => 'Pengurus ketiga',
            'email'         => '-',
            'nomor_hp'      => '0877121878490',
            'tingkatan'     => 'ulya',
            'tempat_lahir'  => 'Sukoharjo',
            'tgl_lahir'     => '2000-02-10',
            'alamat'        => 'Comal, Pekalongan',
            'foto'          => '-',
            'is_pengurus'   => 0,
            'jenis_kelamin' => 'perempuan',
            'status_santri' => 'aktif',
            'universitas'   => 'S1 PBI UIN Surakarta',
            'created_at'    => now()
        ]);

        Santri::create([
            'username'      => 'santri_barokah',
            'password'      => Hash::make('12345678'),
            'nama_santri'   => 'Salik Manahijas',
            'email'         => '-',
            'nomor_hp'      => '0877901878490',
            'tingkatan'     => 'wustho',
            'tempat_lahir'  => 'Jepara',
            'tgl_lahir'     => '2000-08-10',
            'alamat'        => 'Mlonggo, Jepara',
            'foto'          => '-',
            'is_pengurus'   => 0,
            'jenis_kelamin' => 'laki-laki',
            'status_santri' => 'aktif',
            'universitas'   => 'S1 Ilmu Hukum, UNS',
            'created_at'    => now()
        ]);
    }
}
