<?php

namespace App\Actions;

use App\DTOs\PermissionGroupData;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdatePermissionGroupAction
{
    /**
     * Update an existing functional permission group and synchronize assigned roles.
     */
    public function handle(PermissionGroup $group, PermissionGroupData $data): PermissionGroup
    {
        return DB::transaction(function () use ($group, $data) {
            $slug = Str::slug($data->slug ?: $data->name);

            // Check collision ignoring current record
            $collision = PermissionGroup::where('slug', $slug)
                ->where('id', '!=', $group->id)
                ->exists();

            if ($collision) {
                $slug = $slug.'-'.Str::lower(Str::random(4));
            }

            $newPermissions = array_values(array_unique($data->permissions));

            $group->update([
                'name' => $data->name,
                'slug' => $slug,
                'badge_color' => $data->badgeColor,
                'icon' => $data->icon ?: '⚡',
                'description' => $data->description,
                'permissions' => $newPermissions,
            ]);

            // Synchronize all roles currently holding this permission group
            $roles = $group->roles()->with('permissionGroups')->get();
            foreach ($roles as $role) {
                $allGroupPerms = $role->permissionGroups
                    ->pluck('permissions')
                    ->flatten()
                    ->filter()
                    ->all();

                $merged = array_values(array_unique(array_merge($allGroupPerms, $role->permissions ?? [])));
                $role->update(['permissions' => $merged]);
            }

            return $group->fresh(['roles']);
        });
    }
}
