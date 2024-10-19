<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

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

    public function profile()
    {
        return view('admin.profile', [
            "title" => "Profile",
        ]);
    }
}
