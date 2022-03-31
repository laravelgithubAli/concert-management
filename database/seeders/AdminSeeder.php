<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::query()->where('title','admin')->first();

        $adminUser = User::query()->create([
            'role_id' => $adminRole->id,
            'name' => 'Ali',
            'email' => 'Ali@mail.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
