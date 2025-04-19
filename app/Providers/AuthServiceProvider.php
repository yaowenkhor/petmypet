<?php

namespace App\Providers;

use App\Models\Pet;
use App\Models\User;
use App\Models\Organization;
use App\Models\Adopter;
use App\Policies\AdopterPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\PetPolicy;
use App\Policies\AdminPolicy;
use App\Policies\OrganizationPolicy;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
            // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Pet::class => PetPolicy::class,
        User::class => AdminPolicy::class,
        Organization::class => OrganizationPolicy::class,
        Adopter::class => AdopterPolicy::class,
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
