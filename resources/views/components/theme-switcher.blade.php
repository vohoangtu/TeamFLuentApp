@props([
    'variant' => 'dropdown', // 'dropdown' or 'pills'
])

<div class="relative" x-data="{
    open: false,
    activeTheme: window.ThemeManager ? window.ThemeManager.getCurrentThemeId() : (localStorage.getItem('teamnexus_theme') || 'fluent-light'),
    themes: window.ThemeManager ? window.ThemeManager.themes : [
        { id: 'fluent-light', name: 'Fluent 2 Mica Light', tag: 'Mica Light', desc: 'Microsoft Fluent Acrylic & Colorful Aurora', icon: '🎨', color: 'from-violet-500 via-fuchsia-500 to-cyan-400', bg: '#f8fafc', border: '#e2e8f0', dark: false },
        { id: 'dracula', name: 'Dracula', tag: 'Dracula Dark', desc: 'Vampire Dark Palette with Pink & Purple', icon: '🧛', color: 'from-purple-500 via-pink-500 to-cyan-400', bg: '#282a36', border: '#6272a4', dark: true },
        { id: 'github', name: 'GitHub', tag: 'GitHub Dark', desc: 'Primer Jet Black & Classic Accent Blue', icon: '🐙', color: 'from-blue-600 to-emerald-500', bg: '#0d1117', border: '#30363d', dark: true },
        { id: 'one', name: 'One Dark', tag: 'Atom One', desc: 'One Dark Pro Balanced Coding Syntax', icon: '⚡', color: 'from-sky-400 via-purple-500 to-emerald-400', bg: '#21252b', border: '#3e4451', dark: true },
        { id: 'nord', name: 'Nord Frost', tag: 'Nord Arctic', desc: 'Serene Arctic Night with Frost Blue & Aurora', icon: '❄️', color: 'from-cyan-400 via-sky-500 to-indigo-500', bg: '#2e3440', border: '#4c566a', dark: true }
    ],
    init() {
        window.addEventListener('theme-changed', (e) => {
            this.activeTheme = e.detail.theme;
        });
    },
    selectTheme(themeId, event) {
        this.activeTheme = themeId;
        if (window.ThemeManager) {
            window.ThemeManager.setTheme(themeId, event);
        } else {
            localStorage.setItem('teamnexus_theme', themeId);
            document.documentElement.setAttribute('data-theme', themeId);
        }
        this.open = false;
    },
    currentThemeObj() {
        return this.themes.find(t => t.id === this.activeTheme) || this.themes[0];
    }
}" @click.outside="open = false">
    <!-- Trigger Button -->
    <button type="button"
            @click="open = !open"
            class="px-3 py-2 rounded-xl text-xs font-semibold mica-pill flex items-center gap-2 transition-all hover:scale-[1.02] shadow-sm select-none"
            title="Đổi giao diện / Theme Style (Phím tắt: Alt+T)">
        <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-r" :class="currentThemeObj().color"></span>
        <span class="font-bold hidden sm:inline text-slate-800" x-text="currentThemeObj().tag"></span>
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
         class="absolute right-0 mt-2 w-80 rounded-2xl p-2.5 mica-card-solid z-50 shadow-2xl border border-slate-200/80">
        <div class="px-3 py-2 border-b border-slate-200/70 mb-2 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-900">Giao Diện Hệ Thống</p>
                <p class="text-[10px] text-slate-500">Phím tắt nhanh: <kbd class="px-1.5 py-0.5 rounded bg-slate-100 border border-slate-200 font-mono text-[9px] font-bold">Alt + T</kbd></p>
            </div>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 font-bold border border-purple-200">5 Styles</span>
        </div>

        <div class="space-y-1.5 max-h-96 overflow-y-auto">
            <template x-for="theme in themes" :key="theme.id">
                <button type="button"
                        @click="selectTheme(theme.id, $event)"
                        class="w-full flex items-center justify-between p-2.5 rounded-xl text-left text-xs transition-all border border-transparent hover:border-[var(--border-hover)] hover:bg-[var(--bg-surface-hover)] group cursor-pointer"
                        :class="activeTheme === theme.id ? 'bg-[var(--bg-surface-hover)] border-[var(--border-hover)] font-bold shadow-sm' : ''">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow-sm shrink-0 transition-transform group-hover:scale-105"
                             :style="'background-color: ' + theme.bg + '; border: 1px solid ' + theme.border + ';'">
                            <span x-text="theme.icon"></span>
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-slate-900" x-text="theme.name"></span>
                                <span x-show="theme.id === 'fluent-light'" class="text-[9px] px-1 py-0.2 rounded bg-cyan-100 text-cyan-800 font-bold">MICA</span>
                                <span x-show="theme.id === 'nord'" class="text-[9px] px-1 py-0.2 rounded bg-sky-100 text-sky-800 font-bold">NEW</span>
                            </div>
                            <p class="text-[10px] text-slate-500 line-clamp-1" x-text="theme.desc"></p>
                        </div>
                    </div>

                    <div x-show="activeTheme === theme.id" class="w-4 h-4 rounded-full bg-purple-600 text-white flex items-center justify-center text-[10px] font-black shrink-0 shadow-sm">
                        ✓
                    </div>
                </button>
            </template>
        </div>
    </div>
</div>
