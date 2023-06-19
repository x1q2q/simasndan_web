<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class guruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guru::create([
            'username'      => 'guru_baik',
            'password'      => Hash::make('12345'),
            'nama_guru'     => 'Ki Hajar Dewantara',
            'email'         => 'kihajar@gmail.com',
            'nomor_hp'      => '0899901878490',
            'tempat_lahir'  => 'Kudus',
            'alamat'        => 'Pabelan, Sukoarjo',
            'foto'          => '-',
            'created_at'    => now()
        ]);
    }
}
