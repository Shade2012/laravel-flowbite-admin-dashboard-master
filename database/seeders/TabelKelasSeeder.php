<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class TabelKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::create([
            'nama_kelas' => '10 DKV 1',
            'wali_kelas_id' => 1,
        ]);

        Kelas::create([
            'nama_kelas' => '10 DKV 2',
            'wali_kelas_id' => 2,
        ]);

        Kelas::create([
            'nama_kelas' => '10 Animasi 1',
            'wali_kelas_id' => 3,
        ]);

        Kelas::create([
            'nama_kelas' => '10 Animasi 2',
            'wali_kelas_id' => 4,
        ]);

        Kelas::create([
            'nama_kelas' => '10 PPLG 1',
            'wali_kelas_id' => 5,
        ]);

        Kelas::create([
            'nama_kelas' => '10 PPLG 2',
            'wali_kelas_id' => 6,
        ]);

        Kelas::create([
            'nama_kelas' => '11 DKV 1',
            'wali_kelas_id' => 7,
        ]);

        Kelas::create([
            'nama_kelas' => '11 DKV 2',
            'wali_kelas_id' => 8,
        ]);

        Kelas::create([
            'nama_kelas' => '11 Animasi 1',
            'wali_kelas_id' => 9,
        ]);

        Kelas::create([
            'nama_kelas' => '11 Animasi 2',
            'wali_kelas_id' => 10,
        ]);

        Kelas::create([
            'nama_kelas' => '11 PPLG 1',
            'wali_kelas_id' => 1,
        ]);

        Kelas::create([
            'nama_kelas' => '11 PPLG 2',
            'wali_kelas_id' => 2,
        ]);

        Kelas::create([
            'nama_kelas' => '12 DKV 1',
            'wali_kelas_id' => 3,
        ]);

        Kelas::create([
            'nama_kelas' => '12 DKV 2',
            'wali_kelas_id' => 4,
        ]);

        Kelas::create([
            'nama_kelas' => '12 Animasi 1',
            'wali_kelas_id' => 5,
        ]);

        Kelas::create([
            'nama_kelas' => '12 Animasi 2',
            'wali_kelas_id' => 6,
        ]);

        Kelas::create([
            'nama_kelas' => '12 PPLG 1',
            'wali_kelas_id' => 7,
        ]);

        Kelas::create([
            'nama_kelas' => '12 PPLG 2',
            'wali_kelas_id' => 8,
        ]);
    }
}
