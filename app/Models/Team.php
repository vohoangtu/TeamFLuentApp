<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
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
        'color',
        'icon',
        'lead_id',
    ];

    /**
     * Members belonging to this team.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * The leader of this team.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'lead_id');
    }
}
