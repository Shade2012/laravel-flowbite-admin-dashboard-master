<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\JadwalPelajaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotificationFCM;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as NotificationModel;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $users = User::whereNotNull('fcm_token')->get();

        $jadwal_pelajaran = JadwalPelajaran::with('kelas.waliKelas', 'kelas.siswa', 'kelas.jadwalPelajaran', 'pelajaran.guru', 'pelajaran.jadwalPelajaran', 'guru.user', 'guru.pelajaran', 'ruang.jadwalPelajaran')
            ->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'Tidak ada pengguna dengan FCM token ditemukan'], 404);
        }

        foreach ($users as $user) {
            try {
                Notification::send($user, new NotificationFCM($request->title, $request->message));

                NotificationModel::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'message' => $request->message,
                    'fcm_token' => $user->fcm_token,
                ]);
            } catch (\Exception $e) {
                continue;
            }
        }

        return response()->json(['message' => 'Notifikasi berhasil dikirim dan disimpan untuk pengguna dengan FCM token', 'jadwal' => $jadwal_pelajaran]);
    }

    public function getUserNotifications()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $notifications = NotificationModel::where('user_id', $user->id)->with([
            'user.kelas',
            'user.guru',
            'user.siswa'
        ])->get();

        return response()->json([
            'status' => 200,
            'notifications' => $notifications,
        ]);
    }

    public function sendNotificationScheduler()
    {
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);
        $tenMinutesFromNow = $now->copy()->addMinutes(10);

        $hariMapping = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $hariSekarang = $hariMapping[$now->format('l')];

        $jadwal_pelajaran = JadwalPelajaran::with('kelas.siswa.user', 'guru.user', 'pelajaran', 'ruang')
            ->whereBetween('jam_mulai', [$now, $tenMinutesFromNow])
            ->where('hari', $hariSekarang)
            ->get();

        Log::info('Waktu sekarang: ' . $now);
        Log::info('Hari sekarang: ' . $hariSekarang);
        Log::info('Jadwal yang diambil: ' . json_encode($jadwal_pelajaran));

        if ($jadwal_pelajaran->isEmpty()) {
            return response()->json(['message' => 'Tidak ada jadwal pelajaran yang perlu diberitahukan'], 404);
        }

        foreach ($jadwal_pelajaran as $jadwal) {
            $jamMulai = $jadwal->jam_mulai;

            Log::info('Jam mulai pelajaran: ' . $jamMulai);
            Log::info('Waktu sekarang: ' . $now);

            $diffInMinutes = $now->diffInMinutes($jamMulai);
            Log::info('Perbedaan menit: ' . $diffInMinutes);

            $title = "Notifikasi Pelajaran Kelas {$jadwal->kelas->nama_kelas}";
            $message = "Pelajaran {$jadwal->pelajaran->nama_pelajaran} dimulai dalam {$diffInMinutes} menit di ruangan {$jadwal->ruang->nama_ruang} pada jam {$jamMulai}.";

            if ($jadwal->guru->user->fcm_token) {
                try {
                    Notification::send($jadwal->guru->user, new NotificationFCM($title, $message));

                    Log::info('FCM Token Guru: ' . $jadwal->guru->user->fcm_token);

                    $notif = NotificationModel::create([
                        'user_id' => $jadwal->guru->user_id,
                        'title' => $title,
                        'message' => $message,
                        'fcm_token' => $jadwal->guru->user->fcm_token,
                    ]);

                    Log::info('Data Notif Guru: ' . $notif);
                } catch (\Exception $e) {
                    Log::error('Error saving notification for guru: ' . $e->getMessage());
                }
            }

            foreach ($jadwal->kelas->siswa as $siswa) {
                if ($siswa->user->fcm_token) {
                    try {
                        Notification::send($siswa->user, new NotificationFCM($title, $message));

                        Log::info('FCM Token Siswa: ' . $siswa->user->fcm_token);

                        $notif = NotificationModel::create([
                            'user_id' => $siswa->user_id,
                            'title' => $title,
                            'message' => $message,
                            'fcm_token' => $siswa->user->fcm_token,
                        ]);

                        Log::info('Data Notif Siswa: ' . $notif);
                    } catch (\Exception $e) {
                        Log::error('Error saving notification for siswa: ' . $e->getMessage());
                    }
                }
            }
        }

        return response()->json(['message' => 'Notifikasi berhasil dikirim dan disimpan untuk pengguna dengan FCM token', 'notif' => $notif]);
    }
}
