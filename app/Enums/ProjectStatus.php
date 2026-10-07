<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Planning = 'planning';
    case InProgress = 'in_progress';
    case Review = 'review';
    case Completed = 'completed';
    case OnHold = 'on_hold';

    /**
     * Human-readable label in Vietnamese.
     */
    public function label(): string
    {
        return match ($this) {
            self::Planning => 'Đang lên kế hoạch',
            self::InProgress => 'Đang triển khai',
            self::Review => 'Nghiệm thu / Review',
            self::Completed => 'Đã hoàn thành',
            self::OnHold => 'Tạm hoãn',
        };
    }

    /**
     * Fluent 2 badge CSS classes (Light Theme Ultra-Colorful).
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Planning => 'bg-sky-50 text-sky-700 border-sky-300 shadow-[0_2px_8px_rgba(14,165,233,0.12)] font-semibold',
            self::InProgress => 'bg-emerald-50 text-emerald-800 border-emerald-300 shadow-[0_2px_8px_rgba(16,185,129,0.12)] font-semibold',
            self::Review => 'bg-amber-50 text-amber-800 border-amber-300 shadow-[0_2px_8px_rgba(245,158,11,0.12)] font-semibold',
            self::Completed => 'bg-indigo-50 text-indigo-700 border-indigo-300 shadow-[0_2px_8px_rgba(99,102,241,0.12)] font-semibold',
            self::OnHold => 'bg-rose-50 text-rose-800 border-rose-300 shadow-[0_2px_8px_rgba(244,63,94,0.12)] font-semibold',
        };
    }

    /**
     * Dot indicator CSS class.
     */
    public function dotClass(): string
    {
        return match ($this) {
            self::Planning => 'bg-sky-500',
            self::InProgress => 'bg-emerald-500 animate-pulse',
            self::Review => 'bg-amber-500',
            self::Completed => 'bg-indigo-500',
            self::OnHold => 'bg-rose-500',
        };
    }
}
