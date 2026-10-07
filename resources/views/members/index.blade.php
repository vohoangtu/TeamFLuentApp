<x-layouts.app>
    <x-slot:title>Quản Lý Thành Viên & Phụ Trách Dự Án - TeamNexus</x-slot:title>
    <x-slot:header>Danh Sách Thành Viên & Dự Án Phụ Trách</x-slot:header>

    <div class="space-y-6">
        <!-- Header Actions & Search Bar Filter Ribbon -->
        <div class="mica-card rounded-2xl p-5 border border-white/10 space-y-4">
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <span>Đội Ngũ Nhân Sự & Trọng Trách Dự Án</span>
                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                            {{ $members->total() }} nhân sự
                        </span>
                    </h2>
                    <p class="text-xs text-slate-400">Một thành viên có thể phụ trách và đóng góp vào nhiều dự án khác nhau cùng lúc.</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('members.create') }}"
                       class="glow-btn-primary px-4 py-2.5 rounded-xl text-xs font-bold text-white flex items-center gap-2 shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Thêm thành viên mới</span>
                    </a>
                </div>
            </div>

            <!-- Filter Controls Form -->
            <form action="{{ route('members.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 pt-2 border-t border-white/5">
                <!-- Search text -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Tìm kiếm</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Tên, email, số ĐT..."
                           class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                </div>

                <!-- Filter by Team -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Phòng ban / Nhóm</label>
                    <select name="team_id" class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                        <option value="">Tất cả phòng ban</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }} ({{ $team->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Role -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Vai trò hệ thống</label>
                    <select name="role_id" class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                        <option value="">Tất cả vai trò</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Project -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Dự án tham gia</label>
                    <select name="project_id" class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                        <option value="">Tất cả dự án</option>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->code }} - {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button & Multi-project checkbox -->
                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="flex-1 py-2 px-3 rounded-xl text-xs font-semibold bg-white/10 hover:bg-white/15 text-white border border-white/15 transition-all text-center">
                        Áp dụng lọc
                    </button>
                    @if(request()->anyFilled(['search', 'team_id', 'role_id', 'project_id', 'multi_project']))
                        <a href="{{ route('members.index') }}"
                           class="py-2 px-3 rounded-xl text-xs font-semibold bg-rose-500/10 hover:bg-rose-500/20 text-rose-300 border border-rose-500/20">
                            Xóa lọc
                        </a>
                    @endif
                </div>
            </form>

            <div class="flex items-center gap-4 pt-1">
                <a href="{{ route('members.index', array_merge(request()->query(), ['multi_project' => request('multi_project') ? null : 1])) }}"
                   class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium transition-all {{ request('multi_project') ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/40 shadow-[0_0_12px_rgba(6,182,212,0.3)]' : 'bg-white/5 text-slate-400 border border-white/10 hover:text-white' }}">
                    <span class="w-2 h-2 rounded-full {{ request('multi_project') ? 'bg-cyan-400' : 'bg-slate-500' }}"></span>
                    Chỉ hiển thị thành viên phụ trách từ 2 dự án trở lên
                </a>
            </div>
        </div>

        <!-- Members Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($members as $member)
                @php
                    $status = $member->status_badge;
                    $totalAlloc = $member->total_allocation;
                @endphp
                <div class="mica-card rounded-2xl p-5 border border-white/10 hover:border-white/20 flex flex-col justify-between transition-all group">
                    <div>
                        <!-- Member Top: Avatar, Name, Role, Lead Badge -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="relative shrink-0">
                                    <img class="w-12 h-12 rounded-2xl object-cover ring-2 ring-white/15 shadow-md"
                                         src="{{ $member->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=6366f1&color=fff' }}"
                                         alt="{{ $member->name }}">
                                    <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full border-2 border-slate-900 {{ $status['dot'] }}"></span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <a href="{{ route('members.show', $member) }}" class="font-bold text-white text-base hover:text-cyan-300 transition-colors">
                                            {{ $member->name }}
                                        </a>
                                        @if($member->is_team_lead)
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-extrabold bg-amber-500/20 text-amber-300 border border-amber-500/30">LEAD</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-400 font-mono">{{ $member->email }}</p>
                                </div>
                            </div>

                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-md border {{ $member->role->badge_classes }} shrink-0">
                                {{ $member->role->name }}
                            </span>
                        </div>

                        <!-- Team & Status Badges -->
                        <div class="mt-4 flex items-center justify-between text-xs">
                            <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-slate-300 font-medium">
                                🏢 {{ $member->team->name ?? 'Chưa phân nhóm' }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full border text-[11px] font-medium {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                        </div>

                        <!-- CORE REQUIREMENT: Projects Assigned (Multi-Project Capability) -->
                        <div class="mt-4 pt-3.5 border-t border-white/10 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-semibold text-slate-300 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                                    Dự án phụ trách ({{ $member->projects->count() }}):
                                </span>
                                <span class="font-bold text-xs {{ $totalAlloc > 100 ? 'text-rose-400' : ($totalAlloc > 80 ? 'text-amber-400' : 'text-emerald-400') }}">
                                    {{ $totalAlloc }}% tải
                                </span>
                            </div>

                            <!-- Workload Progress Bar -->
                            <div class="w-full bg-slate-800/80 rounded-full h-1.5 overflow-hidden border border-white/5">
                                <div class="h-full rounded-full transition-all {{ $totalAlloc > 100 ? 'bg-gradient-to-r from-amber-500 to-rose-500' : 'bg-gradient-to-r from-violet-500 via-fuchsia-500 to-cyan-400' }}"
                                     style="width: {{ min($totalAlloc, 100) }}%;"></div>
                            </div>

                            <!-- Project Badges with Role & Allocation -->
                            <div class="flex flex-wrap gap-1.5 pt-1">
                                @forelse($member->projects as $p)
                                    <a href="{{ route('projects.show', $p) }}"
                                       class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[11px] font-medium bg-slate-800/80 hover:bg-slate-700/80 text-slate-200 border border-white/10 hover:border-cyan-400/40 transition-all"
                                       title="Dự án: {{ $p->name }} | Vai trò: {{ $p->pivot->role_in_project }}">
                                        <span class="font-mono text-[10px] text-cyan-300 font-bold">{{ $p->code }}</span>
                                        <span class="text-slate-400">&bull;</span>
                                        <span class="text-slate-300 text-[10px]">{{ $p->pivot->role_in_project }}</span>
                                        <span class="text-purple-300 font-semibold text-[10px]">({{ $p->pivot->allocation_percent }}%)</span>
                                    </a>
                                @empty
                                    <span class="text-xs text-slate-500 italic">Chưa được gán dự án nào.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="mt-5 pt-3 border-t border-white/5 flex items-center justify-between text-xs">
                        <a href="{{ route('members.show', $member) }}"
                           class="font-semibold text-cyan-400 hover:text-cyan-300 flex items-center gap-1">
                            <span>Chi tiết & Phân công</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('members.edit', $member) }}"
                               class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white transition-colors"
                               title="Chỉnh sửa">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa thành viên {{ $member->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-300 hover:text-rose-200 transition-colors"
                                        title="Xóa thành viên">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full mica-card rounded-2xl p-12 text-center space-y-4">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">Không tìm thấy thành viên phù hợp</h3>
                    <p class="text-xs text-slate-400">Thử thay đổi bộ lọc tìm kiếm hoặc thêm thành viên mới.</p>
                    <a href="{{ route('members.create') }}" class="glow-btn-primary inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white">
                        Tạo thành viên mới
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $members->links() }}
        </div>
    </div>
</x-layouts.app>
