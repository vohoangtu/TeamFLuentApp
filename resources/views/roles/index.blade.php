<x-layouts.app>
    <x-slot:title>Quản Lý Vai Trò & Ma Trận Phân Quyền - TeamNexus</x-slot:title>
    <x-slot:header>Quản Lý Vai Trò, Nhóm Quyền Chức Năng & Ma Trận RBAC</x-slot:header>

    <div class="space-y-6" x-data="{
        activeTab: '{{ request('tab', 'matrix') }}', // 'matrix', 'groups', or 'roles'
        searchTerm: '',
        matchesSearch(name, desc) {
            if (!this.searchTerm) return true;
            const term = this.searchTerm.toLowerCase();
            return name.toLowerCase().includes(term) || desc.toLowerCase().includes(term);
        }
    }">
        <!-- Header Ribbon -->
        <x-card padding="default" class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h2 class="text-lg font-bold text-slate-900">Kiến Trúc Phân Quyền Vai Trò & Nhóm Chức Năng</h2>
                    <x-badge color="primary" size="sm">{{ $roles->count() }} vai trò</x-badge>
                    <x-badge color="cyan" size="sm">{{ $permissionGroups->count() }} nhóm chức năng</x-badge>
                    <x-info-popover text="Gán quyền theo nhóm chức năng (nhóm Dev, nhóm System...) hoặc thiết lập ma trận phân quyền chi tiết." color="blue" />
                </div>
            </div>

            <div class="flex items-center gap-2.5 flex-wrap">
                <x-button variant="secondary" size="md" href="{{ route('permission-groups.create') }}">
                    <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Thêm nhóm chức năng</span>
                </x-button>

                <x-button variant="primary" size="md" href="{{ route('roles.create') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Thêm vai trò mới</span>
                </x-button>
            </div>
        </x-card>

        <!-- Navigation Tabs: Matrix Grid vs Permission Groups vs Role Directory -->
        <div class="flex items-center justify-between border-b border-slate-200/80 pb-1 gap-4 flex-wrap">
            <div class="flex items-center gap-2">
                <button type="button"
                        @click="activeTab = 'matrix'"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2"
                        :class="activeTab === 'matrix' ? 'glow-btn-primary shadow-sm text-white' : 'mica-pill text-slate-600 hover:text-slate-900'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Ma Trận Phân Quyền (RBAC Grid)</span>
                </button>

                <button type="button"
                        @click="activeTab = 'groups'"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2"
                        :class="activeTab === 'groups' ? 'glow-btn-primary shadow-sm text-white' : 'mica-pill text-slate-600 hover:text-slate-900'">
                    <span class="text-sm">📦</span>
                    <span>Nhóm Quyền Chức Năng ({{ $permissionGroups->count() }})</span>
                </button>

                <button type="button"
                        @click="activeTab = 'roles'"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2"
                        :class="activeTab === 'roles' ? 'glow-btn-primary shadow-sm text-white' : 'mica-pill text-slate-600 hover:text-slate-900'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Danh Sách Vai Trò & Nhân Sự</span>
                </button>
            </div>

            <!-- Permission Search (Visible on Matrix Tab) -->
            <div x-show="activeTab === 'matrix'" class="w-full sm:w-64">
                <input type="text"
                       x-model="searchTerm"
                       placeholder="Tìm kiếm quyền hạn..."
                       class="w-full px-3 py-1.5 text-xs rounded-xl mica-input">
            </div>
        </div>

        <!-- ===================================================================== -->
        <!-- TAB 1: PERMISSIONS MATRIX (INTERACTIVE RBAC GRID)                     -->
        <!-- ===================================================================== -->
        <div x-show="activeTab === 'matrix'" class="space-y-4">
            <form action="{{ route('roles.matrix.update') }}" method="POST">
                @csrf

                <x-card padding="none" class="overflow-hidden shadow-lg">
                    <!-- Top Matrix Toolbar -->
                    <div class="p-4 border-b border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-xs font-bold text-slate-800">Bảng Đối Chiếu Ma Trận 2 Chiều</span>
                            <p class="text-[11px] text-slate-500">
                                Tích chọn gán cả Nhóm chức năng (Dev, System...) hoặc tinh chỉnh từng quyền hạn chi tiết và bấm Lưu.
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <x-button variant="primary" size="md" type="submit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Lưu Ma Trận Phân Quyền</span>
                            </x-button>
                        </div>
                    </div>

                    <!-- Scrollable Grid Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <!-- Table Header: Role Columns -->
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-100/70">
                                    <th class="p-4 min-w-[280px] sticky left-0 z-20 bg-slate-100/95 backdrop-blur-md font-bold text-slate-800">
                                        Nhóm Chức Năng & Quyền Hạn
                                    </th>
                                    @foreach($roles as $role)
                                        <th class="p-4 text-center min-w-[160px] align-top">
                                            <div class="flex flex-col items-center gap-1.5">
                                                <span class="px-2.5 py-1 rounded-xl text-[11px] font-bold border {{ $role->badge_classes }}">
                                                    {{ $role->name }}
                                                </span>
                                                <span class="text-[10px] text-slate-500 font-semibold">
                                                    {{ $role->members_count }} nhân sự
                                                </span>
                                                <a href="{{ route('roles.edit', $role) }}" class="text-[10px] text-indigo-600 hover:text-indigo-800 underline">
                                                    Sửa vai trò
                                                </a>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>

                            <!-- Table Body: Functional Groups and Modules -->
                            <tbody class="divide-y divide-slate-200/70">
                                <!-- ==================================================== -->
                                <!-- 1. FUNCTIONAL PERMISSION GROUPS (NHÓM CHỨC NĂNG)      -->
                                <!-- ==================================================== -->
                                <tr class="bg-gradient-to-r from-cyan-50/90 to-blue-50/90 dark:from-cyan-950/40 dark:to-blue-950/40 border-t-2 border-cyan-300 dark:border-cyan-700 font-bold">
                                    <td colspan="{{ 1 + $roles->count() }}" class="px-4 py-3.5 text-slate-900">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="text-lg">📦</span>
                                                <span class="text-sm font-extrabold uppercase tracking-wide text-cyan-900">
                                                    Gán Phân Quyền Theo Nhóm Chức Năng (Functional Permission Groups)
                                                </span>
                                                <span class="text-[11px] font-normal text-cyan-700">({{ $permissionGroups->count() }} nhóm chức năng)</span>
                                            </div>
                                            <span class="text-[11px] font-medium text-cyan-700">
                                                Tích chọn để gán toàn bộ nhóm quyền cho vai trò
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                @foreach($permissionGroups as $pGroup)
                                    <tr class="bg-cyan-50/20 hover:bg-cyan-50/40 border-b border-cyan-100 transition-colors">
                                        <td class="p-4 sticky left-0 z-10 bg-white/95 backdrop-blur-md border-r border-slate-100">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-base">{{ $pGroup->icon }}</span>
                                                    <span class="font-bold text-slate-900 text-xs">{{ $pGroup->name }}</span>
                                                    @if($pGroup->description)
                                                        <x-info-popover :text="$pGroup->description" color="cyan" size="sm" />
                                                    @endif
                                                    <x-badge :color="$pGroup->badge_color" size="sm">{{ count($pGroup->permissions ?? []) }} quyền</x-badge>
                                                </div>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach(array_slice($pGroup->permissions ?? [], 0, 3) as $k)
                                                        <code class="text-[9px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-mono">{{ $k }}</code>
                                                    @endforeach
                                                    @if(count($pGroup->permissions ?? []) > 3)
                                                        <span class="text-[9px] text-slate-400 font-medium">+{{ count($pGroup->permissions) - 3 }} nữa</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        @foreach($roles as $role)
                                            @php
                                                $isGroupAssigned = $role->hasPermissionGroup($pGroup->id);
                                            @endphp
                                            <td class="p-4 text-center align-middle bg-cyan-50/10">
                                                <label class="inline-flex flex-col items-center justify-center p-2 rounded-xl cursor-pointer hover:bg-cyan-100/60 transition-colors">
                                                    <input type="checkbox"
                                                           name="matrix_groups[{{ $role->id }}][]"
                                                           value="{{ $pGroup->id }}"
                                                           {{ $isGroupAssigned ? 'checked' : '' }}
                                                           class="w-5 h-5 rounded-lg text-cyan-600 bg-white border-slate-300 focus:ring-cyan-500 cursor-pointer">
                                                    <span class="text-[9px] font-semibold mt-1 text-slate-500">
                                                        {{ $isGroupAssigned ? 'Đã gán' : 'Chưa gán' }}
                                                    </span>
                                                </label>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                <!-- ==================================================== -->
                                <!-- 2. GRANULAR PERMISSIONS BY MODULE                    -->
                                <!-- ==================================================== -->
                                @foreach($permissionModules as $moduleKey => $module)
                                    <!-- Module Group Header Row -->
                                    <tr class="bg-indigo-50/40 dark:bg-indigo-950/30 border-t-2 border-indigo-200/60 dark:border-indigo-800/60 font-bold">
                                        <td colspan="{{ 1 + $roles->count() }}" class="px-4 py-3 text-slate-900">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-base">{{ $module['icon'] }}</span>
                                                    <span class="text-sm tracking-tight">{{ $module['name'] }}</span>
                                                    <span class="text-[11px] font-normal text-slate-500">({{ count($module['permissions']) }} quyền)</span>
                                                </div>
                                                <span class="text-[11px] font-normal text-slate-500">{{ $module['description'] }}</span>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Individual Permissions Rows -->
                                    @foreach($module['permissions'] as $permKey => $perm)
                                        <tr class="hover:bg-slate-50/80 transition-colors"
                                            x-show="matchesSearch('{{ addslashes($perm['name']) }}', '{{ addslashes($perm['description']) }}')">
                                            <!-- Permission Details -->
                                            <td class="p-4 sticky left-0 z-10 bg-white/95 backdrop-blur-md">
                                                <div class="space-y-0.5">
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-bold text-slate-800">{{ $perm['name'] }}</span>
                                                        @if(!empty($perm['description']))
                                                            <x-info-popover :text="$perm['description']" color="slate" size="sm" />
                                                        @endif
                                                        @if(!empty($perm['critical']))
                                                            <span class="px-1.5 py-0.2 rounded text-[9px] font-black uppercase tracking-wider bg-rose-100 text-rose-700 border border-rose-300">
                                                                Nguy hiểm
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <code class="text-[10px] font-mono text-indigo-600 bg-indigo-50/80 px-1.5 py-0.5 rounded">{{ $permKey }}</code>
                                                </div>
                                            </td>

                                            <!-- Checkbox for each role -->
                                            @foreach($roles as $role)
                                                @php
                                                    $hasPermission = \App\Services\PermissionRegistry::roleHasPermission($role->permissions, $permKey);
                                                @endphp
                                                <td class="p-4 text-center align-middle">
                                                    <label class="inline-flex items-center justify-center p-2 rounded-xl cursor-pointer hover:bg-slate-200/50 transition-colors">
                                                        <input type="checkbox"
                                                               name="matrix[{{ $role->id }}][]"
                                                               value="{{ $permKey }}"
                                                               {{ $hasPermission ? 'checked' : '' }}
                                                               class="w-4 h-4 rounded text-indigo-600 bg-white border-slate-300 focus:ring-indigo-500 cursor-pointer">
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>

                            <!-- Footer Summary Row -->
                            <tfoot>
                                <tr class="bg-slate-100/90 border-t-2 border-slate-300 font-bold">
                                    <td class="p-4 sticky left-0 z-20 bg-slate-100/95 backdrop-blur-md text-slate-800">
                                        Tổng số quyền được gán
                                    </td>
                                    @foreach($roles as $role)
                                        @php
                                            $grantedCount = 0;
                                            foreach(\App\Services\PermissionRegistry::allKeys() as $key) {
                                                if (\App\Services\PermissionRegistry::roleHasPermission($role->permissions, $key)) {
                                                    $grantedCount++;
                                                }
                                            }
                                            $totalKeys = count(\App\Services\PermissionRegistry::allKeys());
                                        @endphp
                                        <td class="p-4 text-center text-slate-900 font-mono text-xs">
                                            <span class="{{ $grantedCount === $totalKeys ? 'text-purple-700 font-black' : 'text-slate-700' }}">
                                                {{ $grantedCount }} / {{ $totalKeys }}
                                            </span>
                                        </td>
                                    @endforeach
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="p-4 bg-slate-50 border-t border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs text-slate-600 font-medium">
                            <x-info-popover text="Thay đổi sẽ có hiệu lực ngay sau khi bấm lưu. Mọi thành viên mang vai trò tương ứng sẽ được áp dụng quyền mới." color="slate" />
                            <span>Lưu ma trận phân quyền</span>
                        </div>
                        <x-button variant="primary" size="md" type="submit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Lưu Ma Trận Phân Quyền</span>
                        </x-button>
                    </div>
                </x-card>
            </form>
        </div>

        <!-- ===================================================================== -->
        <!-- TAB 2: FUNCTIONAL PERMISSION GROUPS DIRECTORY                         -->
        <!-- ===================================================================== -->
        <div x-show="activeTab === 'groups'" class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        Danh Mục Nhóm Quyền Chức Năng (Permission Groups)
                        <x-info-popover text="Các gói quyền chức năng được phân loại logic (Nhóm Dev, Nhóm System, Nhóm Quản Trị...)." color="cyan" />
                    </h3>
                </div>
                <x-button variant="primary" size="sm" href="{{ route('permission-groups.create') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Thêm nhóm chức năng</span>
                </x-button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($permissionGroups as $group)
                    <x-card padding="default" class="flex flex-col justify-between hover:border-cyan-300 transition-all shadow-md">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-2xl">{{ $group->icon }}</span>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                                            {{ $group->name }}
                                            <x-info-popover :text="$group->description" color="cyan" size="sm" />
                                        </h4>
                                        <span class="font-mono text-[10px] text-slate-400">#{{ $group->slug }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <x-badge :color="$group->badge_color" size="sm">
                                        {{ count($group->permissions ?? []) }} quyền
                                    </x-badge>
                                    @if($group->is_system)
                                        <span class="text-[9px] font-bold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200">
                                            Hệ thống
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <!-- Assigned Roles -->
                            <div class="pt-3 border-t border-slate-100 space-y-2">
                                <div class="flex items-center justify-between text-[11px]">
                                    <span class="font-bold text-slate-500">Vai trò đang sử dụng:</span>
                                    <span class="font-bold text-cyan-700">{{ $group->roles_count }} vai trò</span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($group->roles as $r)
                                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold border {{ $r->badge_classes }}">
                                            {{ $r->name }}
                                        </span>
                                    @empty
                                        <span class="text-[11px] text-slate-400 italic">Chưa gán cho vai trò nào</span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Permissions Preview -->
                            <div class="mt-3 pt-3 border-t border-slate-100 space-y-1.5">
                                <span class="text-[11px] font-bold text-slate-500 block">Quyền trong nhóm này:</span>
                                <div class="flex flex-wrap gap-1 max-h-24 overflow-y-auto pr-1">
                                    @foreach($group->permissions ?? [] as $perm)
                                        <code class="text-[9px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 font-mono">
                                            {{ $perm }}
                                        </code>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="mt-6 pt-3.5 border-t border-slate-100 flex items-center justify-end gap-2">
                            <x-button variant="secondary" size="sm" href="{{ route('permission-groups.edit', $group) }}">
                                <svg class="w-3.5 h-3.5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                <span>Điều chỉnh</span>
                            </x-button>

                            @if(!$group->is_system)
                                <form action="{{ route('permission-groups.destroy', $group) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhóm quyền {{ $group->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="danger" size="sm" type="submit">
                                        Xóa
                                    </x-button>
                                </form>
                            @endif
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>

        <!-- ===================================================================== -->
        <!-- TAB 3: ROLES DIRECTORY (LIST & MANAGEMENT)                            -->
        <!-- ===================================================================== -->
        <div x-show="activeTab === 'roles'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($roles as $role)
                    <x-card padding="default" class="flex flex-col justify-between hover:border-purple-300 transition-all">
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-bold px-3 py-1 rounded-xl border {{ $role->badge_classes }}">
                                        {{ $role->name }}
                                    </span>
                                    <span class="font-mono text-[10px] text-slate-400">#{{ $role->slug }}</span>
                                    <x-info-popover :text="$role->description" color="slate" size="sm" />
                                </div>
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-700">
                                    {{ $role->members_count }} nhân sự
                                </span>
                            </div>

                            <!-- Functional Groups Assigned to this Role -->
                            <div class="space-y-1.5 pt-3 border-t border-slate-100">
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">
                                    Nhóm chức năng sở hữu:
                                </span>
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($role->permissionGroups as $grp)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-xs font-semibold bg-cyan-50 text-cyan-800 border border-cyan-200">
                                            <span>{{ $grp->icon }}</span>
                                            <span>{{ $grp->name }}</span>
                                        </span>
                                    @empty
                                        <span class="text-[11px] text-slate-400 italic">Chưa gán nhóm chức năng cụ thể</span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Permissions Badges Preview -->
                            <div class="space-y-2 mt-3 pt-3 border-t border-slate-100">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">
                                        Tổng quyền có hiệu lực:
                                    </span>
                                    <span class="text-[11px] font-bold text-purple-700 font-mono">
                                        {{ count((array)$role->permissions) }} quyền
                                    </span>
                                </div>

                                <div class="flex flex-wrap gap-1.5 max-h-24 overflow-y-auto pr-1">
                                    @if($role->permissions)
                                        @foreach($role->permissions as $perm)
                                            <span class="px-2 py-0.5 rounded-lg text-[10px] font-mono font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                                ✓ {{ $perm }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-xs text-slate-400 italic">Chưa phân quyền</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Members with this Role -->
                            <div class="mt-4 pt-3.5 border-t border-slate-100">
                                <span class="text-[11px] font-bold text-slate-600 block mb-2">Thành viên đảm nhận:</span>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($role->members as $m)
                                        <a href="{{ route('members.show', $m) }}"
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-800 border border-slate-200 text-xs transition-colors shadow-sm">
                                            <x-avatar :name="$m->name" :url="$m->avatar_url" size="sm" />
                                            <span class="font-semibold">{{ $m->name }}</span>
                                            <span class="text-[10px] text-cyan-700 font-bold">({{ $m->projects->count() }} dự án)</span>
                                        </a>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">Chưa có thành viên nào mang vai trò này.</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="mt-6 pt-3.5 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('members.index', ['role_id' => $role->id]) }}" class="text-xs font-bold text-purple-700 hover:text-purple-900 transition-colors">
                                Xem danh sách thành viên &rarr;
                            </a>

                            <div class="flex items-center gap-2">
                                <x-button variant="secondary" size="sm" href="{{ route('roles.edit', $role) }}">
                                    <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    <span>Chỉnh sửa</span>
                                </x-button>

                                @if($role->members_count === 0)
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa vai trò {{ $role->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-button variant="danger" size="sm" type="submit">
                                            Xóa
                                        </x-button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
