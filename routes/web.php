<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebAuthController;

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::get("/",[HomeController::class,"home"]);
Route::get("/home",[HomeController::class,"home"]);

Route::post("/add-items",[HomeController::class,"addItems"]);

Route::get("/auth",[WebAuthController::class,"auth"]);
Route::post("/register",[WebAuthController::class,"register"]);
Route::post("/login",[WebAuthController::class,"login"]);

