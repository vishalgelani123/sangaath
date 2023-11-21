<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request): array
    {
        $userData = null;
        if ($request->user()) {
            $user = $request->user();

            $userName = $user->name;
            $splitName = explode(" ", $userName);
            $firstName = $splitName[0];

            $role = "";
            $displayRole = "";
            if ($user->hasRole('admin')) {
                $firstName = 'Head Office';
                $displayRole = "Master Admin";
                $role = "admin";
            } else if ($user->hasRole('project_coordinator')) {
                $displayRole = "Project Co-Ordinator";
                $role = "project_coordinator";
            } else if ($user->hasRole('supervisor')) {
                $displayRole = "Supervisor";
                $role = "supervisor";
            } else if ($user->hasRole('facilitator')) {
                $displayRole = "Facilitator";
                $role = "facilitator";
            } else if ($user->hasRole('sub_admin')) {
                $displayRole = "Sub Admin";
                $role = "sub_admin";
            } else if ($user->hasRole('report_admin')) {
                $displayRole = "Report Admin";
                $role = "report_admin";
            }

            $userData = [
                "first_name" => $firstName,
                "display_role" => $displayRole,
                "role" => $role
            ];
        }

        $pageName = Route::currentRouteName();

        return array_merge(parent::share($request), [
            'auth.user' => $userData,
            'current_page' => $pageName
        ]);
    }
}
