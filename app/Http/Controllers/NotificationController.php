<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotificationFCM;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as NotificationModel;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $user = User::where('fcm_token', $request->fcm_token)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found or FCM token invalid'], 404);
        }

        Notification::send($user, new NotificationFCM($request->title, $request->message));

        NotificationModel::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'message' => $request->message,
            'fcm_token' => $request->fcm_token,
        ]);

        return response()->json(['message' => 'Notification sent and saved successfully']);
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
}
