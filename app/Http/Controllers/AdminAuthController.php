<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }

        return view('authentication.sign-in', [
            "title" => "Sign In",
        ]);
    }

    public function loginStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role !== 'admin') {
                Auth::logout();
                return redirect()->back()->with('failed', 'Akses ditolak. Anda tidak memiliki izin untuk masuk sebagai admin.');
            }

            return redirect()->route('index')->with('success', 'Berhasil masuk! Selamat datang kembali.');
        } else {
            return redirect()->back()->with('failed', 'Gagal masuk. Silakan periksa kembali email dan kata sandi Anda.');
        }
    }

    public function register()
    {
        if (Auth::check()) return redirect()->route('admin.index');

        return view('authentication.sign-up', [
            "title" => "Sign Up",
        ]);
    }

    public function registerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if ($request->password != $request->password_confirmation) {
            return redirect()->back()->with('failed', 'Password dan konfirmasi tidak cocok. Silakan coba lagi.');
        }

        if ($validator->fails()) {
            return redirect()->back()->with('failed', 'Email sudah terdaftar. Silakan gunakan email lain atau login dengan akun yang sudah ada.');
        }

        $validatedData = $validator->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        if ($user) {
            return redirect()->route('sign-in')->with('success', 'Pendaftaran berhasil! Silakan masuk untuk melanjutkan.');
        } else {
            return redirect()->back()->with('failed', 'Pendaftaran gagal. Silakan coba lagi.');
        }
    }


    public function forgotPassword()
    {
        if (Auth::check()) return redirect()->route('admin.index');

        return view('authentication.forgot-password', [
            "title" => "Forgot Password",
        ]);
    }

    public function forgotPasswordStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('failed', 'Alamat email tidak ditemukan.');
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
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

            $request->session()->put('email', $request->email);

            Mail::to($request->email)->send(new OtpMail($mailData));

            return redirect()->route('verify-code')->with('success', 'Kode OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function resendOtp(Request $request)
    {
        $email = $request->session()->get('email');

        if (!$email) {
            return redirect()->back()->with('failed', 'Alamat email tidak ditemukan.');
        }

        $otp = rand(100000, 999999);
        $expires_at = Carbon::now()->addMinutes(10);

        try {
            $mailData = [
                'otp' => $otp,
                'expires_at' => $expires_at->format('d-m-Y H:i:s'),
            ];

            Otp::updateOrCreate(
                ['email' => $email],
                ['otp' => $otp, 'expires_at' => $expires_at, 'is_used' => false]
            );

            Mail::to($email)->send(new OtpMail($mailData));

            return redirect()->route('verify-code')->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function verifyCode(Request $request)
    {
        if (Auth::check()) return redirect()->route('admin.index');

        $email = $request->session()->get('email');

        $otpRecord = Otp::where('email', $email)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('authentication.verify-code', [
            "title" => "Verify Code",
            "otp" => $otpRecord ? $otpRecord->otp : null,
        ]);
    }

    public function verifyCodeStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|numeric|digits_between:0,9',
        ]);

        $email = $request->session()->get('email');

        if (!$email) {
            return redirect()->back()->with('failed', 'Alamat email tidak ditemukan.');
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $otpInput = implode('', $request->otp);

        $otpRecord = Otp::where('email', $email)
            ->where('otp', $otpInput)
            ->where('expires_at', '>', Carbon::now())
            ->where('is_used', false)
            ->first();

        if ($otpRecord) {
            $otpRecord->update(['is_used' => true]);

            return redirect()->route('reset-password')->with('success', 'Kode OTP berhasil diverifikasi. Anda dapat mengatur ulang kata sandi Anda sekarang.');
        }

        return redirect()->back()->with('failed', 'Kode OTP tidak valid atau sudah kedaluwarsa.');
    }

    public function resetPassword()
    {
        if (Auth::check()) return redirect()->route('admin.index');

        return view('authentication.reset-password', [
            "title" => "Reset Password",
        ]);
    }

    public function resetPasswordStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $email = $request->session()->get('email');

        if (!$email) {
            return redirect()->back()->with('failed', 'Alamat email tidak ditemukan.');
        }

        if ($request->password != $request->password_confirmation) {
            return redirect()->back()->with('failed', 'Password dan konfirmasi tidak cocok. Silakan coba lagi.');
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('sign-in')->with('success', 'Kata sandi Anda telah diperbarui! Silakan masuk dengan kata sandi baru Anda.');
        } else {
            return redirect()->back()->with('failed', 'Pengguna tidak ditemukan.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sign-in')->with('success', 'Anda telah berhasil keluar. Sampai jumpa lagi!');
    }
}
