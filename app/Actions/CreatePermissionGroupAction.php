<?php

namespace App\Actions;

use App\DTOs\PermissionGroupData;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreatePermissionGroupAction
{
    /**
     * Create a new functional permission group.
     */
    public function handle(PermissionGroupData $data): PermissionGroup
    {
        return DB::transaction(function () use ($data) {
            $slug = Str::slug($data->slug ?: $data->name);

            // Handle potential collision
            $existing = PermissionGroup::where('slug', $slug)->exists();
            if ($existing) {
                $slug = $slug.'-'.Str::lower(Str::random(4));
            }

            return PermissionGroup::create([
                'name' => $data->name,
                'slug' => $slug,
                'badge_color' => $data->badgeColor,
                'icon' => $data->icon ?: '⚡',
                'description' => $data->description,
                'permissions' => array_values(array_unique($data->permissions)),
                'is_system' => $data->isSystem,
            ]);
        });
    }
}
