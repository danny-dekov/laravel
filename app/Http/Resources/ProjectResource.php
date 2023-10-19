<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'start_date' => date_format($this->start_date,'Y-m-d'),
            'end_Date' => date_format($this->end_date,'Y-m-d'),
        ];

        if(!empty($this->client_id)) {
            $response['client'] = $this->client->name();
        }

        if(!empty($this->company_id)) {
            $response['company'] = $this->company->name;
        }

        $tasks = [];
        foreach ($this->tasks as $task) {
            $tasks[] = new TaskResource($task);
        }
        $response['tasks'] = $tasks;

        return $response;
    }
}
