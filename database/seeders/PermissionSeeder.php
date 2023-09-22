<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'create post']);
        Permission::create(['name' => 'edit post']);
        Permission::create(['name' => 'delete post']);
        Permission::create(['name' => 'view post']);
        Permission::create(['name' => 'create role']);

        $roles = ['developer', 'support', 'super-admin'];

       
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // - actions include Create Role, Create Posts
        // - let developers have read and write access but no delete access
        // - let support have read access alone
        // - let superadmin have all access 
        $developer = Role::findByName('developer');
        $support = Role::findByName('support');
        $superAdmin = Role::findByName('super-admin');

        $developer->givePermissionTo(['create post', 'view post', 'edit post']);
        $support->givePermissionTo('view post');
        $superAdmin->givePermissionTo(Permission::all());

        // Create demo users
        $developerUser = User::factory()->create([
            'name' => 'Developer',
            'email' => 'developer@demo.com',
        ]);
        $developerUser->assignRole($developer);

        $supportUser = User::factory()->create([
            'name' => 'Support',
            'email' => 'support@demo.com',
        ]);
        $supportUser->assignRole($support);

        $superAdminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@demo.com',
        ]);
        $superAdminUser->assignRole($superAdmin);
    }
}
