<?php

namespace App\Actions;

use App\DTOs\ProjectData;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateProjectAction
{
    /**
     * Execute atomic update of project data.
     */
    public function handle(Project $project, ProjectData $data): Project
    {
        return DB::transaction(function () use ($project, $data) {
            $project->update([
                'name' => $data->name,
                'code' => Str::upper($data->code),
                'description' => $data->description,
                'status' => $data->status,
                'priority' => $data->priority,
                'progress' => $data->progress,
                'color' => $data->color ?? $project->color,
                'start_date' => $data->startDate,
                'due_date' => $data->dueDate,
                'budget' => $data->budget,
            ]);

            return $project->fresh();
        });
    }
}
