<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Fluent 2 Mica Ultra colorful dashboard.
     */
    public function index(): View
    {
        $totalMembers = Member::count();
        $totalTeams = Team::count();
        $totalProjects = Project::count();

        $activeProjects = Project::with(['members.role'])
            ->whereIn('status', ['in_progress', 'review', 'planning'])
            ->orderByRaw("CASE priority WHEN 'urgent' THEN 1 WHEN 'high' THEN 2 WHEN 'medium' THEN 3 ELSE 4 END")
            ->take(5)
            ->get();

        $multiProjectMembersCount = Member::has('projects', '>=', 2)->count();

        $members = Member::with(['team', 'role', 'projects'])->get();
        $totalAllocationSum = $members->sum(fn (Member $m) => $m->total_allocation);
        $averageAllocation = $totalMembers > 0 ? (int) round($totalAllocationSum / $totalMembers) : 0;

        $overloadedMembers = $members->filter(fn (Member $m) => $m->total_allocation > 100);

        $roles = Role::withCount('members')->get();
        $teams = Team::with(['lead'])->withCount('members')->get();

        $recentAssignments = Member::with(['projects' => function ($q) {
            $q->latest('project_members.created_at')->take(1);
        }, 'team', 'role'])
            ->has('projects')
            ->latest('updated_at')
            ->take(6)
            ->get();

        return view('dashboard', [
            'totalMembers' => $totalMembers,
            'totalTeams' => $totalTeams,
            'totalProjects' => $totalProjects,
            'activeProjects' => $activeProjects,
            'multiProjectMembersCount' => $multiProjectMembersCount,
            'averageAllocation' => $averageAllocation,
            'overloadedMembers' => $overloadedMembers,
            'roles' => $roles,
            'teams' => $teams,
            'recentAssignments' => $recentAssignments,
        ]);
    }
}
