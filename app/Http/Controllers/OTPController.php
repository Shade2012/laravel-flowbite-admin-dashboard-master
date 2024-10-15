<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\OTP;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OTPController extends Controller
{
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $otp = rand(100000, 999999);
        $expires_at = Carbon::now()->addMinutes(10);

        try {
            $mailData = [
                'otp' => $otp,
                'expires_at' => $expires_at->format('d-m-Y H:i:s'),
            ];

            Otp::create([
                'email' => $request->email,
                'otp' => $otp,
                'expires_at' => $expires_at,
            ]);

            Mail::to($request->email)->send(new OtpMail($mailData));

            $user = User::where('email', $request->email)->first();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'OTP has been sent to your email.',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'OTP' => $otp,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $user = Auth::user();

        $otpRecord = Otp::where('email', $user->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->where('is_used', false)
            ->first();

        if ($otpRecord) {
            $otpRecord->update(['is_used' => true]);

            $userLogin = User::where('email', $user->email)->first();

            $token = $userLogin->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'OTP verified successfully. You can now reset your password.',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid OTP or OTP expired.',
        ], 400);
    }
}
