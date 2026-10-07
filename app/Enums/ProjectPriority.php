<?php

namespace App\Enums;

enum ProjectPriority: string
{
    case Urgent = 'urgent';
    case High = 'high';
    case Medium = 'medium';
    case Low = 'low';

    /**
     * Human-readable label in Vietnamese.
     */
    public function label(): string
    {
        return match ($this) {
            self::Urgent => 'Khẩn cấp',
            self::High => 'Ưu tiên cao',
            self::Medium => 'Trung bình',
            self::Low => 'Thấp',
        };
    }

    /**
     * Fluent 2 badge CSS classes.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Urgent => 'bg-rose-500/20 text-rose-300 border-rose-500/40 shadow-[0_0_10px_rgba(244,63,94,0.3)]',
            self::High => 'bg-amber-500/20 text-amber-300 border-amber-500/40 shadow-[0_0_10px_rgba(245,158,11,0.25)]',
            self::Medium => 'bg-blue-500/20 text-blue-300 border-blue-500/40',
            self::Low => 'bg-slate-500/20 text-slate-300 border-slate-500/30',
        };
    }
}
