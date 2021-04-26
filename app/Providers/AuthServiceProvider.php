<?php

namespace App\Providers;

use App\Models\Team;
use App\Policies\TeamPolicy;
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
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('viewLarecipe', function($user, $documentation) {
            //main admin always has user id 1
            if($user->id === 1){
                return true;
            }

            //only show documentation if the user is a local admin
            $teams = $user->allTeams();
            foreach ($teams as $team) {
                if($team->name == "Local Admins" and $team->membership != ""){
                    if (($team->membership->role == "Local Admin" or $team->membership->role == "Administrator ") and $user->hasTeamPermission($team, 'room:create')) ;
                    {
                        return true;
                    }
                }
            }
            return false;
//            return true;
        });
    }
}
