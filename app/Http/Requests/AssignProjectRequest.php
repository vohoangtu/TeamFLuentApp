<?php

namespace App\Http\Requests;

use App\DTOs\AssignProjectData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignProjectRequest extends FormRequest
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
        return [
            'project_id' => ['sometimes', 'required', 'exists:projects,id'],
            'member_id' => ['sometimes', 'required', 'exists:members,id'],
            'role_in_project' => ['required', 'string', 'max:100'],
            'allocation_percent' => ['required', 'integer', 'min:5', 'max:100'],
        ];
    }

    /**
     * Convert to strongly-typed AssignProjectData DTO.
     */
    public function toDto(int $projectId): AssignProjectData
    {
        return new AssignProjectData(
            projectId: $projectId,
            roleInProject: (string) $this->validated('role_in_project'),
            allocationPercent: (int) $this->validated('allocation_percent'),
            assignedAt: now()->toDateString(),
        );
    }
}
