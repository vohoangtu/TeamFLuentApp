<?php

namespace App\Actions;

use App\DTOs\RoleData;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateRoleAction
{
    /**
     * Execute role update inside a transaction.
     */
    public function handle(Role $role, RoleData $data): Role
    {
        return DB::transaction(function () use ($role, $data) {
            $slug = $data->slug ?: Str::slug($data->name);

            // Ensure unique slug excluding current role
            $originalSlug = $slug;
            $counter = 1;
            while (Role::where('slug', $slug)->where('id', '!=', $role->id)->exists()) {
                $slug = "{$originalSlug}-{$counter}";
                $counter++;
            }

            $role->update([
                'name' => $data->name,
                'slug' => $slug,
                'badge_color' => $data->badgeColor,
                'description' => $data->description,
                'permissions' => $data->permissions,
            ]);

            return $role->fresh();
        });
    }
}
