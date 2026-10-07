<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    /**
     * Display a listing of teams.
     */
    public function index(): View
    {
        $teams = Team::with(['lead', 'members.role', 'members.projects'])
            ->withCount('members')
            ->orderBy('name')
            ->get();

        return view('teams.index', [
            'teams' => $teams,
        ]);
    }

    /**
     * Show the form for creating a new team.
     */
    public function create(): View
    {
        $potentialLeads = Member::where('status', 'active')->orderBy('name')->get();

        return view('teams.create', [
            'potentialLeads' => $potentialLeads,
        ]);
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(StoreTeamRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        $team = Team::create($validated);

        if (! empty($validated['lead_id'])) {
            Member::where('id', $validated['lead_id'])->update(['team_id' => $team->id, 'is_team_lead' => true]);
        }

        return redirect()->route('teams.show', $team)
            ->with('success', 'Nhóm '.$team->name.' đã được thành lập thành công!');
    }

    /**
     * Display the specified team.
     */
    public function show(Team $team): View
    {
        $team->load(['lead', 'members.role', 'members.projects']);

        return view('teams.show', [
            'team' => $team,
        ]);
    }

    /**
     * Show the form for editing the specified team.
     */
    public function edit(Team $team): View
    {
        $potentialLeads = Member::where('team_id', $team->id)
            ->orWhere('id', $team->lead_id)
            ->orderBy('name')
            ->get();

        return view('teams.edit', [
            'team' => $team,
            'potentialLeads' => $potentialLeads,
        ]);
    }

    /**
     * Update the specified team in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team): RedirectResponse
    {
        $validated = $request->validated();

        $oldLeadId = $team->lead_id;
        $team->update($validated);

        if ($oldLeadId && $oldLeadId !== ($validated['lead_id'] ?? null)) {
            Member::where('id', $oldLeadId)->update(['is_team_lead' => false]);
        }

        if (! empty($validated['lead_id'])) {
            Member::where('id', $validated['lead_id'])->update(['is_team_lead' => true]);
        }

        return redirect()->route('teams.show', $team)
            ->with('success', 'Thông tin nhóm '.$team->name.' đã được cập nhật!');
    }

    /**
     * Remove the specified team from storage.
     */
    public function destroy(Team $team): RedirectResponse
    {
        $name = $team->name;
        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Đã giải thể nhóm '.$name.'.');
    }
}
