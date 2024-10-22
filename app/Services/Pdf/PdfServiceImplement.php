<?php

namespace App\Services\Pdf;

use App\Models\JadwalPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use LaravelEasyRepository\Service;
use App\Repositories\Pdf\PdfRepository;

class PdfServiceImplement extends Service implements PdfService{

    public function generatePDF()
    {
        $jadwal_pelajaran = JadwalPelajaran::with('kelas', 'pelajaran', 'guru.user', 'ruang')->get();

        $pdf = PDF::loadView('admin.jadwal_pelajaran.pdf', compact('jadwal_pelajaran'));

        return $pdf->download('jadwal_pelajaran.pdf');
    }
}
