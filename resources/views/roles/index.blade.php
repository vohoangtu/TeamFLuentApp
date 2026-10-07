<x-layouts.app>
    <x-slot:title>Vai Trò & Phân Quyền - TeamNexus</x-slot:title>
    <x-slot:header>Vai Trò & Phân Quyền Hệ Thống (RBAC)</x-slot:header>

    <div class="space-y-6">
        <div class="mica-card rounded-2xl p-6 border border-white/80 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span>Ma Trận Vai Trò & Quyền Hạn ({{ $roles->count() }} vai trò)</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1 font-medium">
                Định nghĩa quyền truy cập và chức năng trong hệ thống. Mỗi thành viên được gán một vai trò chính và có thể phụ trách nhiều dự án với các chức danh cụ thể.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($roles as $role)
                <div class="mica-card rounded-2xl p-6 border border-slate-200/80 hover:border-purple-400/50 hover:shadow-lg transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-3">
                            <span class="text-sm font-bold px-3 py-1 rounded-xl border {{ $role->badge_classes }}">
                                {{ $role->name }}
                            </span>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-700">
                                {{ $role->members_count }} nhân sự
                            </span>
                        </div>

                        <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                            {{ $role->description }}
                        </p>

                        <!-- Permissions Badges -->
                        <div class="space-y-2 pt-3 border-t border-slate-100">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Các quyền được cấp:</span>
                            <div class="flex flex-wrap gap-1.5">
                                @if($role->permissions)
                                    @foreach($role->permissions as $perm)
                                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-mono font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                            ✓ {{ str_replace('_', ' ', $perm) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-xs text-slate-400 italic">Quyền hạn cơ bản</span>
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
                                        <img class="w-4 h-4 rounded-full object-cover shadow-sm"
                                             src="{{ $m->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($m->name).'&background=6366f1&color=fff' }}"
                                             alt="{{ $m->name }}">
                                        <span class="font-semibold">{{ $m->name }}</span>
                                        <span class="text-[10px] text-cyan-700 font-bold">({{ $m->projects->count() }} dự án)</span>
                                    </a>
                                @empty
                                    <span class="text-xs text-slate-400 italic">Chưa có thành viên nào mang vai trò này.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-end">
                        <a href="{{ route('members.index', ['role_id' => $role->id]) }}" class="text-xs font-bold text-purple-700 hover:text-purple-900 transition-colors">
                            Xem tất cả thành viên vai trò này &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>
