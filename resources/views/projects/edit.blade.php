<x-layouts.app>
    <x-slot:title>Chỉnh Sửa Dự Án: {{ $project->name }} - TeamNexus</x-slot:title>
    <x-slot:header>Cập Nhật Thông Tin Dự Án</x-slot:header>

    <div class="max-w-4xl mx-auto space-y-6">
        <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Quay lại dự án</span>
        </a>

        <div class="mica-card rounded-3xl p-8 border border-white/80 shadow-lg shadow-indigo-500/5">
            <div class="mb-6 pb-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <span>Chỉnh Sửa: {{ $project->name }}</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Cập nhật tiến độ, trạng thái và thời hạn dự án.</p>
                </div>
                <span class="font-mono text-xs px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold">
                    {{ $project->code }}
                </span>
            </div>

            @if($errors->any())
                <div class="p-4 mb-6 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs space-y-1">
                    <p class="font-bold">Đã có lỗi xảy ra:</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tên dự án <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="name"
                               required
                               value="{{ old('name', $project->name) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Mã dự án (Code) <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="code"
                               required
                               value="{{ old('code', $project->code) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input uppercase">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Mô tả mục tiêu dự án</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">{{ old('description', $project->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-4 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Trạng thái <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            <option value="planning" {{ old('status', $project->status) == 'planning' ? 'selected' : '' }}>Đang lên kế hoạch</option>
                            <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>Đang triển khai</option>
                            <option value="review" {{ old('status', $project->status) == 'review' ? 'selected' : '' }}>Nghiệm thu / Review</option>
                            <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                            <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>Tạm hoãn</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Mức độ ưu tiên <span class="text-rose-500">*</span></label>
                        <select name="priority" required class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            <option value="urgent" {{ old('priority', $project->priority) == 'urgent' ? 'selected' : '' }}>Khẩn cấp (Urgent)</option>
                            <option value="high" {{ old('priority', $project->priority) == 'high' ? 'selected' : '' }}>Ưu tiên cao (High)</option>
                            <option value="medium" {{ old('priority', $project->priority) == 'medium' ? 'selected' : '' }}>Trung bình (Medium)</option>
                            <option value="low" {{ old('priority', $project->priority) == 'low' ? 'selected' : '' }}>Thấp (Low)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tiến độ hiện tại (% 0-100) <span class="text-rose-500">*</span></label>
                        <input type="number"
                               name="progress"
                               min="0"
                               max="100"
                               required
                               value="{{ old('progress', $project->progress) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-4 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Ngày bắt đầu</label>
                        <input type="date"
                               name="start_date"
                               value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Hạn chót</label>
                        <input type="date"
                               name="due_date"
                               value="{{ old('due_date', $project->due_date ? $project->due_date->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Ngân sách ($ USD)</label>
                        <input type="number"
                               step="0.01"
                               name="budget"
                               value="{{ old('budget', $project->budget) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('projects.show', $project) }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 mica-pill hover:bg-slate-100 transition-all">
                        Hủy
                    </a>
                    <button type="submit" class="glow-btn-primary px-6 py-2.5 rounded-xl text-xs font-bold text-white shadow-lg">
                        Cập Nhật Dự Án
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
