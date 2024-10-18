<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('name');

        if ($searchTerm) {
            $users = User::with('kelas.waliKelas', 'guru.user', 'guru.pelajaran', 'siswa.user', 'siswa.kelas')
                ->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->paginate(10);
        } else {
            $users = User::with('kelas.waliKelas', 'guru.user', 'guru.pelajaran', 'siswa.user', 'siswa.kelas')
                ->paginate(10);
        }

        return view('admin.user.index', [
            'title' => 'All Users',
            'users' => $users,
        ]);
    }

    public function show()
    {
        return view('admin.user.detail', [
            "title" => "Detail User",
        ]);
    }

    public function create()
    {
        return view('admin.user.create', [
            "title" => "Create User",
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|image|max:2048',
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('failed', $validator->errors()->first());
        } else {
            $image = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image')->store('images', 'public');
            }

            $user = User::create([
                'image' => $image,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            if ($user) {
                return redirect()->route('admin.user.index')->with('success', 'Siswa berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('failed', 'Siswa gagal ditambahkan, silakan coba lagi.');
            }
        }
    }

    public function edit()
    {
        return view('admin.user.edit', [
            "title" => "Edit User",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('failed', $validator->errors()->first());
        } else {
            $user = User::find($id);
            if ($user) {
                if ($request->hasFile('image')) {
                    if ($user->image) {
                        Storage::disk('public')->delete($user->image);
                    }
                    $user->image = $request->file('image')->store('images', 'public');
                }

                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }

                $user->fill($request->only([
                    'name',
                    'email',
                    'role',
                ]));

                $user->save();

                return redirect()->route('admin.user.index')->with('success', 'Siswa berhasil diperbarui.');
            } else {
                return redirect()->back()->with('failed', 'Siswa gagal diperbarui, silakan coba lagi.');
            }
        }
    }

    public function delete()
    {
        return view('admin.user.delete', [
            "title" => "Delete User",
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();

        if ($user) {
            return redirect()->route('admin.user.index')->with('success', 'Siswa berhasil dihapus.');
        } else {
            return redirect()->back()->with('failed', 'Siswa gagal dihapus, silakan coba lagi.');
        }
    }
}
