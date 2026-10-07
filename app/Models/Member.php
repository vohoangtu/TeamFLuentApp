<?php

namespace App\Models;

use App\Enums\MemberStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar_url',
        'team_id',
        'role_id',
        'is_team_lead',
        'status',
        'bio',
        'joined_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => MemberStatus::class,
            'joined_at' => 'date',
            'is_team_lead' => 'boolean',
        ];
    }

    /**
     * Team that the member belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Specific role assigned to this member.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Projects that this member is responsible for / assigned to.
     * A member can handle multiple projects.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_members')
            ->withPivot('role_in_project', 'allocation_percent', 'assigned_at')
            ->withTimestamps();
    }

    /**
     * Total workload allocation percentage across all projects.
     */
    public function getTotalAllocationAttribute(): int
    {
        return (int) $this->projects->sum('pivot.allocation_percent');
    }

    /**
     * Fluent 2 status badge styling.
     */
    public function getStatusBadgeAttribute(): array
    {
        $statusEnum = $this->status instanceof MemberStatus
            ? $this->status
            : MemberStatus::tryFrom((string) $this->status);

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
}
