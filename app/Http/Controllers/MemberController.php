<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use App\Models\Project;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of members with search and multi-criteria filters.
     */
    public function index(Request $request): View
    {
        $query = Member::with(['team', 'role', 'projects']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($teamId = $request->input('team_id')) {
            $query->where('team_id', $teamId);
        }

        if ($roleId = $request->input('role_id')) {
            $query->where('role_id', $roleId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($projectId = $request->input('project_id')) {
            $query->whereHas('projects', function ($q) use ($projectId) {
                $q->where('projects.id', $projectId);
            });
        }

        if ($request->boolean('multi_project')) {
            $query->has('projects', '>=', 2);
        }

        $members = $query->latest()->paginate(12)->withQueryString();

        $teams = Team::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();

        return view('members.index', [
            'members' => $members,
            'teams' => $teams,
            'roles' => $roles,
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new member.
     */
    public function create(): View
    {
        $teams = Team::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();

        return view('members.create', [
            'teams' => $teams,
            'roles' => $roles,
            'projects' => $projects,
        ]);
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(StoreMemberRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $member = Member::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'avatar_url' => $validated['avatar_url'] ?? null,
            'team_id' => $validated['team_id'],
            'role_id' => $validated['role_id'],
            'is_team_lead' => $request->boolean('is_team_lead'),
            'status' => $validated['status'],
            'bio' => $validated['bio'] ?? null,
            'joined_at' => $validated['joined_at'] ?? now()->toDateString(),
        ]);

        if (! empty($validated['project_ids'])) {
            $roleInProject = $validated['project_role'] ?? 'Contributor';
            $allocationPercent = $validated['allocation_percent'] ?? 50;

            foreach ($validated['project_ids'] as $projectId) {
                $member->projects()->attach($projectId, [
                    'role_in_project' => $roleInProject,
                    'allocation_percent' => $allocationPercent,
                    'assigned_at' => now()->toDateString(),
                ]);
            }
        }

        return redirect()->route('members.show', $member)
            ->with('success', 'Thành viên '.$member->name.' đã được tạo thành công!');
    }

    /**
     * Display the specified member.
     */
    public function show(Member $member): View
    {
        $member->load(['team', 'role', 'projects']);

        $assignedProjectIds = $member->projects->pluck('id')->all();
        $availableProjects = Project::whereNotIn('id', $assignedProjectIds)->orderBy('name')->get();

        return view('members.show', [
            'member' => $member,
            'availableProjects' => $availableProjects,
        ]);
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(Member $member): View
    {
        $teams = Team::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('members.edit', [
            'member' => $member,
            'teams' => $teams,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified member in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_team_lead'] = $request->boolean('is_team_lead');

        $member->update($validated);

        return redirect()->route('members.show', $member)
            ->with('success', 'Thông tin thành viên '.$member->name.' đã được cập nhật!');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(Member $member): RedirectResponse
    {
        $name = $member->name;
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Đã xóa thành viên '.$name.' khỏi hệ thống.');
    }

    /**
     * Assign an additional project to this member.
     */
    public function assignProject(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'role_in_project' => ['required', 'string', 'max:100'],
            'allocation_percent' => ['required', 'integer', 'min:5', 'max:100'],
        ]);

        $member->projects()->syncWithoutDetaching([
            $validated['project_id'] => [
                'role_in_project' => $validated['role_in_project'],
                'allocation_percent' => $validated['allocation_percent'],
                'assigned_at' => now()->toDateString(),
            ],
        ]);

        return redirect()->route('members.show', $member)
            ->with('success', 'Đã phân công dự án mới cho thành viên '.$member->name.'!');
    }

    /**
     * Unassign a project from this member.
     */
    public function unassignProject(Member $member, Project $project): RedirectResponse
    {
        $member->projects()->detach($project->id);

        return redirect()->route('members.show', $member)
            ->with('success', 'Đã gỡ dự án '.$project->name.' khỏi thành viên '.$member->name.'.');
    }
}
