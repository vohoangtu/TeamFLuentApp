<?php

namespace App\Actions;

use App\DTOs\RoleData;
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

            return Role::create([
                'name' => $data->name,
                'slug' => $slug,
                'badge_color' => $data->badgeColor,
                'description' => $data->description,
                'permissions' => $data->permissions,
            ]);
        });
    }
}
