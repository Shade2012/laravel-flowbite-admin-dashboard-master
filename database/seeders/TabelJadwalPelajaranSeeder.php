<?php

namespace Database\Seeders;

use App\Models\JadwalPelajaran;
use Illuminate\Database\Seeder;

class TabelJadwalPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JadwalPelajaran::create([
            'kelas_id' => 1,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '09:30',
            'pelajaran_id' => 2,
            'guru_id' => 1,
            'ruang_id' => 1,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 2,
            'hari' => 'Selasa',
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:30',
            'pelajaran_id' => 3,
            'guru_id' => 2,
            'ruang_id' => 2,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 3,
            'hari' => 'Rabu',
            'jam_mulai' => '13:00',
            'jam_selesai' => '14:30',
            'pelajaran_id' => 1,
            'guru_id' => 3,
            'ruang_id' => 3,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 4,
            'hari' => 'Senin',
            'jam_mulai' => '09:40',
            'jam_selesai' => '11:00',
            'pelajaran_id' => 8,
            'guru_id' => 7,
            'ruang_id' => 2,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 4,
            'hari' => 'Selasa',
            'jam_mulai' => '07:00',
            'jam_selesai' => '09:00',
            'pelajaran_id' => 4,
            'guru_id' => 3,
            'ruang_id' => 5,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 4,
            'hari' => 'Rabu',
            'jam_mulai' => '12:00',
            'jam_selesai' => '14:00',
            'pelajaran_id' => 4,
            'guru_id' => 3,
            'ruang_id' => 5,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 4,
            'hari' => 'Kamis',
            'jam_mulai' => '09:40',
            'jam_selesai' => '11:00',
            'pelajaran_id' => 6,
            'guru_id' => 6,
            'ruang_id' => 6,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 4,
            'hari' => 'Kamis',
            'jam_mulai' => '08:00',
            'jam_selesai' => '09:30',
            'pelajaran_id' => 14,
            'guru_id' => 4,
            'ruang_id' => 4,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 4,
            'hari' => 'Jumat',
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:00',
            'pelajaran_id' => 8,
            'guru_id' => 4,
            'ruang_id' => 8,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 4,
            'hari' => 'Sabtu',
            'jam_mulai' => '11:30',
            'jam_selesai' => '13:00',
            'pelajaran_id' => 15,
            'guru_id' => 6,
            'ruang_id' => 7,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 4,
            'hari' => 'Jumat',
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:30',
            'pelajaran_id' => 15,
            'guru_id' => 4,
            'ruang_id' => 5,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 7,
            'hari' => 'Kamis',
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:30',
            'pelajaran_id' => 7,
            'guru_id' => 4,
            'ruang_id' => 7,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 8,
            'hari' => 'Kamis',
            'jam_mulai' => '13:00',
            'jam_selesai' => '14:30',
            'pelajaran_id' => 7,
            'guru_id' => 4,
            'ruang_id' => 8,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 8,
            'hari' => 'Kamis',
            'jam_mulai' => '08:00',
            'jam_selesai' => '09:30',
            'pelajaran_id' => 9,
            'guru_id' => 4,
            'ruang_id' => 9,
        ]);

        JadwalPelajaran::create([
            'kelas_id' => 10,
            'hari' => 'Kamis',
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:30',
            'pelajaran_id' => 10,
            'guru_id' => 10,
            'ruang_id' => 10,
        ]);
    }
}
