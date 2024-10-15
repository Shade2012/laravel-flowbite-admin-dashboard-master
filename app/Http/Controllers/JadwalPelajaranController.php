<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use Illuminate\Support\Facades\Validator;

class JadwalPelajaranController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'pelajaran_id' => 'required|exists:pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'ruang_id' => 'required|exists:ruang,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bentrok = JadwalPelajaran::where('hari', $request->hari)
            ->where('jam_mulai', '<=', $request->jam_selesai)
            ->where('jam_selesai', '>=', $request->jam_mulai)
            ->where(function ($query) use ($request) {
                $query->where('guru_id', $request->guru_id)
                      ->orWhere('ruang_id', $request->ruang_id)
                      ->orWhere('kelas_id', $request->kelas_id);
            })
            ->exists();

        if ($bentrok) {
            return redirect()->back()->withErrors('Jadwal bentrok!')->withInput();
        }

        JadwalPelajaran::create($request->all());

        return redirect()->route('admin.jadwal-pelajaran.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }
}
