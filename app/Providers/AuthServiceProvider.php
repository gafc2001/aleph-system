<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(7));
        Passport::refreshTokensExpireIn(now()->addMonths(3));
        Passport::personalAccessTokensExpireIn(now()->addMonths(5));

        Passport::tokensCan([
            "admin-access" => "Manejar todo el acceso a adminstracion",
            "employee-access" => "Permisos y ver sus asistencias"
        ]);

        Passport::setDefaultScope([
            "employee-access"
        ]);
    }
}
