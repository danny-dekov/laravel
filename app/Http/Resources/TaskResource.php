<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'start_date' => date_format($this->start_date,'Y-m-d'),
            'end_Date' => date_format($this->end_date,'Y-m-d'),
            'project' => $this->project->title,
        ];
    }
}
