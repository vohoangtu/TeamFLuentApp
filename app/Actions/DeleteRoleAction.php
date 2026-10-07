<?php

namespace App\Actions;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class DeleteRoleAction
{
    /**
     * Delete role safely inside transaction.
     *
     * @throws InvalidArgumentException
     */
    public function handle(Role $role): void
    {
        DB::transaction(function () use ($role) {
            $membersCount = $role->members()->count();

            if ($membersCount > 0) {
                throw new InvalidArgumentException("Không thể xóa vai trò '{$role->name}' vì đang có {$membersCount} thành viên mang vai trò này. Vui lòng chuyển thành viên sang vai trò khác trước.");
            }

            $role->delete();
        });
    }
}
