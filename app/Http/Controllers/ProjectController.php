<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(Request $request): View
    {
        $query = Project::with(['members.role', 'members.team']);

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
            ->latest()
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
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']).'-'.Str::lower($validated['code']);

        $project = Project::create($validated);

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
        $availableMembers = Member::with(['role', 'team'])
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
        $validated = $request->validated();
        $project->update($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Thông tin dự án '.$project->name.' đã được cập nhật!');
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
    public function assignMember(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'role_in_project' => ['required', 'string', 'max:100'],
            'allocation_percent' => ['required', 'integer', 'min:5', 'max:100'],
        ]);

        $project->members()->syncWithoutDetaching([
            $validated['member_id'] => [
                'role_in_project' => $validated['role_in_project'],
                'allocation_percent' => $validated['allocation_percent'],
                'assigned_at' => now()->toDateString(),
            ],
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Đã bổ nhiệm thành viên vào dự án!');
    }

    /**
     * Remove a member from this project.
     */
    public function removeMember(Project $project, Member $member): RedirectResponse
    {
        $project->members()->detach($member->id);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Đã rút thành viên '.$member->name.' khỏi dự án.');
    }
}
