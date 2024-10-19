<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    
    public function dashboard(Request $request)
    {
        Carbon::setLocale('id'); // Set locale to Indonesian
        $hari = Carbon::now()->isoFormat('dddd');
        $kelas = Kelas::with('jadwalPelajaran')->get();
        $selectedClass = Kelas::first();
        if ($request->has('id')) {
            $selectedClass = Kelas::find($request->id);  // Get the selected class by ID
        }
        $jadwalNow = JadwalPelajaran::where([
            ['kelas_id',$selectedClass->id],
            ['hari', '=', $hari], 
            ])->with(['kelas','pelajaran','ruang','guru.user'])->paginate(8);
        $jadwalHariIni = JadwalPelajaran::where('hari','=',$hari)->with(['guru.user','pelajaran'])->get();
        
        return view('admin.index', [
            "title" => "Dashboard",
            "classes"=> $kelas,
            "selectedClass" => $selectedClass ? $selectedClass : 'None selected',
            "jadwalNow" => $jadwalNow,
            "jadwalHariIni"=>$jadwalHariIni,
            "hari" => $hari,
            // "pelajaran"=> $jadwalNow ? $jadwalNow->pelajaran->nama_pelajaran : 'No pelajaran found'
        ]);
    }

    public function create(){
        
        $title = "Add Data";
        return view("dashboard.student.create", [
            "title" => $title,
            "kelas" => Kelas::all(),
            
        ]);
        
    }
    public function changePassword(Request $request){
        $adminLogin = Auth::user();
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with('errorValidator', 'Password tidak sama');
        }
        $admin = User::find($adminLogin->id);

        if ($admin) {
            if (!Hash::check($request->old_password, $admin->password)) {
                return back()->with('errorValidator', 'Password saat ini salah');
            }
            $admin->password = Hash::make($request->password);
            $admin->save();
            return redirect()->route('profile')->with('successPassword', 'Password berhasil diubah');
        }
    }
    public function update(Request $request){
        $admin = Auth::user();
        $validateData = $request->validate([
            "name" => "required|max:255",
            "email" => "required|max:255"
        ]);
        $existingName = User::where('name',$validateData['name'])->first();
        $existingEmail = User::where('email',$validateData['email'])->first();
        if($validateData['email'] == $admin->email && $validateData['name'] == $admin->name){
    
            return redirect('/admin/profile')->with('success', 'Tidak Ada Perubahan');
        }
        if($validateData['email'] != $admin->email){
            if($existingEmail){
                return back()->withInput()->with('errorProfile', 'Email sudah terdaftar');
            }
        }
        if($validateData['name'] != $admin->name){
            if($existingName){
                return back()->withInput()->with('errorProfile', 'Nama sudah terdaftar');
            }
        }
        
        $adminDetail = User::find($admin->id);
        $result = $adminDetail->update($validateData);
        if ($result) {
            return redirect('/admin/profile')->with('success', 'Data umum berhasil dirubah');
        }
    }
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile', [
            "title" => "Profile",
            "admin"=>$admin
        ]);
    }
}
