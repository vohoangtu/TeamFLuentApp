<!DOCTYPE html>
<html lang="vi" class="dark h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'TeamManager' }} - SaaS Quản Lý Team & Dự Án</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-950 text-slate-100 font-sans antialiased overflow-x-hidden selection:bg-fuchsia-500 selection:text-white">

    <!-- Ambient Fluent 2 Mica Aurora Glow Orbs -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-gradient-to-br from-indigo-600/30 via-purple-600/20 to-transparent blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute top-1/4 -right-28 w-[30rem] h-[30rem] rounded-full bg-gradient-to-br from-fuchsia-600/25 via-pink-600/15 to-transparent blur-3xl"></div>
        <div class="absolute -bottom-32 left-1/3 w-[36rem] h-[36rem] rounded-full bg-gradient-to-tr from-cyan-600/20 via-teal-500/15 to-transparent blur-3xl"></div>
        <div class="absolute top-2/3 right-1/4 w-80 h-80 rounded-full bg-gradient-to-bl from-amber-500/15 via-rose-500/15 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 flex min-h-screen">
        <!-- Sidebar Navigation (Fluent 2 Acrylic Mica) -->
        <aside class="w-72 shrink-0 backdrop-blur-3xl bg-slate-950/70 border-r border-white/10 flex flex-col justify-between transition-all duration-300">
            <div>
                <!-- Brand Header -->
                <div class="h-20 flex items-center gap-3.5 px-6 border-b border-white/10">
                    <div class="relative flex items-center justify-center w-11 h-11 rounded-2xl bg-gradient-to-tr from-violet-600 via-fuchsia-500 to-cyan-400 shadow-[0_0_20px_rgba(192,38,211,0.5)]">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-400 rounded-full border-2 border-slate-950"></span>
                    </div>
                    <div>
                        <div class="font-bold text-lg tracking-tight text-white flex items-center gap-1.5">
                            Team<span class="text-gradient-fluent">Nexus</span>
                            <span class="px-1.5 py-0.5 text-[10px] uppercase font-bold tracking-wider rounded-md bg-purple-500/20 text-purple-300 border border-purple-500/30">Mica</span>
                        </div>
                        <p class="text-xs text-slate-400 font-medium">Enterprise Workspace</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5">
                    <div class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Điều hướng chính</div>

                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-violet-600/30 to-fuchsia-600/20 text-white border border-white/20 shadow-[0_0_15px_rgba(168,85,247,0.3)]' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="p-1.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-violet-500/30 text-violet-300' : 'bg-slate-800/60 text-slate-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <span>Tổng quan Dashboard</span>
                    </a>

                    <!-- Members -->
                    <a href="{{ route('members.index') }}"
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('members.*') ? 'bg-gradient-to-r from-cyan-600/30 to-blue-600/20 text-white border border-white/20 shadow-[0_0_15px_rgba(6,182,212,0.3)]' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 rounded-lg {{ request()->routeIs('members.*') ? 'bg-cyan-500/30 text-cyan-300' : 'bg-slate-800/60 text-slate-400' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <span>Thành viên & Dự án</span>
                        </div>
                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">Đa dự án</span>
                    </a>

                    <!-- Projects -->
                    <a href="{{ route('projects.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('projects.*') ? 'bg-gradient-to-r from-fuchsia-600/30 to-pink-600/20 text-white border border-white/20 shadow-[0_0_15px_rgba(217,70,239,0.3)]' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="p-1.5 rounded-lg {{ request()->routeIs('projects.*') ? 'bg-fuchsia-500/30 text-fuchsia-300' : 'bg-slate-800/60 text-slate-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <span>Quản lý Dự án</span>
                    </a>

                    <!-- Teams -->
                    <a href="{{ route('teams.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('teams.*') ? 'bg-gradient-to-r from-emerald-600/30 to-teal-600/20 text-white border border-white/20 shadow-[0_0_15px_rgba(16,185,129,0.3)]' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="p-1.5 rounded-lg {{ request()->routeIs('teams.*') ? 'bg-emerald-500/30 text-emerald-300' : 'bg-slate-800/60 text-slate-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span>Phòng ban & Nhóm</span>
                    </a>

                    <!-- Roles -->
                    <a href="{{ route('roles.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('roles.*') ? 'bg-gradient-to-r from-amber-600/30 to-rose-600/20 text-white border border-white/20 shadow-[0_0_15px_rgba(245,158,11,0.3)]' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="p-1.5 rounded-lg {{ request()->routeIs('roles.*') ? 'bg-amber-500/30 text-amber-300' : 'bg-slate-800/60 text-slate-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span>Vai trò & Quyền hạn</span>
                    </a>
                </nav>
            </div>

            <!-- Workspace Quick Stats / User Footer -->
            <div class="p-4 border-t border-white/10 space-y-3">
                <div class="p-3 rounded-2xl bg-gradient-to-br from-white/5 to-white/[0.02] border border-white/10">
                    <div class="flex items-center justify-between text-xs text-slate-400 mb-1.5 font-medium">
                        <span>Workload Engine</span>
                        <span class="text-emerald-400 font-semibold">Tối ưu</span>
                    </div>
                    <div class="w-full bg-slate-800/80 rounded-full h-1.5 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-violet-500 via-fuchsia-500 to-cyan-400 rounded-full" style="width: 78%;"></div>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5">Phân bổ đa dự án hiệu quả</p>
                </div>

                <div class="flex items-center justify-between px-2 pt-1">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-fuchsia-600 to-purple-600 flex items-center justify-center font-bold text-white text-sm shadow-[0_0_12px_rgba(192,38,211,0.4)]">
                            AD
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-white">Administrator</p>
                            <p class="text-[10px] text-slate-400">admin@nexus.saas</p>
                        </div>
                    </div>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                </div>
            </div>
        </aside>

        <!-- Main Workspace Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Top Mica Acrylic App Header -->
            <header class="h-20 shrink-0 sticky top-0 z-30 backdrop-blur-3xl bg-slate-950/65 border-b border-white/10 px-8 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-white flex items-center gap-2.5">
                        {{ $header ?? 'Bảng điều khiển' }}
                    </h1>
                    <p class="text-xs text-slate-400 font-normal mt-0.5">Hệ thống phân bổ thành viên & quản trị đa dự án Fluent 2</p>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Quick Search Input -->
                    <form action="{{ route('members.index') }}" method="GET" class="relative hidden md:block w-72">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Tìm thành viên, dự án, email..."
                               class="w-full pl-9 pr-4 py-2 text-xs rounded-xl mica-input placeholder:text-slate-500">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>

                    <!-- Quick Action Button -->
                    <a href="{{ route('members.create') }}"
                       class="glow-btn-primary px-4 py-2 rounded-xl text-xs font-semibold text-white flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Thêm thành viên</span>
                    </a>

                    <a href="{{ route('projects.create') }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-200 mica-pill hover:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-fuchsia-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Tạo dự án</span>
                    </a>
                </div>
            </header>

            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="px-8 pt-6">
                    <div class="p-4 rounded-2xl backdrop-blur-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-200 flex items-center justify-between shadow-[0_0_20px_rgba(16,185,129,0.2)]">
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 rounded-xl bg-emerald-500/30 text-emerald-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white text-xs font-semibold px-2 py-1">Đóng</button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="px-8 pt-6">
                    <div class="p-4 rounded-2xl backdrop-blur-2xl bg-rose-500/15 border border-rose-500/30 text-rose-200 flex items-center justify-between shadow-[0_0_20px_rgba(244,63,94,0.2)]">
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 rounded-xl bg-rose-500/30 text-rose-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-rose-400 hover:text-white text-xs font-semibold px-2 py-1">Đóng</button>
                    </div>
                </div>
            @endif

            <!-- Page Main Content Slot -->
            <main class="flex-1 p-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="py-6 px-8 border-t border-white/5 text-center text-xs text-slate-500">
                TeamNexus SaaS Platform &bull; Fluent 2 Mica Material Design &bull; Laravel 13 + Blade + Tailwind v4
            </footer>
        </div>
    </div>

</body>
</html>
