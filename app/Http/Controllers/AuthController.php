<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'fcm_token' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $user = User::where('email', $request->email)->with([
            'Kelas.waliKelas',
            'guru.user',
            'guru.pelajaran',
            'siswa.user',
            'siswa.kelas'
        ])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid email or password',
            ], 401);
        }

        if ($request->filled('fcm_token')) {
            $user->fcm_token = $request->fcm_token;
            $user->save();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'image' => $user->image ? url($user->image) : null,
                'name' => $user->name,
                'email' => $user->email,
                'fcm_token' => $user->fcm_token,
                'role' => $user->role,
                'created_at' => $user->created_at->toIso8601String(),
                'updated_at' => $user->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    public function loginGoogle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'fcm_token' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $user = User::where('email', $request->email)->with([
            'Kelas.waliKelas',
            'guru.user',
            'guru.pelajaran',
            'siswa.user',
            'siswa.kelas'
        ])->first();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid email',
            ], 401);
        }

        if ($request->filled('fcm_token')) {
            $user->fcm_token = $request->fcm_token;
            $user->save();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'image' => $user->image ? url($user->image) : null,
                'name' => $user->name,
                'email' => $user->email,
                'fcm_token' => $user->fcm_token,
                'role' => $user->role,
                'created_at' => $user->created_at->toIso8601String(),
                'updated_at' => $user->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,guru,siswa',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 201,
            'message' => 'Register successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $user = Auth::user();

        $userLogin = User::where('email', $user->email)->first();
        $userLogin->password = Hash::make($request->password);
        $userLogin->save();

        return response()->json([
            'status' => 200,
            'message' => 'Password reset successfully.',
            'user' => $userLogin,
        ], 200);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Logout successfully',
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'User not authenticated',
        ], 401);
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'All tokens revoked successfully',
        ], 200);
    }

    public function show()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => [
                    'id' => $user->id,
                    'image' => url($user->image),
                    'name' => $user->name,
                    'email' => $user->email,
                    'fcm_token' => $user->fcm_token,
                    'role' => $user->role,
                    'created_at' => $user->created_at->toIso8601String(),
                    'updated_at' => $user->updated_at->toIso8601String(),
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data user tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $userLogin = Auth::user();
        $user = User::find($userLogin->id);

        if ($user) {
            if ($request->filled('old_password') && !Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'The old password is incorrect.',
                ], 401);
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'User data successfully updated',
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }
    }
}
