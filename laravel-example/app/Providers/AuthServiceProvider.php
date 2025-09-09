<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        PostPolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Definir tokens
        Passport::tokensExpireIn(now()->addHours(2));
        Passport::refreshTokensExpireIn(now()->addDay(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        // Gates
        Gate::define('view-health', function(User $user){
            return $user->hasRole(['editor', 'viewer']);
        });

        Gate::define('view-health-admin', function(User $user){
            return $user->hasRole(['editor', 'admin']) || $user->tokenCan('posts.admin');
        });

        // NO RECOMENDADO, PERO ÚTIL PARA PUEBAS
        // Gate::before(function(User $user, string $ability){
        //     return $user->hasRole(['admin']) ? true : null; // true -> condede los permisos
        // });

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
