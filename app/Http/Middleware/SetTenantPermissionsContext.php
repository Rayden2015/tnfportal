<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;

class SetTenantPermissionsContext
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {

            \Log::info('Tenant Context Middleware', [
                'user_id'      => auth()->id(),
                'email'        => auth()->user()->email,
                'tenant_id'    => auth()->user()->tenant_id,
                'roles'        => auth()->user()->getRoleNames(),
                'permissions'  => auth()->user()->getPermissionNames(),
            ]);

            app(PermissionRegistrar::class)
                ->setPermissionsTeamId(auth()->user()->tenant_id);
        }

        return $next($request);
    }
}