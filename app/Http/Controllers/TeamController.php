<?php

namespace App\Http\Controllers;

use App\Actions\CreateTeamAction;
use App\Actions\UpdateTeamAction;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TeamController extends Controller
{
    public function __construct(
        private readonly CreateTeamAction $createTeamAction,
        private readonly UpdateTeamAction $updateTeamAction,
    ) {}

    /**
     * Display a listing of teams.
     */
    public function index(): View
    {
        $teams = Team::query()
            ->with(['lead.role', 'members.role', 'members.projects'])
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
        $potentialLeads = Member::query()->with(['role', 'team', 'projects'])->where('status', 'active')->orderBy('name')->get();

        return view('teams.create', [
            'potentialLeads' => $potentialLeads,
        ]);
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(StoreTeamRequest $request): RedirectResponse
    {
        $team = $this->createTeamAction->handle($request->toDto());

        return redirect()->route('teams.show', $team)
            ->with('success', 'Nhóm '.$team->name.' đã được thành lập thành công!');
    }

    /**
     * Display the specified team.
     */
    public function show(Team $team): View
    {
        $team->load(['lead.role', 'members.role', 'members.projects']);

        return view('teams.show', [
            'team' => $team,
        ]);
    }

    /**
     * Show the form for editing the specified team.
     */
    public function edit(Team $team): View
    {
        $potentialLeads = Member::query()->with(['role', 'team', 'projects'])
            ->where('team_id', $team->id)
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
        $updatedTeam = $this->updateTeamAction->handle($team, $request->toDto());

        return redirect()->route('teams.show', $updatedTeam)
            ->with('success', 'Thông tin nhóm '.$updatedTeam->name.' đã được cập nhật!');
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
