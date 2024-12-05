<?php


use App\Http\Controllers\Company\ApplicationsController;
use App\Http\Controllers\Company\InternshipController;
use Illuminate\Support\Facades\Route;


Route::get("test", function() {
    return "lol";
});

Route::get("internships", [InternshipController::class, "get"]);
Route::get("internship/{internship}/applications", [ApplicationsController::class, "get"]);
Route::delete("internship/{internship}/delete", [InternshipController::class, "delete"]);
Route::post("internship/create", [InternshipController::class, "store"]);
Route::put("internship/{internship}/update", [InternshipController::class, "update"]);

Route::post("login", [\App\Http\Controllers\Company\Auth\AuthenticationController::class, "login"]);
Route::delete("logout", [\App\Http\Controllers\Company\Auth\AuthenticationController::class, "logout"]);

