<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('name');

        if ($searchTerm) {
            $teacher = Guru::with('user.kelas', 'user.guru', 'user.siswa', 'pelajaran.guru', 'pelajaran.jadwalPelajaran')
                ->whereHas('user', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(10);
        } else {
            $teacher = Guru::with('user.kelas', 'user.guru', 'user.siswa', 'pelajaran.guru', 'pelajaran.jadwalPelajaran')
                ->paginate(10);
        }

        $users = User::with('kelas.waliKelas', 'kelas.siswa', 'kelas.jadwalPelajaran', 'guru.user', 'guru.pelajaran', 'siswa.user', 'siswa.kelas')
            ->where('role', 'guru')
            ->get();

        $lesson = Pelajaran::with('guru.user', 'guru.pelajaran', 'jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.ruang')
            ->get();

        return view('admin.guru.index', [
            'title' => 'All Guru',
            'teacher' => $teacher,
            'users' => $users,
            'lesson' => $lesson,
        ]);
    }

    public function show()
    {
        return view('admin.guru.detail', [
            "title" => "Detail Guru",
        ]);
    }

    public function create()
    {
        return view('admin.guru.create', [
            "title" => "Create Guru",
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'pelajaran_id' => 'required|integer|exists:pelajarans,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {

            $teacher = Guru::create([
                'user_id' => $request->user_id,
                'pelajaran_id' => $request->pelajaran_id,
            ]);

            if ($teacher) {
                return redirect()->route('admin.guru.index')->with('Berhasil', 'Guru berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('Gagal', 'Guru gagal ditambahkan, silakan coba lagi.');
            }
        }
    }

    public function edit()
    {
        return view('admin.guru.edit', [
            "title" => "Edit Guru",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pelajaran_id' => 'required|integer|exists:pelajarans,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {
            $teacher = Guru::find($id);
            if ($teacher) {

                $teacher->fill($request->only([
                    'pelajaran_id',
                ]));

                $teacher->save();

                return redirect()->route('admin.guru.index')->with('Berhasil', 'Guru berhasil diperbarui.');
            } else {
                return redirect()->back()->with('Gagal', 'Guru gagal diperbarui, silakan coba lagi.');
            }
        }
    }

    public function delete()
    {
        return view('admin.guru.delete', [
            "title" => "Delete Guru",
        ]);
    }

    public function destroy($id)
    {
        $teacher = Guru::find($id)->delete();

        if ($teacher) {
            return redirect()->route('admin.guru.index')->with('Berhasil', 'Guru berhasil dihapus.');
        } else {
            return redirect()->back()->with('Gagal', 'Guru gagal dihapus, silakan coba lagi.');
        }
    }
}
