<?php

namespace App\Http\Requests;

use App\DTOs\RoleData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $roleId = $this->route('role')?->id ?? $this->route('role');

        return [
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:100', Rule::unique('roles', 'slug')->ignore($roleId)],
            'badge_color' => ['required', 'string', 'in:purple,cyan,emerald,rose,amber,blue,fuchsia,indigo'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
            'permission_group_ids' => ['nullable', 'array'],
            'permission_group_ids.*' => ['integer', 'exists:permission_groups,id'],
        ];
    }

    public function toDto(): RoleData
    {
        return RoleData::fromArray($this->validated());
    }
}
