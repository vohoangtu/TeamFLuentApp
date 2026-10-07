<?php

namespace App\Actions;

use App\DTOs\TeamData;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTeamAction
{
    /**
     * Execute atomic creation of an enterprise team.
     */
    public function handle(TeamData $data): Team
    {
        return DB::transaction(function () use ($data) {
            $slug = Str::slug($data->name);

            $team = Team::create([
                'name' => $data->name,
                'slug' => $slug,
                'code' => Str::upper($data->code),
                'description' => $data->description,
                'color' => $data->color ?? 'from-blue-600 via-indigo-600 to-cyan-500',
                'lead_id' => $data->leadId,
            ]);

            if ($data->leadId) {
                Member::where('id', $data->leadId)->update([
                    'team_id' => $team->id,
                    'is_team_lead' => true,
                ]);
            }

            return $team;
        });
    }
}
