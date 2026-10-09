<x-layouts.app>
    <x-slot:title>Kiến Trúc Component & Bộ Sưu Tập 5 Themes - TeamNexus</x-slot:title>
    <x-slot:header>Kiến Trúc Component & Hệ Thống Multi-Theme</x-slot:header>

    <div class="space-y-10" x-data="{
        activeTheme: window.ThemeManager ? window.ThemeManager.getCurrentThemeId() : (localStorage.getItem('teamnexus_theme') || 'fluent-light'),
        init() {
            window.addEventListener('theme-changed', (e) => {
                this.activeTheme = e.detail.theme;
            });
        },
        setTheme(theme, event) {
            this.activeTheme = theme;
            if (window.ThemeManager) {
                window.ThemeManager.setTheme(theme, event);
            } else {
                localStorage.setItem('teamnexus_theme', theme);
                document.documentElement.setAttribute('data-theme', theme);
            }
        },
        cycleTheme(event) {
            if (window.ThemeManager) {
                window.ThemeManager.cycleNextTheme(event);
            }
        }
    }">
        <!-- Hero Header -->
        <x-card variant="gradient" padding="lg">
            <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-gradient-to-br from-violet-400/30 via-fuchsia-400/20 to-cyan-400/30 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2 flex-wrap">
                        <x-badge color="primary" size="md">Component-Driven Architecture</x-badge>
                        <x-badge color="cyan" size="md">5 Design Presets</x-badge>
                        <x-badge color="emerald" size="md">View Transitions API</x-badge>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2 flex-wrap">
                        <span>Hệ Thống Giao Diện Đa Phong Cách (Live Smooth Ripple)</span>
                        <x-info-popover text="Toàn bộ giao diện được xây dựng trên hệ thống CSS Design Tokens và chuẩn Blade Components độc lập. Chuyển đổi giữa Fluent 2 MICA Light, Dracula, GitHub Dark, One Dark và Nord Frost với hiệu ứng gợn sóng hình tròn (Circular Ripple) tức thì, mượt mà và không gây giật màu." color="blue" />
                    </h2>
                </div>

                <div class="shrink-0 p-4 rounded-2xl mica-card min-w-[220px] text-right space-y-2">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Theme đang hoạt động</span>
                    <div class="text-lg font-black text-slate-900 capitalize flex items-center justify-end gap-2" x-text="activeTheme.replace('-', ' ')"></div>
                    <div class="flex items-center justify-end gap-1.5 text-xs text-emerald-600 font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Đã đồng bộ toàn hệ thống
                    </div>
                    <button type="button"
                            @click="cycleTheme($event)"
                            class="w-full mt-2 py-1.5 px-3 rounded-xl text-xs font-bold glow-btn-primary flex items-center justify-center gap-1.5 shadow-sm">
                        <span>Chuyển theme tiếp theo</span>
                        <kbd class="px-1 py-0.2 rounded bg-black/20 text-[10px] font-mono">Alt+T</kbd>
                    </button>
                </div>
            </div>
        </x-card>

        <!-- Section 1: 5 Theme Selectors -->
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-gradient-to-r from-purple-500 to-pink-500"></span>
                        <span>Bộ Sưu Tập 5 Phong Cách Giao Diện (Live Instant Switch)</span>
                        <x-info-popover text="Bấm vào bất kỳ thẻ phong cách nào bên dưới để kích hoạt hiệu ứng chuyển đổi lan tỏa toàn màn hình." color="purple" size="sm" />
                    </h3>
                </div>
                <span class="text-xs text-slate-500 font-medium hidden sm:inline">Phím tắt nhanh: <kbd class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200 font-mono text-[10px] font-bold">Alt + T</kbd> hoặc <kbd class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200 font-mono text-[10px] font-bold">T</kbd></span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                <!-- Theme 1: Fluent 2 MICA Light -->
                <div @click="setTheme('fluent-light', $event)"
                     class="cursor-pointer rounded-2xl p-5 border transition-all duration-300 hover:scale-[1.02] flex flex-col justify-between"
                     :class="activeTheme === 'fluent-light' ? 'ring-2 ring-violet-500 shadow-xl bg-white/95 border-violet-400' : 'mica-card hover:border-slate-300'">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-violet-600 via-fuchsia-500 to-cyan-400 flex items-center justify-center text-white text-lg shadow-md">
                                🎨
                            </div>
                            <span x-show="activeTheme === 'fluent-light'" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                Đang chọn
                            </span>
                        </div>
                        <h4 class="font-extrabold text-base text-slate-900">Fluent 2 MICA Light</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Kính Acrylic mờ tinh khiết, viền ngọc trai và các dải quầng sáng aurora pastel chuyển động tự nhiên.
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-violet-700 font-bold">#f8fafc / Acrylic</span>
                        <x-button variant="secondary" size="sm" @click.stop="setTheme('fluent-light', $event)">
                            Kích hoạt
                        </x-button>
                    </div>
                </div>

                <!-- Theme 2: Dracula -->
                <div @click="setTheme('dracula', $event)"
                     class="cursor-pointer rounded-2xl p-5 border transition-all duration-300 hover:scale-[1.02] flex flex-col justify-between"
                     :class="activeTheme === 'dracula' ? 'ring-2 ring-pink-500 shadow-xl bg-slate-900 border-pink-400 text-white' : 'mica-card hover:border-slate-300'">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-purple-500 via-pink-500 to-cyan-400 flex items-center justify-center text-white text-lg shadow-md">
                                🧛
                            </div>
                            <span x-show="activeTheme === 'dracula'" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-pink-100 text-pink-800 border border-pink-300">
                                Đang chọn
                            </span>
                        </div>
                        <h4 class="font-extrabold text-base text-slate-900">Dracula</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Bảng màu Dark huyền thoại: Nền tím than `#282a36`, điểm nhấn hồng `#ff79c6` và tím `#bd93f9`.
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-pink-600 font-bold">#282a36 / Gothic</span>
                        <x-button variant="secondary" size="sm" @click.stop="setTheme('dracula', $event)">
                            Kích hoạt
                        </x-button>
                    </div>
                </div>

                <!-- Theme 3: GitHub Dark -->
                <div @click="setTheme('github', $event)"
                     class="cursor-pointer rounded-2xl p-5 border transition-all duration-300 hover:scale-[1.02] flex flex-col justify-between"
                     :class="activeTheme === 'github' ? 'ring-2 ring-emerald-500 shadow-xl bg-slate-950 border-emerald-400 text-white' : 'mica-card hover:border-slate-300'">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-emerald-500 flex items-center justify-center text-white text-lg shadow-md">
                                🐙
                            </div>
                            <span x-show="activeTheme === 'github'" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-300">
                                Đang chọn
                            </span>
                        </div>
                        <h4 class="font-extrabold text-base text-slate-900">GitHub Dark</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Nhận diện GitHub Primer nguyên bản: Nền đen tuyền `#0d1117`, viền `#30363d`, lam sáng và lục.
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-blue-600 font-bold">#0d1117 / Primer</span>
                        <x-button variant="secondary" size="sm" @click.stop="setTheme('github', $event)">
                            Kích hoạt
                        </x-button>
                    </div>
                </div>

                <!-- Theme 4: One Dark Pro -->
                <div @click="setTheme('one', $event)"
                     class="cursor-pointer rounded-2xl p-5 border transition-all duration-300 hover:scale-[1.02] flex flex-col justify-between"
                     :class="activeTheme === 'one' ? 'ring-2 ring-cyan-500 shadow-xl bg-slate-900 border-cyan-400 text-white' : 'mica-card hover:border-slate-300'">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-400 via-purple-500 to-emerald-400 flex items-center justify-center text-white text-lg shadow-md">
                                ⚡
                            </div>
                            <span x-show="activeTheme === 'one'" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-cyan-100 text-cyan-800 border border-cyan-300">
                                Đang chọn
                            </span>
                        </div>
                        <h4 class="font-extrabold text-base text-slate-900">One Dark Pro</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Phong cách Atom cân bằng: Nền `#21252b`, xanh lam `#61afef`, tím `#c678dd` và ngọc bích `#56b6c2`.
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-cyan-600 font-bold">#21252b / Syntax</span>
                        <x-button variant="secondary" size="sm" @click.stop="setTheme('one', $event)">
                            Kích hoạt
                        </x-button>
                    </div>
                </div>

                <!-- Theme 5: Nord Frost (NEW!) -->
                <div @click="setTheme('nord', $event)"
                     class="cursor-pointer rounded-2xl p-5 border transition-all duration-300 hover:scale-[1.02] flex flex-col justify-between"
                     :class="activeTheme === 'nord' ? 'ring-2 ring-sky-400 shadow-xl bg-slate-900 border-sky-300 text-white' : 'mica-card hover:border-slate-300'">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-400 via-sky-500 to-indigo-500 flex items-center justify-center text-white text-lg shadow-md">
                                ❄️
                            </div>
                            <span x-show="activeTheme === 'nord'" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-sky-100 text-sky-800 border border-sky-300">
                                Đang chọn
                            </span>
                        </div>
                        <h4 class="font-extrabold text-base text-slate-900">Nord Frost</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Bắc cực thanh tịnh: Nền đêm cực quang `#2e3440`, băng giá `#88c0d0`, tuyết trắng và cực quang lam.
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-sky-500 font-bold">#2e3440 / Arctic</span>
                        <x-button variant="secondary" size="sm" @click.stop="setTheme('nord', $event)">
                            Kích hoạt
                        </x-button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Reusable Blade Components Showcase -->
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-cyan-500"></span>
                    <span>Thư Viện Blade Components Tái Sử Dụng</span>
                    <x-info-popover text="Tất cả thành phần tự động tương thích và đổi màu sắc hoàn hảo theo từng theme." color="cyan" size="sm" />
                </h3>
            </div>

            <!-- Grid 2 Columns of Component Demos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- 1. Buttons & Badges -->
                <x-card padding="default" class="space-y-6">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-1">1. &lt;x-button&gt; &amp; &lt;x-badge&gt;</h4>
                        <p class="text-xs text-slate-500">Các nút bấm và nhãn trạng thái tự điều chỉnh theo theme hiện tại.</p>
                    </div>

                    <!-- Buttons Group -->
                    <div class="space-y-2">
                        <span class="text-[11px] font-bold text-slate-500 block uppercase tracking-wider">Button Variants:</span>
                        <div class="flex flex-wrap items-center gap-2.5">
                            <x-button variant="primary" size="md">Primary Glow</x-button>
                            <x-button variant="secondary" size="md">Secondary Pill</x-button>
                            <x-button variant="danger" size="md">Danger Action</x-button>
                            <x-button variant="ghost" size="md">Ghost Link</x-button>
                            <x-button variant="primary" size="sm">Small Btn</x-button>
                        </div>
                    </div>

                    <!-- Badges Group -->
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <span class="text-[11px] font-bold text-slate-500 block uppercase tracking-wider">Badge Colors &amp; Dots:</span>
                        <div class="flex flex-wrap items-center gap-2">
                            <x-badge color="primary" :dot="true">Primary</x-badge>
                            <x-badge color="cyan" :dot="true">Cyan Info</x-badge>
                            <x-badge color="emerald" :dot="true">Emerald Active</x-badge>
                            <x-badge color="amber" :dot="true">Amber Warning</x-badge>
                            <x-badge color="rose" :dot="true">Rose Urgent</x-badge>
                            <x-badge color="blue">Info Blue</x-badge>
                            <x-badge color="slate">Neutral Slate</x-badge>
                        </div>
                    </div>
                </x-card>

                <!-- 2. KPI Stat Cards -->
                <x-card padding="default" class="space-y-6">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-1">2. &lt;x-stat-card&gt; (KPI Metrics)</h4>
                        <p class="text-xs text-slate-500">Thẻ thống kê thông số và tiến độ đa dự án.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <x-stat-card title="Thành viên"
                                     value="28"
                                     subtitle="100% đã phân bổ"
                                     color="from-cyan-500 to-blue-600"
                                     badge="Active"
                                     badgeColor="cyan" />

                        <x-stat-card title="Đa Dự Án"
                                     value="85%"
                                     subtitle="Phụ trách >= 2 dự án"
                                     color="from-fuchsia-500 to-purple-600"
                                     badge="High Workload"
                                     badgeColor="rose" />
                    </div>
                </x-card>

                <!-- 3. Progress & Avatars -->
                <x-card padding="default" class="space-y-6">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-1">3. &lt;x-progress&gt; &amp; &lt;x-avatar&gt;</h4>
                        <p class="text-xs text-slate-500">Thanh tiến độ động và ảnh đại diện nhân sự với huy hiệu Trưởng nhóm.</p>
                    </div>

                    <!-- Progress Bars -->
                    <div class="space-y-3">
                        <x-progress :value="75" label="Tiến độ Cloud Migration" color="from-violet-600 to-cyan-500" size="md" />
                        <x-progress :value="92" label="Hạn mức phân bổ nhân sự (Workload)" color="from-emerald-500 to-teal-600" size="md" />
                        <x-progress :value="40" label="Dự án Alpha Zero-Trust" color="from-amber-500 to-rose-500" size="sm" />
                    </div>

                    <!-- Avatars -->
                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-[11px] font-bold text-slate-500 block uppercase tracking-wider mb-2">Avatar Sizes &amp; Indicators:</span>
                        <div class="flex items-center gap-4">
                            <x-avatar name="Nguyễn Văn A" size="xl" :isLead="true" />
                            <x-avatar name="Trần Thị B" size="lg" dot="bg-emerald-500" />
                            <x-avatar name="Lê Hoàng C" size="md" dot="bg-cyan-500" />
                            <x-avatar name="Phạm Đức D" size="sm" dot="bg-amber-500" />
                        </div>
                    </div>
                </x-card>

                <!-- 4. Form Controls (Input & Select) -->
                <x-card padding="default" class="space-y-6">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-1">4. &lt;x-input&gt; &amp; &lt;x-select&gt;</h4>
                        <p class="text-xs text-slate-500">Ô nhập dữ liệu và dropdown chuẩn hóa với hiệu ứng focus theo theme.</p>
                    </div>

                    <div class="space-y-4">
                        <x-input label="Tên thành viên / Nhân sự"
                                 name="demo_name"
                                 placeholder="VD: Hoàng Trọng Nam"
                                 value="Hoàng Trọng Nam"
                                 hint="Nhập đầy đủ họ và tên nhân sự theo hồ sơ doanh nghiệp." />

                        <x-select label="Vai trò hệ thống" name="demo_role" :required="true">
                            <option value="1">Enterprise Admin Lead</option>
                            <option value="2">Project Manager</option>
                            <option value="3" selected>Senior Core Architect</option>
                            <option value="4">Fullstack Developer</option>
                        </x-select>
                    </div>
                </x-card>
            </div>
        </div>

        <!-- Section 3: Interactive Live Data Table Preview -->
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span>Khả Năng Thích Ứng Bảng Dữ Liệu & Sticky Columns</span>
                    <x-info-popover text="Kiểm tra khả năng hiển thị tương phản chuẩn xác của bảng phân công đa dự án trên mọi phong cách." color="emerald" size="sm" />
                </h3>
            </div>

            <x-card padding="none" class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200/80 bg-slate-100/60 font-bold text-slate-900">
                                <th class="p-4 sticky left-0 z-10 bg-slate-100/90 backdrop-blur-md">Nhân sự</th>
                                <th class="p-4">Phòng ban</th>
                                <th class="p-4">Vai trò</th>
                                <th class="p-4">Dự án tham gia</th>
                                <th class="p-4">Workload tải</th>
                                <th class="p-4">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/80">
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 sticky left-0 z-10 font-bold text-slate-900 bg-white/95 backdrop-blur-md flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-violet-600 to-fuchsia-600 flex items-center justify-center font-bold text-white text-xs shadow-sm">
                                        NV
                                    </div>
                                    <span>Nguyễn Văn An</span>
                                </td>
                                <td class="p-4 text-slate-600 font-medium">Core Platform (ENG)</td>
                                <td class="p-4"><x-badge color="primary">Tech Lead</x-badge></td>
                                <td class="p-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-cyan-100 text-cyan-800 border border-cyan-300">CLOUD-MIG</span>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-fuchsia-100 text-fuchsia-800 border border-fuchsia-300">ZERO-TRUST</span>
                                    </div>
                                </td>
                                <td class="p-4 font-bold text-emerald-600">85%</td>
                                <td class="p-4"><x-badge color="emerald" :dot="true">Đang làm việc</x-badge></td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 sticky left-0 z-10 font-bold text-slate-900 bg-white/95 backdrop-blur-md flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-cyan-600 to-blue-600 flex items-center justify-center font-bold text-white text-xs shadow-sm">
                                        TH
                                    </div>
                                    <span>Trần Hoàng Mai</span>
                                </td>
                                <td class="p-4 text-slate-600 font-medium">Product Design (DES)</td>
                                <td class="p-4"><x-badge color="cyan">Senior Designer</x-badge></td>
                                <td class="p-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-violet-100 text-violet-800 border border-violet-300">DESIGN-SYS</span>
                                    </div>
                                </td>
                                <td class="p-4 font-bold text-emerald-600">60%</td>
                                <td class="p-4"><x-badge color="emerald" :dot="true">Đang làm việc</x-badge></td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 sticky left-0 z-10 font-bold text-slate-900 bg-white/95 backdrop-blur-md flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-amber-500 to-rose-500 flex items-center justify-center font-bold text-white text-xs shadow-sm">
                                        LH
                                    </div>
                                    <span>Lê Hữu Phúc</span>
                                </td>
                                <td class="p-4 text-slate-600 font-medium">DevOps &amp; Infra (OPS)</td>
                                <td class="p-4"><x-badge color="amber">Site Reliability</x-badge></td>
                                <td class="p-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-300">SECURITY-AUDIT</span>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">INFRA-K8S</span>
                                    </div>
                                </td>
                                <td class="p-4 font-bold text-amber-600">95%</td>
                                <td class="p-4"><x-badge color="amber" :dot="true">Nghỉ phép</x-badge></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.app>
