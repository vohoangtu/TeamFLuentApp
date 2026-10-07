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
     * Fluent 2 badge CSS classes.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Active => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30 shadow-[0_0_8px_rgba(16,185,129,0.25)]',
            self::OnLeave => 'bg-amber-500/15 text-amber-300 border-amber-500/30 shadow-[0_0_8px_rgba(245,158,11,0.2)]',
            self::Inactive => 'bg-slate-500/15 text-slate-400 border-slate-500/30',
        };
    }

    /**
     * Dot indicator CSS class.
     */
    public function dotClass(): string
    {
        return match ($this) {
            self::Active => 'bg-emerald-400',
            self::OnLeave => 'bg-amber-400',
            self::Inactive => 'bg-slate-400',
        };
    }
}
