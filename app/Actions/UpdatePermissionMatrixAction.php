<?php

namespace App\Actions;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UpdatePermissionMatrixAction
{
    /**
     * Batch update permissions and functional groups for all roles across the RBAC matrix.
     *
     * @param  array<int, list<string>>  $matrix  [role_id => [permission_keys...]]
     * @param  array<int, list<int>>  $matrixGroups  [role_id => [group_ids...]]
     */
    public function handle(array $matrix, array $matrixGroups = []): void
    {
        DB::transaction(function () use ($matrix, $matrixGroups) {
            $roles = Role::all()->keyBy('id');

            foreach ($roles as $roleId => $role) {
                if (isset($matrixGroups[$roleId])) {
                    $groupIds = array_values(array_map('intval', (array) $matrixGroups[$roleId]));
                    $role->permissionGroups()->sync($groupIds);
                }

                $groupPermissions = $role->permissionGroups()->pluck('permissions')->flatten()->filter()->all();

                $customPermissions = isset($matrix[$roleId]) ? array_values(array_unique((array) $matrix[$roleId])) : [];
                $allPermissions = array_values(array_unique(array_merge($groupPermissions, $customPermissions)));

                $role->update([
                    'permissions' => $allPermissions,
                ]);
            }
        });
    }
}
