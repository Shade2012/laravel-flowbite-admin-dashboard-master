<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class TabelSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::create([
            'user_id' => 2,
            'kelas_id' => 4,
        ]);

        Siswa::create([
            'user_id' => 3,
            'kelas_id' => 4,
        ]);

        Siswa::create([
            'user_id' => 4,
            'kelas_id' => 6,
        ]);

        Siswa::create([
            'user_id' => 5,
            'kelas_id' => 8,
        ]);

        Siswa::create([
            'user_id' => 6,
            'kelas_id' => 10,
        ]);

        Siswa::create([
            'user_id' => 7,
            'kelas_id' => 15,
        ]);

        Siswa::create([
            'user_id' => 8,
            'kelas_id' => 18,
        ]);

        Siswa::create([
            'user_id' => 9,
            'kelas_id' => 17,
        ]);

        Siswa::create([
            'user_id' => 10,
            'kelas_id' => 18,
        ]);
    }
}
