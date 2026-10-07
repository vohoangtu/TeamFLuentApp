<?php

namespace App\Actions;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UpdatePermissionMatrixAction
{
    /**
     * Batch update permissions for all roles across the RBAC matrix.
     *
     * @param  array<int, list<string>>  $matrix  [role_id => [permission_keys...]]
     */
    public function handle(array $matrix): void
    {
        DB::transaction(function () use ($matrix) {
            $roles = Role::all()->keyBy('id');

            foreach ($roles as $roleId => $role) {
                // If role key exists in matrix, update with submitted permissions, otherwise empty list
                $permissions = isset($matrix[$roleId]) ? array_values(array_unique((array) $matrix[$roleId])) : [];

                $role->update([
                    'permissions' => $permissions,
                ]);
            }
        });
    }
}
