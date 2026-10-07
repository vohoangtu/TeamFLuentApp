<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\Role;
use App\Models\Team;
use App\Services\WorkloadService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly WorkloadService $workloadService,
    ) {}

    /**
     * Display the Fluent 2 Mica Ultra colorful dashboard.
     */
    public function index(): View
    {
        $workloadSummary = $this->workloadService->getWorkloadSummary();

        $activeProjects = Project::query()
            ->with(['members.role'])
            ->whereIn('status', ['in_progress', 'review', 'planning'])
            ->orderByRaw("CASE priority WHEN 'urgent' THEN 1 WHEN 'high' THEN 2 WHEN 'medium' THEN 3 ELSE 4 END")
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $roles = Role::query()->withCount('members')->orderBy('id')->get();
        $teams = Team::query()->with(['lead'])->withCount('members')->orderBy('name')->get();

        $recentAssignments = Member::query()
            ->with([
                'projects' => fn ($q) => $q->latest('project_members.created_at')->take(1),
                'team',
                'role',
            ])
            ->has('projects')
            ->latest('updated_at')
            ->take(6)
            ->get();

        return view('dashboard', [
            'totalMembers' => $workloadSummary['totalMembers'],
            'totalTeams' => $teams->count(),
            'totalProjects' => Project::count(),
            'activeProjects' => $activeProjects,
            'multiProjectMembersCount' => $workloadSummary['multiProjectMembersCount'],
            'averageAllocation' => $workloadSummary['averageAllocation'],
            'overloadedMembers' => $workloadSummary['overloadedMembers'],
            'roles' => $roles,
            'teams' => $teams,
            'recentAssignments' => $recentAssignments,
        ]);
    }
}
