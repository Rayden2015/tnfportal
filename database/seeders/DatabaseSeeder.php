<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Donor;
use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default roles for each tenant if a tenant context exists during seeding
        // Ensure at least one tenant exists
        $tenant = Tenant::firstOrCreate(['slug' => 'demo'], [
            'name' => 'Demo Org',
        ]);

        app()->instance('tenant.id', (int) $tenant->id);

        $this->seedTenantRoles((int) $tenant->id);

        // Create an admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
        ]);
        $admin->assignRole('tenant_admin');

        // Create sample volunteers, donors, and projects
        Volunteer::factory()->count(15)->create(['tenant_id' => $tenant->id]);
        Donor::factory()->count(10)->create(['tenant_id' => $tenant->id]);
        Project::factory()->count(5)->create(['tenant_id' => $tenant->id]);
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
