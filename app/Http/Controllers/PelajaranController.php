<?php

namespace App\Http\Controllers;

use App\Models\Pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelajaranController extends Controller
{
    public function index()
    {
        $pelajaran = Pelajaran::all();
        return view('admin.pelajaran.index', [
            'title' => 'All Pelajaran',
            'pelajaran' => $pelajaran
        ]);
    }

    public function create()
    {
        return view('admin.pelajaran.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelajaran' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pelajaran::create($request->all());

        return redirect()->route('admin.pelajaran.index')->with('success', 'Pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelajaran = Pelajaran::findOrFail($id);
        return view('admin.pelajaran.edit', compact('pelajaran'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelajaran' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pelajaran = Pelajaran::findOrFail($id);
        $pelajaran->update($request->all());

        return redirect()->route('admin.pelajaran.index')->with('success', 'Pelajaran berhasil diupdate.');
    }

    public function destroy($id)
    {
        Pelajaran::findOrFail($id)->delete();
        return redirect()->route('admin.pelajaran.index')->with('success', 'Pelajaran berhasil dihapus.');
    }
}
