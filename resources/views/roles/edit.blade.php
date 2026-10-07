<x-layouts.app>
    <x-slot:title>Chỉnh Sửa Vai Trò: {{ $role->name }} - TeamNexus</x-slot:title>
    <x-slot:header>Cập Nhật Vai Trò & Phân Quyền: {{ $role->name }}</x-slot:header>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Breadcrumb / Back Navigation -->
        <a href="{{ route('roles.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Quay lại Quản lý Vai trò & Ma trận RBAC</span>
        </a>

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs space-y-1">
                <p class="font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Đã có lỗi xảy ra, vui lòng kiểm tra lại:
                </p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('roles.update', $role) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Role Core Information Card -->
            <x-card padding="lg" class="shadow-lg">
                <div class="mb-6 pb-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-gradient-to-r from-violet-600 to-indigo-600"></span>
                            Thông Tin Vai Trò Chức Danh
                        </h2>
                        <p class="text-xs text-slate-500 mt-1 font-medium">
                            Chỉnh sửa tên gọi, định danh và màu sắc đại diện cho vị trí này.
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-badge :color="$role->badge_color ?? 'purple'" size="md">
                            {{ $role->name }}
                        </x-badge>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input
                            label="Tên vai trò"
                            name="name"
                            required
                            placeholder="VD: Senior DevOps Architect, Project Director..."
                            value="{{ old('name', $role->name) }}"
                            hint="Tên hiển thị công khai trên hồ sơ thành viên và sơ đồ dự án."
                        />
                    </div>

                    <div>
                        <x-input
                            label="Mã định danh (Slug)"
                            name="slug"
                            placeholder="VD: senior-devops-architect"
                            value="{{ old('slug', $role->slug) }}"
                            hint="Định danh duy nhất trên hệ thống."
                        />
                    </div>

                    <!-- Badge Color Selector -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-xs font-bold text-slate-700">
                            Màu sắc huy hiệu đại diện <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-[11px] text-slate-500 mb-2">Chọn màu nhận diện thương hiệu cho vai trò này trên hệ thống thẻ và bảng ma trận:</p>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach($colors as $colorKey => $colorName)
                                @php
                                    $isSelected = old('badge_color', $role->badge_color) === $colorKey;
                                @endphp
                                <label class="relative flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all mica-card hover:border-violet-400">
                                    <input type="radio"
                                           name="badge_color"
                                           value="{{ $colorKey }}"
                                           {{ $isSelected ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <span class="w-4 h-4 rounded-full border border-slate-300 peer-checked:border-violet-600 peer-checked:bg-violet-600 flex items-center justify-center transition-all">
                                        <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <x-badge :color="$colorKey" size="sm">{{ ucfirst($colorKey) }}</x-badge>
                                        <span class="text-xs font-medium text-slate-700">{{ $colorName }}</span>
                                    </div>
                                    <div class="absolute inset-0 rounded-xl border-2 border-violet-500 pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Role Description -->
                    <div class="md:col-span-2 space-y-1.5">
                        <label for="description" class="block text-xs font-bold text-slate-700">Mô tả nhiệm vụ & phạm vi quyền hạn</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="Mô tả tóm tắt trách nhiệm, phạm vi can thiệp của vị trí vai trò này trong tổ chức..."
                            class="w-full px-4 py-2.5 text-xs rounded-xl mica-input resize-none"
                        >{{ old('description', $role->description) }}</textarea>
                    </div>
                </div>
            </x-card>

            <!-- Permissions Assignment Card (Grouped by Module) -->
            <x-card padding="lg" class="shadow-lg space-y-6">
                <div class="pb-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600"></span>
                            Thiết Lập Quyền Hạn Chi Tiết Theo Module (RBAC)
                        </h2>
                        <p class="text-xs text-slate-500 mt-1 font-medium">
                            Chọn lọc từng hành động được phép thực thi. Các quyền đánh dấu [Quan trọng] cần đặc quyền cao.
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button"
                                onclick="document.querySelectorAll('.perm-checkbox').forEach(c => c.checked = true);"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold mica-pill hover:bg-slate-100 transition-colors text-slate-700">
                            Chọn tất cả quyền
                        </button>
                        <button type="button"
                                onclick="document.querySelectorAll('.perm-checkbox').forEach(c => c.checked = false);"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold mica-pill hover:bg-slate-100 transition-colors text-slate-700">
                            Bỏ chọn tất cả
                        </button>
                    </div>
                </div>

                <!-- Module Cards Grid -->
                <div class="space-y-6">
                    @foreach($permissionModules as $modKey => $module)
                        <div class="border border-slate-200/80 rounded-2xl p-5 bg-slate-50/40 space-y-4"
                             x-data="{
                                 toggleAll(checked) {
                                     this.$el.querySelectorAll('input[type=checkbox]').forEach(el => el.checked = checked);
                                 }
                             }">
                            <!-- Module Header -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-200/60">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-sm font-bold text-slate-900">{{ $module['name'] }}</h3>
                                        <x-badge color="indigo" size="sm">{{ count($module['permissions']) }} quyền</x-badge>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $module['description'] }}</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button"
                                            @click="toggleAll(true)"
                                            class="text-[11px] font-semibold text-violet-600 hover:text-violet-800">
                                        Chọn nhóm
                                    </button>
                                    <span class="text-slate-300">|</span>
                                    <button type="button"
                                            @click="toggleAll(false)"
                                            class="text-[11px] font-semibold text-slate-500 hover:text-slate-700">
                                        Bỏ chọn
                                    </button>
                                </div>
                            </div>

                            <!-- Permissions in Module -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($module['permissions'] as $permKey => $perm)
                                    @php
                                        $hasPerm = old('permissions') !== null
                                            ? in_array($permKey, old('permissions', []))
                                            : \App\Services\PermissionRegistry::roleHasPermission($role->permissions, $permKey);
                                    @endphp
                                    <label class="flex items-start gap-3 p-3 rounded-xl border border-white/60 bg-white/70 hover:bg-white hover:border-violet-200 cursor-pointer transition-all shadow-sm">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permKey }}"
                                               {{ $hasPerm ? 'checked' : '' }}
                                               class="perm-checkbox mt-0.5 w-4 h-4 text-violet-600 rounded border-slate-300 focus:ring-violet-500">
                                        <div class="space-y-0.5 flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-bold text-slate-800">{{ $perm['name'] }}</span>
                                                @if(!empty($perm['critical']))
                                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-extrabold bg-rose-100 text-rose-700 border border-rose-200">
                                                        Quan trọng
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-[11px] text-slate-500 leading-relaxed">{{ $perm['description'] }}</p>
                                            <code class="text-[10px] text-slate-400 font-mono">{{ $permKey }}</code>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>

            <!-- Bottom Actions Bar -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <x-button variant="secondary" size="md" href="{{ route('roles.index') }}">
                    Hủy bỏ
                </x-button>
                <x-button variant="primary" size="md" type="submit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Cập Nhật Vai Trò & Phân Quyền</span>
                </x-button>
            </div>
        </form>
    </div>
</x-layouts.app>
