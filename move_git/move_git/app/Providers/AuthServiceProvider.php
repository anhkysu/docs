<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function registerGates($gates){
        foreach ($gates as $gateObj) {
            $gateName = $gateObj->attribute;
            Gate::define($gateName, function ($user) use ($gateName) {
                $navigationControl = json_decode($user->getAttribute('navigation_control'));
                if(!isset($navigationControl->$gateName)){
                    return false;
                } else if($navigationControl->$gateName == \App\Constants\User::NAVIGATION_CONTROL_ACTION_ALLOW){
                    return true;
                }
                return false;
            });
        }
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $navigationControlModel = new \App\Models\NavigationControl();
        $gates =  $navigationControlModel->selectAllActiveNavigationControl();
        $this->registerGates($gates);
    }
}
