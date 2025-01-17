<?php

namespace App\Http\Controllers;

use App\Exports\JadwalPelajaranExport;
use App\Imports\JadwalPelajaranImport;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Ruang;
use App\Models\Pelajaran;
use App\Services\Pdf\PdfServiceImplement;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('name');

        if ($searchTerm) {
            $jadwal_pelajaran = JadwalPelajaran::with('kelas.waliKelas', 'kelas.siswa', 'kelas.jadwalPelajaran', 'pelajaran.guru', 'pelajaran.jadwalPelajaran', 'guru.user', 'guru.pelajaran', 'ruang.jadwalPelajaran')
                ->where('hari', 'LIKE', '%' . $searchTerm . '%')
                ->paginate(10);
        } else {
            $jadwal_pelajaran = JadwalPelajaran::with('kelas.waliKelas', 'kelas.siswa', 'kelas.jadwalPelajaran', 'pelajaran.guru', 'pelajaran.jadwalPelajaran', 'guru.user', 'guru.pelajaran', 'ruang.jadwalPelajaran')
                ->paginate(10);
        }

        $class = Kelas::with('waliKelas.kelas', 'waliKelas.guru', 'waliKelas.siswa', 'siswa.user', 'siswa.kelas', 'jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.ruang')
            ->get();

        $lesson = Pelajaran::with('guru.user', 'guru.pelajaran', 'jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.ruang')
            ->get();

        $teacher = Guru::with('user.kelas', 'user.guru', 'user.siswa', 'pelajaran.guru', 'pelajaran.jadwalPelajaran')
            ->get();

        $room = Ruang::with('jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.ruang')
            ->get();

        return view('admin.jadwal_pelajaran.index', [
            'title' => 'All Jadwal Pelajaran',
            'jadwal_pelajaran' => $jadwal_pelajaran,
            'class' => $class,
            'lesson' => $lesson,
            'teacher' => $teacher,
            'room' => $room,
        ]);
    }

    public function show()
    {
        return view('admin.jadwal_pelajaran.detail', [
            "title" => "Detail Jadwal Pelajaran",
        ]);
    }

    public function create()
    {
        return view('admin.jadwal_pelajaran.create', [
            "title" => "Create Jadwal Pelajaran",
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|integer|exists:kelas,id',
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'pelajaran_id' => 'required|integer|exists:pelajarans,id',
            'guru_id' => 'required|integer|exists:gurus,id',
            'ruang_id' => 'required|integer|exists:ruangs,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {

            $bentrokGuru = JadwalPelajaran::where('guru_id', $request->guru_id)
                ->where('hari', $request->hari)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })->exists();

            if ($bentrokGuru) {
                return redirect()->back()->with('Gagal', 'Jadwal Guru bentrok dengan jadwal lain.');
            }

            $bentrokRuang = JadwalPelajaran::where('ruang_id', $request->ruang_id)
                ->where('hari', $request->hari)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })->exists();

            if ($bentrokRuang) {
                return redirect()->back()->with('Gagal', 'Ruang sudah digunakan pada waktu tersebut.');
            }

            $bentrokKelas = JadwalPelajaran::where('kelas_id', $request->kelas_id)
                ->where('hari', $request->hari)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })->exists();

            if ($bentrokKelas) {
                return redirect()->back()->with('Gagal', 'Kelas sudah memiliki pelajaran pada waktu tersebut.');
            }

            $jadwal_pelajaran = JadwalPelajaran::create([
                'kelas_id' => $request->kelas_id,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'pelajaran_id' => $request->pelajaran_id,
                'guru_id' => $request->guru_id,
                'ruang_id' => $request->ruang_id,
            ]);

            if ($jadwal_pelajaran) {
                return redirect()->route('admin.jadwal_pelajaran.index')->with('Berhasil', 'Jadwal Pelajaran berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('Gagal', 'Jadwal Pelajaran gagal ditambahkan, silakan coba lagi.');
            }
        }
    }

    public function edit()
    {
        return view('admin.jadwal_pelajaran.edit', [
            "title" => "Edit Jadwal Pelajaran",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|integer|exists:kelas,id',
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'pelajaran_id' => 'required|integer|exists:pelajarans,id',
            'guru_id' => 'required|integer|exists:gurus,id',
            'ruang_id' => 'required|integer|exists:ruangs,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {
            $jadwal_pelajaran = JadwalPelajaran::find($id);
            if ($jadwal_pelajaran) {

                $jadwal_pelajaran->fill($request->only([
                    'kelas_id',
                    'hari',
                    'jam_mulai',
                    'jam_selesai',
                    'pelajaran_id',
                    'guru_id',
                    'ruang_id',
                ]));

                $jadwal_pelajaran->save();

                return redirect()->route('admin.jadwal_pelajaran.index')->with('Berhasil', 'Jadwal Pelajaran berhasil diperbarui.');
            } else {
                return redirect()->back()->with('Gagal', 'Jadwal Pelajaran gagal diperbarui, silakan coba lagi.');
            }
        }
    }

    public function delete()
    {
        return view('admin.jadwal_pelajaran.delete', [
            "title" => "Delete Jadwal Pelajaran",
        ]);
    }

    public function destroy($id)
    {
        $jadwal_pelajaran = JadwalPelajaran::find($id)->delete();

        if ($jadwal_pelajaran) {
            return redirect()->route('admin.jadwal_pelajaran.index')->with('Berhasil', 'Jadwal Pelajaran berhasil dihapus.');
        } else {
            return redirect()->back()->with('Gagal', 'Jadwal Pelajaran gagal dihapus, silakan coba lagi.');
        }
    }
    public function export($type)
    {
        if ($type === 'excel') {
            return Excel::download(new JadwalPelajaranExport, 'jadwal_pelajaran.xlsx');
        }

        if ($type === 'pdf') {
            $pdfService = new PdfServiceImplement;
            return $pdfService->generatePDF();
        }

        return redirect()->back()->with('error', 'Invalid export type');
    }

    public function import(Request $request)
    {
        // Reset session for any previous imports
        session()->forget('Gagal');

        // Import data
        $import = new JadwalPelajaranImport();
        Excel::import($import, $request->file('file'));

        // Check for duplicates
        $duplicates = $import->getDuplicates();
        if (!empty($duplicates)) {
            return redirect()->route('admin.jadwal_pelajaran.index')
                ->with('Gagal', 'Gagal mengimpor data, data tidak boleh sama.');
        }

        return redirect()->route('admin.jadwal_pelajaran.index')
            ->with('Berhasil', 'Data berhasil diimpor.');
    }

    public function destroyAll()
    {
        // Menghapus seluruh data di tabel JadwalPelajaran
        JadwalPelajaran::truncate();

        return redirect()->route('admin.jadwal_pelajaran.index')->with('Berhasil', 'Seluruh Jadwal Pelajaran berhasil dihapus.');
    }

}
