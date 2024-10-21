<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('name');

        if ($searchTerm) {
            $kelas = Kelas::with('waliKelas.kelas', 'waliKelas.guru', 'waliKelas.siswa', 'siswa.user', 'siswa.kelas', 'jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.ruang')
                ->where('nama_kelas', 'LIKE', '%' . $searchTerm . '%')
                ->paginate(10);
        } else {
            $kelas = Kelas::with('waliKelas.kelas', 'waliKelas.guru', 'waliKelas.siswa', 'siswa.user', 'siswa.kelas', 'jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.ruang')
                ->paginate(10);
        }

        $users = User::with('kelas.waliKelas', 'kelas.siswa', 'kelas.jadwalPelajaran', 'guru.user', 'guru.pelajaran', 'siswa.user', 'siswa.kelas')
            ->where('role', 'guru')
            ->get();

        return view('admin.kelas.index', [
            'title' => 'All Kelas',
            'kelas' => $kelas,
            'users' => $users,
        ]);
    }

    public function show()
    {
        return view('admin.kelas.detail', [
            "title" => "Detail Kelas",
        ]);
    }

    public function create()
    {
        return view('admin.kelas.create', [
            "title" => "Create Kelas",
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas_id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {

            $kelas = Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'wali_kelas_id' => $request->wali_kelas_id,
            ]);

            if ($kelas) {
                return redirect()->route('admin.kelas.index')->with('Berhasil', 'Kelas berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('Gagal', 'Kelas gagal ditambahkan, silakan coba lagi.');
            }
        }
    }

    public function edit()
    {
        return view('admin.kelas.edit', [
            "title" => "Edit Kelas",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'nullable|string|max:255',
            'wali_kelas_id' => 'nullable|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {
            $kelas = Kelas::find($id);
            if ($kelas) {

                $kelas->fill($request->only([
                    'nama_kelas',
                    'wali_kelas_id',
                ]));

                $kelas->save();

                return redirect()->route('admin.kelas.index')->with('Berhasil', 'Kelas berhasil diperbarui.');
            } else {
                return redirect()->back()->with('Gagal', 'Kelas gagal diperbarui, silakan coba lagi.');
            }
        }
    }

    public function delete()
    {
        return view('admin.kelas.delete', [
            "title" => "Delete Kelas",
        ]);
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id)->delete();

        if ($kelas) {
            return redirect()->route('admin.kelas.index')->with('Berhasil', 'Kelas berhasil dihapus.');
        } else {
            return redirect()->back()->with('Gagal', 'Kelas gagal dihapus, silakan coba lagi.');
        }
    }
}
