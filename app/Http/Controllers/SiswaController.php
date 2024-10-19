<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('name');

        if ($searchTerm) {
            $students = Siswa::with('user', 'kelas.waliKelas')
                ->whereHas('user', function ($query) use ($searchTerm) {
                    $query->where('role', 'siswa')
                        ->where('name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(10);
        } else {
            $students = Siswa::with('user', 'kelas.waliKelas')
                ->whereHas('user', function ($query) {
                    $query->where('role', 'siswa');
                })
                ->paginate(10);
        }

        $users = User::with('kelas.waliKelas', 'kelas.siswa', 'kelas.jadwalPelajaran', 'guru.user', 'guru.pelajaran', 'siswa.user', 'siswa.kelas')
            ->where('role', 'siswa')
            ->get();

        $class = Kelas::with('waliKelas.kelas', 'waliKelas.guru', 'waliKelas.siswa', 'siswa.user', 'siswa.kelas', 'jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.ruang')
            ->get();

        return view('admin.siswa.index', [
            'title' => 'All Siswa',
            'students' => $students,
            'users' => $users,
            'class'=> $class,
        ]);
    }

    public function show()
    {
        return view('admin.siswa.detail', [
            "title" => "Detail Siswa",
        ]);
    }

    public function create()
    {
        return view('admin.siswa.create', [
            "title" => "Create Siswa",
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'kelas_id' => 'required|integer|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {

            $user = Siswa::create([
                'user_id' => $request->user_id,
                'kelas_id' => $request->kelas_id,
            ]);

            if ($user) {
                return redirect()->route('admin.siswa.index')->with('Berhasil', 'Siswa berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('Gagal', 'Siswa gagal ditambahkan, silakan coba lagi.');
            }
        }
    }

    public function edit()
    {
        return view('admin.siswa.edit', [
            "title" => "Edit Siswa",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'nullable|integer|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {
            $student = Siswa::find($id);
            if ($student) {

                $student->fill($request->only([
                    'kelas_id',
                ]));

                $student->save();

                return redirect()->route('admin.siswa.index')->with('Berhasil', 'Siswa berhasil diperbarui.');
            } else {
                return redirect()->back()->with('Gagal', 'Siswa gagal diperbarui, silakan coba lagi.');
            }
        }
    }

    public function delete()
    {
        return view('admin.siswa.delete', [
            "title" => "Delete Siswa",
        ]);
    }

    public function destroy($id)
    {
        $student = Siswa::find($id)->delete();

        if ($student) {
            return redirect()->route('admin.siswa.index')->with('Berhasil', 'Siswa berhasil dihapus.');
        } else {
            return redirect()->back()->with('Gagal', 'Siswa gagal dihapus, silakan coba lagi.');
        }
    }
}
