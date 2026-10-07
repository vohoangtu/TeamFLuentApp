<?php

namespace App\Actions;

use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class DeletePermissionGroupAction
{
    /**
     * Delete a custom permission group.
     *
     * @throws InvalidArgumentException
     */
    public function handle(PermissionGroup $group): void
    {
        if ($group->is_system) {
            throw new InvalidArgumentException('Không thể xóa nhóm quyền chức năng cốt lõi của hệ thống ('.$group->name.').');
        }

        DB::transaction(function () use ($group) {
            $group->roles()->detach();
            $group->delete();
        });
    }
}
