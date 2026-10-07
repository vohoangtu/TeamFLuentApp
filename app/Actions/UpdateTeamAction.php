<?php

namespace App\Actions;

use App\DTOs\TeamData;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateTeamAction
{
    /**
     * Execute atomic update of team data and leadership.
     */
    public function handle(Team $team, TeamData $data): Team
    {
        return DB::transaction(function () use ($team, $data) {
            $oldLeadId = $team->lead_id;

            $team->update([
                'name' => $data->name,
                'code' => Str::upper($data->code),
                'description' => $data->description,
                'color' => $data->color ?? $team->color,
                'lead_id' => $data->leadId,
            ]);

            if ($oldLeadId && $oldLeadId !== $data->leadId) {
                Member::where('id', $oldLeadId)->update(['is_team_lead' => false]);
            }

            if ($data->leadId) {
                Member::where('id', $data->leadId)->update([
                    'team_id' => $team->id,
                    'is_team_lead' => true,
                ]);
            }

            return $team->fresh();
        });
    }
}
