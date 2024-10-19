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
            $ruang = Ruang::with('jadwalPelajaran')
                ->where('nama_pelajaran', 'LIKE', '%' . $searchTerm . '%')
                ->paginate(10);
        } else {
            $ruang = Ruang::with('jadwalPelajaran')
                ->paginate(10);
        }

        return view('admin.ruang.index', [
            'title' => 'All Ruang',
            'ruang' => $ruang,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ruang' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Ruang::create($request->all());

        return redirect()->route('admin.ruang.index')->with('success', 'Ruang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ruang = Ruang::findOrFail($id);
        return view('admin.ruang.edit', compact('ruang'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_ruang' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ruang = Ruang::findOrFail($id);
        $ruang->update($request->all());

        return redirect()->route('admin.ruang.index')->with('success', 'Ruang berhasil diupdate.');
    }

    public function destroy($id)
    {
        Ruang::findOrFail($id)->delete();
        return redirect()->route('admin.ruang.index')->with('success', 'Ruang berhasil dihapus.');
    }
}
