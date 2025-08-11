<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;

class SetTenant
{
    public function handle(Request $request, Closure $next)
    {
        $slug = $this->resolveTenantSlug($request);

        if ($slug) {
            $tenant = Tenant::where('slug', $slug)->first();
            if ($tenant) {
                app()->instance('current_tenant', $tenant);
                // Also bind the id for components that only need the scalar id
                app()->instance('tenant.id', (int) $tenant->id);

                // Inform spatie/laravel-permission about current team/tenant id
                app(PermissionRegistrar::class)->setPermissionsTeamId((int) $tenant->id);
            }
        }

        return $next($request);
    }

    protected function resolveTenantSlug(Request $request): ?string
    {
        // Priority: explicit route param > header > query > session > subdomain
        $routeParam = $request->route('tenant') ?? $request->route('organization');
        if (is_string($routeParam) && $routeParam !== '') {
            return $routeParam;
        }

        $header = $request->header('X-Tenant') ?? $request->header('X-Tenant-Slug');
        if (is_string($header) && $header !== '') {
            return $header;
        }

        $query = $request->query('tenant') ?? $request->query('tenant_slug');
        if (is_string($query) && $query !== '') {
            return $query;
        }

        $sessionSlug = $request->session()->get('tenant_slug');
        if (is_string($sessionSlug) && $sessionSlug !== '') {
            return $sessionSlug;
        }

        return $this->extractSubdomainSlug($request);
    }

    protected function extractSubdomainSlug(Request $request): ?string
    {
        $host = $request->getHost();

        // Ignore localhost and IPs
        if ($host === 'localhost' || filter_var($host, FILTER_VALIDATE_IP)) {
            return null;
        }

        $parts = explode('.', $host);
        if (count($parts) < 3) {
            return null;
        }

        $subdomain = $parts[0];
        if ($subdomain === 'www' || $subdomain === '') {
            return null;
        }

        return $subdomain;
    }
}


