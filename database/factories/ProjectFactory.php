<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client_array = [null, 1,2,3];
        $company_array =  [1,2,3];
        $status_array = [ProjectStatus::NEW, ProjectStatus::PENDING, ProjectStatus::FAILED, ProjectStatus::DONE];

        $randomClient = $client_array[array_rand($client_array)];
        $randomCompany = null;
        if($randomClient === null) {
            $randomCompany = $company_array[array_rand($company_array)];
        }

        return [
            'title' => fake()->lexify('???? ???'),
            'description' => fake()->lexify('??????? ??????????? ????????????? ??????'),
            'status' => $status_array[array_rand($status_array)],
            'start_date' => date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days')),
            'end_date' => date('Y-m-d', strtotime( '+'.mt_rand(8,9).' months')),
            'client_id' => $randomClient,
            'company_id' => $randomCompany
        ];
    }
}
