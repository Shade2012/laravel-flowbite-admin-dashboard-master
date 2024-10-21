<?php

namespace App\Exports;

use App\Models\JadwalPelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;

class JadwalPelajaranExport implements FromCollection
{
    public function collection()
    {
        return JadwalPelajaran::with('kelas', 'pelajaran', 'guru.user', 'ruang')->get();
    }
}
