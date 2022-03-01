<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'juniorhrd',
            'password' => bcrypt('12345678'),
            'name'  => 'Anov Siraj',
            'position' => 'Junior HRD',
            'phone' => '0812345678',
            'image' => 'user.png',
            'email' => 'juniorhrd@gmail.com'
        ]);

        $role = Role::create(['name' => 'Junior HRD']);
        $permissions =Permission::whereIn('id', ['21'])->get();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
