<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [

    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(now()->addHours(2));
        Passport::refreshTokensExpireIn(now()->addDay(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        //Scopes
        // recurso.accion
        Passport::tokensCan([
            'posts.read' => 'Leer posts',
            'posts.write' => 'Crear o editar posts',
            'posts.delete' => 'Puede eliminar posts',
            'posts.admin' => 'Acceso VIP',
        ]);

        Passport::defaultScopes([
            'posts.read', 
        ]);
    }
}
