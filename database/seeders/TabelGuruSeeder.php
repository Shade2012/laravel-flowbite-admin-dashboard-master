<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class TabelGuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guru::create([
            'user_id' => 11,
            'pelajaran_id' => 11,
        ]);

        Guru::create([
            'user_id' => 12,
            'pelajaran_id' => 12,
        ]);

        Guru::create([
            'user_id' => 13,
            'pelajaran_id' => 13,
        ]);

        Guru::create([
            'user_id' => 14,
            'pelajaran_id' => 14,
        ]);

        Guru::create([
            'user_id' => 14,
            'pelajaran_id' => 15,
        ]);

        Guru::create([
            'user_id' => 15,
            'pelajaran_id' => 16,
        ]);

        Guru::create([
            'user_id' => 16,
            'pelajaran_id' => 1,
        ]);

        Guru::create([
            'user_id' => 17,
            'pelajaran_id' => 7,
        ]);

        Guru::create([
            'user_id' => 18,
            'pelajaran_id' => 2,
        ]);

        Guru::create([
            'user_id' => 19,
            'pelajaran_id' => 3,
        ]);

        Guru::create([
            'user_id' => 20,
            'pelajaran_id' => 4,
        ]);
    }
}
