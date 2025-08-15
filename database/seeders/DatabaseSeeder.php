<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Donor;
use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create or fetch the demo tenant
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'demo'],
            ['name' => 'Demo Org']
        );

        // Set the current tenant (team) context for Spatie permissions
        app(PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);

        // Clear previous cached permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Seed roles and permissions scoped to this tenant
        $this->seedRolesAndPermissions();

        // Create or fetch an admin user for this tenant
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'      => 'Admin User',
                'password'  => bcrypt('password'),
                'tenant_id' => $tenant->id,
            ]
        );

        // Ensure 'super_admin' role exists
        if (!Role::where('name', 'super_admin')->where('guard_name', 'web')->exists()) {
            Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        }

        // Set tenant context before assigning
        app(PermissionRegistrar::class)->setPermissionsTeamId($admin->tenant_id);

        // Assign role
        $admin->assignRole('super_admin');

        // Clear cached permissions again after assignment
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Seed tenant-specific data
        Volunteer::factory()->count(15)->create(['tenant_id' => $tenant->id]);
        Donor::factory()->count(10)->create(['tenant_id' => $tenant->id]);
        Project::factory()->count(5)->create(['tenant_id' => $tenant->id]);
    }

    protected function seedRolesAndPermissions(): void
    {
        $permissions = [
            'manage users',
            'manage volunteers',
            'manage donors',
            'manage projects',
            'manage finances',
            'view reports',
            'manage events',
            'view content',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $roles = [
            'super_admin' => [
                'manage users',
                'manage volunteers',
                'manage donors',
                'manage projects',
                'manage finances',
                'view reports',
                'manage events',
                'view content',
            ],
            'tenant_admin' => [
                'manage users',
                'manage volunteers',
                'manage donors',
                'manage projects',
                'manage finances',
                'view reports',
            ],
            'volunteer' => [
                'view content',
                'manage events',
            ],
            'secretary' => [
                'manage users',
                'view reports',
                'manage events',
            ],
            'treasurer' => [
                'manage finances',
                'view reports',
            ],
            'organiser' => [
                'manage events',
                'view content',
            ],
            'donor' => [
                'view content',
            ],
            'visitor' => [
                'view content',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($rolePermissions);
        }
    }

    protected function seedTenantRoles(): void
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
            Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }
    }
}