<x-layouts.app>
    <x-slot:title>{{ $member->name }} - Hồ Sơ & Dự Án Phụ Trách</x-slot:title>
    <x-slot:header>Hồ Sơ Thành Viên: {{ $member->name }}</x-slot:header>

    <div class="space-y-8">
        <!-- Top Back Breadcrumb & Header Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Quay lại danh sách thành viên</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('members.edit', $member) }}"
                   class="px-4 py-2 rounded-xl text-xs font-semibold text-white mica-pill hover:bg-white/10 flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    <span>Chỉnh sửa thông tin</span>
                </a>
            </div>
        </div>

        <!-- Profile Hero Banner (Mica Ultra-Colorful) -->
        @php
            $status = $member->status_badge;
            $totalAlloc = $member->total_allocation;
        @endphp
        <div class="relative overflow-hidden rounded-3xl p-8 mica-card border border-white/15">
            <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-gradient-to-br from-violet-600/30 via-fuchsia-600/20 to-cyan-500/30 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <div class="relative shrink-0">
                        <img class="w-24 h-24 rounded-3xl object-cover ring-4 ring-white/15 shadow-2xl"
                             src="{{ $member->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=6366f1&color=fff' }}"
                             alt="{{ $member->name }}">
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-slate-950 {{ $status['dot'] }}"></span>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center gap-3 flex-wrap">
                            <h2 class="text-2xl font-extrabold text-white tracking-tight">{{ $member->name }}</h2>
                            @if($member->is_team_lead)
                                <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                    ★ TRƯỞNG NHÓM
                                </span>
                            @endif
                            <span class="px-3 py-1 rounded-xl text-xs font-bold border {{ $member->role->badge_classes }}">
                                {{ $member->role->name }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full border text-xs font-medium {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4 text-xs text-slate-300 flex-wrap">
                            <span class="flex items-center gap-1.5 font-mono">
                                📧 {{ $member->email }}
                            </span>
                            @if($member->phone)
                                <span class="flex items-center gap-1.5">
                                    📞 {{ $member->phone }}
                                </span>
                            @endif
                            <span class="flex items-center gap-1.5">
                                🏢 Phòng ban: <strong class="text-white">{{ $member->team->name ?? 'Chưa phân nhóm' }}</strong>
                            </span>
                            @if($member->joined_at)
                                <span class="text-slate-400">
                                    Gia nhập: {{ $member->joined_at->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>

                        @if($member->bio)
                            <p class="text-xs text-slate-400 max-w-2xl pt-1 leading-relaxed">{{ $member->bio }}</p>
                        @endif
                    </div>
                </div>

                <!-- Total Workload Meter Gauge -->
                <div class="shrink-0 p-4 rounded-2xl bg-white/[0.04] border border-white/10 text-right min-w-[180px]">
                    <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Tổng hạn mức tải</div>
                    <div class="text-3xl font-black {{ $totalAlloc > 100 ? 'text-rose-400' : ($totalAlloc > 80 ? 'text-amber-400' : 'text-emerald-400') }}">
                        {{ $totalAlloc }}%
                    </div>
                    <div class="text-[11px] text-slate-400 mt-0.5">
                        Đang phụ trách <strong class="text-cyan-300">{{ $member->projects->count() }} dự án</strong>
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
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(6,182,212,0.8)]"></span>
                            Dự Án Đang Phụ Trách ({{ $member->projects->count() }})
                        </h3>
                        <p class="text-xs text-slate-400">Thành viên có thể đảm nhiệm vai trò và khối lượng công việc khác nhau trong từng dự án.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($member->projects as $project)
                        @php
                            $pStatus = $project->status_badge;
                            $pPriority = $project->priority_badge;
                        @endphp
                        <div class="mica-card rounded-2xl p-5 border border-white/10 hover:border-cyan-400/40 transition-all">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <span class="font-mono text-xs px-2 py-0.5 rounded-md bg-white/5 border border-white/10 text-cyan-300 font-bold">
                                            {{ $project->code }}
                                        </span>
                                        <a href="{{ route('projects.show', $project) }}" class="font-bold text-white text-base hover:text-cyan-300 transition-colors">
                                            {{ $project->name }}
                                        </a>
                                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full border {{ $pStatus['class'] }}">
                                            {{ $pStatus['label'] }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-1 line-clamp-1">{{ $project->description }}</p>
                                </div>

                                <!-- Unassign Button Form -->
                                <form action="{{ route('members.projects.destroy', [$member, $project]) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn rút thành viên {{ $member->name }} khỏi dự án {{ $project->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-2.5 py-1 rounded-lg text-xs font-medium bg-rose-500/10 hover:bg-rose-500/20 text-rose-300 border border-rose-500/20 transition-colors">
                                        Gỡ khỏi dự án
                                    </button>
                                </form>
                            </div>

                            <!-- Member's Specific Project Role & Allocation in this project -->
                            <div class="mt-4 p-3.5 rounded-xl bg-white/[0.03] border border-white/5 grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                                <div>
                                    <span class="text-slate-400 text-[11px] block">Vai trò trong dự án:</span>
                                    <span class="text-white font-bold text-sm text-gradient-fluent">{{ $project->pivot->role_in_project }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 text-[11px] block">Mức tải phân bổ:</span>
                                    <span class="text-cyan-300 font-bold text-sm">{{ $project->pivot->allocation_percent }}% Workload</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 text-[11px] block">Ngày nhận nhiệm vụ:</span>
                                    <span class="text-slate-200 font-medium text-xs">
                                        {{ $project->pivot->assigned_at ? \Carbon\Carbon::parse($project->pivot->assigned_at)->format('d/m/Y') : 'Ban đầu' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Project Progress -->
                            <div class="mt-3">
                                <div class="flex items-center justify-between text-xs mb-1 font-medium">
                                    <span class="text-slate-400">Tiến độ tổng thể dự án</span>
                                    <span class="text-white font-bold">{{ $project->progress }}%</span>
                                </div>
                                <div class="w-full bg-slate-800/80 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r {{ $project->color }} rounded-full" style="width: {{ $project->progress }}%;"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400 mica-card rounded-2xl">
                            <p class="font-semibold text-white mb-1">Chưa phân công dự án nào</p>
                            <p class="text-xs">Sử dụng bảng bên phải để bổ nhiệm thành viên này phụ trách dự án.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Col: Quick Assign New Project & Permissions Box -->
            <div class="space-y-6">
                <!-- Quick Assign Project Form -->
                <div class="mica-card rounded-2xl p-6 border border-white/10 space-y-4">
                    <div>
                        <h3 class="text-base font-bold text-white flex items-center gap-2">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Phân Công Thêm Dự Án Mới
                        </h3>
                        <p class="text-xs text-slate-400">Giao thêm trọng trách dự án cho thành viên này</p>
                    </div>

                    @if($availableProjects->isNotEmpty())
                        <form action="{{ route('members.projects.store', $member) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Chọn dự án</label>
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
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Vai trò trong dự án này</label>
                                <input type="text"
                                       name="role_in_project"
                                       required
                                       placeholder="VD: Project Lead, Architect, Reviewer, Developer..."
                                       value="Core Contributor"
                                       class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                            </div>

                            <div>
                                <div class="flex items-center justify-between text-xs font-semibold text-slate-300 mb-1">
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
                        <div class="p-4 rounded-xl bg-white/5 border border-white/5 text-xs text-slate-400 text-center">
                            Thành viên đã tham gia toàn bộ các dự án hiện có!
                        </div>
                    @endif
                </div>

                <!-- Role Permissions Box -->
                <div class="mica-card rounded-2xl p-6 border border-white/10 space-y-3">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-400"></span>
                        Quyền Hạn Của Vai Trò ({{ $member->role->name }})
                    </h3>
                    <p class="text-xs text-slate-400">{{ $member->role->description }}</p>

                    <div class="flex flex-wrap gap-1.5 pt-2">
                        @if($member->role->permissions)
                            @foreach($member->role->permissions as $perm)
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-mono font-medium bg-purple-500/10 text-purple-300 border border-purple-500/20">
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
