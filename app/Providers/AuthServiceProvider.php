<?php

namespace App\Providers;

use App\Link;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPostPolicies();
    }

    public function registerPostPolicies()
    {
        Gate::define('create-link', function (User $user) {
            return $user->hasAccess(['create-link']);
        });

        Gate::define('update-link', function (User $user, Link $link) {
            return $user->hasAccess(['update-link']) or $user->id == $link->user_id;
        });

        Gate::define('delete-link', function (User $user, Link $link) {
            return $user->hasAccess(['delete-link']) or $user->id == $link->user_id;
        });

        Gate::define('update-user', function (User $user ,User $user2) {
            return $user->hasAccess(['update-user']) or $user->id == $user2->id;
        });

        Gate::define('update-user-role', function (User $user) {
            return $user->hasAccess(['update-user-role']);
        });

        Gate::define('show-private-link', function (User $user, Link $link) {
            return $user->hasAccess(['show-private-link']) or $user->id == $link->user_id;
        });

        Gate::define('list-private-links', function (User $user) {
            return $user->hasAccess(['list-private-links']);
        });
    }
}
