<?php

namespace App\Listeners;

use App\Events\MemberAssignedToProject;
use App\Events\MemberUnassignedFromProject;
use App\Events\MemberWorkloadExceeded;
use Illuminate\Support\Facades\Log;

class LogProjectAssignmentActivity
{
    /**
     * Handle member assigned event.
     */
    public function handleAssignment(MemberAssignedToProject $event): void
    {
        Log::info('Enterprise Audit: Member assigned to project', [
            'member_id' => $event->member->id,
            'member_name' => $event->member->name,
            'project_id' => $event->project->id,
            'project_code' => $event->project->code,
            'role_in_project' => $event->roleInProject,
            'allocation_percent' => $event->allocationPercent,
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * Handle member unassigned event.
     */
    public function handleUnassignment(MemberUnassignedFromProject $event): void
    {
        Log::info('Enterprise Audit: Member removed from project', [
            'member_id' => $event->member->id,
            'member_name' => $event->member->name,
            'project_id' => $event->project->id,
            'project_code' => $event->project->code,
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * Handle member workload exceeded event.
     */
    public function handleOverallocation(MemberWorkloadExceeded $event): void
    {
        Log::warning('Enterprise Alert: Member workload capacity exceeded (>100%)', [
            'member_id' => $event->member->id,
            'member_name' => $event->member->name,
            'total_allocation' => $event->totalAllocation,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
