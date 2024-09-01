<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::get("/",[HomeController::class,"home"]);
Route::get("/home",[HomeController::class,"home"]);

Route::post("/add-items",[HomeController::class,"addItems"]);

