<x-layouts.app>
    <x-slot:title>Quản Lý Dự Án - TeamNexus</x-slot:title>
    <x-slot:header>Danh Sách & Tiến Độ Dự Án</x-slot:header>

    <div class="space-y-6">
        <!-- Header & Filter Bar (Fluent 2 Light Mica) -->
        <div class="mica-card rounded-2xl p-5 border border-white/80 space-y-4 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span>Các Dự Án Doanh Nghiệp</span>
                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-fuchsia-100 text-fuchsia-800 border border-fuchsia-300">
                            {{ $projects->total() }} dự án
                        </span>
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Theo dõi tiến độ, phân bổ nhân sự và ngân sách đa dự án.</p>
                </div>

                <a href="{{ route('projects.create') }}"
                   class="glow-btn-primary px-4 py-2.5 rounded-xl text-xs font-bold text-white flex items-center gap-2 shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Khởi tạo dự án mới</span>
                </a>
            </div>

            <form action="{{ route('projects.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 pt-2 border-t border-slate-100">
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Tìm kiếm</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Mã, tên dự án, mô tả..."
                           class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Trạng thái</label>
                    <select name="status" class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                        <option value="">Tất cả trạng thái</option>
                        <option value="planning" {{ request('status') == 'planning' ? 'selected' : '' }}>Đang lên kế hoạch</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Đang triển khai</option>
                        <option value="review" {{ request('status') == 'review' ? 'selected' : '' }}>Nghiệm thu / Review</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                        <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>Tạm hoãn</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Mức độ ưu tiên</label>
                    <select name="priority" class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                        <option value="">Tất cả mức độ</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Khẩn cấp</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Ưu tiên cao</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Trung bình</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Thấp</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="flex-1 py-2 px-3 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition-all text-center">
                        Áp dụng lọc
                    </button>
                    @if(request()->anyFilled(['search', 'status', 'priority']))
                        <a href="{{ route('projects.index') }}"
                           class="py-2 px-3 rounded-xl text-xs font-bold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition-colors">
                            Xóa lọc
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                @php
                    $status = $project->status_badge;
                    $priority = $project->priority_badge;
                @endphp
                <div class="mica-card rounded-2xl p-6 border border-slate-200/80 hover:border-indigo-400/50 hover:shadow-lg flex flex-col justify-between transition-all group">
                    <div>
                        <!-- Header: Code, Badges, Title -->
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <span class="font-mono text-xs px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold">
                                {{ $project->code }}
                            </span>
                            <div class="flex items-center gap-1.5 flex-wrap justify-end">
                                <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full border {{ $status['class'] }}">
                                    <span class="inline-block w-1.5 h-1.5 rounded-full mr-1 {{ $status['dot'] }}"></span>
                                    {{ $status['label'] }}
                                </span>
                                <span class="text-[11px] font-medium px-2 py-0.5 rounded-full border {{ $priority['class'] }}">
                                    {{ $priority['label'] }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('projects.show', $project) }}" class="font-bold text-slate-900 text-lg hover:text-indigo-600 transition-colors block">
                            {{ $project->name }}
                        </a>

                        <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                            {{ $project->description }}
                        </p>

                        <!-- Progress Bar with colorful gradient -->
                        <div class="mt-5 space-y-1.5">
                            <div class="flex items-center justify-between text-xs font-medium">
                                <span class="text-slate-500 font-medium">Tiến độ thực thi</span>
                                <span class="text-slate-900 font-bold">{{ $project->progress }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200/60">
                                <div class="h-full bg-gradient-to-r {{ $project->color }} rounded-full transition-all duration-500" style="width: {{ $project->progress }}%;"></div>
                            </div>
                        </div>

                        <!-- Budget & Due Date -->
                        <div class="mt-4 pt-3.5 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-[11px] text-slate-500 font-medium block">Hạn hoàn thành:</span>
                                <span class="text-slate-800 font-bold">{{ $project->due_date ? $project->due_date->format('d/m/Y') : 'Chưa định' }}</span>
                            </div>
                            <div>
                                <span class="text-[11px] text-slate-500 font-medium block">Ngân sách dự kiến:</span>
                                <span class="text-emerald-700 font-bold">${{ number_format($project->budget, 0) }}</span>
                            </div>
                        </div>

                        <!-- Assigned Members Stacks -->
                        <div class="mt-4 pt-3.5 border-t border-slate-100">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                    Thành viên phụ trách ({{ $project->members->count() }}):
                                </span>
                            </div>

                            <div class="flex items-center gap-2 flex-wrap">
                                <div class="flex -space-x-2 overflow-hidden">
                                    @foreach($project->members->take(5) as $m)
                                        <a href="{{ route('members.show', $m) }}" title="{{ $m->name }} ({{ $m->pivot->role_in_project }})" class="inline-block relative">
                                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover shadow-sm"
                                                 src="{{ $m->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($m->name).'&background=6366f1&color=fff' }}"
                                                 alt="{{ $m->name }}">
                                        </a>
                                    @endforeach
                                </div>

                                @if($project->members->count() > 5)
                                    <span class="text-xs text-slate-500 font-bold">+{{ $project->members->count() - 5 }} người khác</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between text-xs">
                        <a href="{{ route('projects.show', $project) }}" class="font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors">
                            <span>Chi tiết & Điều phối</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('projects.edit', $project) }}" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition-colors" title="Chỉnh sửa">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa dự án {{ $project->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition-colors" title="Xóa dự án">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full mica-card rounded-2xl p-12 text-center space-y-4 border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Chưa có dự án nào</h3>
                    <p class="text-xs text-slate-500">Hãy khởi tạo dự án đầu tiên cho tổ chức của bạn.</p>
                    <a href="{{ route('projects.create') }}" class="glow-btn-primary inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white shadow-md">
                        Khởi tạo dự án
                    </a>
                </div>
            @endforelse
        </div>

        <div class="pt-4">
            {{ $projects->links() }}
        </div>
    </div>
</x-layouts.app>
