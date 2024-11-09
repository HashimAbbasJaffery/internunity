<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\InternshipController;
use App\Http\Middleware\IsLoggedin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("login", [AuthenticationController::class, "login"])->name("login")
        ->middleware(IsLoggedin::class);

Route::delete("logout", [AuthenticationController::class, "logout"])->name("logout");


Route::get("/internships", [InternshipController::class, "index"]);
