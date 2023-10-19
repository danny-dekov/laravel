<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status_array = [ProjectStatus::NEW, ProjectStatus::PENDING, ProjectStatus::FAILED, ProjectStatus::DONE];

        return [
            'title' => fake()->lexify('???? ???'),
            'description' => fake()->lexify('??????? ??????????? ????????????? ??????'),
            'status' => $status_array[array_rand($status_array)],
            'start_date' => date('Y-m-d', strtotime( '+'.mt_rand(1,2).' months')),
            'end_date' => date('Y-m-d', strtotime( '+'.mt_rand(5,7).' months')),
            'project_id' => rand(1,10),
        ];
    }
}
