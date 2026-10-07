<?php

namespace App\Http\Requests;

use App\DTOs\PermissionGroupData;
use App\Models\PermissionGroup;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var PermissionGroup|null $group */
        $group = $this->route('permission_group') ?? $this->route('group');
        $groupId = $group instanceof PermissionGroup ? $group->id : $group;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('permission_groups', 'slug')->ignore($groupId)],
            'badge_color' => ['required', 'string', 'in:purple,cyan,emerald,rose,amber,blue,fuchsia,indigo'],
            'icon' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:1000'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ];
    }

    /**
     * Map request input to DTO.
     */
    public function toDto(): PermissionGroupData
    {
        /** @var PermissionGroup|null $group */
        $group = $this->route('permission_group') ?? $this->route('group');
        $isSystem = $group instanceof PermissionGroup ? $group->is_system : false;

        return new PermissionGroupData(
            name: (string) $this->validated('name'),
            slug: (string) ($this->validated('slug') ?: $this->validated('name')),
            badgeColor: (string) $this->validated('badge_color', 'indigo'),
            icon: (string) ($this->validated('icon') ?: '⚡'),
            description: $this->validated('description'),
            permissions: (array) $this->validated('permissions', []),
            isSystem: $isSystem,
        );
    }
}
