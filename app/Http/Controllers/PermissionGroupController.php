<?php

namespace App\Http\Controllers;

use App\Actions\CreatePermissionGroupAction;
use App\Actions\DeletePermissionGroupAction;
use App\Actions\UpdatePermissionGroupAction;
use App\Http\Requests\StorePermissionGroupRequest;
use App\Http\Requests\UpdatePermissionGroupRequest;
use App\Models\PermissionGroup;
use App\Services\PermissionRegistry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use InvalidArgumentException;

class PermissionGroupController extends Controller
{
    public function __construct(
        private readonly CreatePermissionGroupAction $createGroupAction,
        private readonly UpdatePermissionGroupAction $updateGroupAction,
        private readonly DeletePermissionGroupAction $deleteGroupAction,
    ) {}

    /**
     * Show the form for creating a new functional permission group.
     */
    public function create(): View
    {
        return view('roles.groups.create', [
            'permissionModules' => PermissionRegistry::all(),
            'colors' => $this->availableColors(),
        ]);
    }

    /**
     * Store a newly created functional permission group.
     */
    public function store(StorePermissionGroupRequest $request): RedirectResponse
    {
        $group = $this->createGroupAction->handle($request->toDto());

        return redirect()->route('roles.index', ['tab' => 'groups'])
            ->with('success', 'Nhóm quyền chức năng '.$group->name.' đã được thiết lập thành công!');
    }

    /**
     * Show the form for editing the functional permission group.
     */
    public function edit(PermissionGroup $permissionGroup): View
    {
        return view('roles.groups.edit', [
            'group' => $permissionGroup,
            'permissionModules' => PermissionRegistry::all(),
            'colors' => $this->availableColors(),
        ]);
    }

    /**
     * Update the functional permission group.
     */
    public function update(UpdatePermissionGroupRequest $request, PermissionGroup $permissionGroup): RedirectResponse
    {
        $updatedGroup = $this->updateGroupAction->handle($permissionGroup, $request->toDto());

        return redirect()->route('roles.index', ['tab' => 'groups'])
            ->with('success', 'Đã cập nhật nhóm chức năng '.$updatedGroup->name.' và đồng bộ hóa các vai trò trực thuộc!');
    }

    /**
     * Delete the functional permission group.
     */
    public function destroy(PermissionGroup $permissionGroup): RedirectResponse
    {
        try {
            $name = $permissionGroup->name;
            $this->deleteGroupAction->handle($permissionGroup);

            return redirect()->route('roles.index', ['tab' => 'groups'])
                ->with('success', 'Đã xóa nhóm chức năng '.$name.' thành công.');
        } catch (InvalidArgumentException $e) {
            return redirect()->route('roles.index', ['tab' => 'groups'])
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Available badge palette colors.
     *
     * @return array<string, string>
     */
    private function availableColors(): array
    {
        return [
            'cyan' => 'Lam Ngọc (Cyan)',
            'purple' => 'Tím Neon (Purple)',
            'emerald' => 'Ngọc Lục Bảo (Emerald)',
            'amber' => 'Hổ Phách (Amber)',
            'rose' => 'Hồng Đào (Rose)',
            'blue' => 'Xanh Dương (Blue)',
            'fuchsia' => 'Hồng Neon (Fuchsia)',
            'indigo' => 'Chàm Sáng (Indigo)',
        ];
    }
}
