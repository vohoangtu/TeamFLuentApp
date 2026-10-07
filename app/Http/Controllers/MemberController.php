<?php

namespace App\Http\Controllers;

use App\Actions\AssignMemberToProjectAction;
use App\Actions\CreateMemberAction;
use App\Actions\UnassignMemberFromProjectAction;
use App\Actions\UpdateMemberAction;
use App\Http\Requests\AssignProjectRequest;
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
    public function __construct(
        private readonly CreateMemberAction $createMemberAction,
        private readonly UpdateMemberAction $updateMemberAction,
        private readonly AssignMemberToProjectAction $assignProjectAction,
        private readonly UnassignMemberFromProjectAction $unassignProjectAction,
    ) {}

    /**
     * Display a listing of members with search and multi-criteria filters.
     */
    public function index(Request $request): View
    {
        $query = Member::query()->with(['team', 'role', 'projects']);

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

        $members = $query->latest('id')->paginate(12)->withQueryString();

        $teams = Team::query()->orderBy('name')->get();
        $roles = Role::query()->orderBy('name')->get();
        $projects = Project::query()->orderBy('name')->get();

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
        $teams = Team::query()->orderBy('name')->get();
        $roles = Role::query()->orderBy('name')->get();
        $projects = Project::query()->orderBy('name')->get();

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
        $member = $this->createMemberAction->handle($request->toDto());

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
        $availableProjects = Project::query()
            ->whereNotIn('id', $assignedProjectIds)
            ->orderBy('name')
            ->get();

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
        $teams = Team::query()->orderBy('name')->get();
        $roles = Role::query()->orderBy('name')->get();

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
        $updatedMember = $this->updateMemberAction->handle($member, $request->toDto());

        return redirect()->route('members.show', $updatedMember)
            ->with('success', 'Thông tin thành viên '.$updatedMember->name.' đã được cập nhật!');
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
    public function assignProject(AssignProjectRequest $request, Member $member): RedirectResponse
    {
        $project = Project::findOrFail($request->validated('project_id'));

        $this->assignProjectAction->handle(
            member: $member,
            project: $project,
            data: $request->toDto($project->id),
        );

        return redirect()->route('members.show', $member)
            ->with('success', 'Đã phân công dự án mới cho thành viên '.$member->name.'!');
    }

    /**
     * Unassign a project from this member.
     */
    public function unassignProject(Member $member, Project $project): RedirectResponse
    {
        $this->unassignProjectAction->handle($member, $project);

        return redirect()->route('members.show', $member)
            ->with('success', 'Đã gỡ dự án '.$project->name.' khỏi thành viên '.$member->name.'.');
    }
}
