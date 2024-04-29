<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'creator_user_id' => User::all()->random()->id,
            'assigned_user_id' => User::all()->random()->id,
            'plan_id' => Plan::all()->random()->id,
            'scheduledFinishDate' => fake()->dateTimeBetween('now', '3 months'),
            'completed' => fake()->boolean(),
        ];
    }
}
