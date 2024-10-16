<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index', [
            "title" => "Dashboard",
        ]);
    }

    public function profile()
    {
        return view('admin.profile', [
            "title" => "Profile",
        ]);
    }
}
