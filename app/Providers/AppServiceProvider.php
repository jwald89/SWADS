<?php

namespace App\Providers;

use App\Enums\UserTypes;
use App\Models\User;
use Laravel\Pennant\Feature;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Feature::purge();

        Feature::define('administrator', fn (User $user) => $this->roleHasAccess($user, UserTypes::IS_ADMIN));
        Feature::define('liaison', fn (User $user) => $this->roleHasAccess($user, UserTypes::IS_LIAISON));
        Feature::define('municipal', fn (User $user) => $this->roleHasAccess($user, UserTypes::IS_MUNICIPAL));
        Feature::define('user', fn (User $user) => $this->roleHasAccess($user, UserTypes::IS_USER));

        Feature::define('allowed-multiple-roles', fn (User $user) => $this->checkAccess($user, [
            UserTypes::IS_ADMIN->value, UserTypes::IS_USER->value,
        ]));

    }


    private function roleHasAccess(User $user, UserTypes $type) {
        return $user->role_type === $type->value;
    }

    private function checkAccess(User $user, $types = []) {
        return in_array($user->role_type, $types);
    }
}
