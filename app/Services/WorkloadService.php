<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Support\Collection;

class WorkloadService
{
    /**
     * Calculate global workload metrics across enterprise members.
     *
     * @return array{
     *     totalMembers: int,
     *     multiProjectMembersCount: int,
     *     averageAllocation: int,
     *     overloadedMembers: Collection<int, Member>
     * }
     */
    public function getWorkloadSummary(): array
    {
        $members = Member::with(['projects'])->get();
        $totalMembers = $members->count();

        $multiProjectMembersCount = $members->filter(fn (Member $m) => $m->projects->count() >= 2)->count();

        $totalAllocationSum = $members->sum(fn (Member $m) => $m->total_allocation);
        $averageAllocation = $totalMembers > 0 ? (int) round($totalAllocationSum / $totalMembers) : 0;

        $overloadedMembers = $members->filter(fn (Member $m) => $m->total_allocation > 100);

        return [
            'totalMembers' => $totalMembers,
            'multiProjectMembersCount' => $multiProjectMembersCount,
            'averageAllocation' => $averageAllocation,
            'overloadedMembers' => $overloadedMembers,
        ];
    }

    /**
     * Calculate total workload allocation for a specific member.
     */
    public function getMemberAllocation(Member $member): int
    {
        return (int) $member->projects()->sum('allocation_percent');
    }

    /**
     * Check if a member exceeds 100% capacity.
     */
    public function isMemberOverallocated(Member $member): bool
    {
        return $this->getMemberAllocation($member) > 100;
    }
}
