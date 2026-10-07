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
     * Fluent 2 badge CSS classes (Light Theme Ultra-Colorful).
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Urgent => 'bg-rose-50 text-rose-800 border-rose-300 shadow-[0_2px_8px_rgba(244,63,94,0.15)] font-semibold',
            self::High => 'bg-amber-50 text-amber-800 border-amber-300 shadow-[0_2px_8px_rgba(245,158,11,0.15)] font-semibold',
            self::Medium => 'bg-blue-50 text-blue-800 border-blue-300 shadow-[0_2px_8px_rgba(59,130,246,0.15)] font-semibold',
            self::Low => 'bg-slate-100 text-slate-700 border-slate-300 font-semibold',
        };
    }
}
