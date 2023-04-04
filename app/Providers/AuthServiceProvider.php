<?php

namespace App\Providers;

use App\Http\Controllers\ConferenceController;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Conference::class => ConferencePolicy::class,
        User::class => UserPolicy::class,
        Lecture::class => LecturePolicy::class,
        Comment::class => CommentPolicy::class,
        Category::class => CategoryPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
