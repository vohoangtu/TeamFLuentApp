<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'badge_color',
        'description',
        'permissions',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'permissions' => 'array',
        ];
    }

    /**
     * Members belonging to this role.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get Fluent 2 color styling classes for this role (Light Theme Ultra-Colorful).
     */
    public function getBadgeClassesAttribute(): string
    {
        return match ($this->badge_color) {
            'purple' => 'bg-purple-100/90 text-purple-700 border-purple-300 shadow-[0_2px_8px_rgba(168,85,247,0.15)] font-semibold',
            'cyan' => 'bg-cyan-100/90 text-cyan-800 border-cyan-300 shadow-[0_2px_8px_rgba(6,182,212,0.15)] font-semibold',
            'emerald' => 'bg-emerald-100/90 text-emerald-800 border-emerald-300 shadow-[0_2px_8px_rgba(16,185,129,0.15)] font-semibold',
            'rose' => 'bg-rose-100/90 text-rose-800 border-rose-300 shadow-[0_2px_8px_rgba(244,63,94,0.15)] font-semibold',
            'amber' => 'bg-amber-100/90 text-amber-800 border-amber-300 shadow-[0_2px_8px_rgba(245,158,11,0.15)] font-semibold',
            'blue' => 'bg-blue-100/90 text-blue-800 border-blue-300 shadow-[0_2px_8px_rgba(59,130,246,0.15)] font-semibold',
            'fuchsia' => 'bg-fuchsia-100/90 text-fuchsia-800 border-fuchsia-300 shadow-[0_2px_8px_rgba(217,70,239,0.15)] font-semibold',
            default => 'bg-indigo-100/90 text-indigo-700 border-indigo-300 shadow-[0_2px_8px_rgba(99,102,241,0.15)] font-semibold',
        };
    }
}
