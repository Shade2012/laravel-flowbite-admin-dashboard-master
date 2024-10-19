<?php

namespace App\Http\Controllers;

use App\Models\Pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelajaranController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('name');

        if ($searchTerm) {
            $pelajaran = Pelajaran::with('guru.user', 'guru.pelajaran', 'jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.ruang')
                ->where('nama_pelajaran', 'LIKE', '%' . $searchTerm . '%')
                ->paginate(10);
        } else {
            $pelajaran = Pelajaran::with('guru.user', 'guru.pelajaran', 'jadwalPelajaran.kelas', 'jadwalPelajaran.pelajaran', 'jadwalPelajaran.guru', 'jadwalPelajaran.ruang')
                ->paginate(10);
        }

        return view('admin.pelajaran.index', [
            'title' => 'All Pelajaran',
            'pelajaran' => $pelajaran,
        ]);
    }

    public function show()
    {
        return view('admin.pelajaran.detail', [
            "title" => "Detail Pelajaran",
        ]);
    }

    public function create()
    {
        return view('admin.pelajaran.create', [
            "title" => "Create Pelajaran",
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelajaran' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {

            $pelajaran = Pelajaran::create([
                'nama_pelajaran' => $request->nama_pelajaran,
            ]);

            if ($pelajaran) {
                return redirect()->route('admin.pelajaran.index')->with('Berhasil', 'Pelajaran berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('Gagal', 'Pelajaran gagal ditambahkan, silakan coba lagi.');
            }
        }
    }

    public function edit()
    {
        return view('admin.pelajaran.edit', [
            "title" => "Edit Pelajaran",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelajaran' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Gagal', $validator->errors()->first());
        } else {
            $pelajaran = Pelajaran::find($id);
            if ($pelajaran) {

                $pelajaran->fill($request->only([
                    'nama_pelajaran',
                ]));

                $pelajaran->save();

                return redirect()->route('admin.pelajaran.index')->with('Berhasil', 'Pelajaran berhasil diperbarui.');
            } else {
                return redirect()->back()->with('Gagal', 'Pelajaran gagal diperbarui, silakan coba lagi.');
            }
        }
    }

    public function delete()
    {
        return view('admin.pelajaran.delete', [
            "title" => "Delete Pelajaran",
        ]);
    }

    public function destroy($id)
    {
        $pelajaran = Pelajaran::find($id)->delete();

        if ($pelajaran) {
            return redirect()->route('admin.pelajaran.index')->with('Berhasil', 'Pelajaran berhasil dihapus.');
        } else {
            return redirect()->back()->with('Gagal', 'Pelajaran gagal dihapus, silakan coba lagi.');
        }
    }
}
