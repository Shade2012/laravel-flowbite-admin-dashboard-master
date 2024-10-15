<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TabelUserSeeder::class);
        $this->call(TabelKelasSeeder::class);
        $this->call(TabelPelajaranSeeder::class);
        $this->call(TabelRuangSeeder::class);
        $this->call(TabelGuruSeeder::class);
        $this->call(TabelSiswaSeeder::class);
        $this->call(TabelJadwalPelajaranSeeder::class);
    }
}
