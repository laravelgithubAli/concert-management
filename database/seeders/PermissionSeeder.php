<?php

namespace Database\Seeders;

use App\Models\permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * category permissions
         * */
        permission::query()->insert([
            [
                'title' => 'create-categories'
            ],
            [
                'title' => 'read-categories'
            ],
            [
                'title' => 'update-categories'
            ],
            [
                'title' => 'delete-categories'
            ],
        ]);


        /*
 * artists permissions
 * */
        permission::query()->insert([
            [
                'title' => 'create-artists'
            ],
            [
                'title' => 'read-artists'
            ],
            [
                'title' => 'update-artists'
            ],
            [
                'title' => 'delete-artists'
            ],
        ]);



        /*
* users permissions
* */
        permission::query()->insert([
            [
                'title' => 'create-users'
            ],
            [
                'title' => 'read-users'
            ],
            [
                'title' => 'update-users'
            ],
            [
                'title' => 'delete-users'
            ],
        ]);


        /*
* roles permissions
* */
        permission::query()->insert([
            [
                'title' => 'create-roles'
            ],
            [
                'title' => 'read-roles'
            ],
            [
                'title' => 'update-roles'
            ],
            [
                'title' => 'delete-roles'
            ],
        ]);
    }
}
