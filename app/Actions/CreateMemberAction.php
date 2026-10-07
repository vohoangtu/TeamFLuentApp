<?php

namespace App\Actions;

use App\DTOs\AssignProjectData;
use App\DTOs\MemberData;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class CreateMemberAction
{
    public function __construct(
        private readonly AssignMemberToProjectAction $assignAction,
    ) {}

    /**
     * Execute atomic creation of a member with optional initial project assignments.
     */
    public function handle(MemberData $data): Member
    {
        return DB::transaction(function () use ($data) {
            $member = Member::create([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'avatar_url' => $data->avatarUrl,
                'team_id' => $data->teamId,
                'role_id' => $data->roleId,
                'is_team_lead' => $data->isTeamLead,
                'status' => $data->status,
                'bio' => $data->bio,
                'joined_at' => $data->joinedAt ?? now()->toDateString(),
            ]);

            if (! empty($data->projectIds)) {
                $roleInProject = $data->projectRole ?? 'Contributor';
                $allocation = $data->allocationPercent ?? 50;

                $projects = Project::whereIn('id', $data->projectIds)->get();
                foreach ($projects as $project) {
                    $this->assignAction->handle(
                        member: $member,
                        project: $project,
                        data: new AssignProjectData(
                            projectId: $project->id,
                            roleInProject: $roleInProject,
                            allocationPercent: $allocation,
                            assignedAt: now()->toDateString(),
                        ),
                    );
                }
            }

            return $member;
        });
    }
}
