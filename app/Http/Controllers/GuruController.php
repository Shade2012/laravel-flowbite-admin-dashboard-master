<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with('user', 'pelajaran')->get();
        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        $users = User::where('role', 'guru')->get();
        $pelajaran = Pelajaran::all();
        return view('admin.guru.create', compact('users', 'pelajaran'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'pelajaran_id' => 'required|exists:pelajaran,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Guru::create($request->all());

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        $users = User::where('role', 'guru')->get();
        $pelajaran = Pelajaran::all();
        return view('admin.guru.edit', compact('guru', 'users', 'pelajaran'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'pelajaran_id' => 'required|exists:pelajaran,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $guru = Guru::findOrFail($id);
        $guru->update($request->all());

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diupdate.');
    }

    public function destroy($id)
    {
        Guru::findOrFail($id)->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
