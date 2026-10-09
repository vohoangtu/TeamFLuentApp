import Alpine from 'alpinejs';

/**
 * Enterprise Multi-Theme Manager with View Transitions API & Smooth Interpolation
 */
const THEMES = [
    {
        id: 'fluent-light',
        name: 'Fluent 2 Mica Light',
        tag: 'Mica Light',
        desc: 'Microsoft Fluent Acrylic & Colorful Aurora',
        icon: '🎨',
        color: 'from-violet-500 via-fuchsia-500 to-cyan-400',
        bg: '#f8fafc',
        border: '#e2e8f0',
        metaColor: '#f8fafc',
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
        metaColor: '#282a36',
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
        metaColor: '#0d1117',
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
        metaColor: '#21252b',
        dark: true
    },
    {
        id: 'nord',
        name: 'Nord Frost',
        tag: 'Nord Arctic',
        desc: 'Serene Arctic Night with Frost Blue & Aurora',
        icon: '❄️',
        color: 'from-cyan-400 via-sky-500 to-indigo-500',
        bg: '#2e3440',
        border: '#4c566a',
        metaColor: '#2e3440',
        dark: true
    }
];

class ThemeManagerService {
    constructor() {
        this.themes = THEMES;
        this.storageKey = 'teamnexus_theme';
    }

    getCurrentThemeId() {
        return localStorage.getItem(this.storageKey) || 'fluent-light';
    }

    getCurrentTheme() {
        const id = this.getCurrentThemeId();
        return this.themes.find(t => t.id === id) || this.themes[0];
    }

    applyThemeTokens(themeId) {
        const theme = this.themes.find(t => t.id === themeId) || this.themes[0];
        const html = document.documentElement;

        html.setAttribute('data-theme', theme.id);
        if (theme.dark) {
            html.classList.add('dark');
            html.classList.remove('light');
        } else {
            html.classList.add('light');
            html.classList.remove('dark');
        }

        // Update mobile theme-color meta tag
        try {
            let meta = document.querySelector('meta[name="theme-color"]');
            if (!meta) {
                meta = document.createElement('meta');
                meta.setAttribute('name', 'theme-color');
                document.head.appendChild(meta);
            }
            meta.setAttribute('content', theme.metaColor);
        } catch (_) {}

        // Save preference
        try {
            localStorage.setItem(this.storageKey, theme.id);
        } catch (_) {}

        // Dispatch app-wide event
        window.dispatchEvent(new CustomEvent('theme-changed', {
            detail: { theme: theme.id, themeObj: theme }
        }));
    }

    setTheme(themeId, event = null) {
        const currentId = this.getCurrentThemeId();
        if (currentId === themeId) return;

        const execute = () => {
            this.applyThemeTokens(themeId);
        };

        // 1. If modern View Transitions API is supported, use standard smooth transition
        if (typeof document.startViewTransition === 'function' && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            try {
                const transition = document.startViewTransition(() => {
                    execute();
                });

                if (transition && typeof transition.ready?.then === 'function') {
                    transition.ready.then(() => {
                        try {
                            let x = window.innerWidth / 2;
                            let y = window.innerHeight / 2;

                            if (event && event.clientX && event.clientY) {
                                x = event.clientX;
                                y = event.clientY;
                            } else if (event?.target?.getBoundingClientRect) {
                                const rect = event.target.getBoundingClientRect();
                                x = rect.left + rect.width / 2;
                                y = rect.top + rect.height / 2;
                            }

                            const endRadius = Math.hypot(
                                Math.max(x, window.innerWidth - x),
                                Math.max(y, window.innerHeight - y)
                            );

                            document.documentElement.animate(
                                {
                                    clipPath: [
                                        `circle(0px at ${x}px ${y}px)`,
                                        `circle(${endRadius}px at ${x}px ${y}px)`
                                    ]
                                },
                                {
                                    duration: 380,
                                    easing: 'ease-in-out',
                                    pseudoElement: '::view-transition-new(root)'
                                }
                            );
                        } catch (_) {
                            // Pseudo-element animation not supported, browser crossfades automatically
                        }
                    }).catch(() => {});
                }
                return;
            } catch (_) {
                // startViewTransition threw (e.g. concurrent transitions)
            }
        }

        // 2. Fallback: Smooth CSS synchronized interpolation
        const html = document.documentElement;
        html.classList.add('theme-transitioning');
        execute();
        setTimeout(() => {
            html.classList.remove('theme-transitioning');
        }, 300);
    }

    cycleNextTheme(event = null) {
        const currentId = this.getCurrentThemeId();
        const currentIndex = this.themes.findIndex(t => t.id === currentId);
        const nextIndex = (currentIndex + 1) % this.themes.length;
        this.setTheme(this.themes[nextIndex].id, event);
    }
}

window.ThemeManager = new ThemeManagerService();

// Global Keyboard Shortcut: Press "Alt+T" or "T" (outside inputs) to quickly cycle themes
window.addEventListener('keydown', (e) => {
    const isInput = ['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement?.tagName) ||
                    document.activeElement?.isContentEditable;

    if (!isInput) {
        if ((e.altKey && (e.key === 't' || e.key === 'T')) || (e.key === 't' || e.key === 'T')) {
            e.preventDefault();
            window.ThemeManager.cycleNextTheme();
        }
    }
});

window.Alpine = Alpine;
Alpine.start();
