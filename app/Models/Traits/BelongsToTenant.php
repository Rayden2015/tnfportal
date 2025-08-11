<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    /**
     * Optional resolver to determine the active tenant id.
     *
     * @var null|callable(): (int|null)
     */
    protected static $tenantIdResolverCallback = null;

    /**
     * Register the tenant global scope and auto-fill behavior.
     */
    public static function bootBelongsToTenant(): void
    {
        // Automatically set tenant_id on create if missing
        static::creating(function (Model $model): void {
            if (empty($model->tenant_id)) {
                $tenantId = static::resolveTenantId();
                if ($tenantId !== null) {
                    $model->tenant_id = $tenantId;
                }
            }
        });

        // Constrain queries to the active tenant when available
        static::addGlobalScope('tenant', function (Builder $builder): void {
            $tenantId = static::resolveTenantId();
            if ($tenantId !== null) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', $tenantId);
            }
        });
    }

    /**
     * Relation to the tenant model.
     */
    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }

    /**
     * Scope without the tenant global scope.
     */
    public function scopeWithoutTenant(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }

    /**
     * Force filter for a given tenant id (ignores resolver).
     */
    public function scopeForTenant(Builder $query, int $tenantId): Builder
    {
        return $query->withoutGlobalScope('tenant')->where($query->getModel()->getTable() . '.tenant_id', $tenantId);
    }

    /**
     * Set a custom tenant id resolver. Useful for middleware that detects tenant by domain or header.
     */
    public static function setTenantIdResolver(callable $resolver): void
    {
        static::$tenantIdResolverCallback = $resolver;
    }

    /**
     * Attempt to resolve the active tenant id.
     */
    protected static function resolveTenantId(): ?int
    {
        if (static::$tenantIdResolverCallback !== null) {
            return (static::$tenantIdResolverCallback)();
        }

        // Prefer an application-bound tenant id set by middleware/service provider
        if (app()->bound('tenant.id')) {
            $bound = app('tenant.id');
            return is_numeric($bound) ? (int) $bound : null;
        }

        // Fallback to the authenticated user's tenant
        $user = Auth::user();
        if ($user && isset($user->tenant_id)) {
            return (int) $user->tenant_id;
        }

        return null;
    }
}


