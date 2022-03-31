<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConcertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'artist_id' => Artist::factory()->create(),
            'title' => 'This is my concert',
            'description' => 'This concert belongs to homayoun shajarian',
            'starts_at' => now()->format('y-m-d'),
            'ends_at' => now()->addWeek()->format('y-m-d'),
            'is_published' => true
        ];
    }
}
