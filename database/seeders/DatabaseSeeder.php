<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Plan;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        Category::factory(4)->create();
        $this->call(UserSeeder::class);
        $plans = Plan::factory(50)->create();
        Task::factory(100)->create();

        // Calculamos el porcentaje completado de cada plan en base a las tareas completadas dentro de este
        foreach ($plans as $plan) {
            $tasks = Task::where('plan_id', $plan->id)->get();
            $completedTasks = $tasks->where('completed', true)->count();
            $totalTasks = $tasks->count();
            $percentageCompleted = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
            $plan->update(['status' => $percentageCompleted]);
            if ($percentageCompleted == 100) {
                $plan->update(['completed' => true]);
            }
        }
    }
}
