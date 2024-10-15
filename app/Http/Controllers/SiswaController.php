<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('user', 'kelas')->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $users = User::where('role', 'siswa')->get();
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('users', 'kelas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Siswa::create($request->all());

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $users = User::where('role', 'siswa')->get();
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'users', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diupdate.');
    }

    public function destroy($id)
    {
        Siswa::findOrFail($id)->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
