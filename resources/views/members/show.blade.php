<x-layouts.app>
    <x-slot:title>{{ $member->name }} - Hồ Sơ & Dự Án Phụ Trách</x-slot:title>
    <x-slot:header>Hồ Sơ Thành Viên: {{ $member->name }}</x-slot:header>

    <div class="space-y-8">
        <!-- Top Back Breadcrumb & Header Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Quay lại danh sách thành viên</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('members.edit', $member) }}"
                   class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white/80 hover:bg-slate-100 border border-slate-200 shadow-sm flex items-center gap-2 transition-all">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    <span>Chỉnh sửa thông tin</span>
                </a>
            </div>
        </div>

        <!-- Profile Hero Banner (Fluent 2 Light Mica) -->
        @php
            $status = $member->status_badge;
            $totalAlloc = $member->total_allocation;
        @endphp
        <div class="relative overflow-hidden rounded-3xl p-8 mica-card border border-white/80 shadow-lg shadow-indigo-500/5">
            <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-gradient-to-br from-violet-200/50 via-fuchsia-200/40 to-cyan-200/40 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <div class="relative shrink-0">
                        <img class="w-24 h-24 rounded-3xl object-cover ring-4 ring-white dark:ring-[var(--bg-surface-solid)] shadow-md"
                             src="{{ $member->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=6366f1&color=fff' }}"
                             alt="{{ $member->name }}">
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white dark:border-[var(--bg-surface-solid)] {{ $status['dot'] }}"></span>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center gap-3 flex-wrap">
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $member->name }}</h2>
                            @if($member->is_team_lead)
                                <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-300">
                                    ★ TRƯỞNG NHÓM
                                </span>
                            @endif
                            <span class="px-3 py-1 rounded-xl text-xs font-bold border {{ $member->role->badge_classes }}">
                                {{ $member->role->name }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full border text-xs font-semibold {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4 text-xs text-slate-600 font-medium flex-wrap">
                            <span class="flex items-center gap-1.5 font-mono">
                                📧 {{ $member->email }}
                            </span>
                            @if($member->phone)
                                <span class="flex items-center gap-1.5">
                                    📞 {{ $member->phone }}
                                </span>
                            @endif
                            <span class="flex items-center gap-1.5">
                                🏢 Phòng ban: <strong class="text-slate-900 font-bold">{{ $member->team->name ?? 'Chưa phân nhóm' }}</strong>
                            </span>
                            @if($member->joined_at)
                                <span class="text-slate-500">
                                    Gia nhập: {{ $member->joined_at->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>

                        @if($member->bio)
                            <p class="text-xs text-slate-600 max-w-2xl pt-1 leading-relaxed">{{ $member->bio }}</p>
                        @endif
                    </div>
                </div>

                <!-- Total Workload Meter Gauge -->
                <div class="shrink-0 p-4 rounded-2xl bg-white/80 border border-slate-200/80 shadow-sm text-right min-w-[180px]">
                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tổng hạn mức tải</div>
                    <div class="text-3xl font-black {{ $totalAlloc > 100 ? 'text-rose-600' : ($totalAlloc > 80 ? 'text-amber-600' : 'text-emerald-600') }}">
                        {{ $totalAlloc }}%
                    </div>
                    <div class="text-[11px] text-slate-500 mt-0.5">
                        Đang phụ trách <strong class="text-indigo-600">{{ $member->projects->count() }} dự án</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid 2 Columns: Assigned Projects vs Quick Assign & Permissions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Assigned Projects (Highlighting Many-to-Many assignments) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-cyan-500 shadow-[0_0_10px_rgba(6,182,212,0.4)]"></span>
                            <span>Dự Án Đang Phụ Trách ({{ $member->projects->count() }})</span>
                            <x-info-popover text="Thành viên có thể đảm nhiệm vai trò và khối lượng công việc khác nhau trong từng dự án." color="cyan" size="sm" />
                        </h3>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($member->projects as $project)
                        @php
                            $pStatus = $project->status_badge;
                            $pPriority = $project->priority_badge;
                        @endphp
                        <div class="mica-card rounded-2xl p-5 border border-slate-200/80 hover:border-indigo-400/50 hover:shadow-md transition-all">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <span class="font-mono text-xs px-2 py-0.5 rounded-md bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold">
                                            {{ $project->code }}
                                        </span>
                                        <a href="{{ route('projects.show', $project) }}" class="font-bold text-slate-900 text-base hover:text-indigo-600 transition-colors">
                                            {{ $project->name }}
                                        </a>
                                        @if($project->description)
                                            <x-info-popover :text="$project->description" color="blue" size="sm" />
                                        @endif
                                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full border {{ $pStatus['class'] }}">
                                            {{ $pStatus['label'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Unassign Button Form -->
                                <form action="{{ route('members.projects.destroy', [$member, $project]) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn rút thành viên {{ $member->name }} khỏi dự án {{ $project->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition-colors">
                                        Gỡ khỏi dự án
                                    </button>
                                </form>
                            </div>

                            <!-- Member's Specific Project Role & Allocation in this project -->
                            <div class="mt-4 p-3.5 rounded-xl bg-slate-50/80 border border-slate-200/60 grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                                <div>
                                    <span class="text-slate-500 text-[11px] font-medium block">Vai trò trong dự án:</span>
                                    <span class="text-indigo-700 font-bold text-sm">{{ $project->pivot->role_in_project }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 text-[11px] font-medium block">Mức tải phân bổ:</span>
                                    <span class="text-cyan-700 font-bold text-sm">{{ $project->pivot->allocation_percent }}% Workload</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 text-[11px] font-medium block">Ngày nhận nhiệm vụ:</span>
                                    <span class="text-slate-700 font-semibold text-xs">
                                        {{ $project->pivot->assigned_at ? \Carbon\Carbon::parse($project->pivot->assigned_at)->format('d/m/Y') : 'Ban đầu' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Project Progress -->
                            <div class="mt-3">
                                <div class="flex items-center justify-between text-xs mb-1 font-medium">
                                    <span class="text-slate-500">Tiến độ tổng thể dự án</span>
                                    <span class="text-slate-900 font-bold">{{ $project->progress }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden border border-slate-200/60">
                                    <div class="h-full bg-gradient-to-r {{ $project->color }} rounded-full" style="width: {{ $project->progress }}%;"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 mica-card rounded-2xl border border-slate-200/70">
                            <p class="font-bold text-slate-800 mb-1">Chưa phân công dự án nào</p>
                            <p class="text-xs">Sử dụng bảng bên phải để bổ nhiệm thành viên này phụ trách dự án.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Col: Quick Assign New Project & Permissions Box -->
            <div class="space-y-6">
                <!-- Quick Assign Project Form -->
                <div class="mica-card rounded-2xl p-6 border border-slate-200/80 space-y-4 shadow-sm">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Phân Công Thêm Dự Án Mới</span>
                            <x-info-popover text="Giao thêm trọng trách dự án cho thành viên này." color="cyan" size="sm" />
                        </h3>
                    </div>

                    @if($availableProjects->isNotEmpty())
                        <form action="{{ route('members.projects.store', $member) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Chọn dự án</label>
                                <select name="project_id" required class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                                    <option value="">-- Chọn dự án khả dụng --</option>
                                    @foreach($availableProjects as $availProject)
                                        <option value="{{ $availProject->id }}">
                                            {{ $availProject->code }} - {{ $availProject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Vai trò trong dự án này</label>
                                <input type="text"
                                       name="role_in_project"
                                       required
                                       placeholder="VD: Project Lead, Architect, Reviewer, Developer..."
                                       value="Core Contributor"
                                       class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                            </div>

                            <div>
                                <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-1">
                                    <span>Hạn mức phân bổ (% Workload)</span>
                                </div>
                                <select name="allocation_percent" required class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                                    <option value="20">20% - Hỗ trợ / Tư vấn bán thời gian</option>
                                    <option value="30">30% - Đóng góp phụ trách module</option>
                                    <option value="50" selected>50% - Thành viên nòng cốt chính</option>
                                    <option value="70">70% - Dẫn dắt kỹ thuật chính</option>
                                    <option value="100">100% - Toàn thời gian duy nhất</option>
                                </select>
                            </div>

                            <button type="submit"
                                    class="w-full py-2.5 rounded-xl text-xs font-bold text-white glow-btn-primary shadow-md">
                                Xác nhận phân công dự án
                            </button>
                        </form>
                    @else
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-500 text-center">
                            Thành viên đã tham gia toàn bộ các dự án hiện có!
                        </div>
                    @endif
                </div>

                <!-- Role Permissions Box -->
                <div class="mica-card rounded-2xl p-6 border border-slate-200/80 space-y-3 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <span>Quyền Hạn Của Vai Trò ({{ $member->role->name }})</span>
                        @if($member->role->description)
                            <x-info-popover :text="$member->role->description" color="slate" size="sm" />
                        @endif
                    </h3>

                    <div class="flex flex-wrap gap-1.5 pt-2">
                        @if($member->role->permissions)
                            @foreach($member->role->permissions as $perm)
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-mono font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                    ✓ {{ str_replace('_', ' ', $perm) }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-xs text-slate-500">Quyền hạn cơ bản</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
