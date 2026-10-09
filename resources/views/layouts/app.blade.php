<!DOCTYPE html>
<html lang="vi" class="light h-full" data-theme="fluent-light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'TeamManager' }} - SaaS Quản Lý Team & Dự Án</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Instant Theme Hydration (Zero FOUC) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('teamnexus_theme') || 'fluent-light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'fluent-light') {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 text-slate-800 font-sans antialiased overflow-x-hidden selection:bg-fuchsia-500 selection:text-white mica-bg">

    <!-- Ambient Multi-Theme Adaptive Aurora Orbs -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden transition-opacity duration-700" style="opacity: var(--aurora-opacity);">
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full blur-3xl animate-pulse transition-all duration-700"
             style="background: radial-gradient(circle, var(--aurora-1) 0%, transparent 70%); animation-duration: 8s;"></div>
        <div class="absolute top-1/4 -right-28 w-[30rem] h-[30rem] rounded-full blur-3xl transition-all duration-700"
             style="background: radial-gradient(circle, var(--aurora-2) 0%, transparent 70%);"></div>
        <div class="absolute -bottom-32 left-1/3 w-[36rem] h-[36rem] rounded-full blur-3xl transition-all duration-700"
             style="background: radial-gradient(circle, var(--aurora-3) 0%, transparent 70%);"></div>
        <div class="absolute top-2/3 right-1/4 w-80 h-80 rounded-full blur-3xl transition-all duration-700"
             style="background: radial-gradient(circle, var(--aurora-4) 0%, transparent 70%);"></div>
    </div>

    <div class="relative z-10 flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="w-72 shrink-0 backdrop-blur-3xl theme-sidebar border-r flex flex-col justify-between transition-all duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.03)]">
            <div>
                <!-- Brand Header -->
                <div class="h-20 flex items-center gap-3.5 px-6 border-b border-slate-200/80">
                    <div class="relative flex items-center justify-center w-11 h-11 rounded-2xl bg-gradient-to-tr from-violet-600 via-fuchsia-500 to-cyan-500 shadow-[0_4px_16px_rgba(192,38,211,0.35)]">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-white dark:border-[var(--bg-sidebar)]"></span>
                    </div>
                    <div>
                        <div class="font-bold text-lg tracking-tight text-slate-900 flex items-center gap-1.5">
                            Team<span class="text-gradient-fluent">Nexus</span>
                            <span class="px-1.5 py-0.5 text-[9px] uppercase font-bold tracking-wider rounded-md bg-purple-100 text-purple-700 border border-purple-200">SaaS</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">Enterprise Workspace</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5">
                    <div class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Điều hướng chính</div>

                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <span>Tổng quan Dashboard</span>
                    </a>

                    <!-- Members -->
                    <a href="{{ route('members.index') }}"
                       class="nav-item justify-between {{ request()->routeIs('members.*') ? 'active' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="nav-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <span>Thành viên & Dự án</span>
                        </div>
                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-cyan-100 text-cyan-800 border border-cyan-200">Đa dự án</span>
                    </a>

                    <!-- Projects -->
                    <a href="{{ route('projects.index') }}"
                       class="nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <span>Quản lý Dự án</span>
                    </a>

                    <!-- Teams -->
                    <a href="{{ route('teams.index') }}"
                       class="nav-item {{ request()->routeIs('teams.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span>Phòng ban & Nhóm</span>
                    </a>

                    <!-- Roles -->
                    <a href="{{ route('roles.index') }}"
                       class="nav-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span>Vai trò & Quyền hạn</span>
                    </a>

                    <!-- Themes -->
                    <a href="{{ route('themes.index') }}"
                       class="nav-item {{ request()->routeIs('themes.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        </div>
                        <span>Giao diện & Themes</span>
                    </a>
                </nav>
            </div>

            <!-- Workspace Quick Stats / User Footer -->
            <div class="p-4 border-t border-slate-200/80 space-y-3">
                <div class="p-3.5 rounded-2xl mica-card shadow-sm">
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-1.5 font-medium">
                        <span>Workload Engine</span>
                        <span class="text-emerald-700 font-bold">Tối ưu</span>
                    </div>
                    <div class="w-full bg-slate-200/60 rounded-full h-1.5 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 rounded-full" style="width: 78%;"></div>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1.5 font-medium">Phân bổ đa dự án hiệu quả</p>
                </div>

                <div class="flex items-center justify-between px-2 pt-1">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-fuchsia-600 to-purple-600 flex items-center justify-center font-bold text-white text-sm shadow-md">
                            AD
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Administrator</p>
                            <p class="text-[10px] text-slate-500">admin@nexus.saas</p>
                        </div>
                    </div>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                </div>
            </div>
        </aside>

        <!-- Main Workspace Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Top App Header with Theme Switcher -->
            <header class="h-20 shrink-0 sticky top-0 z-30 backdrop-blur-3xl theme-header border-b px-8 flex items-center justify-between shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
                <div>
                    <h1 class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2.5">
                        {{ $header ?? 'Bảng điều khiển' }}
                    </h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Hệ thống phân bổ thành viên & quản trị đa dự án Enterprise</p>
                </div>

                <div class="flex items-center gap-3.5">
                    <!-- Quick Search Input -->
                    <form action="{{ route('members.index') }}" method="GET" class="relative hidden xl:block w-64">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Tìm thành viên, dự án..."
                               class="w-full pl-9 pr-4 py-2 text-xs rounded-xl mica-input">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>

                    <!-- Theme Switcher Component (Fluent 2, Dracula, GitHub, One, Nord) -->
                    <x-theme-switcher />

                    <!-- Quick Action Buttons -->
                    <x-button variant="primary" size="md" href="{{ route('members.create') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Thêm thành viên</span>
                    </x-button>

                    <x-button variant="secondary" size="md" href="{{ route('projects.create') }}">
                        <svg class="w-4 h-4 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Tạo dự án</span>
                    </x-button>
                </div>
            </header>

            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="px-8 pt-6">
                    <div class="p-4 rounded-2xl backdrop-blur-2xl bg-emerald-50/90 border border-emerald-300 text-emerald-800 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 rounded-xl bg-emerald-200 text-emerald-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold">{{ session('success') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 text-xs font-bold px-2 py-1">Đóng</button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="px-8 pt-6">
                    <div class="p-4 rounded-2xl backdrop-blur-2xl bg-rose-50/90 border border-rose-300 text-rose-800 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 rounded-xl bg-rose-200 text-rose-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold">{{ session('error') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900 text-xs font-bold px-2 py-1">Đóng</button>
                    </div>
                </div>
            @endif

            <!-- Page Main Content Slot -->
            <main class="flex-1 p-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="py-6 px-8 border-t border-slate-200/80 text-center text-xs text-slate-500 font-medium">
                TeamNexus SaaS Platform &bull; Multi-Theme System (Fluent 2 Mica, Dracula, GitHub, One Dark, Nord Frost) &bull; View Transitions API
            </footer>
        </div>
    </div>

</body>
</html>
