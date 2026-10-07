<?php

namespace App\Http\Controllers;

use App\Actions\CreateRoleAction;
use App\Actions\DeleteRoleAction;
use App\Actions\UpdatePermissionMatrixAction;
use App\Actions\UpdateRoleAction;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateMatrixRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Services\PermissionRegistry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use InvalidArgumentException;

class RoleController extends Controller
{
    public function __construct(
        private readonly CreateRoleAction $createRoleAction,
        private readonly UpdateRoleAction $updateRoleAction,
        private readonly DeleteRoleAction $deleteRoleAction,
        private readonly UpdatePermissionMatrixAction $updateMatrixAction,
    ) {}

    /**
     * Display a listing of system roles and the interactive RBAC permissions matrix.
     */
    public function index(): View
    {
        $roles = Role::query()
            ->with(['members.team', 'members.projects', 'permissionGroups'])
            ->withCount('members')
            ->orderBy('id')
            ->get();

        $permissionGroups = PermissionGroup::query()
            ->with('roles')
            ->withCount('roles')
            ->orderBy('id')
            ->get();

        $permissionModules = PermissionRegistry::all();

        return view('roles.index', [
            'roles' => $roles,
            'permissionGroups' => $permissionGroups,
            'permissionModules' => $permissionModules,
        ]);
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        return view('roles.create', [
            'permissionModules' => PermissionRegistry::all(),
            'permissionGroups' => PermissionGroup::orderBy('id')->get(),
            'colors' => $this->availableColors(),
        ]);
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = $this->createRoleAction->handle($request->toDto());

        return redirect()->route('roles.index')
            ->with('success', 'Vai trò '.$role->name.' đã được thiết lập thành công!');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View
    {
        $role->load('permissionGroups');

        return view('roles.edit', [
            'role' => $role,
            'permissionModules' => PermissionRegistry::all(),
            'permissionGroups' => PermissionGroup::orderBy('id')->get(),
            'colors' => $this->availableColors(),
        ]);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $updatedRole = $this->updateRoleAction->handle($role, $request->toDto());

        return redirect()->route('roles.index')
            ->with('success', 'Đã cập nhật thông tin và phân quyền cho vai trò '.$updatedRole->name.'!');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        try {
            $name = $role->name;
            $this->deleteRoleAction->handle($role);

            return redirect()->route('roles.index')
                ->with('success', 'Đã xóa vai trò '.$name.' thành công.');
        } catch (InvalidArgumentException $e) {
            return redirect()->route('roles.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Batch update permissions for all roles via the RBAC matrix grid.
     */
    public function updateMatrix(UpdateMatrixRequest $request): RedirectResponse
    {
        $matrix = (array) $request->validated('matrix', []);
        $matrixGroups = (array) $request->validated('matrix_groups', []);
        $this->updateMatrixAction->handle($matrix, $matrixGroups);

        return redirect()->route('roles.index')
            ->with('success', 'Đã lưu và cập nhật ma trận phân quyền RBAC thành công!');
    }

    /**
     * Available badge palette colors.
     *
     * @return array<string, string>
     */
    private function availableColors(): array
    {
        return [
            'purple' => 'Tím Neon (Purple)',
            'cyan' => 'Lam Ngọc (Cyan)',
            'emerald' => 'Ngọc Lục Bảo (Emerald)',
            'rose' => 'Hồng Đào (Rose)',
            'amber' => 'Hổ Phách (Amber)',
            'blue' => 'Xanh Dương (Blue)',
            'fuchsia' => 'Hồng Neon (Fuchsia)',
            'indigo' => 'Chàm Sáng (Indigo)',
        ];
    }
}
