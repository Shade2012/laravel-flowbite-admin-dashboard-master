<?php

namespace App\Imports;

use App\Models\JadwalPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JadwalPelajaranImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new JadwalPelajaran([
            'kelas_id'      => $row['kelas_id'],
            'hari'          => $row['hari'],
            'jam_mulai'     => $row['jam_mulai'],
            'jam_selesai'   => $row['jam_selesai'],
            'pelajaran_id'  => $row['pelajaran_id'],
            'guru_id'       => $row['guru_id'],
            'ruang_id'      => $row['ruang_id'],
        ]);
    }

}
