<?php

namespace App\Http\Requests;

use App\DTOs\RoleData;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:100', 'unique:roles,slug'],
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
