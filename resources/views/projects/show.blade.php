<x-layouts.app>
    <x-slot:title>{{ $project->name }} - Chi Tiết & Đội Ngũ Dự Án</x-slot:title>
    <x-slot:header>Dự Án: {{ $project->name }}</x-slot:header>

    <div class="space-y-8">
        <!-- Top Back Breadcrumb & Header Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Quay lại danh sách dự án</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('projects.edit', $project) }}"
                   class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white/80 hover:bg-slate-100 border border-slate-200 shadow-sm flex items-center gap-2 transition-all">
                    <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    <span>Sửa dự án</span>
                </a>
            </div>
        </div>

        <!-- Project Hero Card (Fluent 2 Light Mica) -->
        @php
            $status = $project->status_badge;
            $priority = $project->priority_badge;
        @endphp
        <div class="relative overflow-hidden rounded-3xl p-8 mica-card border border-white/80 shadow-lg shadow-indigo-500/5">
            <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-gradient-to-br from-cyan-200/50 via-indigo-200/40 to-fuchsia-200/40 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <span class="font-mono text-xs px-3 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold">
                                {{ $project->code }}
                            </span>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $status['class'] }}">
                                <span class="inline-block w-2 h-2 rounded-full mr-1.5 {{ $status['dot'] }}"></span>
                                {{ $status['label'] }}
                            </span>
                            <span class="text-xs font-medium px-3 py-1 rounded-full border {{ $priority['class'] }}">
                                {{ $priority['label'] }}
                            </span>
                        </div>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $project->name }}</h2>
                    </div>

                    <div class="flex items-center gap-4 text-right">
                        <div class="p-3.5 rounded-2xl bg-white/80 border border-slate-200/80 shadow-sm">
                            <span class="text-[11px] text-slate-500 uppercase tracking-wider block font-bold">Ngân sách</span>
                            <span class="text-xl font-black text-emerald-700">${{ number_format($project->budget, 0) }}</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/80 border border-slate-200/80 shadow-sm">
                            <span class="text-[11px] text-slate-500 uppercase tracking-wider block font-bold">Hạn hoàn thành</span>
                            <span class="text-base font-bold text-slate-800">{{ $project->due_date ? $project->due_date->format('d/m/Y') : 'Chưa định' }}</span>
                        </div>
                    </div>
                </div>

                <p class="text-sm text-slate-600 max-w-4xl leading-relaxed">{{ $project->description }}</p>

                <!-- Big Progress Gauge -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs font-medium">
                        <span class="text-slate-500 font-medium">Tiến độ hoàn thành dự án</span>
                        <span class="text-indigo-700 font-bold text-sm">{{ $project->progress }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden border border-slate-200/60">
                        <div class="h-full bg-gradient-to-r {{ $project->color }} rounded-full transition-all duration-500" style="width: {{ $project->progress }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Assigned Members vs Assign New Member Form -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Assigned Members List -->
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                        Đội Ngũ Nhân Sự Phụ Trách ({{ $project->members->count() }} thành viên)
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Mỗi thành viên có thể phụ trách nhiều dự án cùng lúc với hạn mức công việc riêng.</p>
                </div>

                <div class="space-y-4">
                    @forelse($project->members as $member)
                        <div class="mica-card rounded-2xl p-5 border border-slate-200/80 hover:border-indigo-400/50 hover:shadow-md transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <img class="w-12 h-12 rounded-2xl object-cover ring-2 ring-white shadow-sm"
                                     src="{{ $member->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=6366f1&color=fff' }}"
                                     alt="{{ $member->name }}">
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <a href="{{ route('members.show', $member) }}" class="font-bold text-slate-900 text-base hover:text-indigo-600 transition-colors">
                                            {{ $member->name }}
                                        </a>
                                        <span class="text-xs font-bold px-2 py-0.5 rounded-md border {{ $member->role->badge_classes }}">
                                            {{ $member->role->name }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-0.5 font-medium">
                                        {{ $member->team->name ?? 'Chưa phân nhóm' }} &bull;
                                        <span class="text-indigo-700 font-bold">{{ $member->pivot->role_in_project }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-6 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                <div class="text-left sm:text-right">
                                    <span class="text-[11px] text-slate-500 font-medium block">Tải trong dự án:</span>
                                    <span class="text-indigo-700 font-bold text-sm">{{ $member->pivot->allocation_percent }}% Workload</span>
                                    <span class="text-[10px] text-slate-500 block font-medium">Tổng tải: {{ $member->total_allocation }}%</span>
                                </div>

                                <form action="{{ route('projects.members.destroy', [$project, $member]) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn rút thành viên {{ $member->name }} khỏi dự án này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition-colors"
                                            title="Rút thành viên">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 mica-card rounded-2xl border border-slate-200">
                            Chưa có thành viên nào phụ trách dự án này. Hãy bổ nhiệm nhân sự từ bảng bên phải.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Col: Add Member to Project Form -->
            <div class="space-y-6">
                <div class="mica-card rounded-2xl p-6 border border-slate-200/80 space-y-4 shadow-sm">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Bổ Nhiệm Nhân Sự Vào Dự Án
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">Thêm thành viên phụ trách và xác lập vai trò trong dự án</p>
                    </div>

                    @if($availableMembers->isNotEmpty())
                        <form action="{{ route('projects.members.store', $project) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Chọn nhân sự</label>
                                <select name="member_id" required class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                                    <option value="">-- Chọn thành viên --</option>
                                    @foreach($availableMembers as $availMember)
                                        <option value="{{ $availMember->id }}">
                                            {{ $availMember->name }} ({{ $availMember->role->name }} - {{ $availMember->team->code }})
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
                                <label class="block text-xs font-bold text-slate-700 mb-1">Hạn mức tải (% Workload)</label>
                                <select name="allocation_percent" required class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                                    <option value="20">20% - Hỗ trợ / Tư vấn</option>
                                    <option value="30">30% - Đóng góp module</option>
                                    <option value="50" selected>50% - Thành viên chủ lực</option>
                                    <option value="70">70% - Dẫn dắt kỹ thuật</option>
                                    <option value="100">100% - Toàn thời gian</option>
                                </select>
                            </div>

                            <button type="submit"
                                    class="w-full py-2.5 rounded-xl text-xs font-bold text-white glow-btn-primary shadow-md">
                                Bổ nhiệm vào dự án
                            </button>
                        </form>
                    @else
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-500 text-center">
                            Tất cả thành viên trong tổ chức đã được bổ nhiệm vào dự án này!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
