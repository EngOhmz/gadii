<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isLogistic', function($user){            
            foreach($user->roles as $role)
            {                
            }
            return $role->id == 13;
        });

        // Gate::define('isAgronomy', function($user){            
        //     foreach($user->roles as $role)
        //     {                
        //     }
        //     return $role->id == 14;
        // });

        // Gate::define('isCooperate', function($user){            
        //     foreach($user->roles as $role)
        //     {                
        //     }
        //     return $role->id == 15;
        // });

        // Gate::define('isFarmer', function($user){            
        //     foreach($user->roles as $role)
        //     {                
        //     }
        //     return $role->id == 16;
        // });

        // Gate::define('isWarehouse', function($user){            
        //     foreach($user->roles as $role)
        //     {                
        //     }
        //     return $role->id == 17;
        // });

        //
    }
}
