<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectMember extends Pivot
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'project_members';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'member_id',
        'role_in_project',
        'allocation_percent',
        'assigned_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'allocation_percent' => 'integer',
            'assigned_at' => 'date',
        ];
    }
}
