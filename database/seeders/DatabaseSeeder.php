<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default roles for each tenant if a tenant context exists during seeding
        $tenantIds = \App\Models\Tenant::query()->pluck('id');
        foreach ($tenantIds as $tenantId) {
            app()->instance('tenant.id', (int) $tenantId);
            $this->seedTenantRoles((int) $tenantId);
        }
    }

    protected function seedTenantRoles(int $tenantId): void
    {
        $roles = [
            'tenant_admin',
            'manager',
            'volunteer_coordinator',
            'volunteer',
            'finance',
            'donor',
        ];

        foreach ($roles as $name) {
            Role::findOrCreate($name, 'web');
        }
    }
}
