<?php

namespace App\Actions;

use App\DTOs\RoleData;
use App\Models\PermissionGroup;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateRoleAction
{
    /**
     * Execute the role creation inside a transaction.
     */
    public function handle(RoleData $data): Role
    {
        return DB::transaction(function () use ($data) {
            $slug = $data->slug ?: Str::slug($data->name);

            // Ensure unique slug
            $originalSlug = $slug;
            $counter = 1;
            while (Role::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-{$counter}";
                $counter++;
            }

            $role = Role::create([
                'name' => $data->name,
                'slug' => $slug,
                'badge_color' => $data->badgeColor,
                'description' => $data->description,
                'permissions' => $data->permissions,
            ]);

            if (! empty($data->permissionGroupIds)) {
                $role->permissionGroups()->sync($data->permissionGroupIds);

                $groupPermissions = PermissionGroup::whereIn('id', $data->permissionGroupIds)
                    ->pluck('permissions')
                    ->flatten()
                    ->filter()
                    ->all();

                $allPermissions = array_values(array_unique(array_merge($groupPermissions, $data->permissions)));
                $role->update(['permissions' => $allPermissions]);
            }

            return $role->fresh(['permissionGroups']);
        });
    }
}
