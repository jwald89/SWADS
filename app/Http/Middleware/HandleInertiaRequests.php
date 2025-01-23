<?php

namespace App\Http\Middleware;

use App\Enums\Month;
use Inertia\Middleware;
use App\Enums\CivilStatus;
use App\Enums\GenderTypes;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'civilStatus' => CivilStatus::values(),
            'months' => Month::values(),
            'gender' => GenderTypes::values(),
            'role_type' => auth()->user()?->role_type,
            'fullname' => auth()->user()?->last_name  . ', ' . auth()->user()?->first_name . ' ' . substr(auth()->user()?->middle_init, 0, 1) .'.',
            'first_name' => auth()->user()?->first_name,
            'last_name' => auth()->user()?->last_name,
            'username' => auth()->user()?->username
        ]);
    }
}
