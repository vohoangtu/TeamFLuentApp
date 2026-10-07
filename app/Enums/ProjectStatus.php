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
     * Fluent 2 badge CSS classes.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Planning => 'bg-sky-500/15 text-sky-300 border-sky-500/30 shadow-[0_0_10px_rgba(14,165,233,0.2)]',
            self::InProgress => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.2)]',
            self::Review => 'bg-amber-500/15 text-amber-300 border-amber-500/30 shadow-[0_0_10px_rgba(245,158,11,0.2)]',
            self::Completed => 'bg-indigo-500/15 text-indigo-300 border-indigo-500/30 shadow-[0_0_10px_rgba(99,102,241,0.2)]',
            self::OnHold => 'bg-rose-500/15 text-rose-300 border-rose-500/30 shadow-[0_0_10px_rgba(244,63,94,0.2)]',
        };
    }

    /**
     * Dot indicator CSS class.
     */
    public function dotClass(): string
    {
        return match ($this) {
            self::Planning => 'bg-sky-400',
            self::InProgress => 'bg-emerald-400 animate-pulse',
            self::Review => 'bg-amber-400',
            self::Completed => 'bg-indigo-400',
            self::OnHold => 'bg-rose-400',
        };
    }
}
