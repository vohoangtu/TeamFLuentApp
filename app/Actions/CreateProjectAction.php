<?php

namespace App\Actions;

use App\DTOs\ProjectData;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateProjectAction
{
    /**
     * Execute atomic creation of an enterprise project.
     */
    public function handle(ProjectData $data): Project
    {
        return DB::transaction(function () use ($data) {
            $slug = Str::slug($data->name).'-'.Str::lower($data->code);

            return Project::create([
                'name' => $data->name,
                'slug' => $slug,
                'code' => Str::upper($data->code),
                'description' => $data->description,
                'status' => $data->status,
                'priority' => $data->priority,
                'progress' => $data->progress,
                'color' => $data->color ?? 'from-purple-500 via-indigo-600 to-cyan-400',
                'start_date' => $data->startDate,
                'due_date' => $data->dueDate,
                'budget' => $data->budget,
            ]);
        });
    }
}
