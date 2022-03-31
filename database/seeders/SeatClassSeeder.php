<?php

namespace Database\Seeders;

use App\Models\SeatClass;
use Illuminate\Database\Seeder;

class SeatClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeatClass::query()->insert([
            [
                'title' => 'first class'
            ],
            [
                'title' => 'second class'
            ],
            [
                'title' => 'third class'
            ],
            [
                'title' => 'fourth class'
            ],
        ]);
    }
}
