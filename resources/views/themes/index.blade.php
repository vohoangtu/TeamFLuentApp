<x-layouts.app>
    <x-slot:title>Kiến Trúc Component & Bộ Sưu Tập Themes - TeamNexus</x-slot:title>
    <x-slot:header>Kiến Trúc Component & Hệ Thống Themes</x-slot:header>

    <div class="space-y-10" x-data="{
        activeTheme: localStorage.getItem('teamnexus_theme') || 'fluent-light',
        setTheme(theme) {
            this.activeTheme = theme;
            localStorage.setItem('teamnexus_theme', theme);
            document.documentElement.setAttribute('data-theme', theme);
            if (theme === 'fluent-light') {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            }
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme } }));
        }
    }">
        <!-- Hero Header -->
        <x-card variant="gradient" padding="lg">
            <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-gradient-to-br from-violet-400/30 via-fuchsia-400/20 to-cyan-400/30 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <x-badge color="primary" size="md">Component-Driven Architecture</x-badge>
                        <x-badge color="cyan" size="md">4 Design Presets</x-badge>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Hệ Thống Giao Diện Đa Phong Cách
                    </h2>
                    <p class="text-sm text-slate-600 max-w-2xl leading-relaxed">
                        Toàn bộ giao diện được xây dựng theo chuẩn <strong>Blade Components</strong> độc lập và có khả năng đổi màu sắc toàn diện (CSS Tokens) giữa <strong>Fluent 2 MICA Light</strong>, <strong>Dracula</strong>, <strong>GitHub Dark</strong> và <strong>One Dark</strong> mà không cần tải lại trang.
                    </p>
                </div>

                <div class="shrink-0 p-4 rounded-2xl bg-white/70 border border-slate-200/80 shadow-sm min-w-[200px] text-right">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Theme đang hoạt động</span>
                    <div class="text-lg font-black text-slate-900 mt-1 capitalize" x-text="activeTheme.replace('-', ' ')"></div>
                    <span class="inline-flex items-center gap-1.5 text-xs text-emerald-600 font-bold mt-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Đã đồng bộ toàn hệ thống
                    </span>
                </div>
            </div>
        </x-card>

        <!-- Section 1: 4 Theme Selectors -->
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gradient-to-r from-purple-500 to-pink-500"></span>
                    Chọn Phong Cách Giao Diện (Live Instant Switch)
                </h3>
                <p class="text-xs text-slate-500 font-medium">Bấm vào bất kỳ thẻ phong cách nào bên dưới để áp dụng trực tiếp cho toàn bộ ứng dụng.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Theme 1: Fluent 2 MICA Light -->
                <div @click="setTheme('fluent-light')"
                     class="cursor-pointer rounded-2xl p-5 border transition-all duration-200 hover:scale-[1.02] flex flex-col justify-between"
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
                            Chất liệu kính acrylic mờ tinh khiết, viền ngọc trai và các dải quầng sáng aurora pastel chuyển động.
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-violet-700 font-bold">#f8fafc / Acrylic</span>
                        <x-button variant="secondary" size="sm" @click.stop="setTheme('fluent-light')">
                            Kích hoạt
                        </x-button>
                    </div>
                </div>

                <!-- Theme 2: Dracula -->
                <div @click="setTheme('dracula')"
                     class="cursor-pointer rounded-2xl p-5 border transition-all duration-200 hover:scale-[1.02] flex flex-col justify-between"
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
                            Bảng màu Dark huyền thoại của cộng đồng lập trình: Nền tím than `#282a36`, điểm nhấn hồng `#ff79c6` và tím `#bd93f9`.
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-pink-600 font-bold">#282a36 / Gothic</span>
                        <x-button variant="secondary" size="sm" @click.stop="setTheme('dracula')">
                            Kích hoạt
                        </x-button>
                    </div>
                </div>

                <!-- Theme 3: GitHub Dark -->
                <div @click="setTheme('github')"
                     class="cursor-pointer rounded-2xl p-5 border transition-all duration-200 hover:scale-[1.02] flex flex-col justify-between"
                     :class="activeTheme === 'github' ? 'ring-2 ring-blue-500 shadow-xl bg-slate-950 border-blue-400 text-white' : 'mica-card hover:border-slate-300'">
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
                            Bộ nhận diện GitHub Primer Dark nguyên bản: Nền đen tuyền `#0d1117`, viền `#30363d`, lam sáng `#58a6ff` và nút xanh lục.
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-blue-600 font-bold">#0d1117 / Primer</span>
                        <x-button variant="secondary" size="sm" @click.stop="setTheme('github')">
                            Kích hoạt
                        </x-button>
                    </div>
                </div>

                <!-- Theme 4: One Dark -->
                <div @click="setTheme('one')"
                     class="cursor-pointer rounded-2xl p-5 border transition-all duration-200 hover:scale-[1.02] flex flex-col justify-between"
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
                            Phong cách Atom / One Dark Pro cân bằng tối ưu: Nền `#21252b`, xanh lam `#61afef`, tím `#c678dd` và ngọc bích `#56b6c2`.
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-cyan-600 font-bold">#21252b / Syntax</span>
                        <x-button variant="secondary" size="sm" @click.stop="setTheme('one')">
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
                    Thư Viện Blade Components Tái Sử Dụng
                </h3>
                <p class="text-xs text-slate-500 font-medium">Các thành phần giao diện đã được chuẩn hóa để gọi bằng cú pháp ngắn gọn: &lt;x-card&gt;, &lt;x-badge&gt;, &lt;x-button&gt;, v.v.</p>
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
    </div>
</x-layouts.app>
