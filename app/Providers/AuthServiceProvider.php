<?php

namespace App\Providers;

use App\Models\CustomerGroup;
use App\Models\User;
use App\Policies\CustomerGroupPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * El arreglo de políticas para la aplicación.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        \Spatie\Permission\Models\Role::class => \App\Policies\RolePolicy::class,
        CustomerGroup::class => CustomerGroupPolicy::class,
    ];

    /**
     * Registrar cualquier servicio de autenticación / autorización.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}