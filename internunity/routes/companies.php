<?php


use App\Http\Controllers\Company\ApplicationsController;
use App\Http\Controllers\Company\InternshipController;
use App\Http\Controllers\Company\UserController;
use App\Http\Controllers\Company\UserHeartLikesController;
use App\Http\Controllers\HiringController;
use App\Http\Middleware\HasToken;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

Route::get("/", function() {
    return (PersonalAccessToken::findToken(request()->bearerToken()))->tokenable()->select(["id", "name", "email"])->first();
});

Route::get("internships", [InternshipController::class, "get"]);
Route::get("internships/{internship}", [InternshipController::class, "get_by_id"]);
Route::get("internship/{internship}/applications", [ApplicationsController::class, "get"]);
Route::delete("internship/{internship}/delete", [InternshipController::class, "delete"]);
Route::post("internship/create", [InternshipController::class, "store"]);
Route::put("internship/{internship}/update", [InternshipController::class, "update"]);

// Internship Actions
Route::put("/internship/{application}/hire", [HiringController::class, "hire"]);
Route::put("/internship/{internship}/close", [HiringController::class, "close"]);
Route::put("/internship/{internship}/shortlist", [HiringController::class, "shortlist"]);
Route::put("/internship/{application}/reject", [HiringController::class, "reject"]);

Route::get("/applications/{internship}", [ApplicationsController::class, "get_by_internship"]);

Route::get("/users", [UserController::class, "get"]);

Route::post("/heart/{user}", [UserHeartLikesController::class, "heart"]);

Route::post("login", [\App\Http\Controllers\Company\Auth\AuthenticationController::class, "login"])
    ->withoutMiddleware(HasToken::class);
Route::delete("logout", [\App\Http\Controllers\Company\Auth\AuthenticationController::class, "logout"]);

