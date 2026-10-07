<x-layouts.app>
    <x-slot:title>Thêm Thành Viên Mới - TeamNexus</x-slot:title>
    <x-slot:header>Thêm Thành Viên & Phân Bổ Dự Án</x-slot:header>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Breadcrumb -->
        <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Quay lại danh sách</span>
        </a>

        <div class="mica-card rounded-3xl p-8 border border-white/15">
            <div class="mb-6 pb-6 border-b border-white/10">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gradient-to-r from-violet-500 to-fuchsia-500"></span>
                    Thông Tin Thành Viên & Chỉ Định Dự Án Ban Đầu
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    Điền thông tin nhân sự và bạn có thể phân công thành viên phụ trách nhiều dự án ngay khi tạo.
                </p>
            </div>

            @if($errors->any())
                <div class="p-4 mb-6 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs space-y-1">
                    <p class="font-bold">Đã có lỗi xảy ra, vui lòng kiểm tra lại:</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('members.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Basic Profile Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Họ và tên <span class="text-rose-400">*</span></label>
                        <input type="text"
                               name="name"
                               required
                               value="{{ old('name') }}"
                               placeholder="VD: Trần Đình Trọng"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email doanh nghiệp <span class="text-rose-400">*</span></label>
                        <input type="email"
                               name="email"
                               required
                               value="{{ old('email') }}"
                               placeholder="VD: trong.tran@teammanager.internal"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Số điện thoại liên hệ</label>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone') }}"
                               placeholder="VD: +84 987 654 321"
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Đường dẫn ảnh đại diện (Avatar URL)</label>
                        <input type="url"
                               name="avatar_url"
                               value="{{ old('avatar_url') }}"
                               placeholder="https://images.unsplash.com/photo-..."
                               class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                    </div>
                </div>

                <!-- Organization & Role -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-4 border-t border-white/5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Thuộc phòng ban / nhóm <span class="text-rose-400">*</span></label>
                        <select name="team_id" required class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            <option value="">-- Chọn nhóm --</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Vai trò hệ thống (Role) <span class="text-rose-400">*</span></label>
                        <select name="role_id" required class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            <option value="">-- Chọn vai trò --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Trạng thái công tác <span class="text-rose-400">*</span></label>
                        <select name="status" required class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Đang làm việc (Active)</option>
                            <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>Nghỉ phép (On Leave)</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tạm dừng (Inactive)</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox"
                           id="is_team_lead"
                           name="is_team_lead"
                           value="1"
                           {{ old('is_team_lead') ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-purple-600 bg-slate-800 border-white/20 focus:ring-purple-500">
                    <label for="is_team_lead" class="text-xs font-semibold text-slate-300">
                        Đặt thành viên này làm Trưởng nhóm (Team Lead)
                    </label>
                </div>

                <!-- Bio -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Giới thiệu ngắn / Kỹ năng chuyên môn</label>
                    <textarea name="bio" rows="3" placeholder="Mô tả kỹ năng, thế mạnh, kinh nghiệm..."
                              class="w-full px-4 py-2.5 text-xs rounded-xl mica-input">{{ old('bio') }}</textarea>
                </div>

                <!-- Multi-Project Assignment Section (Core Feature) -->
                <div class="p-6 rounded-2xl bg-white/[0.03] border border-cyan-500/20 space-y-4 shadow-[0_0_20px_rgba(6,182,212,0.1)]">
                    <div>
                        <h3 class="text-sm font-bold text-cyan-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Phân Bổ Dự Án Phụ Trách Ngay (Tùy chọn)
                        </h3>
                        <p class="text-[11px] text-slate-400">Chọn 1 hoặc nhiều dự án để thành viên phụ trách ngay khi tạo hồ sơ.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($projects as $p)
                            <label class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-900/60 border border-white/10 hover:border-cyan-400/40 cursor-pointer transition-all">
                                <input type="checkbox"
                                       name="project_ids[]"
                                       value="{{ $p->id }}"
                                       class="w-4 h-4 mt-0.5 rounded text-cyan-600 bg-slate-800 border-white/20">
                                <div>
                                    <span class="block text-xs font-bold text-white">{{ $p->name }}</span>
                                    <span class="text-[10px] font-mono text-cyan-300">{{ $p->code }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-300 mb-1">Vai trò trong các dự án trên</label>
                            <input type="text"
                                   name="project_role"
                                   value="Core Contributor"
                                   placeholder="VD: Project Lead, Architect, Core Contributor..."
                                   class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-300 mb-1">Hạn mức tải (% cho mỗi dự án)</label>
                            <select name="allocation_percent" class="w-full px-3 py-2 text-xs rounded-xl mica-input">
                                <option value="20">20%</option>
                                <option value="30">30%</option>
                                <option value="40">40%</option>
                                <option value="50" selected>50%</option>
                                <option value="80">80%</option>
                                <option value="100">100%</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                    <a href="{{ route('members.index') }}"
                       class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white mica-pill">
                        Hủy bỏ
                    </a>
                    <button type="submit"
                            class="glow-btn-primary px-6 py-2.5 rounded-xl text-xs font-bold text-white shadow-lg">
                        Lưu & Tạo Thành Viên
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
