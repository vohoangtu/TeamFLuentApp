<?php

namespace App\Actions;

use App\DTOs\MemberData;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class UpdateMemberAction
{
    /**
     * Execute atomic update of member profile.
     */
    public function handle(Member $member, MemberData $data): Member
    {
        return DB::transaction(function () use ($member, $data) {
            $member->update([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'avatar_url' => $data->avatarUrl,
                'team_id' => $data->teamId,
                'role_id' => $data->roleId,
                'is_team_lead' => $data->isTeamLead,
                'status' => $data->status,
                'bio' => $data->bio,
                'joined_at' => $data->joinedAt ?? $member->joined_at,
            ]);

            return $member->fresh();
        });
    }
}
