<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('Kelas.waliKelas', 'guru.user', 'guru.pelajaran', 'siswa.user', 'siswa.kelas')->get();
        return view('admin.user.index', [
            "title" => "All Users",
        ], compact('user'));
    }

    public function create()
    {
        $wali_kelas = User::where('role', 'guru')->get();
        return view('admin.kelas.create', compact('wali_kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
            'wali_kelas_id' => 'required|exists:users,id'
        ]);

        Kelas::create($request->all());
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $wali_kelas = User::where('role', 'guru')->get();
        return view('admin.kelas.edit', compact('kelas', 'wali_kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
            'wali_kelas_id' => 'required|exists:users,id'
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
