<?php

namespace App\Actions;

use App\DTOs\AssignProjectData;
use App\Events\MemberAssignedToProject;
use App\Events\MemberWorkloadExceeded;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class AssignMemberToProjectAction
{
    /**
     * Execute the atomic assignment of a member to a project.
     */
    public function handle(Member $member, Project $project, AssignProjectData $data): void
    {
        DB::transaction(function () use ($member, $project, $data) {
            $member->projects()->syncWithoutDetaching([
                $project->id => [
                    'role_in_project' => $data->roleInProject,
                    'allocation_percent' => $data->allocationPercent,
                    'assigned_at' => $data->assignedAt ?? now()->toDateString(),
                ],
            ]);

            event(new MemberAssignedToProject(
                member: $member,
                project: $project,
                roleInProject: $data->roleInProject,
                allocationPercent: $data->allocationPercent,
            ));

            $totalAllocation = (int) $member->projects()->sum('allocation_percent');
            if ($totalAllocation > 100) {
                event(new MemberWorkloadExceeded(
                    member: $member,
                    totalAllocation: $totalAllocation,
                ));
            }
        });
    }
}
