<x-layouts.app>
    <x-slot:title>Phòng Ban & Nhóm - TeamNexus</x-slot:title>
    <x-slot:header>Cơ Cấu Phòng Ban & Nhóm Chức Năng</x-slot:header>

    <div class="space-y-6">
        <!-- Header -->
        <div class="mica-card rounded-2xl p-6 border border-white/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <span>Phòng Ban & Nhóm Chức Năng ({{ $teams->count() }})</span>
                </h2>
                <p class="text-xs text-slate-400">Tổ chức nhân sự theo chuyên môn, mỗi nhóm có đội trưởng và đóng góp vào nhiều dự án.</p>
            </div>

            <a href="{{ route('teams.create') }}"
               class="glow-btn-primary px-4 py-2.5 rounded-xl text-xs font-bold text-white flex items-center gap-2 shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Thành lập nhóm mới</span>
            </a>
        </div>

        <!-- Teams Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($teams as $team)
                <div class="mica-card rounded-2xl p-6 border border-white/10 hover:border-white/20 flex flex-col justify-between transition-all group">
                    <div>
                        <!-- Team Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr {{ $team->color }} flex items-center justify-center font-mono font-black text-white text-sm shadow-[0_0_15px_rgba(255,255,255,0.2)]">
                                {{ $team->code }}
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                                {{ $team->members_count }} nhân sự
                            </span>
                        </div>

                        <a href="{{ route('teams.show', $team) }}" class="font-bold text-white text-lg hover:text-cyan-300 transition-colors block">
                            {{ $team->name }}
                        </a>

                        <p class="text-xs text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                            {{ $team->description }}
                        </p>

                        <!-- Team Lead -->
                        <div class="mt-4 p-3 rounded-xl bg-white/[0.03] border border-white/5 flex items-center gap-3">
                            @if($team->lead)
                                <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-amber-400/50"
                                     src="{{ $team->lead->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($team->lead->name).'&background=6366f1&color=fff' }}"
                                     alt="{{ $team->lead->name }}">
                                <div>
                                    <span class="text-[10px] font-semibold text-amber-300 uppercase tracking-wider block">Trưởng nhóm (Team Lead)</span>
                                    <a href="{{ route('members.show', $team->lead) }}" class="text-xs font-bold text-white hover:text-cyan-300">
                                        {{ $team->lead->name }}
                                    </a>
                                </div>
                            @else
                                <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-slate-500 text-xs">?</div>
                                <div>
                                    <span class="text-[10px] text-slate-500 block">Trưởng nhóm</span>
                                    <span class="text-xs text-slate-400 italic">Chưa chỉ định</span>
                                </div>
                            @endif
                        </div>

                        <!-- Members avatar stack in this team -->
                        <div class="mt-4 pt-3 border-t border-white/5">
                            <span class="text-[11px] font-semibold text-slate-400 block mb-2">Thành viên trong nhóm:</span>
                            <div class="flex -space-x-2 overflow-hidden">
                                @foreach($team->members->take(6) as $m)
                                    <a href="{{ route('members.show', $m) }}" title="{{ $m->name }} ({{ $m->role->name }})" class="inline-block relative">
                                        <img class="inline-block h-7 w-7 rounded-full ring-2 ring-slate-900 object-cover"
                                             src="{{ $m->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($m->name).'&background=6366f1&color=fff' }}"
                                             alt="{{ $m->name }}">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="mt-5 pt-3.5 border-t border-white/5 flex items-center justify-between text-xs">
                        <a href="{{ route('teams.show', $team) }}" class="font-semibold text-cyan-400 hover:text-cyan-300 flex items-center gap-1">
                            <span>Chi tiết nhóm</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('teams.edit', $team) }}" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('teams.destroy', $team) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn giải thể nhóm {{ $team->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-300 transition-colors">
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
                    <h3 class="text-lg font-bold text-white">Chưa có nhóm nào</h3>
                    <p class="text-xs text-slate-400">Hãy thành lập nhóm làm việc đầu tiên.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
