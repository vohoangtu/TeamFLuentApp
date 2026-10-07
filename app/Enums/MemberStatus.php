<?php

namespace App\Enums;

enum MemberStatus: string
{
    case Active = 'active';
    case OnLeave = 'on_leave';
    case Inactive = 'inactive';

    /**
     * Human-readable label in Vietnamese.
     */
    public function label(): string
    {
        return match ($this) {
            self::Active => 'Đang làm việc',
            self::OnLeave => 'Nghỉ phép',
            self::Inactive => 'Đã rời nhóm',
        };
    }

    /**
     * Fluent 2 badge CSS classes (Light Theme Ultra-Colorful).
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Active => 'bg-emerald-50 text-emerald-800 border-emerald-300 shadow-[0_2px_8px_rgba(16,185,129,0.15)] font-semibold',
            self::OnLeave => 'bg-amber-50 text-amber-800 border-amber-300 shadow-[0_2px_8px_rgba(245,158,11,0.15)] font-semibold',
            self::Inactive => 'bg-slate-100 text-slate-600 border-slate-300 font-semibold',
        };
    }

    /**
     * Dot indicator CSS class.
     */
    public function dotClass(): string
    {
        return match ($this) {
            self::Active => 'bg-emerald-500',
            self::OnLeave => 'bg-amber-500',
            self::Inactive => 'bg-slate-400',
        };
    }
}
