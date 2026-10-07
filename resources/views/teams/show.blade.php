<x-layouts.app>
    <x-slot:title>{{ $team->name }} - Phòng Ban & Nhóm - TeamNexus</x-slot:title>
    <x-slot:header>Nhóm: {{ $team->name }}</x-slot:header>

    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <a href="{{ route('teams.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Quay lại danh sách nhóm</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('teams.edit', $team) }}"
                   class="px-4 py-2 rounded-xl text-xs font-semibold text-white mica-pill hover:bg-white/10 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    <span>Sửa nhóm</span>
                </a>
            </div>
        </div>

        <!-- Team Hero Banner -->
        <div class="relative overflow-hidden rounded-3xl p-8 mica-card border border-white/15">
            <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-gradient-to-br from-emerald-600/30 via-teal-600/20 to-blue-500/30 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-3xl bg-gradient-to-tr {{ $team->color }} flex items-center justify-center font-mono font-black text-white text-xl shadow-[0_0_20px_rgba(255,255,255,0.25)]">
                        {{ $team->code }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-white tracking-tight">{{ $team->name }}</h2>
                        <p class="text-xs text-slate-300 max-w-xl mt-1 leading-relaxed">{{ $team->description }}</p>
                    </div>
                </div>

                <!-- Team Lead Info Box -->
                <div class="p-4 rounded-2xl bg-white/[0.04] border border-white/10 min-w-[220px]">
                    <span class="text-[10px] font-semibold text-amber-300 uppercase tracking-wider block mb-2">Trưởng nhóm (Team Lead)</span>
                    @if($team->lead)
                        <div class="flex items-center gap-3">
                            <img class="w-10 h-10 rounded-xl object-cover ring-2 ring-amber-400"
                                 src="{{ $team->lead->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($team->lead->name).'&background=6366f1&color=fff' }}"
                                 alt="{{ $team->lead->name }}">
                            <div>
                                <a href="{{ route('members.show', $team->lead) }}" class="text-sm font-bold text-white hover:text-cyan-300">
                                    {{ $team->lead->name }}
                                </a>
                                <p class="text-[11px] text-slate-400">{{ $team->lead->role->name }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic">Chưa chỉ định đội trưởng</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Members in this Team -->
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                    Danh Sách Thành Viên Thuộc Nhóm ({{ $team->members->count() }} nhân sự)
                </h3>
                <p class="text-xs text-slate-400">Mỗi thành viên trong nhóm có thể phụ trách nhiều dự án đa ngành khác nhau.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($team->members as $member)
                    <div class="mica-card rounded-2xl p-5 border border-white/10 hover:border-white/20 transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <div class="flex items-center gap-3">
                                    <img class="w-11 h-11 rounded-xl object-cover ring-2 ring-white/10 shadow-md"
                                         src="{{ $member->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=6366f1&color=fff' }}"
                                         alt="{{ $member->name }}">
                                    <div>
                                        <a href="{{ route('members.show', $member) }}" class="font-bold text-white text-sm hover:text-cyan-300">
                                            {{ $member->name }}
                                        </a>
                                        <p class="text-[11px] text-slate-400 font-mono">{{ $member->email }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md border {{ $member->role->badge_classes }}">
                                    {{ $member->role->name }}
                                </span>
                            </div>

                            <!-- Assigned Projects -->
                            <div class="pt-3 border-t border-white/5 space-y-1.5">
                                <div class="flex items-center justify-between text-[11px] text-slate-400">
                                    <span>Dự án phụ trách ({{ $member->projects->count() }}):</span>
                                    <span class="font-bold {{ $member->total_allocation > 100 ? 'text-rose-400' : 'text-emerald-400' }}">
                                        {{ $member->total_allocation }}% tải
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($member->projects as $p)
                                        <a href="{{ route('projects.show', $p) }}"
                                           class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-medium bg-white/5 text-slate-300 hover:text-white border border-white/10">
                                            <span>{{ $p->code }}</span>
                                            <span class="text-cyan-300">({{ $p->pivot->allocation_percent }}%)</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-white/5 flex items-center justify-end">
                            <a href="{{ route('members.show', $member) }}" class="text-xs font-semibold text-cyan-400 hover:text-cyan-300">
                                Xem hồ sơ & phân công &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full mica-card rounded-2xl p-8 text-center text-slate-400">
                        Chưa có thành viên nào trong nhóm này.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
