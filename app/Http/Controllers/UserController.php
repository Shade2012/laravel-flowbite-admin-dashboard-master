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
            'users' => $users
        ]);
    }

    public function show($id)
    {
        $user = User::with('kelas.waliKelas', 'guru.user', 'guru.pelajaran', 'siswa.user', 'siswa.kelas')->find($id)->get();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'kelas' => $user->kelas,
            'role' => $user->role,
            'image' => $user->image,
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
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
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
                return redirect()->route('admin.user.index')->with('success', 'User successfully added.');
            } else {
                return redirect()->back()->with('success', 'User successfully added.');
            }
        }
    }

    public function edit($user)
    {
        $user = User::with('kelas.waliKelas', 'guru.user', 'guru.pelajaran', 'siswa.user', 'siswa.kelas')->find($user)->get();

        return view('admin.user.create', [
            "title" => "Edit User",
            "user" => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'User successfully updated.');
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();

        if ($user) {
            return redirect()->route('admin.user.index')->with('success', 'User successfully deleted.');
        }
    }
}
