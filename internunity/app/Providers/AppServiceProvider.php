<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // \App\Models\Internship::macro("relatedInternships", function(User $user) {
            // $tags = $user->getUserCallable()->skills->pluck("id");
            // return $this->with("tags")->whereIn("tags.tag_id", $tags)->get();
        // });

    }
}
