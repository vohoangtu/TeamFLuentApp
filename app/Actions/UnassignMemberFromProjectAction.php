<?php

namespace App\Actions;

use App\Events\MemberUnassignedFromProject;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class UnassignMemberFromProjectAction
{
    /**
     * Execute the atomic removal of a member from a project.
     */
    public function handle(Member $member, Project $project): void
    {
        DB::transaction(function () use ($member, $project) {
            $member->projects()->detach($project->id);

            event(new MemberUnassignedFromProject(
                member: $member,
                project: $project,
            ));
        });
    }
}
