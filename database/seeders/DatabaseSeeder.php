<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{

    // /**
    //  * List of applications to add.
    //  */
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'type-list',
        'type-create',
        'type-edit',
        'type-delete',
        'project-list',
        'project-create',
        'project-edit',
        'project-delete',
        'categoty-list',
        'categoty-create',
        'categoty-edit',
        'categoty-delete',
        'position-list',
        'position-create',
        'position-edit',
        'position-delete',
        'member-list',
        'member-create',
        'member-edit',
        'member-delete',
        'setting-list',
        'setting-create',
        'setting-edit',
        'setting-delete',
        'finance-list',
        'finance-create',
        'finance-edit',
        'finance-delete',
    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // foreach ($this->permissions as $permission) {
        //     Permission::create(['name' => $permission]);
        // }

        // $permissions = Permission::pluck('id', 'id')->all();

        // $role = Role::create(['name' => 'Admin'])->syncPermissions($permissions);

        // // Create admin User and assign the role to him.
        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('12345678'),
        //     // 'created_by' => 1,
        // ])->assignRole([$role->id]);

        // // Create admin User and assign the role to him.
        // /**
        //  * Spatie package
        //  */
        // $user = User::create([
        //     'name' => 'Ahmed Sheta',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('12345678')
        // ]);

        // $permissions = Permission::pluck('id', 'id')->all();

        // $role = Role::create(['name' => 'Admin']);

        // $role->syncPermissions($permissions);

        // $user->assignRole([$role->id]);

        // Create admin User and assign the role to him.

        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => '2024-03-14 14:43:51',
            // 'created_by' => 1,
        ]);
    }

}
