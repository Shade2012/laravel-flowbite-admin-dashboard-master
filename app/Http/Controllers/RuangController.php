<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuangController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('name');

        if ($searchTerm) {
            $ruang = Ruang::with('jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru.user', 'jadwalPelajaran.guru.pelajaran', 'jadwalPelajaran.ruang')
                ->where('nama_ruang', 'LIKE', '%' . $searchTerm . '%')
                ->paginate(10);
        } else {
            $ruang = Ruang::with('jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru.user', 'jadwalPelajaran.guru.pelajaran', 'jadwalPelajaran.ruang')
                ->paginate(10);
        }

        return view('admin.ruang.index', [
            'title' => 'All Ruang',
            'ruang' => $ruang,
        ]);
    }

    public function show()
    {
        return view('admin.ruang.detail', [
            "title" => "Detail Ruang",
        ]);
    }

    public function create()
    {
        return view('admin.ruang.create', [
            "title" => "Create Ruang",
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ruang' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {

            $ruang = Ruang::create([
                'nama_ruang' => $request->nama_ruang,
            ]);

            if ($ruang) {
                return redirect()->route('admin.ruang.index')->with('Berhasil', 'Ruang berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('Gagal', 'Ruang gagal ditambahkan, silakan coba lagi.');
            }
        }
    }

    public function edit()
    {
        return view('admin.ruang.edit', [
            "title" => "Edit Ruang",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_ruang' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {
            $ruang = Ruang::find($id);
            if ($ruang) {

                $ruang->fill($request->only([
                    'nama_ruang',
                ]));

                $ruang->save();

                return redirect()->route('admin.ruang.index')->with('Berhasil', 'Ruang berhasil diperbarui.');
            } else {
                return redirect()->back()->with('Gagal', 'Ruang gagal diperbarui, silakan coba lagi.');
            }
        }
    }

    public function delete()
    {
        return view('admin.ruang.delete', [
            "title" => "Delete Ruang",
        ]);
    }

    public function destroy($id)
    {
        $ruang = Ruang::find($id)->delete();

        if ($ruang) {
            return redirect()->route('admin.ruang.index')->with('Berhasil', 'Ruang berhasil dihapus.');
        } else {
            return redirect()->back()->with('Gagal', 'Ruang gagal dihapus, silakan coba lagi.');
        }
    }
}
