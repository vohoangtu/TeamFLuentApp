<?php

namespace App\Http\Requests;

use App\DTOs\TeamData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamRequest extends FormRequest
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
        $teamId = $this->route('team')?->id ?? $this->route('team');

        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', Rule::unique('teams')->ignore($teamId)],
            'description' => ['nullable', 'string', 'max:1000'],
            'color' => ['nullable', 'string', 'max:100'],
            'lead_id' => ['nullable', 'exists:members,id'],
        ];
    }

    /**
     * Convert to strongly-typed TeamData DTO.
     */
    public function toDto(): TeamData
    {
        return TeamData::fromArray($this->validated());
    }
}
