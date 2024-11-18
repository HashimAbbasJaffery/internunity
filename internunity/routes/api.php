<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\IsLoggedin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", [UserController::class, "get"]);
Route::patch("/user/update", [UserController::class, "edit"]);

Route::get("/user/projects", [PortfolioController::class, "get"]);
Route::post("/user/project/create", [PortfolioController::class, "store"]);
Route::delete("/user/project/{project}/delete", [PortfolioController::class, "destroy"]);
Route::put("/user/project/{project}/update", [PortfolioController::class, "edit"]);

Route::get("/user/experiences", [ExperienceController::class, "get"]);
Route::post("/user/experience/create", [ExperienceController::class, "store"]);
Route::put("/experience/{experience}/update", [ExperienceController::class, "update"]);

Route::get("/user/educations", [EducationController::class, "get"]);
Route::post("/user/education/create", [EducationController::class, "store"]);

Route::post("login", [AuthenticationController::class, "login"])->name("login")
        ->middleware(IsLoggedin::class);
Route::delete("logout", [AuthenticationController::class, "logout"])->name("logout");


Route::get("/internships", [InternshipController::class, "index"]);
