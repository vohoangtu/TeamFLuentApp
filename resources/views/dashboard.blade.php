<x-layouts.app>
    <x-slot:title>Bảng Điều Khiển Quản Trị - TeamNexus Mica</x-slot:title>
    <x-slot:header>Tổng Quan Năng Suất & Đa Dự Án</x-slot:header>

    <div class="space-y-8">
        <!-- Hero Welcome Mica Ultra Colorful Banner (Light Theme) -->
        <div class="relative overflow-hidden rounded-3xl p-8 mica-card border border-white/80 shadow-[0_8px_30px_rgba(148,163,184,0.15)]">
            <div class="absolute -right-10 -bottom-10 w-96 h-96 rounded-full bg-gradient-to-br from-fuchsia-300/30 via-violet-300/20 to-cyan-200/30 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="max-w-2xl space-y-2">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full mica-pill text-xs font-bold shadow-sm text-slate-800"
                         x-data="{ currentTheme: window.ThemeManager ? window.ThemeManager.getCurrentTheme() : { name: 'Fluent 2 Mica Light', icon: '🎨' } }"
                         x-init="window.addEventListener('theme-changed', (e) => currentTheme = e.detail.themeObj)">
                        <span class="w-2 h-2 rounded-full bg-cyan-500 animate-ping"></span>
                        <span x-text="currentTheme.icon + ' ' + currentTheme.name"></span>
                        <span class="text-[10px] text-slate-500 font-medium">&bull; Active Design System</span>
                    </div>
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2 flex-wrap">
                        <span>Hệ thống điều phối <span class="text-gradient-fluent">Thành viên & Đa dự án</span></span>
                        <x-info-popover text="Theo dõi phân bổ nguồn lực thời gian thực. Mỗi thành viên được tối ưu hóa năng suất khi phụ trách nhiều dự án cùng lúc với vai trò và hạn mức công việc riêng biệt." color="cyan" />
                    </h2>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('members.create') }}"
                       class="glow-btn-primary px-5 py-3 rounded-2xl text-xs font-bold text-white flex items-center gap-2.5 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Thêm thành viên mới</span>
                    </a>
                    <a href="{{ route('projects.create') }}"
                       class="px-5 py-3 rounded-2xl text-xs font-bold text-slate-700 mica-pill hover:bg-slate-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Tạo dự án mới</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 4 KPI Mica Cards (Light Theme) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Metric 1: Total Members -->
            <div class="mica-card rounded-2xl p-5 border border-white/80 group hover:border-purple-300">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tổng thành viên</span>
                    <div class="w-10 h-10 rounded-xl bg-purple-100 border border-purple-200 flex items-center justify-center text-purple-700 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalMembers }}</span>
                    <span class="text-xs text-emerald-700 font-bold flex items-center gap-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> 100% Hoạt động
                    </span>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>Phân bổ vào {{ $totalTeams }} phòng ban</span>
                    <a href="{{ route('members.index') }}" class="text-purple-600 hover:text-purple-700 font-bold">Chi tiết &rarr;</a>
                </div>
            </div>

            <!-- Metric 2: Multi-Project Assignees -->
            <div class="mica-card rounded-2xl p-5 border border-cyan-200/90 group hover:border-cyan-400 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-cyan-800 uppercase tracking-wider">Phụ trách đa dự án</span>
                    <div class="w-10 h-10 rounded-xl bg-cyan-100 border border-cyan-200 flex items-center justify-center text-cyan-700 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-cyan-900 tracking-tight">{{ $multiProjectMembersCount }}</span>
                    <span class="text-xs text-cyan-700 font-bold">thành viên &ge; 2 dự án</span>
                </div>
                <div class="mt-3 pt-3 border-t border-cyan-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>Đạt hiệu suất đa nhiệm cao</span>
                    <a href="{{ route('members.index', ['multi_project' => 1]) }}" class="text-cyan-700 hover:text-cyan-800 font-bold">Lọc ngay &rarr;</a>
                </div>
            </div>

            <!-- Metric 3: Total Projects -->
            <div class="mica-card rounded-2xl p-5 border border-white/80 group hover:border-fuchsia-300">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Dự án hoạt động</span>
                    <div class="w-10 h-10 rounded-xl bg-fuchsia-100 border border-fuchsia-200 flex items-center justify-center text-fuchsia-700 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalProjects }}</span>
                    <span class="text-xs text-fuchsia-700 font-bold">toàn doanh nghiệp</span>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>Tiến độ trung bình 75%</span>
                    <a href="{{ route('projects.index') }}" class="text-fuchsia-600 hover:text-fuchsia-700 font-bold">Tất cả dự án &rarr;</a>
                </div>
            </div>

            <!-- Metric 4: Workload Allocation -->
            <div class="mica-card rounded-2xl p-5 border border-white/80 group hover:border-emerald-300">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tải phân bổ TB</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 border border-emerald-200 flex items-center justify-center text-emerald-700 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $averageAllocation }}%</span>
                    <span class="text-xs {{ $averageAllocation > 90 ? 'text-amber-700' : 'text-emerald-700' }} font-bold">
                        {{ $averageAllocation > 90 ? 'Gần tối đa' : 'Cân bằng lý tưởng' }}
                    </span>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>Quá tải (>100%): {{ $overloadedMembers->count() }} người</span>
                    <span class="text-xs text-slate-500 font-bold">Real-time</span>
                </div>
            </div>
        </div>

        <!-- Section: Active Projects with Member Assignment Stacks -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: High Priority Projects Spotlight -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-violet-600 to-fuchsia-600"></span>
                            <span>Dự Án Trọng Điểm Đang Triển Khai</span>
                            <x-info-popover text="Danh sách các dự án ưu tiên cùng đội ngũ nhân sự phụ trách." color="blue" size="sm" />
                        </h3>
                    </div>
                    <a href="{{ route('projects.index') }}" class="text-xs font-bold text-purple-700 hover:text-purple-800">Xem tất cả &rarr;</a>
                </div>

                <div class="space-y-4">
                    @forelse($activeProjects as $project)
                        @php
                            $status = $project->status_badge;
                            $priority = $project->priority_badge;
                        @endphp
                        <div class="mica-card rounded-2xl p-5 border border-white/80 hover:border-purple-300 transition-all">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <span class="font-mono text-xs px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold">{{ $project->code }}</span>
                                        <a href="{{ route('projects.show', $project) }}" class="font-bold text-slate-900 dark:text-slate-100 text-base hover:text-purple-700 dark:hover:text-purple-400 transition-colors">
                                            {{ $project->name }}
                                        </a>
                                        @if($project->description)
                                            <x-info-popover :text="$project->description" color="blue" size="sm" />
                                        @endif
                                        <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border {{ $status['class'] }}">
                                            <span class="inline-block w-1.5 h-1.5 rounded-full mr-1 {{ $status['dot'] }}"></span>
                                            {{ $status['label'] }}
                                        </span>
                                        <span class="text-[11px] font-medium px-2 py-0.5 rounded-full border {{ $priority['class'] }}">
                                            {{ $priority['label'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="text-right shrink-0">
                                    <div class="text-xs text-slate-500 font-medium">Hạn chót: <span class="text-slate-800 font-bold">{{ $project->due_date ? $project->due_date->format('d/m/Y') : 'Chưa định' }}</span></div>
                                    <div class="text-xs text-slate-500 mt-0.5 font-medium">Ngân sách: <span class="text-emerald-700 font-extrabold">${{ number_format($project->budget, 0) }}</span></div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-4">
                                <div class="flex items-center justify-between text-xs mb-1.5 font-medium">
                                    <span class="text-slate-500">Tiến độ thực thi</span>
                                    <span class="text-cyan-800 font-extrabold">{{ $project->progress }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200/80">
                                    <div class="h-full bg-gradient-to-r {{ $project->color }} rounded-full transition-all duration-500" style="width: {{ $project->progress }}%;"></div>
                                </div>
                            </div>

                            <!-- Assigned Members Showcase -->
                            <div class="mt-4 pt-3.5 border-t border-slate-100 flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-bold text-slate-600">Đội ngũ phụ trách ({{ $project->members->count() }}):</span>
                                    <div class="flex -space-x-2 overflow-hidden items-center">
                                        @foreach($project->members->take(5) as $member)
                                            <a href="{{ route('members.show', $member) }}" title="{{ $member->name }} - {{ $member->pivot->role_in_project }} ({{ $member->pivot->allocation_percent }}%)" class="inline-block relative">
                                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-[var(--bg-surface-solid)] object-cover shadow-sm transition-transform hover:scale-110 hover:z-10"
                                                     src="{{ $member->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=6366f1&color=fff' }}"
                                                     alt="{{ $member->name }}">
                                            </a>
                                        @endforeach
                                        @if($project->members->count() > 5)
                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full ring-2 ring-white dark:ring-[var(--bg-surface-solid)] bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold shadow-sm"
                                                  title="Và {{ $project->members->count() - 5 }} thành viên khác">
                                                +{{ $project->members->count() - 5 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] text-slate-500 font-medium">Trọng trách chính:</span>
                                    @if($lead = $project->members->firstWhere('pivot.role_in_project', '!=', 'Contributor'))
                                        <span class="text-[11px] font-bold text-purple-700 px-2.5 py-0.5 rounded-lg bg-purple-100 border border-purple-200">
                                            {{ $lead->name }} ({{ $lead->pivot->role_in_project }})
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 mica-card rounded-2xl">
                            Chưa có dự án nào đang hoạt động.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Col: Multi-Project Workload Spotlight (Light Theme) -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-cyan-600"></span>
                            <span>Nhân Sự Đa Dự Án</span>
                            <x-info-popover text="Thành viên kiêm nhiệm nhiều dự án." color="cyan" size="sm" />
                        </h3>
                    </div>
                </div>

                <div class="space-y-3.5">
                    @foreach($recentAssignments as $member)
                        <div class="mica-card rounded-2xl p-4 border border-white/80 hover:border-cyan-300 transition-all">
                            <div class="flex items-center justify-between mb-2.5">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img class="w-10 h-10 rounded-xl object-cover ring-2 ring-slate-200 dark:ring-[var(--bg-surface-solid)] shadow-sm"
                                             src="{{ $member->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=6366f1&color=fff' }}"
                                             alt="{{ $member->name }}">
                                        @if($member->is_team_lead)
                                            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-amber-400 rounded-full border border-white dark:border-[var(--bg-surface-solid)] flex items-center justify-center text-[8px] font-black text-slate-950" title="Team Lead">★</span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('members.show', $member) }}" class="text-sm font-bold text-slate-900 hover:text-cyan-700 transition-colors">
                                            {{ $member->name }}
                                        </a>
                                        <p class="text-[11px] text-slate-500 font-medium">{{ $member->team->name ?? 'Chưa phân nhóm' }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold px-2 py-0.5 rounded-md {{ $member->role->badge_classes }}">
                                    {{ $member->role->name }}
                                </span>
                            </div>

                            <!-- List of projects this member handles -->
                            <div class="mt-3 pt-2.5 border-t border-slate-100 space-y-1.5">
                                <div class="flex items-center justify-between text-[11px] text-slate-500 font-medium">
                                    <span>Các dự án phụ trách ({{ $member->projects->count() }}):</span>
                                    <span class="font-extrabold {{ $member->total_allocation > 100 ? 'text-rose-700' : 'text-emerald-700' }}">
                                        Tổng tải: {{ $member->total_allocation }}%
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($member->projects as $p)
                                        <a href="{{ route('projects.show', $p) }}"
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition-colors"
                                           title="{{ $p->pivot->role_in_project }} ({{ $p->pivot->allocation_percent }}%)">
                                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-600"></span>
                                            <span class="truncate max-w-[130px]">{{ $p->name }}</span>
                                            <span class="text-cyan-800 font-bold">({{ $p->pivot->allocation_percent }}%)</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Section: Teams & Roles Matrix (Light Theme) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Teams Overview -->
            <div class="mica-card rounded-2xl p-6 border border-white/80">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span>Phòng Ban & Nhóm Chức Năng</span>
                            <x-info-popover text="Cơ cấu tổ chức doanh nghiệp." color="emerald" size="sm" />
                        </h3>
                    </div>
                    <a href="{{ route('teams.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800">Quản lý nhóm &rarr;</a>
                </div>

                <div class="space-y-3">
                    @foreach($teams as $team)
                        <div class="p-3.5 rounded-xl bg-slate-50/90 dark:bg-white/5 hover:bg-white dark:hover:bg-white/10 border border-slate-200/80 dark:border-white/10 flex items-center justify-between transition-all shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr {{ $team->color }} flex items-center justify-center font-mono font-bold text-white text-xs shadow-md">
                                    {{ $team->code }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('teams.show', $team) }}" class="text-sm font-bold text-slate-900 dark:text-slate-100 hover:text-cyan-700 dark:hover:text-cyan-400 transition-colors">
                                            {{ $team->name }}
                                        </a>
                                        @if($team->description)
                                            <x-info-popover :text="$team->description" color="emerald" size="sm" />
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                        Trưởng nhóm: <span class="text-slate-800 dark:text-slate-200 font-bold">{{ $team->lead->name ?? 'Chưa chỉ định' }}</span>
                                    </p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                {{ $team->members_count }} nhân sự
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Roles & Permissions Overview -->
            <div class="mica-card rounded-2xl p-6 border border-white/80">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span>Vai Trò & Quyền Hạn (RBAC)</span>
                            <x-info-popover text="Phân quyền bảo mật Fluent 2." color="slate" size="sm" />
                        </h3>
                    </div>
                    <a href="{{ route('roles.index') }}" class="text-xs font-bold text-purple-700 hover:text-purple-800">Xem ma trận quyền &rarr;</a>
                </div>

                <div class="space-y-3">
                    @foreach($roles as $role)
                        <div class="p-3.5 rounded-xl bg-slate-50/90 dark:bg-white/5 hover:bg-white dark:hover:bg-white/10 border border-slate-200/80 dark:border-white/10 flex items-center justify-between transition-all shadow-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-lg {{ $role->badge_classes }}">
                                    {{ $role->name }}
                                </span>
                                @if($role->description)
                                    <x-info-popover :text="$role->description" color="slate" size="sm" />
                                @endif
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 px-2 py-1 rounded-md bg-slate-100 dark:bg-slate-800 shrink-0 ml-2 border border-slate-200 dark:border-slate-700">
                                {{ $role->members_count }} người
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
