<x-layouts.app>
    <x-slot:title>Chỉnh Sửa: {{ $member->name }} - TeamNexus</x-slot:title>
    <x-slot:header>Cập Nhật Hồ Sơ Thành Viên</x-slot:header>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Breadcrumb -->
        <a href="{{ route('members.show', $member) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Quay lại hồ sơ</span>
        </a>

        <div class="mica-card rounded-3xl p-8 border border-white/15">
            <div class="mb-6 pb-6 border-b border-white/10 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <span>Chỉnh Sửa Thông Tin: {{ $member->name }}</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">Cập nhật chức vụ, phòng ban và thông tin liên hệ của nhân sự.</p>
                </div>
                <span class="px-3 py-1 rounded-xl text-xs font-bold border {{ $member->role->badge_classes }}">
                    {{ $member->role->name }}
                </span>
            </div>

            @if($errors->any())
                <div class="p-4 mb-6 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs space-y-1">
                    <p class="font-bold">Đã có lỗi xảy ra:</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('members.update', $member) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Họ và tên <span class="text-rose-400">*</span></label>
                        <input type="text"
                               name="name"
                               required
                               value="{{ old('name', $member->name) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email doanh nghiệp <span class="text-rose-400">*</span></label>
                        <input type="email"
                               name="email"
                               required
                               value="{{ old('email', $member->email) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Số điện thoại liên hệ</label>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone', $member->phone) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Đường dẫn ảnh đại diện (Avatar URL)</label>
                        <input type="url"
                               name="avatar_url"
                               value="{{ old('avatar_url', $member->avatar_url) }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-4 border-t border-white/5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Phòng ban / Nhóm <span class="text-rose-400">*</span></label>
                        <select name="team_id" required class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('team_id', $member->team_id) == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Vai trò hệ thống <span class="text-rose-400">*</span></label>
                        <select name="role_id" required class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $member->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Trạng thái công tác <span class="text-rose-400">*</span></label>
                        <select name="status" required class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Đang làm việc (Active)</option>
                            <option value="on_leave" {{ old('status', $member->status) == 'on_leave' ? 'selected' : '' }}>Nghỉ phép (On Leave)</option>
                            <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Tạm dừng (Inactive)</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox"
                           id="is_team_lead"
                           name="is_team_lead"
                           value="1"
                           {{ old('is_team_lead', $member->is_team_lead) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-purple-600 bg-slate-800 border-white/20 focus:ring-purple-500">
                    <label for="is_team_lead" class="text-xs font-semibold text-slate-300">
                        Đặt thành viên này làm Trưởng nhóm (Team Lead)
                    </label>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Giới thiệu ngắn / Kỹ năng</label>
                    <textarea name="bio" rows="3" class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">{{ old('bio', $member->bio) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                    <a href="{{ route('members.show', $member) }}"
                       class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white mica-pill">
                        Hủy
                    </a>
                    <button type="submit"
                            class="glow-btn-primary px-6 py-2.5 rounded-xl text-xs font-bold text-white shadow-lg">
                        Cập Nhật Hồ Sơ
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
