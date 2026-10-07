<?php

namespace App\Events;

use App\Models\Member;
use App\Models\Project;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberUnassignedFromProject
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Member $member,
        public Project $project,
    ) {}
}
