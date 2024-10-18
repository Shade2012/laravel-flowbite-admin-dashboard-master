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
            $kelas = Kelas::with('waliKelas')
                ->where('nama_kelas', 'LIKE', '%' . $searchTerm . '%')
                ->paginate(10);
        } else {
            $kelas = Kelas::with('waliKelas')
                ->paginate(10);
        }

        $users = User::with('Kelas.waliKelas', 'guru.user', 'guru.pelajaran', 'siswa.user', 'siswa.kelas')->get();

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
            "title" => "Tambah Kelas Baru",
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas_id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', 'Gagal menambahkan kelas. Pastikan semua inputan dimasukan dengan benar.');
        } else {
            $kelas = Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'wali_kelas_id' => $request->wali_kelas_id
            ]);

            if ($kelas) {
                return redirect()->route('admin.kelas.index')->with('Berhasil', 'Kelas berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('Gagal', 'Gagal menambahkan kelas, silahkan coba lagi.');
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
        // Define validation rules for nama_kelas and wali_kelas_id
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255', // Example validation rule
            'wali_kelas_id' => 'required|integer', // Example validation rule
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the user by ID
        $kelas = Kelas::find($id);
        if ($kelas) {
            $kelas->nama_kelas = $request->nama_kelas;
            $kelas->wali_kelas_id = $request->wali_kelas_id;

            // Save the user
            $kelas->save();

            return redirect()->route('admin.kelas.index')->with('Berhasil', 'User berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('Gagal', 'User update gagal, silahkan coba lagi.');
        }
    }



    public function delete()
    {
        return view('admin.kelas.delete', [
            "title" => "Tambah Kelas Baru",
        ]);
    }

    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
