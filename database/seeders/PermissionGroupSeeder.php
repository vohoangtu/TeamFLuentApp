<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Nhóm Lập Trình & Kỹ Thuật (Dev Suite)',
                'slug' => 'dev',
                'description' => 'Quản lý mã nguồn, tác vụ kỹ thuật, giám sát tiến độ dự án và phân tích logs.',
                'icon' => '💻',
                'badge_color' => 'cyan',
                'permissions' => [
                    'projects.view',
                    'projects.edit',
                    'projects.assign',
                    'members.view',
                    'system.logs',
                ],
                'is_system' => true,
            ],
            [
                'name' => 'Nhóm Quản Trị Hệ Thống & DevOps (System Ops)',
                'slug' => 'system',
                'description' => 'Cấu hình máy chủ, thiết lập phân quyền RBAC, bảo mật hạ tầng và rà soát audit logs.',
                'icon' => '⚙️',
                'badge_color' => 'purple',
                'permissions' => [
                    'system.settings',
                    'system.roles',
                    'system.logs',
                    'projects.view',
                    'members.view',
                ],
                'is_system' => true,
            ],
            [
                'name' => 'Nhóm Điều Phối & Quản Lý Dự Án (Project Management)',
                'slug' => 'management',
                'description' => 'Khởi tạo dự án, điều phối thành viên, phân bổ ngân sách và cơ cấu phòng ban.',
                'icon' => '📁',
                'badge_color' => 'blue',
                'permissions' => [
                    'projects.view',
                    'projects.create',
                    'projects.edit',
                    'projects.assign',
                    'projects.budget',
                    'members.view',
                    'members.create',
                    'members.edit',
                    'members.workload',
                    'teams.view',
                    'teams.create',
                    'teams.edit',
                ],
                'is_system' => true,
            ],
            [
                'name' => 'Nhóm Kiểm Thử & An Toàn Chất Lượng (QA & SecOps)',
                'slug' => 'qa',
                'description' => 'Kiểm thử ứng dụng, đánh giá sự cố, rà soát nhật ký và xuất báo cáo kiểm định.',
                'icon' => '🛡️',
                'badge_color' => 'amber',
                'permissions' => [
                    'projects.view',
                    'members.view',
                    'reports.view',
                    'reports.export',
                    'system.logs',
                ],
                'is_system' => true,
            ],
            [
                'name' => 'Nhóm Báo Cáo & Đo Lường Hiệu Suất (Analytics & BI)',
                'slug' => 'reports',
                'description' => 'Xem báo cáo kinh doanh, trích xuất dữ liệu đa chiều, theo dõi tiến độ KPI.',
                'icon' => '📊',
                'badge_color' => 'emerald',
                'permissions' => [
                    'reports.view',
                    'reports.export',
                    'reports.kpi',
                    'projects.view',
                ],
                'is_system' => true,
            ],
        ];

        $createdGroups = [];
        foreach ($groups as $groupData) {
            $createdGroups[$groupData['slug']] = PermissionGroup::updateOrCreate(
                ['slug' => $groupData['slug']],
                $groupData
            );
        }

        // Assign default functional groups to existing seeded roles if they exist
        $roleGroupMap = [
            'admin' => ['system', 'management', 'dev', 'reports'],
            'tech-lead' => ['dev', 'system', 'management'],
            'senior-dev' => ['dev'],
            'qa-specialist' => ['qa', 'reports'],
            'project-manager' => ['management', 'reports'],
            'product-designer' => ['dev', 'management'],
        ];

        foreach ($roleGroupMap as $roleSlug => $groupSlugs) {
            $role = Role::where('slug', $roleSlug)->first();
            if ($role) {
                $groupIds = [];
                $allPerms = $role->permissions ?? [];

                foreach ($groupSlugs as $groupSlug) {
                    if (isset($createdGroups[$groupSlug])) {
                        $groupIds[] = $createdGroups[$groupSlug]->id;
                        $allPerms = array_merge($allPerms, $createdGroups[$groupSlug]->permissions ?? []);
                    }
                }

                $role->permissionGroups()->syncWithoutDetaching($groupIds);
                $role->update([
                    'permissions' => array_values(array_unique($allPerms)),
                ]);
            }
        }
    }
}
