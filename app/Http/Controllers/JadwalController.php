<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function getKelas()
    {
        $kelas = Kelas::all();

        if ($kelas->count() > 0) {
            return response()->json([
                'status' => 200,
                'kelas' => $kelas,
            ], 200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Guru ini tidak memiliki kelas yang diampu.',
                'kelas' => [],
            ], 200);
        }
    }

    public function getGuruMataPelajaran()
    {
        $user = Auth::user();

        $mataPelajaran = JadwalPelajaran::where('guru_id', $user->guru->id)
            ->with('pelajaran')
            ->get();

        if ($mataPelajaran->count() > 0) {
            $dataPelajaran = $mataPelajaran->map(function ($jadwal) {
                return [
                    "id" => $jadwal->pelajaran->id,
                    "nama_pelajaran" => $jadwal->pelajaran->nama_pelajaran,
                    "updated_at" => $jadwal->pelajaran->updated_at,
                    "created_at" => $jadwal->pelajaran->created_at,
                ];
            });

            return response()->json([
                'status' => 200,
                'mata_pelajaran' => $dataPelajaran,
            ], 200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Guru ini tidak memiliki mata pelajaran yang diampu.',
                'mata_pelajaran' => [],
            ], 200);
        }
    }

    public function getFilteredJadwal(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'hari' => 'required|string',
            'kelas' => 'nullable|string',
            'mata_pelajaran' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $hariRequest = $request->input('hari');
        $kelasRequest = $request->input('kelas');
        $mataPelajaranRequest = $request->input('mata_pelajaran');

        $query = JadwalPelajaran::where('guru_id', $user->guru->id)
            ->with(['kelas', 'pelajaran']);

        // Filter berdasarkan hari
        if ($hariRequest) {
            $query->where('hari', $hariRequest);
        }

        if ($kelasRequest) {
            $query->whereHas('kelas', function ($q) use ($kelasRequest) {
                $q->where('nama_kelas', 'like', '%' . $kelasRequest . '%');
            });
        }

        if ($mataPelajaranRequest) {
            $query->whereHas('pelajaran', function ($q) use ($mataPelajaranRequest) {
                $q->where('nama_pelajaran', 'like', '%' . $mataPelajaranRequest . '%');
            });
        }

        $jadwal = $query->orderBy('jam_mulai', 'asc')
            ->get();

        if ($jadwal->count() > 0) {
            $dataJadwal = $jadwal->map(function ($item) {
                return [
                    "id" => $item->id,
                    "kelas" => $item->kelas->nama_kelas,
                    "hari" => $item->hari,
                    "jam_mulai" => $item->jam_mulai,
                    "jam_selesai" => $item->jam_selesai,
                    "pelajaran" => $item->pelajaran->nama_pelajaran,
                    "guru" => $item->guru->user->name,
                    "ruang" => $item->ruang->nama_ruang,
                    "created_at" => $item->created_at,
                    "updated_at" => $item->updated_at,
                ];
            });

            return response()->json([
                'status' => 200,
                'jadwal' => $dataJadwal,
            ], 200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Jadwal guru tidak ditemukan.',
                'jadwal' => [],
            ], 200);
        }
    }

    public function getSiswaJadwal(Request $request)
    {
        $user = Auth::user();

        $hariRequest = $request->input('hari');

        $jadwal = JadwalPelajaran::where('kelas_id', $user->siswa->kelas->id)
            ->where('hari', $hariRequest)
            ->orderBy('jam_mulai', 'asc')
            ->with(['kelas.waliKelas', 'pelajaran', 'guru.user', 'guru.pelajaran', 'ruang'])
            ->get();

        if ($jadwal->count() > 0) {
            $dataJadwal = $jadwal->map(function ($item) {
                return [
                    "id" => $item->id,
                    "kelas" => $item->kelas->nama_kelas,
                    "hari" => $item->hari,
                    "jam_mulai" => $item->jam_mulai,
                    "jam_selesai" => $item->jam_selesai,
                    "pelajaran" => $item->pelajaran->nama_pelajaran,
                    "guru" => $item->guru->user->name,
                    "ruang" => $item->ruang->nama_ruang,
                    "created_at" => $item->created_at,
                    "updated_at" => $item->updated_at,
                ];
            });

            return response()->json([
                'status' => 200,
                'jadwal' => $dataJadwal,
            ], 200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Jadwal kelas hari ini tidak ada.',
                'jadwal' => [],
            ], 200);
        }
    }

    public function show($id)
    {
        $jadwal = JadwalPelajaran::with(['kelas.waliKelas', 'pelajaran', 'guru.user', 'guru.pelajaran', 'ruang'])->find($id);

        if ($jadwal) {
            return response()->json([
                'status' => 200,
                'jadwal' => $jadwal,
            ], 200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Jadwal tidak ditemukan.',
                'jadwal' => [],
            ], 200);
        }
    }
}
