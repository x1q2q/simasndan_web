<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            santriSeeder::class,
            adminSeeder::class,
            guruSeeder::class,
            beritaSeeder::class,
            materiSeeder::class,
            mediaSeeder::class
        ]);

    }
}
