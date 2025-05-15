<?php

namespace App\Http\Controllers;

use App\Models\unitkerja;

class UnitkerjaController extends Controller
{
    public function index()
    {
        $unitkerja = unitkerja::all();
        return view("unit-kerja.index", compact("unitkerja"));
    }
}
