<?php

namespace Database\Seeders;

use App\Models\Pelajaran;
use Illuminate\Database\Seeder;

class TabelPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelajaran::create([
            'nama_pelajaran' => 'Bahasa Indonesia',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Bahasa Inggris',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Bahasa Jawa',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Bahasa Jepang',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Sejarah',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'PKN',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Matematika',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Agama',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'IPA',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'IPS',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Mobile Programming',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Web Programming',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Game Programming',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'IOT',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'Desktop Programming',
        ]);

        Pelajaran::create([
            'nama_pelajaran' => 'PKK',
        ]);
    }
}
