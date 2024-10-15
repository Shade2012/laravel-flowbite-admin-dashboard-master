<?php

namespace Database\Seeders;

use App\Models\Ruang;
use Illuminate\Database\Seeder;

class TabelRuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ruang::create([
            'nama_ruang' => 'Kelas',
        ]);

        Ruang::create([
            'nama_ruang' => 'Lab PPLG',
        ]);

        Ruang::create([
            'nama_ruang' => 'Lab Mario',
        ]);

        Ruang::create([
            'nama_ruang' => 'Lab DKV',
        ]);

        Ruang::create([
            'nama_ruang' => 'Lab Animasi',
        ]);

        Ruang::create([
            'nama_ruang' => 'Tribun',
        ]);

        Ruang::create([
            'nama_ruang' => 'Perpustakaan',
        ]);

        Ruang::create([
            'nama_ruang' => 'Ruang Karpet',
        ]);

        Ruang::create([
            'nama_ruang' => 'Aula',
        ]);

        Ruang::create([
            'nama_ruang' => 'Lapangan',
        ]);
    }
}
