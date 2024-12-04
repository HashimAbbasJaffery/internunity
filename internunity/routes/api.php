<?php

use App\Events\SendMessage;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationStatusController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\HeartActionController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\MarkAsReadController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportTypeController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\HasToken;
use App\Http\Middleware\IsLoggedin;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/send_message", [ChatController::class, "get"])->middleware("auth:api");
// Route::post("/notification/{user}", [NotificationController::class, "notify"]);
Route::post("/send", [ChatController::class, "store"]);
Route::put("/notifications/user", [MarkAsReadController::class, "edit"]);

Route::put("/notification/{notification}/read", function(Notification $notification) {
    $notification->read_at = now();
    $notification->save();
    return 1;
});
Route::patch("/message/{room}/changeStatus", [ChatController::class, "changeStatus"]);
Route::get("/notifications", [NotificationController::class, "get"]);

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

Route::get("/user/applications", [ApplicationController::class, "get"]);
Route::post("/user/{internship}/application/create", [ApplicationController::class, "store"]);

Route::post("/user/{internship}/heart", [HeartActionController::class, "store"]);

Route::get("/status/get", [ApplicationStatusController::class, "get"]);

Route::post("/user/{internship}/report", [ReportController::class, "store"]);
Route::get("/report_types", [ReportTypeController::class, "get"]);;

Route::post("login", [AuthenticationController::class, "login"])->name("login")
        ->withoutMiddleware(HasToken::class);
Route::delete("logout", [AuthenticationController::class, "logout"])->name("logout");


Route::get("/internships", [InternshipController::class, "index"])
        ->withoutMiddleware(HasToken::class);
