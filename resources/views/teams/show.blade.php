<x-layouts.app>
    <x-slot:title>{{ $team->name }} - Phòng Ban & Nhóm - TeamNexus</x-slot:title>
    <x-slot:header>Nhóm: {{ $team->name }}</x-slot:header>

    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <a href="{{ route('teams.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Quay lại danh sách nhóm</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('teams.edit', $team) }}"
                   class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white/80 hover:bg-slate-100 border border-slate-200 shadow-sm flex items-center gap-2 transition-all">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    <span>Sửa nhóm</span>
                </a>
            </div>
        </div>

        <!-- Team Hero Banner (Fluent 2 Light Mica) -->
        <div class="relative overflow-hidden rounded-3xl p-8 mica-card border border-white/80 shadow-lg shadow-indigo-500/5">
            <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-gradient-to-br from-emerald-200/50 via-teal-200/40 to-blue-200/40 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-3xl bg-gradient-to-tr {{ $team->color }} flex items-center justify-center font-mono font-black text-white text-xl shadow-md">
                        {{ $team->code }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $team->name }}</h2>
                        <p class="text-xs text-slate-600 max-w-xl mt-1 leading-relaxed">{{ $team->description }}</p>
                    </div>
                </div>

                <!-- Team Lead Info Box -->
                <div class="p-4 rounded-2xl bg-white/80 border border-slate-200/80 shadow-sm min-w-[220px]">
                    <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block mb-2">Trưởng nhóm (Team Lead)</span>
                    @if($team->lead)
                        <div class="flex items-center gap-3">
                            <img class="w-10 h-10 rounded-xl object-cover ring-2 ring-amber-400 shadow-sm"
                                 src="{{ $team->lead->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($team->lead->name).'&background=6366f1&color=fff' }}"
                                 alt="{{ $team->lead->name }}">
                            <div>
                                <a href="{{ route('members.show', $team->lead) }}" class="text-sm font-bold text-slate-900 hover:text-emerald-700">
                                    {{ $team->lead->name }}
                                </a>
                                <p class="text-[11px] text-slate-500 font-medium">{{ $team->lead->role->name }}</p>
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
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span>Danh Sách Thành Viên Thuộc Nhóm ({{ $team->members->count() }} nhân sự)</span>
                    <x-info-popover text="Mỗi thành viên trong nhóm có thể phụ trách nhiều dự án đa ngành khác nhau." color="emerald" size="sm" />
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($team->members as $member)
                    <div class="mica-card rounded-2xl p-5 border border-slate-200/80 hover:border-emerald-400/50 hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <div class="flex items-center gap-3">
                                    <img class="w-11 h-11 rounded-xl object-cover ring-2 ring-white dark:ring-[var(--bg-surface-solid)] shadow-sm"
                                         src="{{ $member->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=6366f1&color=fff' }}"
                                         alt="{{ $member->name }}">
                                    <div>
                                        <a href="{{ route('members.show', $member) }}" class="font-bold text-slate-900 text-sm hover:text-emerald-700 transition-colors">
                                            {{ $member->name }}
                                        </a>
                                        <p class="text-[11px] text-slate-500 font-mono">{{ $member->email }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md border {{ $member->role->badge_classes }}">
                                    {{ $member->role->name }}
                                </span>
                            </div>

                            <!-- Assigned Projects -->
                            <div class="pt-3 border-t border-slate-100 space-y-1.5">
                                <div class="flex items-center justify-between text-[11px] text-slate-500">
                                    <span class="font-medium">Dự án phụ trách ({{ $member->projects->count() }}):</span>
                                    <span class="font-bold {{ $member->total_allocation > 100 ? 'text-rose-600' : 'text-emerald-600' }}">
                                        {{ $member->total_allocation }}% tải
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($member->projects as $p)
                                        <a href="{{ route('projects.show', $p) }}"
                                           class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-700 hover:text-slate-900 border border-slate-200 transition-colors">
                                            <span>{{ $p->code }}</span>
                                            <span class="text-cyan-700 font-bold">({{ $p->pivot->allocation_percent }}%)</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-end">
                            <a href="{{ route('members.show', $member) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 transition-colors">
                                Xem hồ sơ & phân công &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full mica-card rounded-2xl p-8 text-center text-slate-500 border border-slate-200">
                        Chưa có thành viên nào trong nhóm này.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
