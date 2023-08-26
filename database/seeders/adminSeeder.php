<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'username'      => 'pengasuh123',
            'password'      => Hash::make('12345'),
            'nama_admin'    => 'Gus Baha',
            'is_pengasuh'   => 1,
            'foto'          => '-',
            'created_at'    => now()
        ]);

        Admin::create([
            'username'      => 'bojes123',
            'password'      => Hash::make('12345'),
            'nama_admin'    => 'Admin Ganteng',
            'is_pengasuh'   => 0,
            'foto'          => '-',
            'created_at'    => now()
        ]);
    }
}
