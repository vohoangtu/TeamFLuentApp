<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Project;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles với màu sắc neon/jewel đặc trưng Fluent 2
        $rolesData = [
            [
                'name' => 'System Admin / Director',
                'slug' => 'admin',
                'badge_color' => 'purple',
                'description' => 'Toàn quyền quản trị tài nguyên tổ chức, phân quyền và cấu hình hệ thống.',
                'permissions' => ['all_access', 'manage_teams', 'manage_members', 'manage_projects', 'security_audit', 'billing'],
            ],
            [
                'name' => 'Technical Lead & Architect',
                'slug' => 'tech-lead',
                'badge_color' => 'cyan',
                'description' => 'Định hình kiến trúc hệ thống, phê duyệt kỹ thuật và dẫn dắt triển khai dự án.',
                'permissions' => ['create_projects', 'assign_members', 'code_review', 'deploy_production', 'manage_infra'],
            ],
            [
                'name' => 'Senior Fullstack Engineer',
                'slug' => 'senior-dev',
                'badge_color' => 'emerald',
                'description' => 'Xây dựng module lõi, tối ưu hiệu năng và phát triển giải pháp kỹ thuật cao cấp.',
                'permissions' => ['edit_projects', 'manage_tasks', 'commit_code', 'review_pr'],
            ],
            [
                'name' => 'Product Designer / UX Lead',
                'slug' => 'product-designer',
                'badge_color' => 'rose',
                'description' => 'Thiết kế giao diện Fluent 2, xây dựng Design System và kiểm soát trải nghiệm người dùng.',
                'permissions' => ['manage_design_system', 'prototype_review', 'ux_research', 'view_projects'],
            ],
            [
                'name' => 'QA Specialist & SecOps',
                'slug' => 'qa-specialist',
                'badge_color' => 'amber',
                'description' => 'Kiểm thử tự động, đánh giá chất lượng và giám sát an ninh bảo mật.',
                'permissions' => ['create_bug_reports', 'execute_tests', 'approve_releases', 'security_scan'],
            ],
            [
                'name' => 'Project Manager & Scrum Master',
                'slug' => 'project-manager',
                'badge_color' => 'blue',
                'description' => 'Quản trị tiến độ, phân bổ nguồn lực và điều phối giữa các đội ngũ dự án.',
                'permissions' => ['schedule_milestones', 'track_budget', 'assign_members', 'generate_reports'],
            ],
        ];

        $roles = [];
        foreach ($rolesData as $role) {
            $roles[$role['slug']] = Role::create($role);
        }

        // 2. Teams với bảng màu rực rỡ Fluent 2 Mica
        $teamsData = [
            [
                'name' => 'Core Platform & Cloud',
                'slug' => 'core-platform',
                'code' => 'CORE',
                'description' => 'Chịu trách nhiệm hạ tầng đám mây phân tán, microservices và bảo mật tầng thấp.',
                'color' => 'from-blue-600 via-indigo-600 to-cyan-500',
                'icon' => 'server-stack',
            ],
            [
                'name' => 'AI Intelligence & Data',
                'slug' => 'ai-intelligence',
                'code' => 'AI-LAB',
                'description' => 'Nghiên cứu mô hình ngôn ngữ lớn, pipeline dữ liệu thời gian thực và agentic workflows.',
                'color' => 'from-purple-600 via-fuchsia-600 to-pink-500',
                'icon' => 'cpu-chip',
            ],
            [
                'name' => 'Product Experience & UX',
                'slug' => 'product-experience',
                'code' => 'PX-UX',
                'description' => 'Xây dựng thư viện component Fluent 2 Mica và thiết kế trải nghiệm đa nền tảng.',
                'color' => 'from-rose-500 via-pink-500 to-orange-400',
                'icon' => 'swatch',
            ],
            [
                'name' => 'Mobile & Edge Clients',
                'slug' => 'mobile-edge',
                'code' => 'MOBILE',
                'description' => 'Phát triển ứng dụng di động iOS/Android và tối ưu hóa client ngoại tuyến.',
                'color' => 'from-cyan-500 via-teal-500 to-emerald-500',
                'icon' => 'device-phone-mobile',
            ],
            [
                'name' => 'Quality & Cybersecurity',
                'slug' => 'quality-cybersecurity',
                'code' => 'QA-SEC',
                'description' => 'Kiểm thử tải, bảo mật Zero-Trust và giám sát độ tin cậy hệ thống (SRE).',
                'color' => 'from-emerald-500 via-green-600 to-teal-700',
                'icon' => 'shield-check',
            ],
        ];

        $teams = [];
        foreach ($teamsData as $team) {
            $teams[$team['slug']] = Team::create($team);
        }

        // 3. Projects rực rỡ với các chỉ số tiến độ và ngân sách
        $projectsData = [
            [
                'name' => 'HyperFlow AI Agent Orchestrator',
                'slug' => 'hyperflow-ai-agent',
                'code' => 'PRJ-AI01',
                'description' => 'Nền tảng điều phối đa agent tự động hóa quy trình nghiệp vụ doanh nghiệp với phản hồi mili-giây.',
                'status' => 'in_progress',
                'priority' => 'urgent',
                'progress' => 82,
                'color' => 'from-purple-500 via-indigo-600 to-cyan-400',
                'start_date' => '2026-08-01',
                'due_date' => '2026-12-15',
                'budget' => 125000.00,
            ],
            [
                'name' => 'Cloud Nexus Multi-Tenant Mesh',
                'slug' => 'cloud-nexus-mesh',
                'code' => 'PRJ-CL02',
                'description' => 'Kiến trúc Multi-tenant thế hệ mới với khả năng cô lập dữ liệu theo từng tổ chức và mở rộng tự động.',
                'status' => 'in_progress',
                'priority' => 'high',
                'progress' => 64,
                'color' => 'from-blue-500 via-cyan-500 to-emerald-400',
                'start_date' => '2026-07-15',
                'due_date' => '2026-11-30',
                'budget' => 95000.00,
            ],
            [
                'name' => 'Fluent 2 Mica UI Component Suite',
                'slug' => 'fluent-2-mica-suite',
                'code' => 'PRJ-UI03',
                'description' => 'Bộ UI kit thiết kế theo ngôn ngữ Microsoft Fluent 2 tích hợp hiệu ứng mica mờ ảo và bảng màu siêu rực rỡ.',
                'status' => 'review',
                'priority' => 'high',
                'progress' => 94,
                'color' => 'from-pink-500 via-rose-500 to-purple-500',
                'start_date' => '2026-06-01',
                'due_date' => '2026-10-25',
                'budget' => 60000.00,
            ],
            [
                'name' => 'NextGen Banking Mobile Client',
                'slug' => 'nextgen-banking-mobile',
                'code' => 'PRJ-MB04',
                'description' => 'Trải nghiệm ứng dụng ngân hàng số hiện đại, chuyển tiền tức thì và quản lý thẻ thông minh.',
                'status' => 'planning',
                'priority' => 'medium',
                'progress' => 30,
                'color' => 'from-teal-400 via-emerald-500 to-cyan-500',
                'start_date' => '2026-09-01',
                'due_date' => '2027-02-28',
                'budget' => 88000.00,
            ],
            [
                'name' => 'Zero-Trust Shield & Identity SSO',
                'slug' => 'zero-trust-shield',
                'code' => 'PRJ-SEC05',
                'description' => 'Hệ thống xác thực một chạm không mật khẩu dựa trên FIDO2/Passkeys và phân tích rủi ro theo ngữ cảnh.',
                'status' => 'in_progress',
                'priority' => 'urgent',
                'progress' => 58,
                'color' => 'from-amber-500 via-orange-500 to-rose-500',
                'start_date' => '2026-08-20',
                'due_date' => '2026-12-30',
                'budget' => 74000.00,
            ],
            [
                'name' => 'Real-Time Telemetry & Insights Lake',
                'slug' => 'realtime-telemetry-lake',
                'code' => 'PRJ-DAT06',
                'description' => 'Cụm xử lý dữ liệu luồng 500k events/giây phục vụ báo cáo trực quan và cảnh báo sai lệch tức thì.',
                'status' => 'completed',
                'priority' => 'medium',
                'progress' => 100,
                'color' => 'from-indigo-500 via-blue-500 to-sky-400',
                'start_date' => '2026-04-10',
                'due_date' => '2026-09-15',
                'budget' => 110000.00,
            ],
        ];

        $projects = [];
        foreach ($projectsData as $project) {
            $projects[$project['slug']] = Project::create($project);
        }

        // 4. Members (Thành viên) - Đa dạng vai trò & thuộc các Teams
        $membersData = [
            [
                'name' => 'Trần Tuấn Khôi',
                'email' => 'khoi.tran@teammanager.internal',
                'phone' => '+84 901 888 101',
                'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['core-platform']->id,
                'role_id' => $roles['admin']->id,
                'is_team_lead' => true,
                'status' => 'active',
                'bio' => 'Trưởng ban công nghệ, phụ trách định hướng kỹ thuật chung và bảo mật toàn diện.',
                'joined_at' => '2024-01-15',
            ],
            [
                'name' => 'Nguyễn Minh Quân',
                'email' => 'quan.nguyen@teammanager.internal',
                'phone' => '+84 902 333 444',
                'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['ai-intelligence']->id,
                'role_id' => $roles['tech-lead']->id,
                'is_team_lead' => true,
                'status' => 'active',
                'bio' => 'Chuyên gia AI/LLM và hệ thống suy luận thời gian thực, từng làm việc tại viện nghiên cứu.',
                'joined_at' => '2024-03-01',
            ],
            [
                'name' => 'Lê Thảo My',
                'email' => 'my.le@teammanager.internal',
                'phone' => '+84 903 555 777',
                'avatar_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['product-experience']->id,
                'role_id' => $roles['product-designer']->id,
                'is_team_lead' => true,
                'status' => 'active',
                'bio' => 'Thiết kế giao diện trưởng, đam mê Fluent 2, hiệu ứng Mica và micro-interactions tinh tế.',
                'joined_at' => '2024-04-10',
            ],
            [
                'name' => 'Phạm Hoàng Nam',
                'email' => 'nam.pham@teammanager.internal',
                'phone' => '+84 904 222 111',
                'avatar_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['core-platform']->id,
                'role_id' => $roles['senior-dev']->id,
                'is_team_lead' => false,
                'status' => 'active',
                'bio' => 'Kỹ sư backend chuyên sâu Laravel & Distributed Systems, đam mê tối ưu cơ sở dữ liệu.',
                'joined_at' => '2024-05-18',
            ],
            [
                'name' => 'Đỗ Gia Bảo',
                'email' => 'bao.do@teammanager.internal',
                'phone' => '+84 905 777 888',
                'avatar_url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['mobile-edge']->id,
                'role_id' => $roles['tech-lead']->id,
                'is_team_lead' => true,
                'status' => 'active',
                'bio' => 'Dẫn dắt các giải pháp Mobile đa nền tảng, offline-first sync và bảo mật sinh trắc học.',
                'joined_at' => '2024-06-01',
            ],
            [
                'name' => 'Vũ Hải Yến',
                'email' => 'yen.vu@teammanager.internal',
                'phone' => '+84 906 999 000',
                'avatar_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['quality-cybersecurity']->id,
                'role_id' => $roles['qa-specialist']->id,
                'is_team_lead' => true,
                'status' => 'active',
                'bio' => 'Chuyên gia bảo mật ứng dụng web và tự động hóa kiểm thử end-to-end với CI/CD.',
                'joined_at' => '2024-07-12',
            ],
            [
                'name' => 'Hoàng Nhật Minh',
                'email' => 'minh.hoang@teammanager.internal',
                'phone' => '+84 907 123 456',
                'avatar_url' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['ai-intelligence']->id,
                'role_id' => $roles['senior-dev']->id,
                'is_team_lead' => false,
                'status' => 'active',
                'bio' => 'Phát triển pipeline xử lý embedding và tích hợp agentic tool calling.',
                'joined_at' => '2024-08-05',
            ],
            [
                'name' => 'Đặng Kim Ngân',
                'email' => 'ngan.dang@teammanager.internal',
                'phone' => '+84 908 654 321',
                'avatar_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['product-experience']->id,
                'role_id' => $roles['project-manager']->id,
                'is_team_lead' => false,
                'status' => 'active',
                'bio' => 'Điều phối sprint, cân bằng khối lượng công việc và duy trì năng suất vượt trội cho các team.',
                'joined_at' => '2024-09-01',
            ],
            [
                'name' => 'Bùi Tuấn Anh',
                'email' => 'anh.bui@teammanager.internal',
                'phone' => '+84 909 789 012',
                'avatar_url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['mobile-edge']->id,
                'role_id' => $roles['senior-dev']->id,
                'is_team_lead' => false,
                'status' => 'active',
                'bio' => 'Kỹ sư chuyên sâu Kotlin Multiplatform và giao diện cảm ứng mượt mà.',
                'joined_at' => '2024-10-10',
            ],
            [
                'name' => 'Cao Phương Linh',
                'email' => 'linh.cao@teammanager.internal',
                'phone' => '+84 910 888 222',
                'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
                'team_id' => $teams['quality-cybersecurity']->id,
                'role_id' => $roles['qa-specialist']->id,
                'is_team_lead' => false,
                'status' => 'on_leave',
                'bio' => 'Kiểm thử hiệu năng, pen-testing API và đánh giá rủi ro an toàn thông tin.',
                'joined_at' => '2024-11-02',
            ],
        ];

        $members = [];
        foreach ($membersData as $m) {
            $member = Member::create($m);
            $members[$member->email] = $member;

            // Gán lead_id vào team nếu là lead
            if ($member->is_team_lead) {
                Team::where('id', $member->team_id)->update(['lead_id' => $member->id]);
            }
        }

        // 5. QUAN TRỌNG: MỖI THÀNH VIÊN PHỤ TRÁCH NHIỀU DỰ ÁN (Many-to-Many Assignments)
        // Minh họa rõ ràng tính năng cốt lõi: 1 thành viên có thể là Lead ở dự án A, Contributor ở dự án B, Reviewer ở dự án C!
        $assignments = [
            // Trần Tuấn Khôi (Admin/Director) -> phụ trách 3 dự án
            [
                'member' => 'khoi.tran@teammanager.internal',
                'project' => 'cloud-nexus-mesh',
                'role_in_project' => 'Architecture Advisor',
                'allocation_percent' => 30,
                'assigned_at' => '2026-07-15',
            ],
            [
                'member' => 'khoi.tran@teammanager.internal',
                'project' => 'zero-trust-shield',
                'role_in_project' => 'Executive Sponsor',
                'allocation_percent' => 20,
                'assigned_at' => '2026-08-20',
            ],
            [
                'member' => 'khoi.tran@teammanager.internal',
                'project' => 'hyperflow-ai-agent',
                'role_in_project' => 'Tech Strategy Reviewer',
                'allocation_percent' => 30,
                'assigned_at' => '2026-08-01',
            ],

            // Nguyễn Minh Quân (AI Tech Lead) -> phụ trách 2 dự án
            [
                'member' => 'quan.nguyen@teammanager.internal',
                'project' => 'hyperflow-ai-agent',
                'role_in_project' => 'Principal Tech Lead',
                'allocation_percent' => 60,
                'assigned_at' => '2026-08-01',
            ],
            [
                'member' => 'quan.nguyen@teammanager.internal',
                'project' => 'realtime-telemetry-lake',
                'role_in_project' => 'AI Pipeline Consultant',
                'allocation_percent' => 30,
                'assigned_at' => '2026-05-01',
            ],

            // Lê Thảo My (Design Lead) -> phụ trách 3 dự án
            [
                'member' => 'my.le@teammanager.internal',
                'project' => 'fluent-2-mica-suite',
                'role_in_project' => 'Lead Design Architect',
                'allocation_percent' => 50,
                'assigned_at' => '2026-06-01',
            ],
            [
                'member' => 'my.le@teammanager.internal',
                'project' => 'hyperflow-ai-agent',
                'role_in_project' => 'Agent UX/UI Specialist',
                'allocation_percent' => 25,
                'assigned_at' => '2026-08-05',
            ],
            [
                'member' => 'my.le@teammanager.internal',
                'project' => 'nextgen-banking-mobile',
                'role_in_project' => 'Design System Consultant',
                'allocation_percent' => 25,
                'assigned_at' => '2026-09-05',
            ],

            // Phạm Hoàng Nam (Senior Dev) -> phụ trách 2 dự án
            [
                'member' => 'nam.pham@teammanager.internal',
                'project' => 'cloud-nexus-mesh',
                'role_in_project' => 'Core Backend Lead',
                'allocation_percent' => 60,
                'assigned_at' => '2026-07-20',
            ],
            [
                'member' => 'nam.pham@teammanager.internal',
                'project' => 'zero-trust-shield',
                'role_in_project' => 'Auth Backend Engineer',
                'allocation_percent' => 40,
                'assigned_at' => '2026-08-25',
            ],

            // Đỗ Gia Bảo (Mobile Tech Lead) -> phụ trách 2 dự án
            [
                'member' => 'bao.do@teammanager.internal',
                'project' => 'nextgen-banking-mobile',
                'role_in_project' => 'Mobile Project Lead',
                'allocation_percent' => 70,
                'assigned_at' => '2026-09-01',
            ],
            [
                'member' => 'bao.do@teammanager.internal',
                'project' => 'fluent-2-mica-suite',
                'role_in_project' => 'Mobile Token Integrator',
                'allocation_percent' => 30,
                'assigned_at' => '2026-07-10',
            ],

            // Vũ Hải Yến (QA SecOps Lead) -> phụ trách 3 dự án
            [
                'member' => 'yen.vu@teammanager.internal',
                'project' => 'zero-trust-shield',
                'role_in_project' => 'Security Audit Lead',
                'allocation_percent' => 40,
                'assigned_at' => '2026-08-20',
            ],
            [
                'member' => 'yen.vu@teammanager.internal',
                'project' => 'hyperflow-ai-agent',
                'role_in_project' => 'E2E Testing Lead',
                'allocation_percent' => 30,
                'assigned_at' => '2026-08-10',
            ],
            [
                'member' => 'yen.vu@teammanager.internal',
                'project' => 'cloud-nexus-mesh',
                'role_in_project' => 'Penetration Tester',
                'allocation_percent' => 30,
                'assigned_at' => '2026-08-01',
            ],

            // Hoàng Nhật Minh (AI Senior Dev) -> phụ trách 2 dự án
            [
                'member' => 'minh.hoang@teammanager.internal',
                'project' => 'hyperflow-ai-agent',
                'role_in_project' => 'LLM Integration Engineer',
                'allocation_percent' => 60,
                'assigned_at' => '2026-08-15',
            ],
            [
                'member' => 'minh.hoang@teammanager.internal',
                'project' => 'realtime-telemetry-lake',
                'role_in_project' => 'Vector Database Maintainer',
                'allocation_percent' => 40,
                'assigned_at' => '2026-06-01',
            ],

            // Đặng Kim Ngân (Project Manager) -> phụ trách 3 dự án
            [
                'member' => 'ngan.dang@teammanager.internal',
                'project' => 'hyperflow-ai-agent',
                'role_in_project' => 'Scrum Master',
                'allocation_percent' => 35,
                'assigned_at' => '2026-08-01',
            ],
            [
                'member' => 'ngan.dang@teammanager.internal',
                'project' => 'cloud-nexus-mesh',
                'role_in_project' => 'Delivery Manager',
                'allocation_percent' => 35,
                'assigned_at' => '2026-07-20',
            ],
            [
                'member' => 'ngan.dang@teammanager.internal',
                'project' => 'fluent-2-mica-suite',
                'role_in_project' => 'Release Coordinator',
                'allocation_percent' => 30,
                'assigned_at' => '2026-06-15',
            ],

            // Bùi Tuấn Anh (Mobile Senior Dev) -> phụ trách 2 dự án
            [
                'member' => 'anh.bui@teammanager.internal',
                'project' => 'nextgen-banking-mobile',
                'role_in_project' => 'Senior iOS/Android Engineer',
                'allocation_percent' => 70,
                'assigned_at' => '2026-09-05',
            ],
            [
                'member' => 'anh.bui@teammanager.internal',
                'project' => 'fluent-2-mica-suite',
                'role_in_project' => 'UI Component Tester',
                'allocation_percent' => 20,
                'assigned_at' => '2026-08-01',
            ],

            // Cao Phương Linh (QA) -> phụ trách 1 dự án
            [
                'member' => 'linh.cao@teammanager.internal',
                'project' => 'nextgen-banking-mobile',
                'role_in_project' => 'Automated QA Engineer',
                'allocation_percent' => 50,
                'assigned_at' => '2026-09-10',
            ],
        ];

        foreach ($assignments as $a) {
            $member = $members[$a['member']] ?? null;
            $project = $projects[$a['project']] ?? null;

            if ($member && $project) {
                $member->projects()->attach($project->id, [
                    'role_in_project' => $a['role_in_project'],
                    'allocation_percent' => $a['allocation_percent'],
                    'assigned_at' => $a['assigned_at'],
                ]);
            }
        }
    }
}
