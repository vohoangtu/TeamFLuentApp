<?php

namespace App\Events;

use App\Models\Member;
use App\Models\Project;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberAssignedToProject
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Member $member,
        public Project $project,
        public string $roleInProject,
        public int $allocationPercent,
    ) {}
}
