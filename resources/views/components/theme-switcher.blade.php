@props([
    'variant' => 'dropdown', // 'dropdown' or 'pills'
])

<div class="relative" x-data="{
    open: false,
    activeTheme: 'fluent-light',
    themes: [
        {
            id: 'fluent-light',
            name: 'Fluent 2 Mica Light',
            tag: 'Mica Light',
            desc: 'Microsoft Fluent Acrylic & Colorful Aurora',
            icon: '🎨',
            color: 'from-violet-500 via-fuchsia-500 to-cyan-400',
            bg: '#f8fafc',
            border: '#e2e8f0',
            dark: false
        },
        {
            id: 'dracula',
            name: 'Dracula',
            tag: 'Dracula Dark',
            desc: 'Vampire Dark Palette with Pink & Purple',
            icon: '🧛',
            color: 'from-purple-500 via-pink-500 to-cyan-400',
            bg: '#282a36',
            border: '#6272a4',
            dark: true
        },
        {
            id: 'github',
            name: 'GitHub',
            tag: 'GitHub Dark',
            desc: 'Primer Jet Black & Classic Accent Blue',
            icon: '🐙',
            color: 'from-blue-600 to-emerald-500',
            bg: '#0d1117',
            border: '#30363d',
            dark: true
        },
        {
            id: 'one',
            name: 'One Dark',
            tag: 'Atom One',
            desc: 'One Dark Pro Balanced Coding Syntax',
            icon: '⚡',
            color: 'from-sky-400 via-purple-500 to-emerald-400',
            bg: '#21252b',
            border: '#3e4451',
            dark: true
        }
    ],
    init() {
        this.activeTheme = localStorage.getItem('teamnexus_theme') || 'fluent-light';
        this.applyTheme(this.activeTheme);
    },
    selectTheme(themeId) {
        this.activeTheme = themeId;
        localStorage.setItem('teamnexus_theme', themeId);
        this.applyTheme(themeId);
        this.open = false;
    },
    applyTheme(themeId) {
        document.documentElement.setAttribute('data-theme', themeId);
        if (themeId === 'fluent-light') {
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        }
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: themeId } }));
    },
    currentThemeObj() {
        return this.themes.find(t => t.id === this.activeTheme) || this.themes[0];
    }
}" @click.outside="open = false">
    <!-- Trigger Button -->
    <button type="button"
            @click="open = !open"
            class="px-3 py-2 rounded-xl text-xs font-semibold mica-pill flex items-center gap-2 transition-all hover:scale-[1.02] shadow-sm"
            title="Đổi giao diện / Theme Style">
        <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-r" :class="currentThemeObj().color"></span>
        <span class="font-bold hidden sm:inline" x-text="currentThemeObj().tag"></span>
        <span class="text-xs" x-text="currentThemeObj().icon"></span>
        <svg class="w-3.5 h-3.5 opacity-60 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
         style="display: none;"
         class="absolute right-0 mt-2 w-72 rounded-2xl p-2 mica-card-solid z-50 shadow-2xl border border-slate-200/80">
        <div class="px-3 py-2 border-b border-slate-200/70 mb-1.5 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-900">Giao Diện Hệ Thống</p>
                <p class="text-[10px] text-slate-500">Chọn phong cách hiển thị yêu thích</p>
            </div>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 font-bold border border-purple-200">4 Styles</span>
        </div>

        <div class="space-y-1">
            <template x-for="theme in themes" :key="theme.id">
                <button type="button"
                        @click="selectTheme(theme.id)"
                        class="w-full flex items-center justify-between p-2.5 rounded-xl text-left text-xs transition-all hover:bg-slate-100/80"
                        :class="{ 'ring-1 ring-purple-500/50 bg-purple-50/50 font-bold': activeTheme === theme.id }">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow-sm"
                             :style="'background-color: ' + theme.bg + '; border: 1px solid ' + theme.border + ';'">
                            <span x-text="theme.icon"></span>
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-slate-900" x-text="theme.name"></span>
                                <span x-show="theme.id === 'fluent-light'" class="text-[9px] px-1 py-0.2 rounded bg-cyan-100 text-cyan-800 font-bold">MICA</span>
                            </div>
                            <p class="text-[10px] text-slate-500" x-text="theme.desc"></p>
                        </div>
                    </div>

                    <div x-show="activeTheme === theme.id" class="w-4 h-4 rounded-full bg-purple-600 text-white flex items-center justify-center text-[10px] font-black shrink-0">
                        ✓
                    </div>
                </button>
            </template>
        </div>
    </div>
</div>
