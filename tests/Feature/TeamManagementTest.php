<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Project;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Role $adminRole;

    protected Role $developerRole;

    protected Team $engineeringTeam;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminRole = Role::create([
            'name' => 'Admin Lead',
            'slug' => 'admin-lead',
            'badge_color' => 'purple',
            'permissions' => ['all'],
        ]);

        $this->developerRole = Role::create([
            'name' => 'Senior Developer',
            'slug' => 'senior-dev',
            'badge_color' => 'emerald',
            'permissions' => ['commit_code'],
        ]);

        $this->engineeringTeam = Team::create([
            'name' => 'Core Engineering',
            'slug' => 'core-engineering',
            'code' => 'CORE',
            'description' => 'Core team',
            'color' => 'from-blue-600 to-indigo-600',
        ]);
    }

    public function test_dashboard_page_loads_and_displays_kpis(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('TeamNexus');
        $response->assertSee('Tổng thành viên');
        $response->assertSee('Phụ trách đa dự án');
    }

    public function test_member_can_be_assigned_to_multiple_projects(): void
    {
        $member = Member::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'a.nguyen@test.internal',
            'team_id' => $this->engineeringTeam->id,
            'role_id' => $this->developerRole->id,
            'status' => 'active',
        ]);

        $project1 = Project::create([
            'name' => 'Dự án Alpha AI',
            'slug' => 'du-an-alpha-ai',
            'code' => 'PRJ-A1',
            'status' => 'in_progress',
            'priority' => 'urgent',
            'progress' => 50,
        ]);

        $project2 = Project::create([
            'name' => 'Dự án Beta Cloud',
            'slug' => 'du-an-beta-cloud',
            'code' => 'PRJ-B2',
            'status' => 'in_progress',
            'priority' => 'high',
            'progress' => 30,
        ]);

        // Assign to project 1
        $this->post(route('members.projects.store', $member), [
            'project_id' => $project1->id,
            'role_in_project' => 'Lead Architect',
            'allocation_percent' => 50,
        ])->assertRedirect(route('members.show', $member));

        // Assign to project 2
        $this->post(route('members.projects.store', $member), [
            'project_id' => $project2->id,
            'role_in_project' => 'Backend Contributor',
            'allocation_percent' => 30,
        ])->assertRedirect(route('members.show', $member));

        $member->refresh();

        $this->assertCount(2, $member->projects);
        $this->assertEquals(80, $member->total_allocation);

        // Check show page displays both projects
        $response = $this->get(route('members.show', $member));
        $response->assertStatus(200);
        $response->assertSee('Dự án Alpha AI');
        $response->assertSee('Lead Architect');
        $response->assertSee('Dự án Beta Cloud');
        $response->assertSee('Backend Contributor');
    }

    public function test_can_create_member_via_web_form_with_initial_projects(): void
    {
        $project = Project::create([
            'name' => 'Mobile App Pro',
            'slug' => 'mobile-app-pro',
            'code' => 'PRJ-M1',
            'status' => 'planning',
            'priority' => 'medium',
            'progress' => 10,
        ]);

        $response = $this->post(route('members.store'), [
            'name' => 'Lê Thị Thu',
            'email' => 'thu.le@test.internal',
            'phone' => '0912345678',
            'team_id' => $this->engineeringTeam->id,
            'role_id' => $this->developerRole->id,
            'status' => 'active',
            'project_ids' => [$project->id],
            'project_role' => 'Principal Engineer',
            'allocation_percent' => 60,
        ]);

        $member = Member::where('email', 'thu.le@test.internal')->first();
        $this->assertNotNull($member);

        $response->assertRedirect(route('members.show', $member));
        $this->assertCount(1, $member->projects);
        $this->assertEquals('Principal Engineer', $member->projects->first()->pivot->role_in_project);
    }

    public function test_can_unassign_member_from_project(): void
    {
        $member = Member::create([
            'name' => 'Trần Văn C',
            'email' => 'c.tran@test.internal',
            'team_id' => $this->engineeringTeam->id,
            'role_id' => $this->developerRole->id,
            'status' => 'active',
        ]);

        $project = Project::create([
            'name' => 'Data Lake v1',
            'slug' => 'data-lake-v1',
            'code' => 'PRJ-D1',
            'status' => 'in_progress',
            'priority' => 'high',
            'progress' => 40,
        ]);

        $member->projects()->attach($project->id, [
            'role_in_project' => 'Developer',
            'allocation_percent' => 50,
        ]);

        $this->assertCount(1, $member->projects);

        $this->delete(route('members.projects.destroy', [$member, $project]))
            ->assertRedirect(route('members.show', $member));

        $member->refresh();
        $this->assertCount(0, $member->projects);
    }

    public function test_projects_and_teams_and_roles_index_pages_render(): void
    {
        $this->get(route('projects.index'))->assertStatus(200);
        $this->get(route('teams.index'))->assertStatus(200);
        $this->get(route('roles.index'))->assertStatus(200);
    }
}
