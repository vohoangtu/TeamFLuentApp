<?php

namespace App\Services;

class PermissionRegistry
{
    /**
     * Get all registered system modules and their specific granular permissions.
     *
     * @return array<string, array{
     *     name: string,
     *     description: string,
     *     icon: string,
     *     permissions: array<string, array{
     *         name: string,
     *         description: string,
     *         critical?: bool
     *     }>
     * }>
     */
    public static function all(): array
    {
        return [
            'projects' => [
                'name' => 'Quản lý Dự án (Projects)',
                'description' => 'Khởi tạo, chỉnh sửa tiến độ và giám sát đa dự án.',
                'icon' => '📁',
                'permissions' => [
                    'projects.view' => [
                        'name' => 'Xem danh sách & tiến độ',
                        'description' => 'Xem tổng quan và thông số tiến độ các dự án trong hệ thống.',
                    ],
                    'projects.create' => [
                        'name' => 'Khởi tạo dự án mới',
                        'description' => 'Tạo dự án mới, thiết lập mã Code và thời hạn hoàn thành.',
                    ],
                    'projects.edit' => [
                        'name' => 'Chỉnh sửa thông tin & tiến độ',
                        'description' => 'Cập nhật phần trăm hoàn thành, trạng thái và chi tiết dự án.',
                    ],
                    'projects.delete' => [
                        'name' => 'Xóa dự án',
                        'description' => 'Gỡ bỏ hoặc xóa vĩnh viễn dự án khỏi hệ thống.',
                        'critical' => true,
                    ],
                    'projects.assign' => [
                        'name' => 'Điều phối & phân bổ nhân sự',
                        'description' => 'Giao dự án cho thành viên và xác lập hạn mức tải (% Workload).',
                    ],
                    'projects.budget' => [
                        'name' => 'Quản lý ngân sách',
                        'description' => 'Xem và điều chỉnh ngân sách tài chính của từng dự án.',
                        'critical' => true,
                    ],
                ],
            ],

            'members' => [
                'name' => 'Quản trị Thành viên & Nhân sự (Members)',
                'description' => 'Quản lý hồ sơ nhân sự, phân bổ chức danh và giám sát workload.',
                'icon' => '👥',
                'permissions' => [
                    'members.view' => [
                        'name' => 'Xem danh sách & hồ sơ nhân sự',
                        'description' => 'Truy cập thông tin liên hệ và các dự án thành viên đang phụ trách.',
                    ],
                    'members.create' => [
                        'name' => 'Thêm thành viên mới',
                        'description' => 'Tạo hồ sơ nhân sự mới và phân bổ dự án ban đầu.',
                    ],
                    'members.edit' => [
                        'name' => 'Chỉnh sửa hồ sơ & chức vụ',
                        'description' => 'Cập nhật email, số điện thoại, vai trò và phòng ban nhân sự.',
                    ],
                    'members.delete' => [
                        'name' => 'Xóa thành viên',
                        'description' => 'Xóa nhân sự khỏi tổ chức và thu hồi mọi dự án phụ trách.',
                        'critical' => true,
                    ],
                    'members.workload' => [
                        'name' => 'Điều chỉnh hạn mức tải (Workload)',
                        'description' => 'Thay đổi % phân bổ công việc và xử lý tình trạng quá tải (>100%).',
                    ],
                ],
            ],

            'teams' => [
                'name' => 'Cơ cấu Phòng ban & Nhóm (Teams)',
                'description' => 'Thành lập phòng ban chuyên môn và chỉ định đội trưởng nhóm.',
                'icon' => '🏢',
                'permissions' => [
                    'teams.view' => [
                        'name' => 'Xem cơ cấu tổ chức nhóm',
                        'description' => 'Xem sơ đồ phòng ban và danh sách nhân sự trực thuộc.',
                    ],
                    'teams.create' => [
                        'name' => 'Thành lập nhóm mới',
                        'description' => 'Tạo phòng ban hoặc nhóm chức năng mới.',
                    ],
                    'teams.edit' => [
                        'name' => 'Chỉnh sửa & bổ nhiệm Team Lead',
                        'description' => 'Cập nhật thông tin nhóm và chỉ định Trưởng nhóm phụ trách.',
                    ],
                    'teams.delete' => [
                        'name' => 'Giải thể nhóm',
                        'description' => 'Giải thể phòng ban và phân phối lại các thành viên.',
                        'critical' => true,
                    ],
                ],
            ],

            'reports' => [
                'name' => 'Báo cáo & Phân tích (Analytics & Reports)',
                'description' => 'Theo dõi hiệu suất đa dự án và số liệu thống kê vận hành.',
                'icon' => '📊',
                'permissions' => [
                    'reports.view' => [
                        'name' => 'Xem bảng điều khiển phân tích',
                        'description' => 'Xem thống kê tổng quan, tỷ lệ quá tải và tiến độ chung.',
                    ],
                    'reports.export' => [
                        'name' => 'Xuất báo cáo dữ liệu',
                        'description' => 'Trích xuất dữ liệu dự án và nhân sự sang file Excel / CSV.',
                    ],
                ],
            ],

            'system' => [
                'name' => 'Hệ thống & Ma trận Phân quyền (Security & RBAC)',
                'description' => 'Toàn quyền cấu hình vai trò, ma trận bảo mật và audit log.',
                'icon' => '🛡️',
                'permissions' => [
                    'roles.manage' => [
                        'name' => 'Quản lý vai trò & ma trận phân quyền',
                        'description' => 'Tạo vai trò mới và điều chỉnh ma trận phân quyền RBAC.',
                        'critical' => true,
                    ],
                    'audit.logs' => [
                        'name' => 'Xem nhật ký kiểm toán (Audit Logs)',
                        'description' => 'Truy vết các thay đổi phân bổ nhân sự và quyền hạn trong hệ thống.',
                    ],
                    'system.settings' => [
                        'name' => 'Cấu hình nền tảng doanh nghiệp',
                        'description' => 'Thiết lập tham số workspace, bảo mật và tích hợp bên thứ ba.',
                        'critical' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * Get a flattened list of all valid permission keys.
     *
     * @return list<string>
     */
    public static function allKeys(): array
    {
        $keys = [];
        foreach (self::all() as $module) {
            foreach (array_keys($module['permissions']) as $key) {
                $keys[] = $key;
            }
        }

        return $keys;
    }

    /**
     * Check if a role possesses a specific permission (or has wildcard 'all_access' or legacy alias).
     *
     * @param  array<string>|null  $rolePermissions
     */
    public static function roleHasPermission(?array $rolePermissions, string $permission): bool
    {
        if (empty($rolePermissions)) {
            return false;
        }

        if (in_array('all_access', $rolePermissions, true) || in_array('all', $rolePermissions, true)) {
            return true;
        }

        if (in_array($permission, $rolePermissions, true)) {
            return true;
        }

        // Map legacy seeded aliases to granular permissions
        $legacyMap = [
            'manage_teams' => ['teams.view', 'teams.create', 'teams.edit', 'teams.delete'],
            'manage_members' => ['members.view', 'members.create', 'members.edit', 'members.delete', 'members.workload'],
            'manage_projects' => ['projects.view', 'projects.create', 'projects.edit', 'projects.delete', 'projects.assign', 'projects.budget'],
            'create_projects' => ['projects.create', 'projects.view'],
            'assign_members' => ['projects.assign'],
            'edit_projects' => ['projects.edit', 'projects.view'],
            'security_audit' => ['audit.logs', 'system.settings'],
            'billing' => ['projects.budget'],
            'view_projects' => ['projects.view'],
            'schedule_milestones' => ['projects.edit'],
            'track_budget' => ['projects.budget'],
            'generate_reports' => ['reports.view', 'reports.export'],
        ];

        foreach ($rolePermissions as $p) {
            if (isset($legacyMap[$p]) && in_array($permission, $legacyMap[$p], true)) {
                return true;
            }
        }

        return false;
    }
}
