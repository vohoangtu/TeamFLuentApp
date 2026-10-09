<x-layouts.app>
    <x-slot:title>Chỉnh Sửa Nhóm: {{ $team->name }} - TeamNexus</x-slot:title>
    <x-slot:header>Cập Nhật Thông Tin Nhóm</x-slot:header>

    <div class="max-w-3xl mx-auto space-y-6">
        <a href="{{ route('teams.show', $team) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Quay lại nhóm</span>
        </a>

        <div class="mica-card rounded-3xl p-8 border border-white/80 shadow-lg shadow-indigo-500/5">
            <div class="mb-6 pb-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <span>Chỉnh Sửa: {{ $team->name }}</span>
                        <x-info-popover text="Cập nhật thông tin và đội trưởng của nhóm." color="emerald" />
                    </h2>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr {{ $team->color }} flex items-center justify-center font-mono font-black text-white text-xs shadow-md">
                    {{ $team->code }}
                </div>
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

            <form action="{{ route('teams.update', $team) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tên phòng ban / nhóm <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="name"
                               required
                               value="{{ old('name', $team->name) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Mã nhóm (Code) <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="code"
                               required
                               value="{{ old('code', $team->code) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input uppercase">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Mô tả chức năng nhiệm vụ</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">{{ old('description', $team->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Đội trưởng nhóm (Team Lead)</label>
                        <select name="lead_id" class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            <option value="">-- Chưa chỉ định --</option>
                            @foreach($potentialLeads as $lead)
                                <option value="{{ $lead->id }}" {{ old('lead_id', $team->lead_id) == $lead->id ? 'selected' : '' }}>
                                    {{ $lead->name }} ({{ $lead->role->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Bảng màu nhận diện nhóm</label>
                        <select name="color" class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            <option value="from-blue-600 via-indigo-600 to-cyan-500" {{ $team->color == 'from-blue-600 via-indigo-600 to-cyan-500' ? 'selected' : '' }}>Xanh Dương & Lam Sáng</option>
                            <option value="from-purple-600 via-fuchsia-600 to-pink-500" {{ $team->color == 'from-purple-600 via-fuchsia-600 to-pink-500' ? 'selected' : '' }}>Tím & Hồng Neon</option>
                            <option value="from-rose-500 via-pink-500 to-orange-400" {{ $team->color == 'from-rose-500 via-pink-500 to-orange-400' ? 'selected' : '' }}>Hồng Đào & Cam Rực</option>
                            <option value="from-emerald-500 via-green-600 to-teal-700" {{ $team->color == 'from-emerald-500 via-green-600 to-teal-700' ? 'selected' : '' }}>Ngọc Lục Bảo & Xanh Rừng</option>
                            <option value="from-cyan-500 via-teal-500 to-emerald-500" {{ $team->color == 'from-cyan-500 via-teal-500 to-emerald-500' ? 'selected' : '' }}>Lam Ngọc & Xanh Băng</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('teams.show', $team) }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 mica-pill hover:bg-slate-100 transition-all">
                        Hủy
                    </a>
                    <button type="submit" class="glow-btn-primary px-6 py-2.5 rounded-xl text-xs font-bold text-white shadow-lg">
                        Cập Nhật Nhóm
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
