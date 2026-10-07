<?php

namespace App\Models;

use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;
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
            'status' => ProjectStatus::class,
            'priority' => ProjectPriority::class,
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
        $statusEnum = $this->status instanceof ProjectStatus
            ? $this->status
            : ProjectStatus::tryFrom((string) $this->status);

        if (! $statusEnum) {
            return [
                'label' => ucfirst((string) $this->status),
                'class' => 'bg-slate-500/15 text-slate-300 border-slate-500/30',
                'dot' => 'bg-slate-400',
            ];
        }

        return [
            'label' => $statusEnum->label(),
            'class' => $statusEnum->badgeClass(),
            'dot' => $statusEnum->dotClass(),
        ];
    }

    /**
     * Fluent 2 priority badge styling.
     */
    public function getPriorityBadgeAttribute(): array
    {
        $priorityEnum = $this->priority instanceof ProjectPriority
            ? $this->priority
            : ProjectPriority::tryFrom((string) $this->priority);

        if (! $priorityEnum) {
            return [
                'label' => ucfirst((string) $this->priority),
                'class' => 'bg-slate-500/20 text-slate-300 border-slate-500/30',
            ];
        }

        return [
            'label' => $priorityEnum->label(),
            'class' => $priorityEnum->badgeClass(),
        ];
    }
}
