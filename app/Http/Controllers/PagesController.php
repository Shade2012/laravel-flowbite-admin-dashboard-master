<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function maintenance()
    {
        return view('errors.maintenance', [
            "title" => "Maintenance Mode",
        ]);
    }

    public function pageNotFound()
    {
        return view('errors.404', [
            "title" => "404 - Page Not Found",
        ]);
    }

    public function serverError()
    {
        return view('errors.500', [
            "title" => "500 - Server Error",
        ]);
    }
}
