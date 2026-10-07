<?php

namespace App\Http\Controllers;

use App\Actions\AssignMemberToProjectAction;
use App\Actions\CreateProjectAction;
use App\Actions\UnassignMemberFromProjectAction;
use App\Actions\UpdateProjectAction;
use App\Http\Requests\AssignProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        private readonly CreateProjectAction $createProjectAction,
        private readonly UpdateProjectAction $updateProjectAction,
        private readonly AssignMemberToProjectAction $assignProjectAction,
        private readonly UnassignMemberFromProjectAction $unassignProjectAction,
    ) {}

    /**
     * Display a listing of projects.
     */
    public function index(Request $request): View
    {
        $query = Project::query()->with(['members.role', 'members.team']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($priority = $request->input('priority')) {
            $query->where('priority', $priority);
        }

        $projects = $query->orderByRaw("CASE priority WHEN 'urgent' THEN 1 WHEN 'high' THEN 2 WHEN 'medium' THEN 3 ELSE 4 END")
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = $this->createProjectAction->handle($request->toDto());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Dự án '.$project->name.' đã được khởi tạo!');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        $project->load(['members.role', 'members.team']);

        $assignedMemberIds = $project->members->pluck('id')->all();
        $availableMembers = Member::query()->with(['role', 'team'])
            ->whereNotIn('id', $assignedMemberIds)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('projects.show', [
            'project' => $project,
            'availableMembers' => $availableMembers,
        ]);
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        return view('projects.edit', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $updatedProject = $this->updateProjectAction->handle($project, $request->toDto());

        return redirect()->route('projects.show', $updatedProject)
            ->with('success', 'Thông tin dự án '.$updatedProject->name.' đã được cập nhật!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $name = $project->name;
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Đã xóa dự án '.$name.'.');
    }

    /**
     * Assign a member to this project.
     */
    public function assignMember(AssignProjectRequest $request, Project $project): RedirectResponse
    {
        $member = Member::findOrFail($request->validated('member_id'));

        $this->assignProjectAction->handle(
            member: $member,
            project: $project,
            data: $request->toDto($project->id),
        );

        return redirect()->route('projects.show', $project)
            ->with('success', 'Đã bổ nhiệm thành viên vào dự án!');
    }

    /**
     * Remove a member from this project.
     */
    public function removeMember(Project $project, Member $member): RedirectResponse
    {
        $this->unassignProjectAction->handle($member, $project);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Đã rút thành viên '.$member->name.' khỏi dự án.');
    }
}
