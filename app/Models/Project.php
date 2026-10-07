<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'status',
        'priority',
        'progress',
        'color',
        'start_date',
        'due_date',
        'budget',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'due_date' => 'date',
            'progress' => 'integer',
            'budget' => 'decimal:2',
        ];
    }

    /**
     * Members assigned to this project.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'project_members')
            ->withPivot('role_in_project', 'allocation_percent', 'assigned_at')
            ->withTimestamps();
    }

    /**
     * Fluent 2 status badge styling.
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'planning' => [
                'label' => 'Đang lên kế hoạch',
                'class' => 'bg-sky-500/15 text-sky-300 border-sky-500/30 shadow-[0_0_10px_rgba(14,165,233,0.2)]',
                'dot' => 'bg-sky-400',
            ],
            'in_progress' => [
                'label' => 'Đang triển khai',
                'class' => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.2)]',
                'dot' => 'bg-emerald-400 animate-pulse',
            ],
            'review' => [
                'label' => 'Nghiệm thu / Review',
                'class' => 'bg-amber-500/15 text-amber-300 border-amber-500/30 shadow-[0_0_10px_rgba(245,158,11,0.2)]',
                'dot' => 'bg-amber-400',
            ],
            'completed' => [
                'label' => 'Đã hoàn thành',
                'class' => 'bg-indigo-500/15 text-indigo-300 border-indigo-500/30 shadow-[0_0_10px_rgba(99,102,241,0.2)]',
                'dot' => 'bg-indigo-400',
            ],
            'on_hold' => [
                'label' => 'Tạm hoãn',
                'class' => 'bg-rose-500/15 text-rose-300 border-rose-500/30 shadow-[0_0_10px_rgba(244,63,94,0.2)]',
                'dot' => 'bg-rose-400',
            ],
            default => [
                'label' => ucfirst($this->status),
                'class' => 'bg-slate-500/15 text-slate-300 border-slate-500/30',
                'dot' => 'bg-slate-400',
            ],
        };
    }

    /**
     * Fluent 2 priority badge styling.
     */
    public function getPriorityBadgeAttribute(): array
    {
        return match ($this->priority) {
            'urgent' => [
                'label' => 'Khẩn cấp',
                'class' => 'bg-rose-500/20 text-rose-300 border-rose-500/40 shadow-[0_0_10px_rgba(244,63,94,0.3)]',
            ],
            'high' => [
                'label' => 'Ưu tiên cao',
                'class' => 'bg-amber-500/20 text-amber-300 border-amber-500/40 shadow-[0_0_10px_rgba(245,158,11,0.25)]',
            ],
            'medium' => [
                'label' => 'Trung bình',
                'class' => 'bg-blue-500/20 text-blue-300 border-blue-500/40',
            ],
            'low' => [
                'label' => 'Thấp',
                'class' => 'bg-slate-500/20 text-slate-300 border-slate-500/30',
            ],
            default => [
                'label' => ucfirst($this->priority),
                'class' => 'bg-slate-500/20 text-slate-300 border-slate-500/30',
            ],
        };
    }
}
