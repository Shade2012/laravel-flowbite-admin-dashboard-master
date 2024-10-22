<?php

namespace App\Exports;

use App\Models\JadwalPelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JadwalPelajaranExport implements FromCollection, WithHeadings
{
    /**
     * Retrieve the collection of data to be exported.
     */
    public function collection()
    {
        // Select only the columns you want to export
        return JadwalPelajaran::with(['kelas', 'pelajaran', 'guru', 'ruang'])
            ->get(['kelas_id', 'hari', 'jam_mulai', 'jam_selesai', 'pelajaran_id', 'guru_id', 'ruang_id']);
    }

    /**
     * Define the headings for the exported file.
     */
    public function headings(): array
    {
        return [
            'kelas_id',
            'hari',
            'jam_mulai',
            'jam_selesai',
            'pelajaran_id',
            'guru_id',
            'ruang_id',
        ];
    }
}
