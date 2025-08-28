<?php

use App\Http\Controllers\unitkerjaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/profil', function () {
    return "Belajar Laravel di STTNF 2025";
});

Route::get("/unit-kerja", [unitkerjaController::class, "index"]);
