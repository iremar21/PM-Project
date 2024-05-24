<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    protected $model = Plan::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        return [
            'title' => $title,
            'description' => fake()->text(100),
            'category_id' => Category::all()->random()->id,
            'creator_user_id' => User::all()->random()->id,
            'manager_user_id' => User::all()->random()->id,
            'creationDate' => fake()->dateTimeBetween('-3 months', 'now'),
            'finishDate' => fake()->dateTimeBetween('-3 months', 'now'),
            'scheduledFinishDate' => fake()->dateTimeBetween('now', '30 days'),
            'slug' => Str::slug($title),
        ];
    }
}
