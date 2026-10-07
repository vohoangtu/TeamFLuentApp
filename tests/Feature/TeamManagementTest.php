<?php

namespace Tests\Feature;

use App\Actions\AssignMemberToProjectAction;
use App\DTOs\AssignProjectData;
use App\Enums\MemberStatus;
use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;
use App\Events\MemberAssignedToProject;
use App\Events\MemberWorkloadExceeded;
use App\Models\Member;
use App\Models\Project;
use App\Models\Role;
use App\Models\Team;
use App\Services\WorkloadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
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
            'status' => MemberStatus::Active,
        ]);

        $project1 = Project::create([
            'name' => 'Dự án Alpha AI',
            'slug' => 'du-an-alpha-ai',
            'code' => 'PRJ-A1',
            'status' => ProjectStatus::InProgress,
            'priority' => ProjectPriority::Urgent,
            'progress' => 50,
        ]);

        $project2 = Project::create([
            'name' => 'Dự án Beta Cloud',
            'slug' => 'du-an-beta-cloud',
            'code' => 'PRJ-B2',
            'status' => ProjectStatus::InProgress,
            'priority' => ProjectPriority::High,
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
            'status' => ProjectStatus::Planning,
            'priority' => ProjectPriority::Medium,
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
            'status' => MemberStatus::Active,
        ]);

        $project = Project::create([
            'name' => 'Data Lake v1',
            'slug' => 'data-lake-v1',
            'code' => 'PRJ-D1',
            'status' => ProjectStatus::InProgress,
            'priority' => ProjectPriority::High,
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

    public function test_assign_action_dispatches_events_and_detects_overload(): void
    {
        Event::fake([MemberAssignedToProject::class, MemberWorkloadExceeded::class]);

        $member = Member::create([
            'name' => 'Phạm Văn D',
            'email' => 'd.pham@test.internal',
            'team_id' => $this->engineeringTeam->id,
            'role_id' => $this->developerRole->id,
            'status' => MemberStatus::Active,
        ]);

        $project1 = Project::create([
            'name' => 'Project 101',
            'slug' => 'prj-101',
            'code' => 'PRJ-101',
            'status' => ProjectStatus::InProgress,
            'priority' => ProjectPriority::High,
            'progress' => 20,
        ]);

        $project2 = Project::create([
            'name' => 'Project 102',
            'slug' => 'prj-102',
            'code' => 'PRJ-102',
            'status' => ProjectStatus::InProgress,
            'priority' => ProjectPriority::High,
            'progress' => 20,
        ]);

        $action = app(AssignMemberToProjectAction::class);

        // Assign 70%
        $action->handle($member, $project1, new AssignProjectData($project1->id, 'Lead', 70));
        Event::assertDispatched(MemberAssignedToProject::class);
        Event::assertNotDispatched(MemberWorkloadExceeded::class);

        // Assign additional 50% (total 120% => exceeds 100%)
        $action->handle($member, $project2, new AssignProjectData($project2->id, 'Architect', 50));
        Event::assertDispatched(MemberWorkloadExceeded::class);
    }

    public function test_workload_service_metrics(): void
    {
        $member = Member::create([
            'name' => 'Hoàng Văn E',
            'email' => 'e.hoang@test.internal',
            'team_id' => $this->engineeringTeam->id,
            'role_id' => $this->developerRole->id,
            'status' => MemberStatus::Active,
        ]);

        $service = app(WorkloadService::class);
        $summary = $service->getWorkloadSummary();

        $this->assertArrayHasKey('totalMembers', $summary);
        $this->assertArrayHasKey('averageAllocation', $summary);
        $this->assertArrayHasKey('multiProjectMembersCount', $summary);
        $this->assertArrayHasKey('overloadedMembers', $summary);
    }

    public function test_projects_and_teams_and_roles_index_pages_render(): void
    {
        $this->get(route('projects.index'))->assertStatus(200);
        $this->get(route('teams.index'))->assertStatus(200);
        $this->get(route('roles.index'))->assertStatus(200);

        $response = $this->get(route('themes.index'))->assertStatus(200);
        $response->assertSee('Fluent 2 MICA Light');
        $response->assertSee('Dracula');
        $response->assertSee('GitHub Dark');
        $response->assertSee('One Dark Pro');
    }

    public function test_all_create_edit_and_show_pages_render_successfully(): void
    {
        $member = Member::create([
            'name' => 'Vũ Thị F',
            'email' => 'f.vu@test.internal',
            'team_id' => $this->engineeringTeam->id,
            'role_id' => $this->developerRole->id,
            'status' => MemberStatus::Active,
        ]);

        $project = Project::create([
            'name' => 'Project X',
            'slug' => 'project-x',
            'code' => 'PRJ-X',
            'status' => ProjectStatus::InProgress,
            'priority' => ProjectPriority::High,
            'progress' => 15,
        ]);

        $project2 = Project::create([
            'name' => 'Project Y',
            'slug' => 'project-y',
            'code' => 'PRJ-Y',
            'status' => ProjectStatus::Planning,
            'priority' => ProjectPriority::Medium,
            'progress' => 0,
        ]);

        $project->members()->attach($member->id, [
            'role_in_project' => 'Lead Engineer',
            'allocation_percent' => 50,
        ]);

        $project2->members()->attach($member->id, [
            'role_in_project' => 'Consultant',
            'allocation_percent' => 30,
        ]);

        $this->get(route('members.create'))->assertStatus(200);
        $this->get(route('members.edit', $member))->assertStatus(200);
        $this->get(route('members.show', $member))->assertStatus(200);

        $this->get(route('projects.create'))->assertStatus(200);
        $this->get(route('projects.edit', $project))->assertStatus(200);
        $response = $this->get(route('projects.show', $project))->assertStatus(200);
        $response->assertSee('Lead Engineer');
        $response->assertSee('50% Workload');
        $response->assertSee('Tổng tải: 80%');

        $this->get(route('teams.create'))->assertStatus(200);
        $this->get(route('teams.edit', $this->engineeringTeam))->assertStatus(200);
        $this->get(route('teams.show', $this->engineeringTeam))->assertStatus(200);

        $this->get(route('roles.create'))->assertStatus(200);
        $this->get(route('roles.edit', $this->developerRole))->assertStatus(200);
    }

    public function test_can_create_new_role_with_permissions(): void
    {
        $response = $this->post(route('roles.store'), [
            'name' => 'Security Analyst',
            'slug' => 'security-analyst',
            'badge_color' => 'cyan',
            'description' => 'Chuyên gia bảo mật và đánh giá tuân thủ quy trình.',
            'permissions' => ['projects.view', 'system.logs', 'reports.export'],
        ]);

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('roles', [
            'name' => 'Security Analyst',
            'slug' => 'security-analyst',
            'badge_color' => 'cyan',
        ]);

        $role = Role::where('slug', 'security-analyst')->firstOrFail();
        $this->assertContains('projects.view', $role->permissions);
        $this->assertContains('system.logs', $role->permissions);
        $this->assertContains('reports.export', $role->permissions);
    }

    public function test_can_update_existing_role(): void
    {
        $role = Role::create([
            'name' => 'Scrum Master',
            'slug' => 'scrum-master',
            'badge_color' => 'amber',
            'description' => 'Quản trị quy trình Agile.',
            'permissions' => ['projects.view'],
        ]);

        $response = $this->put(route('roles.update', $role), [
            'name' => 'Agile Coach & Scrum Master',
            'slug' => 'agile-coach-scrum-master',
            'badge_color' => 'fuchsia',
            'description' => 'Huấn luyện agile toàn diện.',
            'permissions' => ['projects.view', 'projects.edit', 'members.view'],
        ]);

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');

        $role->refresh();
        $this->assertSame('Agile Coach & Scrum Master', $role->name);
        $this->assertSame('agile-coach-scrum-master', $role->slug);
        $this->assertSame('fuchsia', $role->badge_color);
        $this->assertContains('projects.edit', $role->permissions);
    }

    public function test_can_batch_update_rbac_matrix_permissions(): void
    {
        $roleA = Role::create([
            'name' => 'Role A',
            'slug' => 'role-a',
            'badge_color' => 'blue',
            'permissions' => ['projects.view'],
        ]);

        $roleB = Role::create([
            'name' => 'Role B',
            'slug' => 'role-b',
            'badge_color' => 'rose',
            'permissions' => ['teams.view'],
        ]);

        $matrixPayload = [
            'matrix' => [
                $roleA->id => ['projects.view', 'projects.create', 'projects.edit'],
                $roleB->id => ['teams.view', 'teams.create', 'system.settings'],
            ],
        ];

        $response = $this->post(route('roles.matrix.update'), $matrixPayload);

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');

        $roleA->refresh();
        $roleB->refresh();

        $this->assertEquals(['projects.view', 'projects.create', 'projects.edit'], $roleA->permissions);
        $this->assertEquals(['teams.view', 'teams.create', 'system.settings'], $roleB->permissions);
    }

    public function test_can_delete_unassigned_role(): void
    {
        $role = Role::create([
            'name' => 'Temporary Contractor',
            'slug' => 'temp-contractor',
            'badge_color' => 'indigo',
            'permissions' => ['projects.view'],
        ]);

        $response = $this->delete(route('roles.destroy', $role));

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    public function test_cannot_delete_role_with_assigned_members(): void
    {
        $role = Role::create([
            'name' => 'DevOps Specialist',
            'slug' => 'devops-specialist',
            'badge_color' => 'purple',
            'permissions' => ['system.settings'],
        ]);

        Member::create([
            'name' => 'Đặng Văn Lâm',
            'email' => 'lam.dang@test.internal',
            'team_id' => $this->engineeringTeam->id,
            'role_id' => $role->id,
            'status' => MemberStatus::Active,
        ]);

        $response = $this->delete(route('roles.destroy', $role));

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }
}
