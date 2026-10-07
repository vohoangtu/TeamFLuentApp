<?php

namespace App\Http\Requests;

use App\DTOs\MemberData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
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
        $memberId = $this->route('member')?->id ?? $this->route('member');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('members')->ignore($memberId)],
            'phone' => ['nullable', 'string', 'max:50'],
            'avatar_url' => ['nullable', 'string', 'max:1000'],
            'team_id' => ['required', 'exists:teams,id'],
            'role_id' => ['required', 'exists:roles,id'],
            'is_team_lead' => ['nullable', 'boolean'],
            'status' => ['required', 'in:active,inactive,on_leave'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'joined_at' => ['nullable', 'date'],
        ];
    }

    /**
     * Convert validated input into a strongly-typed MemberData DTO.
     */
    public function toDto(): MemberData
    {
        $validated = $this->validated();
        $validated['is_team_lead'] = $this->boolean('is_team_lead');

        return MemberData::fromArray($validated);
    }
}
