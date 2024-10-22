<?php

namespace App\Imports;

use App\Models\JadwalPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JadwalPelajaranImport implements ToModel, WithHeadingRow
{
    protected $duplicates = [];

    public function model(array $row)
    {
        // Check if the combination of guru_id, ruang_id, and kelas_id already exists
        $exists = JadwalPelajaran::where('guru_id', $row['guru_id'])
            ->where('ruang_id', $row['ruang_id'])
            ->where('kelas_id', $row['kelas_id'])
            ->exists();

        if ($exists) {
            // Store duplicates for later
            $this->duplicates[] = $row;
            return null; // Skip the import for this row
        }

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

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
